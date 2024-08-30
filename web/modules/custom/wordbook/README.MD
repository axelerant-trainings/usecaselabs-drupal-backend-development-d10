# Wordbook

You are maintaining a module that provides functionalities related to word storage and usage. To efficiently handle the data you need to create a Wordbook entity type with the fields: Label(plain text), Usage(text long), Author(user reference), Status(Boolean), Authored on(Timestamp) and Changed(Timestamp) using Drupal's custom entity API which provides a more powerful, integrated, and scalable solution.

## Acceptance Criteria

- A custom entity type is created and registered.
- The entity type can be managed through the Drupal admin interface.
- CRUD operations (Create, Read, Update, Delete) are functional for the custom Wordbook entity.
- There should be a listing page to show all the words added.
- The custom entity type is tested for integration with views.

## Steps to configure

1. `ddev drush cim -y`
2. Navigate to [Wordbook Admin Listing](/admin/content/wordbook) to add wordbook item
3. Once you have added the data, navigate to [Wordbook Listing](/wordbook-listing)
4. You will be able to see all your added data
