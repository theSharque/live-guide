<?php

function guide_user( $form, &$form_state ) {
  global $user;

  $form = array();

  $form['login'] = array(
    '#type' => 'item',
    '#title' => t( 'Login' ),
    '#markup' => $user->name,
  );

  $form['firstname'] = array(
    '#type' => 'item',
    '#title' => t( 'Firstname' ),
    '#markup' => $user->data['firstname'],
  );

  $form['lastname'] = array(
    '#type' => 'item',
    '#title' => t( 'Lastname' ),
    '#markup' => $user->data['lastname'],
  );

  if( $user->picture ) {
    $image = file_load( $user->picture );

    $form['photo'] = array(
      '#type' => 'item',
      '#title' => t( 'Photo' ),
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  $form['country'] = array(
    '#title' => t( 'Country' ),
    '#type' => 'item',
    '#markup' => $user->data['country'],
  );

  $form['city'] = array(
    '#title' => t( 'City' ),
    '#type' => 'item',
    '#markup' => $user->data['city'],
  );

  $form['email'] = array(
    '#type' => 'item',
    '#title' => t( 'Contact e-mail' ),
    '#markup' => $user->mail,
  );

  $form['paypal'] = array(
    '#type' => 'item',
    '#title' => t( 'PayPal e-mail' ),
    '#markup' => $user->data['paypal'],
  );

  return $form;
}

function guide_user_edit( $form, &$form_state, $new = true ) {
  global $user;

  $form = array();

  if( $new && $user->uid == 0 ) {
    $form['login'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Login' ),
      '#required' => true,
    );

    $form['firstname'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Firstname' ),
      '#required' => true,
    );

    $form['lastname'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Lastname' ),
      '#required' => true,
    );

    $form['picture'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Photo' ),
      '#description' => 'The uploaded image will be displayed on this page using the image style choosen below. Maximum size of file is 262144 bytes.',
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 262144 ),
      ),

      '#upload_location' => 'public://users',
    );

    $form['country'] = array(
      '#title' => t( 'Country' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#autocomplete_path' => 'taxonomy/autocomplete/field_country',
      '#required' => true,
    );

    $form['city'] = array(
      '#title' => t( 'City' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#autocomplete_path' => 'taxonomy/autocomplete/field_city',
      '#required' => true,
    );

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Contact e-mail' ),
      '#required' => true,
    );

    $form['paypal'] = array(
      '#type' => 'textfield',
      '#title' => t( 'PayPal e-mail' ),
      '#required' => true,
    );

    $form['pass'] = array(
      '#type' => 'password_confirm',
      '#required' => true,
    );
  }

  if( !$new && $user->uid ) {
    $form['login'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Login' ),
      '#default_value' => $user->name,
      '#required' => true,
    );

    $form['firstname'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Firstname' ),
      '#default_value' => $user->data['firstname'],
      '#required' => true,
    );

    $form['lastname'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Lastname' ),
      '#default_value' => $user->data['lastname'],
      '#required' => true,
    );

    $form['picture'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Photo' ),
      '#description' => 'The uploaded image will be displayed on this page using the image style choosen below. Maximum size of file is 262144 bytes.',
      '#default_value' => $user->picture,
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 262144 ),
      ),

      '#upload_location' => 'public://users',
    );

    $form['country'] = array(
      '#title' => t( 'Country' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => $user->data['country'],
      '#autocomplete_path' => 'taxonomy/autocomplete/field_country',
      '#required' => true,
    );

    $form['city'] = array(
      '#title' => t('City'),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => $user->data['city'],
      '#autocomplete_path' => 'taxonomy/autocomplete/field_city',
      '#required' => true,
    );

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Contact e-mail' ),
      '#default_value' => $user->mail,
      '#required' => true,
    );

    $form['paypal'] = array(
      '#type' => 'textfield',
      '#title' => t( 'PayPal e-mail' ),
      '#default_value' => $user->data['paypal'],
      '#required' => true,
    );

    $form['pass'] = array(
      '#type' => 'password_confirm',
      '#description' => 'Leave blank if you don\'t wish to change it.',
    );
  }

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => 'Save',
  );

  return $form;
}

function guide_user_edit_validate( $form, &$form_state ) {
  // Check e-mail
  if( !valid_email_address( $form_state['values']['email'] ) ) {
    form_set_error('error', t('E-mail is incorrect.'));
  }

  // Check PayPal e-mail
  if( !valid_email_address( $form_state['values']['paypal'] ) ) {
    form_set_error('error', t('PayPal e-mail is incorrect.'));
  }
}

function guide_user_edit_submit( $form, &$form_state ) {
  global $user;

  if( $user->uid > 0 ) {
    $newUser = array(
      'name' => $form_state['values']['login'],
      'mail' => $form_state['values']['email'],
      'status' => 1,
      'init' => $form_state['values']['email'],
      'data' => array(
        'firstname' => $form_state['values']['firstname'],
        'lastname' => $form_state['values']['lastname'],
        'paypal' => $form_state['values']['paypal'],
        'country' => $form_state['values']['country'],
        'city' => $form_state['values']['city'],
      ),
    );

    if( $form_state['values']['pass'] ) {
      $newUser['pass'] = $form_state['values']['pass'];
    }

    if( $user->picture ) {
      $newUser['picture'] = file_load( $user->picture );
    }

    $tmpUser = user_save($user, $newUser);
  } else {
    $newUser = array(
      'name' => $form_state['values']['login'],
      'pass' => $form_state['values']['pass'],
      'mail' => $form_state['values']['email'],
      'status' => 1,
      'init' => $form_state['values']['email'],
      'data' => array(
        'firstname' => $form_state['values']['firstname'],
        'lastname' => $form_state['values']['lastname'],
        'paypal' => $form_state['values']['paypal'],
        'country' => $form_state['values']['country'],
        'city' => $form_state['values']['city'],
      ),
    );

    $tmpUser = user_save(null, $newUser);
  }

  if( $form_state['input']['picture']['fid'] ) {
    $newUser['picture'] = file_load( $form_state['input']['picture']['fid'] );
    $tmpUser = user_save($tmpUser, $newUser);
  }

  $user = user_load( $tmpUser->uid );
  $login_array = array ('name' => $user->name);
  user_login_finalize($login_array);

  $form_state['redirect'] = 'guide/profile';
}

function guide_user_login( $form, &$form_state ) {
  $form['login'] = array(
    '#type' => 'textfield',
    '#title' => t( 'Login' ),
    '#required' => true,
  );

  $form['pass'] = array(
    '#type' => 'password',
    '#title' => 'User password retype',
    '#required' => true,
  );

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => 'Save',
  );

  return $form;
}

function guide_user_login_validate( $form, &$form_state ) {
  if( !user_authenticate($form_state['values']['login'], $form_state['values']['pass']) ) {
    form_set_error('error', t('Login or password incorrect.'));
  }
}

function guide_user_login_submit( $form, &$form_state ) {
  if ($uid = user_authenticate($form_state['values']['login'], $form_state['values']['pass'])) {
    global $user;
    $user = user_load($uid);

    $login_array = array ('name' => $form_state['values']['login']);
    user_login_finalize($login_array);
  }

  $form_state['redirect'] = 'guide/profile';
}
