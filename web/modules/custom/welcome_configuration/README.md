# Welcome Configuration

The site administrators on your website have requested that they should be able to manage welcome template for the users. Create a custom configuration to store template and dynamically add a menu link beside Home for the user to navigate to the path and check the welcome message.

## Acceptance Criteria

- Configuration form is created with the defined field
- Only site administrator should be able to access the form
- Path to welcome template must be available via menu
- Tokens must be there in template for usage like: username, lastlogin & membersince

## Steps to configure

1. `ddev drush cim -y`
2. Navigate to [Welcome Configuration Form](/admin/config/system/welcome-config/form) to configure template
3. You should be able to see saved values in form
4. Now click on `Back to site` link
5. As logged in user you will be able to see `Welcome` link beside Home in main navigation
