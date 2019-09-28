<?php
if (isset($_GET['sidebar'])) {
    $sidebar = $_GET['sidebar'];
} else {
    $sidebar = theme_get_setting('shop_sidebar', 'smilee');
}
if (empty($sidebar)) {
    $sidebar = 'left';
}
 ?>
    <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/header.tpl.php'); ?>
    <?php if (isset($page['slider'])): ?>
        <?php print render($page['slider']); ?>
    <?php endif; ?>
    <!-- BREADCRUMBS -->
    <div class="bcrumbs">
        <div class="container">
            <?php if ($breadcrumb): ?>
                <?php print $breadcrumb; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <?php if ($page['content']): ?>
        <div class="shop-content">
            <div class="container">
                <div class="row">
                    <aside class="col-md-3">
                        <?php if ($page['sidebar']): ?>
                            <?php print render($page['sidebar']); ?>
                        <?php endif; ?>
                    </aside>
                    <div class="col-md-9">
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <?php print render($page['content']); ?>
                    </div>

                </div>
                <div class="space50"></div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($page['section'])): ?>
                            <?php print render($page['section']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix space20"></div>
    <?php endif; ?>
    <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?>

