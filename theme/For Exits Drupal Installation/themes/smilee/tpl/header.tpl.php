<?php
$background_image = theme_get_setting('logo_title', 'smilee');
if (isset(file_load($background_image)->uri)) {
    $url_background_image = file_create_url(file_load($background_image)->uri);
} else {
    $url_background_image = '';
}
?>
<input type="hidden" value="<?php print $background_image; ?>" id="background-image" />

<?php global $base_url; ?>
<?php
if (isset($node->field_header_style) && !empty($node->field_header_style)) {
    $header_style = $node->field_header_style['und'][0]['value'];
} else {
    $header_style = 'style1';
}

$header_welcome = theme_get_setting('header_welcome', 'smilee');
$contact_mail = theme_get_setting('contact_mail', 'smilee');
$contact_phone = theme_get_setting('contact_phone', 'smilee');

if (isset($node->field_header_style) && !empty($node->field_header_style)) {
    $header_style = $node->field_header_style['und'][0]['value'];
} else {
    $header_style = theme_get_setting('header_style', 'smilee');
}
if ($header_style == "") {
    $header_style = 'style1';
}
if ($header_style == 'style2'):
    $headerid = "home2";
    $headerclass = "header2";
elseif ($header_style == "style3"):
    $headerid = "home2";
    $headerclass = "home3";
elseif ($header_style == "style4"):
    $headerid = "home4";
    $headerclass = "";
elseif ($header_style == "style5"):
    $headerid = "home5";
    $headerclass = "";
else:
    $headerid = "none";
    $headerclass = "";
