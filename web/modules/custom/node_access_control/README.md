# Define node access using a field

The site-administrator has requested to provide access to nodes of content type “Company Finances” only to a defined list of users. This list of users would be defined by a user reference field on the content type.

## Acceptance Criteria

- The reference field should only accept published users

- The field should be accessible only to site-administrators and be hidden from other roles

- The user should be able access nodes only to which he/she has access to

- Show appropriate Access Denied in case of no access to the node

## Steps to configure and check

1. `ddev drush cim -y` to import module configuration
2. Navigate to [Company Finances Node](/node/add/company_finances) to add content for users who should have access to that node
3. Now check the page with that user login
