<?php

global $base_url;

$setting_skin = theme_get_setting('built_in_skins', 'smilee');
if (!empty($setting_skin)) {
    $skin_color = '/css/color-scheme/' . $setting_skin;
} else {
    $skin_color = '/css/style.css';
}

$css_skin = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array(// Set up an array of attributes inside the tag
        'href' => $base_url . '/' . path_to_theme() . $skin_color,
        'rel' => 'stylesheet',
        'type' => 'text/css',
        'id' => 'site-color',
        'data-baseurl' => $base_url . '/' . path_to_theme()
    ),
    '#weight' => 4,
);

drupal_add_html_head($css_skin, 'skin');

function smilee_preprocess_html(&$variables) {
    //-- Google web fonts -->
    drupal_add_css('http://fonts.googleapis.com/css?family=Raleway:400,200,100,300,500,600,700,800,900', array('type' => 'external'));
    drupal_add_css('http://fonts.googleapis.com/css?family=Lato:400,100,300,300italic,700,900', array('type' => 'external'));
    drupal_add_css('http://fonts.googleapis.com/css?family=Montserrat:400,700', array('type' => 'external'));
    drupal_add_css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css', array('type' => 'external'));
    drupal_add_js('https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false', array('type' => 'external'));
}

function smilee_alpha_preprocess_page(&$vars) {
    if (!empty($vars['page']['#views_contextual_links_info'])) {
        $key = array_search('contextual-links-region', $vars['attributes_array']['class']);
        if ($key !== FALSE) {
            unset($vars['attributes_array']['class'][$key]);

            // Add the JavaScript, with a group and weight such that it will run
            // before modules/contextual/contextual.js.
            drupal_add_js(drupal_get_path('module', 'views') . '/js/views-contextual.js', array('group' => JS_LIBRARY, 'weight' => -1));
        }
    }
}

function smilee_preprocess_page(&$vars) {

    if (isset($vars['node'])) {
        $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
    }
//    print $vars['node']->type ;
    //Taxonomy page
    if (arg(0) == 'taxonomy') {
        $vars['theme_hook_suggestions'][] = 'page__taxonomy';
    }
     if (arg(0) == 'user') {
        $vars['theme_hook_suggestions'][] = 'page__user';
    }

    //View template
    if (views_get_page_view()) {
        $vars['theme_hook_suggestions'][] = 'page__view';
    }

    drupal_add_js('jQuery.extend(Drupal.settings, { "pathToTheme": "' . base_path() . path_to_theme() . '" });', 'inline');
}

function smilee_preprocess_node(&$vars) {
    unset($vars['content']['links']['statistics']['#links']['statistics_counter']['title']);
}

function smilee_css_alter(&$css) {
//    unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
//    unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
//	unset($css[drupal_get_path('module', 'system') . '/system.base.css']);
}

function smilee_form_alter(&$form, &$form_state, $form_id) {
    if ($form_id == 'search_block_form') {
        $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
        $form['search_block_form']['#default_value'] = t(''); // Set a default value for the textfield

        $form['search_block_form']['#attributes']['class'] = array("form-search__input form-control");
        $form['search_block_form']['#attributes']['placeholder'] = array("Keyword ...");
        //disabled submit button
        //unset($form['actions']['submit']);
        unset($form['search_block_form']['#title']);
    }

    if ($form_id == 'comment_form') {
        $form['comment_filter']['format'] = array(); // nuke wysiwyg from comments
    }
}

function smilee_preprocess_file_entity(&$variables) {
    if ($variables['type'] == 'image') {

        // Alt Text
        if (!empty($variables['field_media_alt_text'])) {
            $variables['content']['file']['#alt'] = $variables['field_media_alt_text']['und'][0]['safe_value'];
        }

        // Title
        if (!empty($variables['field_media_title'])) {
            $variables['content']['file']['#title'] = $variables['field_media_title']['und'][0]['safe_value'];
        }
    }
}

/* function smilee_menu_tree__main_menu(array $variables) {
  return '<ul class="pi-menulist ul-mainmenu">' . $variables['tree'] . '</ul>';
  }
 */

function smilee_menu_tree__main_menu(array $variables) {

    return '<ul class="nav navbar-nav">' . $variables['tree'] . '</ul>';
}

function smilee_menu_tree__menu_menu_2(array $variables) {

    return '<ul>' . $variables['tree'] . '</ul>';
}
function smilee_menu_tree__user_menu(array $variables) {

    return  $variables['tree'];
}

