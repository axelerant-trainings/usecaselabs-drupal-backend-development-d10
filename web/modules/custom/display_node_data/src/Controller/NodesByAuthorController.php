<?php

namespace Drupal\display_node_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Nodes by author controller.
 */
class NodesByAuthorController extends ControllerBase {

  public function __construct(protected RequestStack $requestStack, protected DateFormatterInterface $dateFormatter, protected $database) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('date.formatter'),
      $container->get('database')
    );
  }

  /**
   * Display the Nodes by author in tabular format.
   */
  public function displayNodeInTabularFormat() {

    $search_term = $this->requestStack->getCurrentRequest()->query->get('search');

    $build = $this->formBuilder()->getForm('Drupal\display_node_data\Form\NodesByAuthorSearchForm');

    $header = [
      'title' => ['data' => $this->t('Title'), 'field' => 'title', 'specifier' => 'title'],
      'type' => $this->t('Content Type'),
      'status' => $this->t('Status'),
      'author' => $this->t('Author'),
      'updated' => ['data' => $this->t('Updated'), 'field' => 'created', 'specifier' => 'created'],
    ];

    $exclude_nids = [];
    $menu_query = $this->database->select('menu_link_content_data', 'mlcd');
    $menu_query->addField('mlcd', 'link__uri');
    $menu_query->condition('mlcd.enabled', 1);
    $menu_query->condition('mlcd.menu_name', 'main');

    foreach ($menu_query->execute()->fetchAll() as $value) {
      preg_match('/(\d+)$/', $value->link__uri, $matches);
      if (!empty($matches[1])) {
        $exclude_nids[] = $matches[1];
      }
    }

    $query = $this->entityTypeManager()->getStorage('node')->getQuery();
    $query->tableSort($header);
    $query->condition('uid', $this->currentUser()->id());
    if (!empty($exclude_nids)) {
      $query->condition('nid', $exclude_nids, 'NOT IN');
    }
    $query->accessCheck(TRUE);
    $query->condition('title', '%' . $search_term . '%', 'LIKE');
    $query->pager(10);

    $nids = $query->execute();

    $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);

    $rows = [];
    foreach ($nodes as $node) {
      $rows[] = [
        'title' => $node->toLink(),
        'type' => $node->bundle(),
        'status' => $node->isPublished(),
        'author' => $node->getOwner()->getDisplayName(),
        'updated' => $this->dateFormatter->format($node->getChangedTime(), 'medium'),
      ];
    }

    $build['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No results found.'),
    ];

    $build['pager'] = [
      '#type' => 'pager',
    ];

    return $build;

  }

}
