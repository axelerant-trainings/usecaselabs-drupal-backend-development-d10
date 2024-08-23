<?php

namespace Drupal\tagger\Drush\Commands;

use Drush\Commands\DrushCommands;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;

class TaggerCommands extends DrushCommands {

  /**
   * Adds tags to Article nodes.
   *
   * @param string $tags
   *   Comma-separated list of tags to add.
   * @param string $ids
   *   (Optional) Comma-separated list of node IDs to which tags will be added.
   *
   * @command tagger:article-tagger
   * @aliases tat
   * @usage tagger:article-tagger "tag1,tag2" "1,2,3"
   *   Adds the tags 'tag1' and 'tag2' to nodes IDs 1, 2, and 3.
   * @usage tagger:article-tagger "tag1,tag2"
   *   Adds the tags 'tag1' and 'tag2' to all Article nodes.
   */
  public function articleTagger($tags, $ids = "") {
    $tag_ids = $node_ids = [];
    $tags = array_map("trim", explode(",", $tags));

    // Load existing tags ids from passed tag names or create them.
    foreach ($tags as $tag_name) {
      $term = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->loadByProperties(['name' => $tag_name, 'vid' => 'tags']);
      if (empty($term)) {
        $term = Term::create([
          'vid' => 'tags',
          'name' => $tag_name,
        ]);
        $term->save();
      }
      $term = (gettype($term) === "array") ? reset($term) : $term;
      $tag_ids[$term->id()] = $term->get('name')->value;
    }

    // Load node object from ids passed or all article nodes.
    if (!empty($ids)) {
      $node_ids = array_map("trim", explode(",", $ids));
      $nodes = Node::loadMultiple($node_ids);
    } else {
      $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'article']);
    }

    // Processing nodes to check and apply tags.
    foreach ($nodes as $node) {
      if ($node->getType() !== 'article') {
        $this->output()->writeln("Node ID {$node->id()} is not an article, skipping.");
        continue;
      }
      $existing_tags = $node->get('field_tags')->getValue();
      $existing_tag_ids = $existing_tags ? array_column($existing_tags, 'target_id') : [];

      foreach ($tag_ids as $tag_id => $tag_name) {
        if (!in_array($tag_id, $existing_tag_ids)) {
          $node->get('field_tags')->appendItem(['target_id' => $tag_id]);
          $this->output()->writeln("Added tag `{$tag_name}` to Node ID {$node->id()}.");
        }
        else {
          $this->output()->writeln("Tag `{$tag_name}` is already added to Node ID {$node->id()}.");
        }
      }
      $node->save();
      $this->output()->writeln("Process completed.");
    }
    if (empty($nodes)) {
      $this->output()->writeln("No article nodes were found for the tagging.");
    }
  }
}