function smilee_menu_link(array $variables) {
    $element = $variables['element'];
    $sub_menu = '';
    if ($element['#original_link']['menu_name'] == 'main-menu') {

        if ($element['#below'] && $element['#original_link']['depth'] == 1) {
            unset($element['#below']['#theme_wrappers']);

            $sub_menu = '<ul  role="menu" class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
            $element['#localized_options']['attributes']['class'][] = "dropdown-toggle";
            $element['#localized_options']['attributes']['data-toggle'][] = "dropdown";
            $element['#localized_options']['attributes']['role'][] = "button";
            $element['#localized_options']['attributes']['aria-expanded'][] = "false";
            $output = l($element['#title'], $element['#href'], $element['#localized_options']);

            return '<li' . drupal_attributes($element ['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
        } else {
            if ($element['#below']) {
                $sub_menu = drupal_render($element['#below']);
            }
        }
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    }elseif (($element['#original_link']['menu_name'] == 'user-menu')) {
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
          return   $output. "\n";
    } else {
        if ($element['#below']) {
            $sub_menu = drupal_render($element['#below']);
        }
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    }

    return '<li' . drupal_attributes($element ['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function smilee_form_comment_form_alter(&$form, &$form_state, $form_id) {
    $form['comment_body']['#after_build'][] = 'smilee_customize_comment_form';
    switch ($form_id) {
        case 'comment_node_blog_form':

            $form['your_comment']['subject'] = $form['subject'];
            unset($form['subject']);
            $form['your_comment']['subject']['#access'] = FALSE;

            //Comment
            $form['your_comment']['comment_body'] = $form['comment_body'];
            unset($form['comment_body']);
            $form['#attributes']['class'][] = "reply-form";
            $form['author']['name']['#title'] = FALSE;
            $form['author']['name']['#attributes']['placeholder'] = array("Name *");
            $form['author']['name']['#attributes']['class'] = array("input-md form-control");

            $form['author']['title']['#access'] = FALSE;
            $form['author']['mail']['#title'] = FALSE;
            $form['author']['mail']['#attributes']['placeholder'] = array("Email *");
            $form['author']['mail']['#attributes']['class'] = array("input-md form-control");
            $form['author']['mail']['#description'] = FALSE;

            $form['author']['mail']['#access'] = TRUE;
            $form['author']['name']['#access'] = TRUE;
            $form['author']['homepage']['#access'] = TRUE;
            $form['author']['homepage']['#attributes']['placeholder'] = array("Website");
            $form['author']['homepage']['#attributes']['class'] = array("input-md form-control");
            $form['author']['homepage']['#title'] = FALSE;



//    $form['your_comment']['comment_body']['#attributes']['placeholder'] = array("your comment *");
            $form['author']['mail']['#required'] = TRUE;
            $form['author']['name']['#required'] = TRUE;
            $form['author']['name']['#required'] = TRUE;

            $form['actions']['submit']['#value'] = 'Submit Comment';
            $form['actions']['submit']['#attributes']['class'] = array("btn-black");
            $form['actions']['preview']['#access'] = FALSE;
//    

            break;
        default :
            
            $form['your_comment']['subject'] = $form['subject'];
            unset($form['subject']);
            $form['your_comment']['subject']['#access'] = FALSE;

            //Comment
            $form['your_comment']['comment_body'] = $form['comment_body'];
            unset($form['comment_body']);
            $form['#attributes']['class'][] = "reply-form";
            $form['author']['name']['#access'] = TRUE;
            $form['author']['name']['#attributes']['class'] = array("input-md form-control");

            $form['author']['mail']['#access'] = FALSE;
            
            $form['author']['homepage']['#access'] = FALSE;     
//    $form['your_comment']['comment_body']['#attributes']['placeholder'] = array("your comment *");
            $form['author']['mail']['#required'] = TRUE;
            $form['author']['name']['#required'] = TRUE;

            $form['actions']['submit']['#value'] = 'Submit';
            $form['actions']['submit']['#attributes']['class'] = array("btn-black");
            $form['actions']['preview']['#access'] = FALSE;
            break;
    }
}

function smilee_customize_comment_form(&$form) {
    $form[LANGUAGE_NONE][0]['format']['#access'] = FALSE;
    return $form;
}

function smilee_field__field_categories(&$variables) {
    $output = '';

    // Render the label if it's not hidden.
    if (!$variables['label_hidden']) {
        $output .= '<div class="field-label"' . $variables['title_attributes'] . '>' . $variables['label'] . ':&nbsp;</div>';
    }

    // Render the items.
    $index = 0;
    $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
    foreach ($variables['items'] as $delta => $item) {
        $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
        $output .= ($index ? ',' : '') . ' <div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
        $index++;
    }
    $output .= '</div>';

    // Render the top-level div.
    if (isset($variables["atributes"])) {
        $output = '<div class="' . $variables['classes'] . '"' . $variables['atributes'] . '>' . $output . '</div>';
    }

    return $output;
}

function smilee_breadcrumb($variables) {
    $crumbs = '';
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        $crumbs .= '<ul>';
        foreach ($breadcrumb as $value) {

            $crumbs .= '<li>' . $value . '</li>';
        }
        $crumbs .= '<li>' . drupal_get_title() . '</li>';
        return $crumbs . '</ul>';
    } else {
        return NULL;
    }
}

function single_navigation($ntype, $nid, $nav) {
    $current_node = node_load($nid);

    $prev_nid = db_query("SELECT n.nid FROM {node} n WHERE n.type = :type AND n.status = 1 AND n.created < :created  ORDER BY n.created DESC LIMIT 1", array(':created' => $current_node->created, ':type' => $ntype))->fetchField();


    $next_nid = db_query("SELECT n.nid FROM {node} n WHERE n.type = :type AND n.status = 1 AND n.created > :created LIMIT 1", array(':created' => $current_node->created, ':type' => $ntype))->fetchField();
    $link = '';

    if ($prev_nid > 0 && $nav == 'prev') {
        $node = node_load($prev_nid);
        $link .= '<a href="' . url("node/" . $node->nid) . '" class="post-nav__item"><i class="icon icon-arrow-left"></i><span class="post-nav__name">previous article</span></a>';
    } elseif ($next_nid > 0 && $nav == 'next') {
        $node = node_load($next_nid);
        $link .= '<a href="' . url("node/" . $node->nid) . '" class="post-nav__item"><span class="post-nav__name">next article</span><i class="icon icon-arrow-right"></i></a>';
    }
    return $link;
}
