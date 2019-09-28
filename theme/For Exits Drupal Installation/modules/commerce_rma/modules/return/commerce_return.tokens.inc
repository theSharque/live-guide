<?php
/**
 * Implements hook_token_info().
 */
function commerce_return_token_info() {
  $type = array(
    'name' => t('Returns'),
    'description' => t('Tokens related to individual commerce returns.'),
    'needs-data' => 'commerce_return',
  );

  // Core tokens for nodes.
  $commerce_return['return-id'] = array(
    'name' => t("Return ID"),
    'description' => t("The unique ID of the commerce_return."),
  );
  $commerce_return['return-number'] = array(
    'name' => t("Return number"),
    'description' => t("The unique Number of the commerce_return."),
  );
  $commerce_return['return-increment'] = array(
    'name' => t("Return increment by order"),
    'description' => t("Increment returns by commerce_order."),
  );
  $commerce_return['url:admin'] = array(
    'name' => t("View url of return for admin"),
    'description' => t("Url to access to return in back-office."),
  );
  $commerce_return['url:customer'] = array(
    'name' => t("View url of return for customer"),
    'description' => t("Url to access to return in front-office for customer."),
  );
  $commerce_return['url-edit:admin'] = array(
    'name' => t("Edit url of return in back-office"),
    'description' => t("Url to edit return in back-office."),
  );

  $commerce_return['owner'] = array(
    'name' => t('Owner'),
    'description' => t('The owner of the return.'),
    'type' => 'user',
  );
  $commerce_return['created'] = array(
    'name' => t("Date created"),
    'description' => t("The date the commerce_return was submitted."),
    'type' => 'date',
  );

  $commerce_return['changed'] = array(
    'name' => t("Date changed"),
    'description' => t("The date the commerce_return was updated."),
    'type' => 'date',
  );

  return array(
    'types' => array('commerce-return' => $type),
    'tokens' => array('commerce-return' => $commerce_return),
  );
}

/**
 * Implements hook_tokens().
 */
function commerce_return_tokens($type, $tokens, array $data = array(), array $options = array()) {
  $url_options = array('absolute' => TRUE);
  if (isset($options['language'])) {
    $url_options['language'] = $options['language'];
    $language_code = $options['language']->language;
  }
  else {
    $language_code = NULL;
  }

  $sanitize = !empty($options['sanitize']);

  $replacements = array();

  if ($type == 'commerce-return' && !empty($data['commerce-return'])) {
    $commerce_return = $data['commerce-return'];

    foreach ($tokens as $name => $original) {
      switch ($name) {
        case 'return-id':
          $replacements[$original] = $commerce_return->return_id;
          break;
        case 'return-number':
          $replacements[$original] = $sanitize ? check_plain($commerce_return->return_number) : $commerce_return->return_number;
          break;
        case 'return-increment':
          $replacements[$original] = count(commerce_return_get_existing_returns($commerce_return));
          break;

        // Default values for the chained tokens handled below.
        case 'owner':
          if ($commerce_return->uid == 0) {
            $name = variable_get('anonymous', t('Anonymous'));
          }
          else {
            $account = user_load($commerce_return->uid);
            $name = $account->name;
          }
          $replacements[$original] = $sanitize ? filter_xss($name) : $name;
          break;

        case 'url:admin':
          $commerce_return->uri_type = 'admin';
          $uri = $commerce_return->uri();
          $replacements[$original] = url($uri['path'], $url_options);
          break;
        case 'url:customer':
          $commerce_return->uri_type = 'customer';
          $uri = $commerce_return->uri();
          $replacements[$original] = url($uri['path'], $url_options);
          break;
        case 'url-edit:admin':
          $replacements[$original] = url('admin/commerce/store/returns/manage/' . $commerce_return->return_id . '/edit', $url_options);
          break;
        case 'created':
          $replacements[$original] = format_date($commerce_return->created, 'medium', '', NULL, $language_code);
          break;

        case 'changed':
          $replacements[$original] = format_date($commerce_return->changed, 'medium', '', NULL, $language_code);
          break;
      }
    }

    if ($owner_tokens = token_find_with_prefix($tokens, 'owner')) {
      $owner = user_load($commerce_return->uid);
      $replacements += token_generate('user', $owner_tokens, array('user' => $owner), $options);
    }

    foreach (array('created', 'changed') as $date) {
      if ($created_tokens = token_find_with_prefix($tokens, $date)) {
        $replacements += token_generate('date', $created_tokens, array('date' => $commerce_return->{$date}), $options);
      }
    }
  }

  return $replacements;
}
