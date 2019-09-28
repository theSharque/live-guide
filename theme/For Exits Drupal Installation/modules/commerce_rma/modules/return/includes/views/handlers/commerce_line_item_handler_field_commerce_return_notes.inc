<?php

/**
 * Field handler to display the customer notes for a returned product
 * found from a commerce_line_item entity.
 */
class commerce_line_item_handler_field_commerce_return_notes extends views_handler_field {

  function construct() {
    parent::construct();
    $this->additional_fields['data'] = 'data';

    // Set real_field in order to make it generate a field_alias.
    $this->real_field = 'data';
  }

  function render($values) {
    // Fetch data column and unserialize it.
    $data = unserialize($this->get_value($values, 'data'));

    return isset($data['commerce_return']['notes']) ? $data['commerce_return']['notes'] : '';
  }
}
