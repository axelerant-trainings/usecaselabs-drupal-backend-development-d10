/**
 * Provides a color picker for the fancier widget.
 */
(function ($) {
  Drupal.behaviors.colourPicker = {
    attach: function (context, settings) {
      $(".edit-field--colour-picker").on("focus", function (event) {
        const editField = this;
        const picker = $(this)
          .closest("div")
          .parent()
          .find(".field--colour-picker");
        // Hide all colour pickers except this one.
        $(".field--colour-picker").hide();
        $(picker).show();
        $.farbtastic(picker, function (color) {
          editField.value = color;
        }).setColor(editField.value);
      });
    },
  };
})(jQuery);
