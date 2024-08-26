# Show Internal Event details to specific roles

## Description:

The administrators on your site would like to show a custom message related to internal engagements on the homepage of the site to only a specific roles.

Create a custom block plugin that allows administrators to manage the message. The block form should include fields for the Message, End Time and Link(optional).

## Acceptance Criteria:

- Create a custom block plugin with the desired fields
- Allow only administrators to manage this block
- The block plugin is able to store the details in its configuration so that the fields have a default value set.
- The block should be visible only on the homepage and only to the selected roles
- Once the end time has passed, the block should be hidden from the page. This could happen on page load too.

## Usage

- The module adds a block `Internal Event Details` which the adminstrators can manage
- The administrator user can update the message, add link(optional) and an end-time
- The administrator user can set the roles to which this block would be shown
- When the end time has passed, the block should not be shown on the page
