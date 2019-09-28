<?php

function smilee_settings_form_submit(&$form, $form_state) {


    $image_fid3 = $form_state['values']['logo_title'];

    $image3 = file_load($image_fid3);

    if (is_object($image3)) {
// Check to make sure that the file is set to be persmileeent.
        if ($image3->status == 0) {
// Update the status.
            $image3->status = FILE_STATUS_PERMANENT;
// Save the update.
            file_save($image3);
// Add a reference to prevent warnings.
            file_usage_add($image3, 'smilee', 'theme', 1);
        }
    }
}

function smilee_form_system_theme_settings_alter(&$form, &$form_state) {

    $theme_path = drupal_get_path('theme', 'smilee');

    $form['#submit'][] = 'smilee_settings_form_submit';
// Get all themes.
    $themes = list_themes();
// Get the current theme
    $active_theme = $GLOBALS['theme_key'];
    $form_state['build_info']['files'][] = str_replace("/$active_theme.info", '', $themes[$active_theme]->filename) . '/theme-settings.php';

    $theme_path = drupal_get_path('theme', 'smilee');

    $form['settings'] = array(
        '#type' => 'vertical_tabs',
        '#title' => t('Theme settings'),
        '#weight' => 2,
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#attached' => array(
            'css' => array(drupal_get_path('theme', 'smilee') . '/css/drupalet_base/admin.css'),
            'js' => array(
                drupal_get_path('theme', 'smilee') . '/js/drupalet_admin/admin.js',
            ),
        ),
    );

    $form['settings']['general_setting'] = array(
        '#type' => 'fieldset',
        '#title' => t('General Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );

    $form['settings']['general_setting']['general_setting_tracking_code'] = array(
        '#type' => 'textarea',
        '#title' => t('Tracking Code'),
        '#default_value' => theme_get_setting('general_setting_tracking_code', 'smilee'),
    );
     $form['settings']['user_page'] = array(
        '#type' => 'fieldset',
        '#title' => t('User Page Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );
     
      $form['settings']['user_page']['sidebar_user'] = array(
        '#title' => t('User page sidebar'),
        '#type' => 'select',
        '#options' => array(
            'right' => t('Right sidebar '),
            'left' => t('Left sidebar'),
            'full' => t('Full width'),
        ),
        '#default_value' => theme_get_setting('sidebar_user', 'smilee'),
    );
    $form['settings']['switcher'] = array(
        '#type' => 'fieldset',
        '#title' => t('Switcher Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );

    $form['settings']['switcher']['disable_switch'] = array(
        '#title' => t('Switcher style'),
        '#type' => 'select',
        '#options' => array('on' => t('ON'), 'off' => t('OFF')),
        '#default_value' => theme_get_setting('disable_switch', 'smilee'),
    );
        $form['settings']['switcher']['site_layout'] = array(
        '#title' => t('Layout Style'),
        '#type' => 'select',
        '#options' => array(
            'wide' => t('Wide'),
            'boxed' => t('Boxed'),
        ),
        '#default_value' => theme_get_setting('site_layout', 'smilee')
    ); 
        
         $form['settings']['switcher']['background_image'] = array(
        '#title' => t('Background Image'),
        '#type' => 'radios',
        '#options' => array(
            'wood_pattern.png' => t('Bg1'),
            'shattered.png' => t('Bg2'),
            'vichy.png' => t('Bg3'),
            'random_grey_variations.png' => t('Bg4'),
            'irongrip.png' => t('Bg5'),
            'gplaypattern.png' => t('Bg6'),
            'diamond_upholstery.png' => t('Bg7'),
            'denim.png' => t('Bg8'),
            'crissXcross.png' => t('Bg9'),
            'climpek.png' => t('Bg10'),
        ),
        '#default_value' => theme_get_setting('background_image', 'smilee')
    );

         
    $form['settings']['switcher']['built_in_skins'] = array(
        '#title' => t('Built-in Skins'),
        '#type' => 'radios',
        '#options' => array(
            'grass-green.css' => t('Grass-green'),
            'green.css' => t('Green'),
            'turquoise.css' => t('Turquoise'),
            'blue.css' => t('Blue'),
            'klein-blue.css' => t('Klein-blue'),
            'purple.css' => t('Purple'),
            'pink.css' => t('Pink'),
            'red.css' => t('Red'),
            'orange.css' => t('Orange'),),
        '#default_value' => theme_get_setting('built_in_skins', 'smilee'),
    );


    $form['settings']['custom_css'] = array(
        '#type' => 'fieldset',
        '#title' => t('Custom CSS'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );

    $form['settings']['custom_css']['custom_css'] = array(
        '#type' => 'textarea',
        '#title' => t('Custom CSS'),
        '#default_value' => theme_get_setting('custom_css', 'smilee'),
        '#description' => t('<strong>Example:</strong><br/>h1 { font-family: \'Metrophobic\', Arial, serif; font-weight: 400; }')
    );



    $form['settings']['header_footer'] = array(
        '#type' => 'fieldset',
        '#title' => t('Header and footer settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );
    
    $form['settings']['header_footer']['header'] = array(
        '#type' => 'textarea',
        '#title' => t('Header Style Seting'),
          '#type' => 'select',
        '#options' => array(
            'style1' => t('Style1'),
            'style2' => t('Style2'),
            'style3' => t('Style3'),
            'style4' => t('Style4'),
            'style5' => t('Style5'),
            
        ),
        '#default_value' => theme_get_setting('header_style', 'smilee'),
    );

      $form['settings']['header_footer']['logo_title'] = array(
        '#title' => t('Logo title image'),
        '#type' => 'managed_file',
        '#required' => FALSE,
        '#upload_location' => 'public://bg-image/',
        '#default_value' => theme_get_setting('logo_title', 'smilee'),
    );
    $form['settings']['header_footer']['header_welcome'] = array(
        '#type' => 'textfield',
        '#title' => t('Welcome'),
        '#default_value' => theme_get_setting('header_welcome', 'smilee'),
    );
    

    $form['settings']['header_footer']['contact_mail'] = array(
        '#title' => t('Contact email'),
        '#type' => 'textfield',
        '#default_value' => theme_get_setting('contact_mail', 'smilee'),
    );

    $form['settings']['header_footer']['contact_phone'] = array(
        '#title' => t('Contact phone'),
        '#type' => 'textfield',
        '#default_value' => theme_get_setting('contact_phone', 'smilee'),
    );

 

    $form['settings']['blog'] = array(
        '#type' => 'fieldset',
        '#title' => t('Blog Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );



    $form['settings']['blog']['sidebar'] = array(
        '#title' => t('Blog sidebar'),
        '#type' => 'select',
        '#options' => array(
            'right' => t('Right sidebar'),
            'left' => t('Left sidebar'),
        ),
        '#default_value' => theme_get_setting('sidebar', 'smilee'),
    );
}
