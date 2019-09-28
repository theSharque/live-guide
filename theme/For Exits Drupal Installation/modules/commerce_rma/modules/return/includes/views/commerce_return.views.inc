<?php

/**
 * @file
 * Provides support for the Views module.
 */

/**
 * Commerce Return entity Views definitions.
 */
class CommerceReturnViewsController extends EntityDefaultViewsController {
  /**
   * Override EntityDefaultViewsController::views_data().
   */
  public function views_data() {
    $data = parent::views_data();

    // Expose the owner uid.
    $data['commerce_return']['uid'] = array(
      'title' => t('Owner UID'),
      'help' => t("The owner's user ID."),
      'field' => array(
        'handler' => 'views_handler_field_user',
        'click sortable' => TRUE,
      ),
      'argument' => array(
        'handler' => 'views_handler_argument_user_uid',
        'name field' => 'name', // display this field in the summary
      ),
      'filter' => array(
        'title' => t('Name'),
        'handler' => 'views_handler_filter_user_name',
      ),
      'sort' => array(
        'handler' => 'views_handler_sort',
      ),
      'relationship' => array(
        'title' => t('Owner'),
        'help' => t("Relate this return to its owner's user account"),
        'handler' => 'views_handler_relationship',
        'base' => 'users',
        'base field' => 'uid',
        'field' => 'uid',
        'label' => t('Return owner'),
      ),
    );

    // Show the operations using CTools dropbutton menu.
    $data['commerce_return']['operations_dropbutton'] = array(
      'title' => t('Operations'),
      'help' => t('Show the operation links using dropbutton menu.'),
      'field' => array(
        'handler' => 'commerce_return_handler_field_operations_dropbutton',
      ),
      // This is a dummy field, so attach it to the ID column.
      'real field' => 'return_id',
    );

    // Alter the options callback for the status property.
    $data['commerce_return']['status']['field']['options callback'] = 'commerce_return_status_options_list_flat';
    $data['commerce_return']['status']['field']['options arguments'] = array();

    return $data;
  }
}

function commerce_return_views_data_alter(&$data) {
  $data['commerce_line_item']['commerce_return_status'] = array(
    'title' => t('Return status'),
    'help' => t('Show the status of the returned product.'),
    'field' => array(
      'handler' => 'commerce_line_item_handler_field_commerce_return_status'
    ),
    // This is a dummy field, so attach it to the ID column.
    'real field' => 'line_item_id',
  );

  $data['commerce_line_item']['commerce_return_method'] = array(
    'title' => t('Return method'),
    'help' => t('Show the customer return method for the returned product.'),
    'field' => array(
      'handler' => 'commerce_line_item_handler_field_commerce_return_method',
    ),
    // This is a dummy field, so attach it to the ID column.
    'real field' => 'line_item_id',
  );

  $data['commerce_line_item']['commerce_return_reason'] = array(
    'title' => t('Return reason'),
    'help' => t('Show the customer reason for the returned product.'),
    'field' => array(
      'handler' => 'commerce_line_item_handler_field_commerce_return_reason',
    ),
    // This is a dummy field, so attach it to the ID column.
    'real field' => 'line_item_id',
  );

  $data['commerce_line_item']['commerce_return_notes'] = array(
    'title' => t('Return Customer notes'),
    'help' => t('Display the customer notes for a returned product.'),
    'field' => array(
      'handler' => 'commerce_line_item_handler_field_commerce_return_notes',
    ),
    // This is a dummy field, so attach it to the line item ID column.
    'real field' => 'line_item_id',
  );
}