endif;
$boxed = theme_get_setting('site_layout', 'smilee');
if ($boxed == "boxed") {
    $boxed = "boxed";
} else {
    $boxed = '';
}
?>
<div class=" <?php print $headerclass ?> body <?php print $boxed; ?>" id="<?php print $headerid; ?>" >
    <?php if ($header_style == 'style1'): ?>
        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tb_left pull-left">
                                <p><?php print $header_welcome; ?></p>
                            </div>
                            <div class="tb_center pull-left">
                                <ul>
                                    <li><?php print $contact_phone; ?></li>
                                    <li><?php print $contact_mail; ?></li>
                                </ul>
                            </div>
                            <div class="tb_right pull-right">
                                <ul>
                                    <li>
                                        <div class="tbr-info">
                                            <span>Account <i class="fa fa-caret-down"></i></span>
                                            <div class="tbr-inner">
                                                <?php if ($page['user_menu']): ?>
                                                    <?php print render($page['user_menu']); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <header>
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="row">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!-- Logo -->
                            <a class="navbar-brand" href="<?php print $base_url; ?>"><img src="<?php print $logo; ?>" class="img-responsive" alt="<?php print $site_name; ?>"/></a>
                        </div>
                        <!-- Cart & Search -->
                        <div class="header-xtra pull-right">
                            <!--region shopping cart-->
                            <?php if ($page['shopping_cart']): ?>
                                <div class="topcart">
                                    <span class="span-class">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    <div class="cart-info">

                                        <?php print render($page['shopping_cart']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($page['search']): ?>
                                <div class="topsearch">
                                    <span class="span-class">
                                        <i class="fa fa-search"></i>
                                    </span>

                                    <?php print render($page['search']); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Navmenu -->
                        <?php if ($page['main_menu']): ?>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <div class="navbar-right">
                                    <?php print render($page['main_menu']); ?>    
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </header>
    <?php elseif ($header_style == 'style2'): ?>

        <!-- TOPBAR -->
        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tb_center pull-left">
                                <ul>
                                    <li><?php print $contact_phone; ?></li>
                                    <li><?php print $contact_mail; ?></li>
                                </ul>
                            </div>
                            <div class="tb_right pull-right">
                                <ul>
                                    <li>
                                        <div class="tbr-info">
                                            <span>Account <i class="fa fa-caret-down"></i></span>
                                            <div class="tbr-inner">
                                                <?php if ($page['user_menu']): ?>
                                                    <?php print render($page['user_menu']); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER -->
        <header id="header2">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <p class="no-margin top-welcome"><?php print $header_welcome; ?></p>
                    </div>
                    <div class="col-md-4">
                        <a class="navbar-brand" href="<?php print $base_url; ?>"><img src="<?php print $logo; ?>" class="img-responsive" alt="<?php print $site_name; ?>"/></a>
                    </div>
                    <!--region shopping cart-->
                    <?php if ($page['shopping_cart']): ?>
                        <div class="col-md-4">
                            <div class="topcart pull-right">
                                <span><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;My Bag</span>
                                <div class="cart-info">

                                    <?php print render($page['shopping_cart']); ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($page['search']): ?>
                            <div class="top-search2 pull-right">
                                <?php print render($page['search']); ?>
                            </div>
                        <?php endif; ?>
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Logo -->
                            </div>
                            <!-- Navmenu -->
                            <?php if ($page['main_menu']): ?>
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <?php print render($page['main_menu']); ?>
                                </div>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    <?php elseif ($header_style == 'style3'): ?>
        <!-- TOPBAR -->
        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tb_center pull-left">
                                <ul>
                                    <li><?php print $contact_phone; ?></li>
                                    <li><?php print $contact_mail; ?></li>
                                </ul>
                            </div>
                            <div class="tb_right pull-right">
                                <ul>
                                    <li>
                                        <div class="tbr-info">
                                            <span>Account <i class="fa fa-caret-down"></i></span>
                                            <div class="tbr-inner">
                                                <?php if ($page['user_menu']): ?>
                                                    <?php print render($page['user_menu']); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <a class="navbar-brand" href="<?php print $base_url; ?>"><img src="<?php print $logo; ?>" class="img-responsive" alt="<?php print $site_name; ?>"/></a>
                    </div>
                    <?php if ($page['search']): ?>
                        <div class="col-md-7">
                            <div class="top-search3 pull-right">
                                <?php print render($page['search']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!--region shopping cart-->
                    <?php if ($page['shopping_cart']): ?>
                        <div class="col-md-3">
                            <div class="clearfix space30"></div>
                            <div class="topcart pull-right">
                                <span><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;My Bag </span>
                                <div class="cart-info">
                                    <?php print render($page['shopping_cart']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dark-nav">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Logo -->
                            </div>
                            <!-- Navmenu -->
                            <?php if ($page['main_menu']): ?>
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <?php print render($page['main_menu']); ?>
                                </div>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    <?php elseif ($header_style == 'style4'): ?>
        <div id="header4">
            <div class="top_bar">
                <div class="container">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tb_left pull-left">
                                    <p><?php print $header_welcome; ?></p>
                                </div>
                                <div class="tb_center pull-left">
                                    <ul>
                                        <li><?php print $contact_phone; ?></li>
                                        <li><?php print $contact_mail; ?></li>
                                    </ul>
                                </div>
                                <div class="tb_right pull-right">
                                    <ul>
                                        <li>
                                            <div class="tbr-info">
                                                <span>Account <i class="fa fa-caret-down"></i></span>
                                                <div class="tbr-inner">
                                                    <?php if ($page['user_menu']): ?>
                                                        <?php print render($page['user_menu']); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <header>
                <nav class="navbar navbar-default">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!-- Logo -->
                            <?php
                            $img_logo = theme_get_setting('logo_title', 'smilee');
                            if (isset(file_load($img_logo)->uri)) {
                                $url_img_logo = file_create_url(file_load($img_logo)->uri);
                            } else {
                                $url_img_logo = base_path() . drupal_get_path('theme', 'smilee') . '/images/basic/logo-lite.png';
                            }
                            ?> <a class="navbar-brand" href="<?php print $base_url; ?>"><img src="<?php print $url_img_logo; ?>" class="img-responsive" alt="<?php print $site_name; ?>"/></a>
                        </div>
                        <!-- Cart & Search -->
                        <div class="header-xtra pull-right">
                            <?php if ($page['shopping_cart']): ?>
                                <div class="topcart">
                                    <span class="span-class"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="cart-info">
                                        <?php print render($page['shopping_cart']); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($page['search']): ?>
                                <div class="topsearch">
                                    <span class="span-class">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <?php print render($page['search']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Navmenu -->
                        <?php if ($page['main_menu']): ?>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <div class="navbar-right">
                                    <?php print render($page['main_menu']); ?>      
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            </header>
        </div>
    <?php else : ?>
        <div class="nav-trigger fa fa-bars"></div>
        <div class="side-menu">
            <p><?php print $header_welcome; ?></p>
            <div class="vlogo">
                <?php
                $img_logo = theme_get_setting('logo_title', 'smilee');
                if (isset(file_load($img_logo)->uri)) {
                    $url_img_logo = file_create_url(file_load($img_logo)->uri);
                } else {
                    $url_img_logo = base_path() . drupal_get_path('theme', 'smilee') . '/images/basic/logo-lite.png';
                }
                ?>
                <a href="<?php print $base_url; ?>"><img src="<?php print $url_img_logo; ?>" class="img-responsive" alt="<?php print $site_name; ?>"/></a>

            </div>
            <?php if ($page['shopping_cart']): ?>
                <div class="topcart">
                    <span><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Shopping Bag </span>
                    <div class="cart-info">

                        <?php print render($page['shopping_cart']); ?>

                    </div>
                </div>
            <?php endif; ?>


            <?php if ($page['menu_style_2']): ?>
                <div id='cssmenu'>
                    <?php print render($page['menu_style_2']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($page['search'])): ?>
                <div class="vsearch">
                    <?php print render($page['search']); ?>
                </div>
            <?php endif; ?>

            <div class="space30"></div>
            <div class="tb_right pull-right">
                <ul>
                    <li>
                        <div class="tbr-info">
                            <span>Account <i class="fa fa-caret-down"></i></span>
                            <div class="tbr-inner">
                                <?php if ($page['user_menu']): ?>
                                    <?php print render($page['user_menu']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    <?php endif; ?>
    <!-- end header -->


   