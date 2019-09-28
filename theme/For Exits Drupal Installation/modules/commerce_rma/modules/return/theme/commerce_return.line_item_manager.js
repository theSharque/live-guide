// Simple javascript snippet to check/uncheck all checkboxes from the line item
// manager widget.
(function ($) {
  Drupal.behaviors.commercereturn = {
    attach: function (context, settings) {
      jQuery('#return-line-item-manager .select-all').click(
        function () {
          var checkbox = jQuery('#return-line-item-manager tbody input.form-checkbox');
          if (this.checked) {
            checkbox.attr('checked', true);
            checkbox.prop('checked', true);
          }
          else {
            checkbox.attr('checked', false);
            checkbox.prop('checked', false);
          }
        }
      );
    }
  };
})(jQuery);
