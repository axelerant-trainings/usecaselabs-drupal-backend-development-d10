# Add ColourPicker field to Article content type

## Description:

You want the editors to select a colour they want as a background for the article body so that your frontend developers can use this value to style the article accordingly. The colour value should be HEX value stored in the field.

## Acceptance Criteria:

- Create a custom field that allows editors to select a colour using a colour picker
- This field type should store the colour value as a HEX value
- Validate the colour value to ensure it is in the correct format.
- The article page should display the value stored in this field

## Configuration

- The module adds a new field `Colourpicker HEX` which you can add to any entity type
- Add the field as you would for any other Drupal field. That's it!

## Usage

- The field when added adds a textfield to the entity form.
- Clicking on the field will open the colour picker using which you can select the desired colour.
- On entity save, the HEX value would be saved to the field.
