# Block Inactive User Accounts

## Description:

As part of tightening your website’s security, your organisation has decided to block user accounts that have not been active for more than 2 months. The user list could be large and to avoid timeouts, it is advisable to use a batch process to accomplish this.

## Acceptance Criteria:

- Add a button on the `/admin/people` page that says `Block Old Users`
- Identify the users who meet the criteria
- Run a batch process to block these users
- The batch process should reflect the progress and the status correctly
- Any errors encountered should be logged to Drupal watchdog

## Usage

- The module adds a button `Block Old Users` at the top of the `/admin/people` page, make sure you clear the cache if it doesn't.
- Clicking on the button will start a batch process that gets the list of users inactive for more than 2 months and blocks them.
