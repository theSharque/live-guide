<!DOCTYPE html>
<html lang="<?php print $language->language; ?>">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <title><?php print $head_title; ?></title>

        <?php
        print $styles;
        print $head;
        ?>

        <?php
        //Tracking code

        $tracking_code = theme_get_setting('general_setting_tracking_code', 'smilee');

        print $tracking_code;

        //Custom css

        $custom_css = theme_get_setting('custom_css', 'smilee');

        if (!empty($custom_css)):
            ?>

            <style type="text/css" media="all">
    <?php print $custom_css; ?>
            </style>

            <?php
        endif;
        ?>

    </head>
    <?php
    $bg_image = theme_get_setting('background_image', 'smilee');
   
        $background_image = "/images/pattern/" . $bg_image;
    
    ?>
    <body class = "<?php print $classes; ?>" <?php print $attributes; ?> data-bg='<?php print $background_image; ?>'>

        <!-- PRELOADER -->
        <div id="loader"></div>
        <!-- Loader end -->

        <div id="skip-link">
            <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
        </div>
        <?php print $page_top; ?><?php print $page; ?><?php print $page_bottom; ?>

        <div id="backtotop"><i class="fa fa-chevron-up"></i></div>
            <?php
            $disable_switch = theme_get_setting('disable_switch', 'smilee');
            if ($disable_switch == 'on') {
                require_once(drupal_get_path('theme', 'smilee') . '/tpl/switcher.tpl.php');
            }
            ?>

        <?php print $scripts; ?>
      
    </body>

</html>

