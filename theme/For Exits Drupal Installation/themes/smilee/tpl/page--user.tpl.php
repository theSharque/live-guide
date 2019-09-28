
   <?php
   $sidebar = theme_get_setting('sidebar_user', 'smilee');
   if($sidebar==''){
       $sidebar='none';
   }
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
<!-- MY ACCOUNT -->
<div class="account-wrap">
    <div class="container">
        <div class="row">
            <?php if ($sidebar == 'left'): ?>

                <?php if ($page['content']): ?>
                    <div class="col-md-9 col-sm-8">
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        unset($page['content']['system_main']['default_message']);

                        print render($page['content']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($page['sidebar']): ?>          
                    <div class="col-md-3 col-sm-4">
                        <?php print render($page['sidebar']); ?>    
                    </div>
                <?php endif; ?>
            <?php elseif ($sidebar == 'right'): ?>
                <?php if ($page['sidebar']): ?>          
                    <div class="col-md-3 col-sm-4">
                        <?php print render($page['sidebar']); ?>    
                    </div>
                <?php endif; ?>

                <?php if ($page['content']): ?>
                    <div class="col-md-9 col-sm-8">
                        <?php
                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                            print render($tabs);
                        endif;
                        print $messages;
                        unset($page['content']['system_main']['default_message']);

                        print render($page['content']);
                        ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="col-md-12">
                    <!-- HTML -->
                    <div id="account-id">
                        <div class="account-form">
                            <?php if ($page['content']): ?>
                                <?php
                                if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                                    print render($tabs);
                                endif;
                                print $messages;
                                unset($page['content']['system_main']['default_message']);

                                print render($page['content']);
                                ?>
                            <?php endif; ?>
                        </div>                                    
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clearfix space20"></div>
<?php if ($page['section']): ?>
    <?php print render($page['section']); ?>
<?php endif; ?>

<?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?>






