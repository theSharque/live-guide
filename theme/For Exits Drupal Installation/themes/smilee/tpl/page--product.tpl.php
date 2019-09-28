
    <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/header.tpl.php'); ?>
    <!-- BREADCRUMBS -->
    <div class="bcrumbs">
        <div class="container">
            <?php if ($breadcrumb): ?>
                <?php print $breadcrumb; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="space10"></div>

    <!-- MAIN CONTENT -->
    <div class="shop-single">
        <div class="container">
            <div class="row">
                <?php if ($page['content']): ?>
                    <?php
                    if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                        print render($tabs);
                    endif;
                    print $messages;
                    ?>
                    <div class="col-md-12">
                        <?php print render($page['content']) ?>
                        <?php if (isset($page["section"])): ?>
                            <?php print render($page["section"]); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="clearfix space20"></div>
    <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?>

