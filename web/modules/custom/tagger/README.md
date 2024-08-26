# Custom Drush command to add tags

Create a custom drush command to add tags to Article content. The drush command should accept comma-separated values for tags and optional comma-separated values for IDs.

## Acceptance Criteria

- Create a custom drush command that accepts two arguments: ids(optional) and tags(required)
- If ids is not passed, the passed tags should be applied to all the nodes of type article
- If ids is passed, the passed tags should be applied to only those ids
- Ensure entity of type article exists for the ids passed.
- Handle error logging to the screen in case of any errors or validation
- Skip adding tag to the node in the case that tag is already added to the node.
- The command on success should create and assign tags in the respective field for the Article content type

## Steps to configure and check

1. `ddev drush cim -y` to import module configuration
2. Create two sample article nodes
3. To apply tag tag1, tag2 to both nodes `ddev drush tat "tag1, tag2"`
4. To apply tags tag3, tag4 to single node id 1 `ddev drush tat "tag3, tag4" "1"`
