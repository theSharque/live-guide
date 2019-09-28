<?php

function order_list( $form, &$form_state ) {
  global $user;

  $status_dic = array(
    -3 => t('Canceled by guide'),
    -2 => t('Canceled by tourist'),
    -1 => t('Declined'),
     0 => t('Waiting for accept'),
     1 => t('Accepted'),
     2 => t('Finished')
  );

  $query = db_select('excursions', 'e');
  $query->innerJoin( 'deals', 'd', 'd.eid = e.eid' );
  $query->fields( 'e', array( 'title', 'body' ) )
    ->fields( 'd', array( 'did', 'uid_t', 'date', 'comment', 'status', 'price' ) )
    ->condition('uid_e', $user->uid, '=' )
    ->orderBy('d.reg_date','DESC');
  $result = $query->execute();
  $guide = $result->fetchAllAssoc('did');

  if( count( $guide ) ) {
    $form['tbl_g_title'] = array(
      '#markup' => t('Excursion that you guide'),
    );

    $form['tbl_g_start'] = array(
      '#markup' => '<table>',
    );

    $form['tbl_g_head'] = array(
      '#markup' => '<tr><th>'.t('Title').'</th><th>'.t('Price').'</th><th>'.t('Date').'</th><th>'.t('Status').'</th></tr>',
    );

    foreach( $guide as $did => $line ) {
      $form['tbl_g_line_'.$did] = array(
        '#markup' => '<tr><td>'.l($line->title, 'deal/'.$did.'/status').'</td><td>'.$line->price.'</td><td>'.$line->date.'</td><td>'.$status_dic[$line->status].'</td></tr>',
      );
    }

    $form['tbl_g_end'] = array(
      '#markup' => '</table>',
    );
  }

  $query = db_select('excursions', 'e');
  $query->innerJoin( 'deals', 'd', 'd.eid = e.eid' );
  $query->fields( 'e', array( 'title', 'body' ) )
    ->fields( 'd', array( 'did', 'uid_e', 'date', 'comment', 'status', 'price' ) )
    ->condition('uid_t', $user->uid, '=' )
    ->orderBy('d.reg_date','DESC');
  $result = $query->execute();
  $tourist = $result->fetchAllAssoc('did');

  if( count( $tourist ) ) {
    $form['tbl_t_title'] = array(
      '#markup' => t('Excursion you take'),
    );

    $form['tbl_t_start'] = array(
      '#markup' => '<table>',
    );

    $form['tbl_t_head'] = array(
      '#markup' => '<tr><th>'.t('Title').'</th><th>'.t('Price').'</th><th>'.t('Date').'</th><th>'.t('Status').'</th></tr>',
    );

    foreach( $tourist as $did => $line ) {
      $form['tbl_t_line_'.$did] = array(
        '#markup' => '<tr><td>'.l($line->title, 'deal/'.$did.'/status').'</td><td>'.$line->price.'</td><td>'.$line->date.'</td><td>'.$status_dic[$line->status].'</td></tr>',
      );
    }

    $form['tbl_t_end'] = array(
      '#markup' => '</table>',
    );
  }

  return $form;
}

function order_excursion( $form, &$form_state, $eid ) {
  $excursion = db_select('excursions', 'e')
    ->fields( 'e', array( 'eid', 'uid', 'title', 'body', 'country', 'city', 'duration', 'price' ) )
    ->condition('eid', $eid, '=' )
    ->execute()
    ->fetchAssoc();

  $form['eid'] = array(
    '#type' => 'value',
    '#value' => $eid,
  );

  $form['uid'] = array(
    '#type' => 'value',
    '#value' => $excursion['uid'],
  );

  $form['title_val'] = array(
    '#type' => 'value',
    '#value' => $excursion['title'],
  );

  $form['deal_price'] = array(
    '#type' => 'value',
    '#value' => $excursion['price'],
  );


  $form['title'] = array(
    '#type' => 'item',
    '#title' => t( 'Title' ),
    '#markup' => l( $excursion['title'], 'excursion/'.$eid.'/view' ),
  );

  $form['body'] = array(
    '#type' => 'item',
    '#title' => t( 'Description' ),
    '#markup' => $excursion['body'],
  );

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

  $form['duration'] = array(
    '#type' => 'item',
    '#title' => t( 'Duration' ),
    '#markup' => $excursion['duration'],
  );

  $form['price'] = array(
    '#type' => 'item',
    '#title' => t( 'Price' ),
    '#markup' => $excursion['price'],
  );

  $form['date'] = array(
     '#type' => 'date_popup',
     '#title' => t('Excursion date'),
     '#default_value' => date("Y-m-d"),
     '#date_format' => 'Y-m-d',
     '#date_label_position' => 'within',
     '#date_timezone' => 'America/Chicago',
     '#date_year_range' => '-1:+1',
  );

  $form['comment'] = array(
    '#type' => 'textarea',
    '#title' => t( 'Comment' ),
    '#description' => t('You can describe everthing you want. This comment will be sent to your guide with date for approve.'),
  );

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t( 'Send order' ),
  );

  return $form;
}

