<?php
if (isset($_GET['sidebar'])) {
    $sidebar = $_GET['sidebar'];
} elseif (isset($node->field_sidebar) && !empty($node->field_sidebar)) {
    $sidebar = $node->field_sidebar['und'][0]['value'];
} else
    $sidebar = theme_get_setting('sidebar', 'smilee');
if (empty($sidebar)):
    $sidebar = 'none';
endif;
$title = theme_get_setting('blog_title', 'smilee');
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
    <div class="space10"></div>

    <?php if ($sidebar == 'right') { ?>
        <!-- BLOG CONTENT -->
        <div class="blog-content">
            <div class="container">
                <div class="row">
                    <?php if ($page['content']): ?>
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <div class="col-md-9 blog-content">
                            <?php print render($page['content']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Sidebar -->
                    <?php if ($page['sidebar']): ?>
                        <!-- Sidebar -->
                        <aside class="col-sm-3 ">
                            <?php print render($page['sidebar']) ?>
                        </aside>

                    <?php endif; ?>
                    <!-- end col -->


                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end section_border-bottom -->
    <?php }else { ?>
        <!-- BLOG CONTENT -->
        <div class="blog-content">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <?php if ($page['sidebar']): ?>
                        <!-- Sidebar -->
                        <aside class="col-sm-3 ">
                            <?php print render($page['sidebar']) ?>
                        </aside>

                    <?php endif; ?>
                    <!-- end col -->

                    <?php if ($page['content']): ?>
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        ?>
                        <div class="col-md-9 blog-content">
                            <?php print render($page['content']) ?>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end section_border-bottom -->
    <?php } ?>
    <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?>




