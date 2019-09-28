<?php
if (isset($node)) {
    $node_type = $node->type;
    $nid = $node->nid;
} else {
    $node_type = '';
    $nid = '';
}
if (isset($node->field_sidebar) && !empty($node->field_sidebar)) {
    $sidebar = $node->field_sidebar['und'][0]['value'];
} else
    $sidebar = 'full';


$footer_copyright_message = theme_get_setting('footer_copyright_message', 'smilee');
?>

<?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/header.tpl.php'); ?>
<!-- BREADCRUMBS -->
<div class="bcrumbs">
    <div class="container">
        <?php if ($breadcrumb): ?>
            <?php print $breadcrumb; ?>
        <?php endif; ?>
    </div>
</div>

<?php if (arg(0) == 'cart') { ?>

    <?php if ($page['content']): ?>
        <div class="shop-single shopping-cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <?php print render($page['content']); ?>


                        <div class="space40"></div>
                        <?php if ($page['section']): ?>
                            <?php print render($page['section']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php } else { ?>
    <?php if ($page['content']): ?>
        <?php if ($sidebar == 'left'): ?>
            <div class="account-wrap">
                <div class="container">
                    <div class="row">

                        <?php if ($page['sidebar']): ?>
                            <div class="col-md-3 col-sm-3"> 
                                <?php print render($page['sidebar']); ?>
                            </div>
                        <?php endif; ?>


                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <div class="col-md-9 col-sm-8">
                            <?php print render($page['content']); ?>
                        </div>
                        <!-- end container -->

                    </div>
                </div>
            </div>

        <?php elseif ($sidebar == "right"): ?>
            <div class="account-wrap">
                <div class="container">
                    <div class="row">


                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <div class="col-md-9 col-sm-8">
                            <?php print render($page['content']); ?>
                        </div>
                        <!-- end container -->



                        <?php if ($page['sidebar']): ?>
                            <div class="col-md-3 col-sm-3 "> 
                                <?php print render($page['sidebar']); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php if ($node_type != 'page'): ?>
                <div class="account-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ((!empty($tabs['#primary']) || !empty($tabs['#secondary']))):
                                    print render($tabs);
                                endif;
                                print $messages;
                                ?>
                                <?php print render($page['content']) ?>
                            </div>
                        </div>
                    </div></div>
            <?php else: ?>
                <?php
                if ((!empty($tabs['#primary']) || !empty($tabs['#secondary']))):
                    print render($tabs);
                endif;
                print $messages;
                ?>
                <?php print render($page['content']) ?>
            <?php endif; ?>

            <?php if ($page['section']): ?>
                <?php print render($page['section']) ?>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>
<?php } ?>

<?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?>



