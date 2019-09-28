<?php

function moderate_view( $form, &$form_state ) {
  $excursions = db_select('excursions', 'e')
    ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'reg_date', 'price' ) )
    ->condition('status', 0, '=' )
    ->orderBy('reg_date','DESC')
    ->execute()
    ->fetchAllAssoc('eid');

  if( count( $excursions ) ) {
    $form['tbl_e_title'] = array(
      '#markup' => t('Excursion need to moderate'),
    );

    $form['tbl_e_start'] = array(
      '#markup' => '<table>',
    );

    $form['tbl_e_head'] = array(
      '#markup' => '<tr><th>'.t('Date').'</th><th>'.t('Title').'</th><th>'.t('Price').'</th><th>'.t('Body').'</th></tr>',
    );

    foreach( $excursions as $eid => $line ) {
      $form['tbl_e_line_'.$eid] = array(
        '#markup' => '<tr><td>'.$line->reg_date.'</td><td>'.l($line->title, 'moderate/'.$eid.'/excursion').'</td><td>'.$line->price.'</td><td>'.substr( $line->body, 0, 80 ).'...</td></tr>',
      );
    }

    $form['tbl_e_end'] = array(
      '#markup' => '</table>',
    );
  }

  return $form;
}

function approve_excursion( $form, &$form_state, $eid ) {
  global $user;

  $excursion = db_select('excursions', 'e')
    ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'images', 'country', 'city', 'individual', 'duration', 'transfer', 'food', 'drinks', 'price', 'tags', 'phone', 'time', 'address', 'special' ) )
    ->condition('eid', $eid, '=' )
    ->execute()
    ->fetchAssoc();

  $images = unserialize( $excursion['images'] );

  $tags = array();
  foreach( unserialize( $excursion['tags'] ) as $tid ) {
    if( is_object( taxonomy_term_load( $tid ) ) ) {
      $tags[] = taxonomy_term_load( $tid )->name;
    }
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

  $form['phone'] = array(
    '#type' => 'item',
    '#title' => t( 'Contact phone' ),
    '#markup' => $excursion['phone'],
  );

  $form['time'] = array(
    '#type' => 'item',
    '#title' => t( 'Start time of excursion' ),
    '#markup' => $excursion['time'],
  );

  $form['address'] = array(
    '#type' => 'item',
    '#title' => t( 'Address of pickup point' ),
    '#markup' => $excursion['address'],
  );

  $form['special'] = array(
    '#type' => 'item',
    '#title' => t( 'Information' ),
    '#markup' => $excursion['special'],
  );

  $form['approve'] = array(
    '#type' => 'button',
    '#value' => t( 'Approve excursion' ),
  );

  $form['decline'] = array(
    '#type' => 'button',
    '#value' => t( 'Decline excursion' ),
  );

  return $form;
}

function approve_excursion_validate( $form, &$form_state ) {
  if( $form_state['values']['op'] == $form_state['values']['approve'] ) {
    db_update('excursions')
      ->fields( array(
          'status' => 1,
        )
      )
      ->condition('eid', $form_state['values']['eid'], '=' )
      ->execute();

  // todo Send emails!!!

  } else {
    db_update('excursions')
      ->fields( array(
          'status' => -1,
        )
      )
      ->condition('eid', $form_state['values']['eid'], '=' )
      ->execute();

  // todo Send emails!!!

  }

  drupal_goto( 'moderate' );
}
