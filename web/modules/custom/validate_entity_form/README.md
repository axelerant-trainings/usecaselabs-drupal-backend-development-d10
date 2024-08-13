# Validate Entity Forms

## Description:

Given an Employee content type with fields: ID(integer), Name, Department(select list), Date of Joining, add validation constraint for ID field. Make ID field as unique.

## Acceptance Criteria:

- Custom validation rules are defined and implemented for specific forms only.
- Validation errors are displayed to users with clear messages.
- Forms with custom validation are tested for functionality and accuracy.
- Data integrity is maintained through the validation process.

## Usage

- The module adds a validation to check for unique values on the ID field of the Employee content type.
- Add a node of type `Employee` with ID 1
- Add another node of type `Employee` with ID 1. You should see a validation message that says `1 is not unique`
- Update the ID to 2 and you should be able to save the form.
