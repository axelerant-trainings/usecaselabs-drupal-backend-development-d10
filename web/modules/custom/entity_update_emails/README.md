# Send personalised emails on entity updates

Your site needs to send email notifications to a predefined set of users every time an entity of type 'Article' is created or updated. The list of users could be huge and you don’t want your server to take a hit. Use a queue to stagger the email sending process.

## Acceptance Criteria

- Create a custom module to manage the email sending process using queue worker service of Drupal
- Add each email task to a queue, including the recipient’s email address and personalised message. The message should be of the type `An article with the title {title} has been {action} by {username}`. The title should link to that article page. 
- Implement a queue worker to send each email, using Drupal’s mail system.
- Ensure the queue worker handles email sending failures and logs it correctly to Drupal watchdog.
- Mailhog or a similar service could be used to verify the emails being sent.

## Steps to configure and check
- Run `ddev mailpit` command in terminal to open the mail inbox.
- Mails will trigger on cron run.
- Users having `Content Editor` role will only receive the mails.

## Uses
- On create or update of Article content mail will be added in the queue.
- On cron run mail will get from the queue and send to all the users of content editor role.
- Mail will be received in MailPit on local.

