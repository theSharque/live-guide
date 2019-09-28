<?php

function guide_excursion_view( $form, &$form_state ) {
  global $user;

  $query = db_select('excursions', 'e')
    ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'images', 'country', 'city', 'individual', 'duration', 'transfer', 'food', 'drinks', 'price', 'tags' ) )
    ->condition('status', 1, '=' );

  if( isset( $form_state['values'] ) ) {
    if( $form_state['values']['my'] ) {
      $query->condition('uid', $user->uid, '=');
    }

    if( $form_state['values']['country'] ) {
      $country = current( taxonomy_get_term_by_name( $form_state['values']['country'], 'country' ) )->tid;
      $query->condition('country', $country, '=');
    }

    if( $form_state['values']['city'] ) {
      $city = current( taxonomy_get_term_by_name( $form_state['values']['city'], 'cities' ) )->tid;
      $query->condition('city', $city, '=');
    }

    if( $form_state['values']['price_min'] ) {
      $price_min = str_replace( ',', '.', $form_state['values']['price_min'] );
      $query->condition('price', $price_min, '>');
    }

    if( $form_state['values']['price_max'] ) {
      $price_max = str_replace( ',', '.', $form_state['values']['price_max'] );
      $query->condition('price', $price_max, '<');
    }

    if( $form_state['values']['individual'] ) {
      $query->condition('individual', 1, '=');
    }

    if( $form_state['values']['transfer'] ) {
      $query->condition('transfer', 1, '=');
    }

    if( $form_state['values']['food'] ) {
      $query->condition('food', 1, '=');
    }

    if( $form_state['values']['drinks'] ) {
      $query->condition('drinks', 1, '=');
    }
  }

  $excursions = $query->execute()->fetchAllAssoc('eid');

  $form = array();

  $form['filter'] = array(
    '#type' => 'fieldset',
    '#title' => t('Filters'),
    '#collapsible' => TRUE, 
    '#collapsed' => TRUE,
  );

  $form['filter']['my'] = array(
    '#title' => t( 'Created by me' ),
    '#type' => 'checkbox',
    '#description' => t('Check this to see excursions that you guide.'),
  );

  $form['filter']['country'] = array(
    '#title' => t( 'Country' ),
    '#type' => 'textfield',
    '#maxlength' => 100,
    '#autocomplete_path' => 'taxonomy/autocomplete/field_country',
  );

  $form['filter']['city'] = array(
    '#title' => t( 'City' ),
    '#type' => 'textfield',
    '#maxlength' => 100,
    '#autocomplete_path' => 'taxonomy/autocomplete/field_city',
  );

  $form['filter']['price_max'] = array(
    '#type' => 'textfield',
    '#title' => t( 'Maximum price' ),
    '#maxlength' => 128,
    '#description' => t('Set your price in US$'),
  );

  $form['filter']['price_min'] = array(
    '#type' => 'textfield',
    '#title' => t( 'Minimum price' ),
    '#maxlength' => 128,
    '#description' => t('Set your price in US$'),
  );

  $form['filter']['individual'] = array(
    '#title' => t( 'Individual' ),
    '#type' => 'checkbox',
    '#description' => t('Check this if excursion for is individual and tourists not a part of group.'),
  );

  $form['filter']['transfer'] = array(
    '#title' => t( 'Transfer from and to hotel' ),
    '#type' => 'checkbox',
    '#default_value' => false,
    '#description' => t('Check this if you pickup tourist from hotel and drop back after excursion.'),
  );

  $form['filter']['food'] = array(
    '#title' => t( 'With food' ),
    '#type' => 'checkbox',
    '#default_value' => false,
    '#description' => t('Check this if breakfast, dinner or any other food available during the excursion. Describe in description.'),
  );

  $form['filter']['drinks'] = array(
    '#title' => t( 'With free drinks' ),
    '#type' => 'checkbox',
    '#default_value' => false,
    '#description' => t('Check this if any type of drinks available during the excursion. Describe in description.'),
  );

  $form['filter']['use'] = array(
    '#type' => 'button',
    '#value' => t( 'Filter' ),
  );

  $form['filter']['clear'] = array(
    '#type' => 'button',
    '#value' => t( 'Clear' ),
  );

  foreach( $excursions as $line ) {
    $form['excursion'.$line->eid] = array(
      '#markup' => guide_excursion_render( $line ),
    );
  }

  return $form;
}

