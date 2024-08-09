# Email Configuration Form

The site administrators on your website have requested they should be able to manage email templates and define a list of users who will receive email notifications. Create a custom configuration to manage these values.

## Acceptance Criteria

- Configuration form is created with the defined fields
- Only site administrator should be able to access it
- Values are updated correctly on form save

## Steps to configure

1. `ddev drush en email_configuration`
2. `ddev drush cim -y`
3. Navigate to [Email Configuration Form](/admin/config/system/email-config/form) to configure values
4. You should be able to see values for Template and User email ids
5. Change the data as per need and hit save
