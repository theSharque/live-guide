<?php

 require_once(drupal_get_path('theme', 'smilee') . '/tpl/header.tpl.php'); ?>

        <!-- BREADCRUMBS -->

        <div class="bcrumbs">

            <div class="container">

                <?php if ($breadcrumb): ?>

                    <?php print $breadcrumb; ?>

                <?php endif; ?>

            </div>

        </div>

        <div class="space10"></div>

        <?php if ($page['content']): ?>

            <?php

            if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                print render($tabs);

            endif;

            print $messages;

            unset($page['content']['system_main']['default_message']);

            ?>	

        <div class="checkout">

            <div class="shop-single">

                <div class="container">

                    <div class="row">

                        <?php print render($page['content']); ?>

                    </div>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <div class="clearfix space20"></div>

        <?php require_once(drupal_get_path('theme', 'smilee') . '/tpl/footer.tpl.php'); ?> 

        <?php

   