function order_excursion_submit( $form, &$form_state ) {
  global $user;

  $did = db_insert('deals')
    ->fields( array(
        'eid' => $form_state['values']['eid'],
        'uid_e' => $form_state['values']['uid'],
        'uid_t' => $user->uid,
        'status' => 0,
        'comment' => $form_state['values']['comment'],
        'date' => $form_state['values']['date'],
        'price' => $form_state['values']['deal_price'],
      )
    )
    ->execute();

  $recv = user_load( $form_state['values']['uid'] );
  drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
    'type' => 'excursion_g_order',
    'name' => $form_state['values']['title_val'],
    'eid' => $form_state['values']['eid'],
    'comment' => $form_state['values']['comment']
  ) );

  $recv = user_load( $user->uid );
  drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
    'type' => 'excursion_t_order',
    'name' => $form_state['values']['title_val'],
    'eid' => $form_state['values']['eid'],
    'comment' => $form_state['values']['comment']
  ) );

  $form_state['redirect'] = 'deal/'.$did.'/status';
}

function status_excursion( $form, &$form_state, $did ) {
  global $user;

  $query = db_select('excursions', 'e');
  $query->innerJoin( 'deals', 'd', 'd.eid = e.eid' );
  $query->fields( 'e', array( 'eid', 'title', 'body', 'phone', 'time', 'address', 'special' ) )
    ->fields( 'd', array( 'did', 'uid_e', 'uid_t', 'date', 'comment', 'status', 'phone', 'time', 'address', 'special', 'price' ) )
    ->condition('did', $did, '=' );
  $result = $query->execute();
  $excursion = $result->fetchAssoc();

  $form['did'] = array(
    '#type' => 'value',
    '#value' => $did,
  );

  $form['uid_t'] = array(
    '#type' => 'value',
    '#value' => $excursion['uid_t'],
  );

  $form['uid_e'] = array(
    '#type' => 'value',
    '#value' => $excursion['uid_e'],
  );

  $form['title_val'] = array(
    '#type' => 'value',
    '#value' => $excursion['title'],
  );

  $form['title'] = array(
    '#type' => 'item',
    '#title' => t( 'Title' ),
    '#markup' => l( $excursion['title'], 'excursion/'.$excursion['eid'].'/view' ),
  );

  $form['body'] = array(
    '#type' => 'item',
    '#title' => t( 'Description' ),
    '#markup' => $excursion['body'],
  );

  $form['date'] = array(
    '#type' => 'item',
    '#title' => t( 'Excursion date' ),
    '#markup' => $excursion['date'],
  );

  $form['price'] = array(
    '#type' => 'item',
    '#title' => t( 'Price' ),
    '#markup' => $excursion['price'],
  );

  $form['comment'] = array(
    '#type' => 'item',
    '#title' => t( 'Comment' ),
    '#markup' => $excursion['comment'],
  );

  if( $excursion['uid_e'] == $user->uid && $excursion['status'] == 0 ) {
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
      '#default_value' => $excursion['phone'],
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

  if( $excursion['status'] == 1 ) {
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
  }

  $status_dic = array(
    -3 => t('Canceled by guide'),
    -2 => t('Canceled by tourist'),
    -1 => t('Declined'),
     0 => t('Waiting for accept'),
     1 => t('Accepted'),
     2 => t('Finished')
  );

  $form['status'] = array(
    '#type' => 'item',
    '#title' => t( 'Status' ),
    '#markup' => $status_dic[$excursion['status']],
  );

  if( $excursion['status'] == 0 && $excursion['uid_e'] == $user->uid ) {
    $form['accept'] = array(
      '#type' => 'submit',
      '#value' => t( 'Accept' ),
    );

    $form['decline'] = array(
      '#type' => 'submit',
      '#value' => t( 'Decline' ),
    );
  } elseif( $excursion['status'] == 1 || $excursion['status'] == 2 ) {
    if( strtotime( $excursion['date'] ) > time() ) {
      $form['cancel'] = array(
        '#type' => 'submit',
        '#value' => t( 'Cancel' ),
      );
    } else {
      $need = db_select('deals_votes', 'v')
        ->fields( 'v', array( 'did', 'type', 'vote' ) )
        ->condition('did', $did, '=' )
        ->condition('uid', $user->uid, '=' )
        ->execute()
        ->fetchAllAssoc('type');

      if( $excursion['uid_t'] == $user->uid ) {
        if( !count($need) ) {
          $form['type'] = array(
            '#type' => 'value',
            '#value' => 0,
          );

          $form['excursion'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your excursion'),
            '#description' => t('Please rate the content of the tour, you will see whether all that awaited whether the description of the tour to what you see?'),
          );

          $form['guide'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your guide'),
            '#description' => t('Evaluate the performance of your guide as he led a tour, if all you like?'),
          );
        } else {
          $form['excursion'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your excursion'),
            '#default_value' => $need[1]->vote,
            '#description' => t('Please rate the content of the tour, you will see whether all that awaited whether the description of the tour to what you see?'),
          );

          $form['guide'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your guide'),
            '#default_value' => $need[2]->vote,
            '#description' => t('Evaluate the performance of your guide as he led a tour, if all you like?'),
          );
        }
      }

      if( $excursion['uid_e'] == $user->uid ) {
        if( !count($need) ) {
          $form['type'] = array(
            '#type' => 'value',
            '#value' => 1,
          );

          $form['tourist'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your tourist'),
            '#description' => t('Rate tourist behavior on tour, his punctuality and responsibility.'),
          );
        } else {
          $form['tourist'] = array(
            '#type' => 'fivestar',
            '#title' => t('Rate your tourist'),
            '#default_value' => $need[3]->vote,
            '#description' => t('Rate tourist behavior on tour, his punctuality and responsibility.'),
          );
        }
      }

      if( !count($need) ) {
        $form['vote'] = array(
          '#type' => 'submit',
          '#value' => t('Vote'),
        );
      }
    }
  }

  return $form;
}

function status_excursion_submit( $form, &$form_state ) {
  global $user;

  switch( $form_state['values']['op'] ) {
    case t( 'Accept' ):
      db_update('deals')
        ->fields( array(
            'status' => 1,
            'phone' => $form_state['values']['phone'],
            'time' => $form_state['values']['time'],
            'address' => $form_state['values']['address'],
            'special' => $form_state['values']['special'],
          )
        )
        ->condition('did', $form_state['values']['did'], '=' )
        ->execute();

// TODO Send emails!!!
      $recv = user_load( $form_state['values']['uid_e'] );
      drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
        'type' => 'excursion_g_accept',
        'name' => $form_state['values']['title_val'],
        'eid' => $form_state['values']['eid'],
      ) );

      $recv = user_load( $form_state['values']['uid_t'] );
      drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
        'type' => 'excursion_t_accept',
        'name' => $form_state['values']['title_val'],
        'eid' => $form_state['values']['eid'],
      ) );

      break;
   
    case t( 'Decline' ):
      db_update('deals')
        ->fields( array(
            'status' => -1,
          )
        )
        ->condition('did', $form_state['values']['did'], '=' )
        ->execute();

      $recv = user_load( $form_state['values']['uid_e'] );
      drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
        'type' => 'excursion_g_decline',
        'name' => $form_state['values']['title_val'],
        'eid' => $form_state['values']['eid'],
      ) );

      $recv = user_load( $form_state['values']['uid_t'] );
      drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
        'type' => 'excursion_t_decline',
        'name' => $form_state['values']['title_val'],
        'eid' => $form_state['values']['eid'],
      ) );

      break;

    case t( 'Cancel' ):
      if( $form_state['values']['uid_t'] == $user->uid ) {
        db_update('deals')
          ->fields( array(
              'status' => -2,
            )
          )
          ->condition('did', $form_state['values']['did'], '=' )
          ->execute();

        $recv = user_load( $form_state['values']['uid_e'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_g_cancel_t',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );

        $recv = user_load( $form_state['values']['uid_t'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_t_cancel_t',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );
      }

      if( $form_state['values']['uid_e'] == $user->uid ) {
        db_update('deals')
          ->fields( array(
              'status' => -3,
            )
          )
          ->condition('did', $form_state['values']['did'], '=' )
          ->execute();

        $recv = user_load( $form_state['values']['uid_e'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_g_cancel_g',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );

        $recv = user_load( $form_state['values']['uid_t'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_t_cancel_g',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );
      }
      break;

    case t( 'Vote' ):
      if( $form_state['values']['type'] == 0 ) {
        db_insert('deals_votes')
          ->fields( array(
              'did' => $form_state['values']['did'],
              'uid' => $user->uid,
              'type' => 1,
              'vote' => $form_state['values']['excursion'],
            )
          )
          ->execute();
    
        db_insert('deals_votes')
          ->fields( array(
              'did' => $form_state['values']['did'],
              'uid' => $user->uid,
              'type' => 2,
              'vote' => $form_state['values']['guide'],
            )
          )
          ->execute();

        $recv = user_load( $form_state['values']['uid_e'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_g_vote_t',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );

        $recv = user_load( $form_state['values']['uid_t'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_t_vote_t',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );
      } else {
        db_insert('deals_votes')
          ->fields( array(
              'did' => $form_state['values']['did'],
              'uid' => $user->uid,
              'type' => 3,
              'vote' => $form_state['values']['tourist'],
            )
          )
          ->execute();

        $recv = user_load( $form_state['values']['uid_e'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_g_vote_g',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );

        $recv = user_load( $form_state['values']['uid_t'] );
        drupal_mail( 'guide', date( 'His' ), $recv->mail, $recv->language, array(
          'type' => 'excursion_t_vote_g',
          'name' => $form_state['values']['title_val'],
          'eid' => $form_state['values']['eid'],
        ) );
      }

      break;
  }
}
