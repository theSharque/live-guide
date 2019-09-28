<?php if ($node->type == "blog") { ?>
<?php if ($content['#node']->comment and ! ($content['#node']->comment == 1 and $content['#node']->comment_count)) { ?>

    <div class="padding10">
        <h4 class="uppercase space30"><?php print t('Comments ') . '<span >(' . $content['#node']->comment_count . ')</span>' ?></h4>
        <ul class="comment-list">
            <?php print render($content['comments']); ?>
        </ul>
    </div>
    <!-- end section-comment -->

    <div class="space30"></div>
    <h4 class="uppercase space30">Leave a comment</h4>
    <div class="decor-1 decor-1_mod-a"></div>

    <?php print str_replace('resizable', '', render($content['comment_form'])); ?>

    <div class="space60"></div>

    <?php
}
}  else {?>
    <?php print render($content['comments']); ?>
   <h5>Write a Review</h5>
    <?php print str_replace('resizable', '', render($content['comment_form'])); ?>
<?php }
