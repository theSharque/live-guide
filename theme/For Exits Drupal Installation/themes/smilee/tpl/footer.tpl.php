<?php global $base_url; ?>

<?php

if (isset($node)) {

    $node_type = $node->type;

    $nid = $node->nid;

} else {

    $node_type = '';

    $nid = '';

}

?>



<?php $footer_copyright_message = theme_get_setting('footer_copyright_message', 'smilee'); ?>

<?php if (isset($page['footer_first']) || isset($page['footer_second']) || isset($page['footer_third']) || isset($page['footer_fourth'])) { ?>

    <footer>

        <div class="container">

            <div class="row">



                <?php if ($page['footer_first']): ?>
                         <div class="col-md-3">
                    <?php print render($page['footer_first']); ?>                          
                     </div>
                <?php endif; ?>



                <?php if ($page['footer_second']): ?>                          
                     <div class="col-md-3">
                    <?php print render($page['footer_second']); ?>
                        </div>
                <?php endif; ?>

                <?php if ($page['footer_third']): ?>
                           <div class="col-md-3">
                    <?php print render($page['footer_third']); ?>
                          </div>
                <?php endif; ?>

                <?php if ($page['footer_fourth']): ?>
                      <div class="col-md-3">
                    <?php print render($page['footer_fourth']); ?>
                        </div>
                <?php endif; ?>

            </div>

        </div>

    </footer>

<?php } ?>

<?php if ($page['footer']): ?>

    <div class="footer-bottom">

        <div class="container">

            <div class="row">

                <?php print render($page['footer']); ?>

            </div>

        </div>

        <!-- end row -->

    </div>



<?php endif; ?>

<!-- end footer-form -->



</div><!-- end body - body header-->



<?php if ($page['modal']): ?>

    <?php print render($page['modal']); ?>

<?php endif; ?>