function guide_excursion_view_validate( $form, &$form_state ) {
  if( $form_state['values']['op'] == t( 'Clear' ) ) {
    $form_state['input']['my'] = null;
    $form_state['input']['country'] = null;
    $form_state['input']['city'] = null;
    $form_state['input']['individual'] = null;
    $form_state['input']['transfer'] = null;
    $form_state['input']['food'] = null;
    $form_state['input']['drinks'] = null;
    $form_state['input']['price_min'] = null;
    $form_state['input']['price_max'] = null;
    $form_state['input']['tags'] = null;
  }
}

function guide_excursion_render( $data ) {
  $form = array();

  $images = unserialize( $data->images );

  $tags = array();
  foreach( unserialize( $data->tags ) as $tid ) {
    if( is_object( taxonomy_term_load( $tid ) ) ) {
      $tags[] = taxonomy_term_load( $tid )->name;
    }
  }

  $result = '<div class="excursion">';

  $form['title'] = array(
    '#type' => 'item',
    '#title' => t( 'Title' ),
    '#markup' => l( $data->title, 'excursion/'.$data->eid.'/view' ),
  );

  if( $images[0] ) {
    $image = file_load( $images[0] );

    $form['image1'] = array(
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  if( $images[1] ) {
    $image = file_load( $images[1] );

    $form['image2'] = array(
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  if( $images[2] ) {
    $image = file_load( $images[2] );

    $form['image3'] = array(
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  $form['body'] = array(
    '#type' => 'item',
    '#title' => t( 'Description' ),
    '#markup' => $data->body,
  );

  $form['country'] = array(
    '#type' => 'item',
    '#title' => t( 'Country' ),
    '#markup' => taxonomy_term_load( $data->country )->name,
  );

  $form['city'] = array(
    '#type' => 'item',
    '#title' => t( 'City' ),
    '#markup' => taxonomy_term_load( $data->city )->name,
  );

  $form['individual'] = array(
    '#type' => 'item',
    '#title' => t( 'Individual' ),
    '#markup' => $data->individual ? t('Individual') : t('Group'),
  );

  $form['duration'] = array(
    '#type' => 'item',
    '#title' => t( 'Duration' ),
    '#markup' => $data->duration,
  );

  $form['transfer'] = array(
    '#type' => 'item',
    '#title' => t( 'Transfer from and to hotel' ),
    '#markup' => $data->transfer ? t('With transfer') : t('No transfer'),
  );

  $form['food'] = array(
    '#type' => 'item',
    '#title' => t( 'With food' ),
    '#markup' => $data->food ? t('With food') : t('No food'),
  );

  $form['drinks'] = array(
    '#type' => 'item',
    '#title' => t( 'With free drinks' ),
    '#markup' => $data->drinks ? t('With drinks') : t('No drinks'),
  );

  $form['price'] = array(
    '#type' => 'item',
    '#title' => t( 'Price' ),
    '#markup' => $data->price,
  );

  $form['tags'] = array(
    '#type' => 'item',
    '#title' => t( 'Tags' ),
    '#markup' => implode( ', ', $tags ),
  );

  $result .= drupal_render( $form );

  $result .= '</div>';

  return $result;
}

function guide_excursion_edit( $form, &$form_state, $eid = null ) {
  global $user;

  $form = array();

  if( $eid === null ) {
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Title' ),
      '#maxlength' => 128,
      '#description' => t('Short name of excursion maximum 128 letters'),
      '#required' => true,
    );

    $form['body'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Description' ),
      '#rows' => 10,
      '#description' => t('Describe your excursion as good as you can. Minimum is 400 letters'),
      '#required' => true,
    );

    $form['image1'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 1' ),
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => true,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
    );

    $form['image2'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 2' ),
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
    );

    $form['image3'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 3' ),
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
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
      '#title' => t( 'City' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => $user->data['city'],
      '#autocomplete_path' => 'taxonomy/autocomplete/field_city',
      '#required' => true,
    );

    $form['individual'] = array(
      '#title' => t( 'Individual' ),
      '#type' => 'checkbox',
      '#default_value' => true,
      '#description' => t('Check this if excursion for is individual and tourists not a part of group.'),
    );

    $form['duration'] = array(
      '#title' => t( 'Duration' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#description' => t('Duration of excursion in hours or days.'),
    );

    $form['transfer'] = array(
      '#title' => t( 'Transfer from and to hotel' ),
      '#type' => 'checkbox',
      '#default_value' => false,
      '#description' => t('Check this if you pickup tourist from hotel and drop back after excursion.'),
    );

    $form['food'] = array(
      '#title' => t( 'With food' ),
      '#type' => 'checkbox',
      '#default_value' => false,
      '#description' => t('Check this if breakfast, dinner or any other food available during the excursion. Describe in description.'),
    );

    $form['drinks'] = array(
      '#title' => t( 'With free drinks' ),
      '#type' => 'checkbox',
      '#default_value' => false,
      '#description' => t('Check this if any type of drinks available during the excursion. Describe in description.'),
    );

    $form['price'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Price' ),
      '#maxlength' => 128,
      '#description' => t('Set your price in US$'),
      '#required' => true,
    );

    $form['tags'] = array(
      '#title' => t( 'Tags' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#autocomplete_path' => 'taxonomy/autocomplete/field_tags',
      '#required' => true,
    );

    $form['phone'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Contact phone' ),
      '#maxlength' => 128,
      '#description' => t('Please enter your local phone number for contact with you localy.'),
      '#required' => true,
    );

    $form['time'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Start time of excursion' ),
      '#maxlength' => 128,
      '#description' => t('Please enter exact time when you will meet tourist.'),
      '#required' => true,
    );

    $form['address'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Address of pickup point' ),
      '#maxlength' => 128,
      '#description' => t('Please enter address where you will meet tourist.'),
      '#required' => true,
    );

    $form['special'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Information' ),
      '#rows' => 10,
      '#description' => t('Any special information (special shoes, bags, somthing must have for this excursion)'),
    );
  } else {
    $excursion = db_select('excursions', 'e')
      ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'images', 'country', 'city', 'individual', 'duration', 'transfer', 'food', 'drinks', 'price', 'tags', 'phone', 'time', 'address', 'special' ) )
      ->condition('eid', $eid, '=' )
      ->condition('uid', $user->uid, '=' )
      ->execute()
      ->fetchAssoc();

    $images = unserialize( $excursion['images'] );

    $tags = array();
    foreach( unserialize( $excursion['tags'] ) as $tid ) {
      $tags[] = taxonomy_term_load( $tid )->name;
    }

    $form['warning'] = array(
      '#type' => 'item',
      '#title' => t( 'Warning' ),
      '#markup' => t( 'After you edit excursion it change status to unmoderated! It\'s desapear from all excursion until moderation!' ),
    );

    $form['eid'] = array(
      '#type' => 'value',
      '#value' => $eid,
    );

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Title' ),
      '#maxlength' => 128,
      '#default_value' => $excursion['title'],
      '#description' => t('Short name of excursion maximum 128 letters'),
      '#required' => true,
    );

    $form['body'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Description' ),
      '#rows' => 10,
      '#default_value' => $excursion['body'],
      '#description' => t('Describe your excursion as good as you can. Minimum is 400 letters'),
      '#required' => true,
    );

    $form['image1'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 1' ),
      '#default_value' => $images[0],
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => true,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
    );

    $form['image2'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 2' ),
      '#default_value' => $images[1],
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
    );

    $form['image3'] = array(
      '#type' => 'managed_file',
      '#title' => t( 'Image 3' ),
      '#default_value' => $images[2],
      '#description' => 'Image from or about this excursion. Maximum size of file is 2M bytes.',
      '#required' => false,
      '#upload_validators' => array(
        'file_validate_extensions' => array( 'jpg png gif' ),
        'file_validate_is_image',
        'file_validate_size' => array( 2048000 ),
      ),

      '#upload_location' => 'public://excursion/'.$user->uid,
    );

    $form['country'] = array(
      '#title' => t( 'Country' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => taxonomy_term_load( $excursion['country'] )->name,
      '#autocomplete_path' => 'taxonomy/autocomplete/field_country',
      '#required' => true,
    );

    $form['city'] = array(
      '#title' => t( 'City' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => taxonomy_term_load( $excursion['city'] )->name,
      '#autocomplete_path' => 'taxonomy/autocomplete/field_city',
      '#required' => true,
    );

    $form['individual'] = array(
      '#title' => t( 'Individual' ),
      '#type' => 'checkbox',
      '#default_value' => $excursion['individual'],
      '#description' => t('Check this if excursion for is individual and tourists not a part of group.'),
    );

    $form['duration'] = array(
      '#title' => t( 'Duration' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => $excursion['duration'],
      '#description' => t('Duration of excursion in hours or days.'),
    );

    $form['transfer'] = array(
      '#title' => t( 'Transfer from and to hotel' ),
      '#type' => 'checkbox',
      '#default_value' => $excursion['transfer'],
      '#description' => t('Check this if you pickup tourist from hotel and drop back after excursion.'),
    );

    $form['food'] = array(
      '#title' => t( 'With food' ),
      '#type' => 'checkbox',
      '#default_value' => $excursion['food'],
      '#description' => t('Check this if breakfast, dinner or any other food available during the excursion. Describe in description.'),
    );

    $form['drinks'] = array(
      '#title' => t( 'With free drinks' ),
      '#type' => 'checkbox',
      '#default_value' => $excursion['drinks'],
      '#description' => t('Check this if any type of drinks available during the excursion. Describe in description.'),
    );

    $form['price'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Price' ),
      '#maxlength' => 128,
      '#default_value' => $excursion['price'],
      '#description' => t('Set your price in US$'),
      '#required' => true,
    );

    $form['tags'] = array(
      '#title' => t( 'Tags' ),
      '#type' => 'textfield',
      '#maxlength' => 100,
      '#default_value' => implode( ', ', $tags ),
      '#autocomplete_path' => 'taxonomy/autocomplete/field_tags',
      '#required' => true,
    );

    $form['phone'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Contact phone' ),
      '#maxlength' => 128,
      '#default_value' => $excursion['phone'],
      '#description' => t('Please enter your local phone number for contact with you localy.'),
      '#required' => true,
    );

    $form['time'] = array(
      '#type' => 'textfield',
      '#title' => t( 'Start time of excursion' ),
      '#maxlength' => 128,
      '#default_value' => $excursion['time'],
      '#description' => t('Please enter exact time when you will meet tourist.'),
      '#required' => true,
    );

    $form['address'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Address of pickup point' ),
      '#maxlength' => 128,
      '#default_value' => $excursion['address'],
      '#description' => t('Please enter address where you will meet tourist.'),
      '#required' => true,
    );

    $form['special'] = array(
      '#type' => 'textarea',
      '#title' => t( 'Information' ),
      '#rows' => 10,
      '#default_value' => $excursion['special'],
      '#description' => t('Any special information (special shoes, bags, somthing must have for this excursion)'),
    );
  }

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => 'Save',
  );

  return $form;
}

function guide_excursion_edit_submit( $form, &$form_state ) {
  global $user;

  $images = serialize(
    array(
      $form_state['values']['image1'],
      $form_state['values']['image2'],
      $form_state['values']['image3'],
    )
  );

  $country = current( taxonomy_get_term_by_name( $form_state['values']['country'], 'country' ) )->tid;
  $city = current( taxonomy_get_term_by_name( $form_state['values']['city'], 'cities' ) )->tid;
  $price = str_replace( ',', '.', $form_state['values']['price'] );

  $tags = array();
  foreach( explode( ',', $form_state['values']['tags'] ) as $tag ) {
    $tags[] = current( taxonomy_get_term_by_name( $tag, 'tags' ) )->tid;
  }

  $tags = serialize( $tags );

  if( isset( $form_state['values']['eid'] ) ) {
    db_update('excursions')
      ->fields( array(
          'uid' => $user->uid,
          'status' => 0,
          'title' => $form_state['values']['title'],
          'body' => $form_state['values']['body'],
          'images' => $images,
          'country' => $country,
          'city' => $city,
          'individual' => $form_state['values']['individual'],
          'duration' => $form_state['values']['duration'],
          'transfer' => $form_state['values']['transfer'],
          'food' => $form_state['values']['food'],
          'drinks' => $form_state['values']['drinks'],
          'price' => $price,
          'tags' => $tags,
          'phone' => $form_state['values']['phone'],
          'time' => $form_state['values']['time'],
          'address' => $form_state['values']['address'],
          'special' => $form_state['values']['special'],
        )
      )
      ->condition('eid', $form_state['values']['eid'], '=' )
      ->execute();

    $eid = $form_state['values']['eid'];
  } else {
    $eid = db_insert('excursions')
      ->fields( array(
          'uid' => $user->uid,
          'status' => 0,
          'title' => $form_state['values']['title'],
          'body' => $form_state['values']['body'],
          'images' => $images,
          'country' => $country,
          'city' => $city,
          'individual' => $form_state['values']['individual'],
          'duration' => $form_state['values']['duration'],
          'transfer' => $form_state['values']['transfer'],
          'food' => $form_state['values']['food'],
          'drinks' => $form_state['values']['drinks'],
          'price' => $price,
          'tags' => $tags,
          'phone' => $form_state['values']['phone'],
          'time' => $form_state['values']['time'],
          'address' => $form_state['values']['address'],
          'special' => $form_state['values']['special'],
        )
      )
      ->execute();  
  }

  foreach( unserialize( $images ) as $fid ) {
    if( $fid ) {
      $file = file_load($fid);
      $file->status = FILE_STATUS_PERMANENT;
      file_save($file);

      file_usage_add($file, 'guide', 'excursion', $eid);  
    }
  }

  $form_state['redirect'] = 'excursion';
}

function guide_excursion_detail( $form, &$form_state, $eid ) {
  global $user;

  $excursion = db_select('excursions', 'e')
    ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'images', 'country', 'city', 'individual', 'duration', 'transfer', 'food', 'drinks', 'price', 'tags' ) )
    ->condition('eid', $eid, '=' )
    ->execute()
    ->fetchAssoc();

  $order = db_select('deals', 'e')
    ->fields( 'e', array( 'did' ) )
    ->condition('eid', $eid, '=' )
    ->condition('uid_t', $user->uid, '=' )
    ->condition('status', array( 0, 1 ), 'IN' )
    ->execute()
    ->fetchAssoc();

  $images = unserialize( $excursion['images'] );

  $tags = array();
  foreach( unserialize( $excursion['tags'] ) as $tid ) {
    $tags[] = taxonomy_term_load( $tid )->name;
  }

  $form['eid'] = array(
    '#type' => 'value',
    '#value' => $eid,
  );

  $form['title'] = array(
    '#type' => 'item',
    '#title' => t( 'Title' ),
    '#markup' => $excursion['title'],
  );

  $form['body'] = array(
    '#type' => 'item',
    '#title' => t( 'Description' ),
    '#markup' => $excursion['body'],
  );

  if( $images[0] ) {
    $image = file_load( $images[0] );

    $form['image1'] = array(
      '#type' => 'item',
      '#title' => t( 'Image 1' ),
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  if( $images[1] ) {
    $image = file_load( $images[1] );

    $form['image2'] = array(
      '#type' => 'item',
      '#title' => t( 'Image 1' ),
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  if( $images[2] ) {
    $image = file_load( $images[2] );

    $form['image3'] = array(
      '#type' => 'item',
      '#title' => t( 'Image 1' ),
      '#markup' => '<img src="'.image_style_url('thumbnail', $image->uri).'">',
    );
  }

  $form['country'] = array(
    '#type' => 'item',
    '#title' => t( 'Country' ),
    '#markup' => taxonomy_term_load( $excursion['country'] )->name,
  );

  $form['city'] = array(
    '#type' => 'item',
    '#title' => t( 'City' ),
    '#markup' => taxonomy_term_load( $excursion['city'] )->name,
  );

  $form['individual'] = array(
    '#type' => 'item',
    '#title' => t( 'Individual' ),
    '#markup' => $excursion['individual'] ? t('Individual') : t('Group'),
  );

  $form['duration'] = array(
    '#type' => 'item',
    '#title' => t( 'Duration' ),
    '#markup' => $excursion['duration'],
  );

  $form['transfer'] = array(
    '#type' => 'item',
    '#title' => t( 'Transfer from and to hotel' ),
    '#markup' => $excursion['transfer'] ? t('With transfer') : t('No transfer'),
  );

  $form['food'] = array(
    '#type' => 'item',
    '#title' => t( 'With food' ),
    '#markup' => $excursion['food'] ? t('With food') : t('No food'),
  );

  $form['drinks'] = array(
    '#type' => 'item',
    '#title' => t( 'With free drinks' ),
    '#markup' => $excursion['drinks'] ? t('With drinks') : t('No drinks'),
  );

  $form['price'] = array(
    '#type' => 'item',
    '#title' => t( 'Price' ),
    '#markup' => $excursion['price'],
  );

  $form['tags'] = array(
    '#type' => 'item',
    '#title' => t( 'Tags' ),
    '#markup' => implode( ', ', $tags ),
  );

  if( $excursion['uid'] == $user->uid ) {
    $form['button'] = array(
      '#type' => 'button',
      '#value' => t( 'Edit excursion' ),
    );
  } else {
    if( $order['did'] ) {
      $form['tags'] = array(
        '#type' => 'item',
        '#title' => t( 'Status' ),
        '#markup' => l( t( 'Already ordered' ), 'deal/'.$order['did'].'/status' ),
      );
    } else {
      $form['button'] = array(
        '#type' => 'button',
        '#value' => t( 'Order excursion' ),
      );
    }
  }

  return $form;
}

function guide_excursion_detail_validate( $form, &$form_state ) {
  if( $form_state['values']['op'] == t( 'Edit excursion' ) ) {
    drupal_goto( 'excursion/'.$form_state['values']['eid'].'/edit' );
  } else {
    drupal_goto( 'deal/'.$form_state['values']['eid'].'/order' );
  }
}
