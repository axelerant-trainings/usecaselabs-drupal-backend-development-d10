# Store Leads for an Event

Create a custom table to store leads associated with events. Render it using
a view handler so it can be shown to the users. Fields: Lead ID (auto incremented), Event Node ID (Reference nid), Full Name(textfield) and Email.

## Acceptance Criteria

- Ensure you have a `Event` content type setup, to which these leads will link to.
- The custom database table should be setup on module install and be deleted on module uninstall.
- Expose the leads data to Drupal Views using custom view handlers.

## Uses
- This module add pages to create and edit lead - `/add-lead` & `/edit/{id}/lead`.
- It will create a content type Event.
- Lead can be created first and then assigned to event.
- For now we are keeping the things simple one Event can have one Lead.
- It also provide a permission to add edit lead data.
- It provide two views Event and Lead (Content) `/event-and-lead` and Lead Data (Leads and Event) `/lead-data`.

