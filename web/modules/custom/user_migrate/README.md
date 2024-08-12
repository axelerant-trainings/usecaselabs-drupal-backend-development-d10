# Migrate users using CSV

You want to migrate users using CSV file, migrate users using Drupal’s Migrate system.

## Acceptance Criteria

- Users with correct field values and roles should be imported - user name, email, roles and status
- In case of empty or validation failure, that row from CSV should be skipped and should be logged against migration id in migrate messages

## Steps to configure and check

1. `ddev drush en user_migrate -y`
2. To import users from CSV `ddev drush migrate:import user_migrate_csv`
3. To check the import status `ddev drush migrate:status user_migrate_csv`
4. To check the import deatiled status(messages) `ddev drush migrate:messages user_migrate_csv` here Source ID(s) means the `id` column in CSV. For eg: test5
5. To rollback the import `ddev drush migrate:rollback user_migrate_csv`
