<?php if ($node->type == "blog") { ?>
    <li>
        <div class="pull-left comment-picture"> <?php
            if ($picture) {
                print strip_tags($picture, '<img>');
            } else {
                ?><img class="comment-avatar"  src='http://2.gravatar.com/avatar/20ba2a1e248ffa7cd7f48d659107b4c5?s=100&#038;d=mm&#038;r=g' srcset='http://2.gravatar.com/avatar/20ba2a1e248ffa7cd7f48d659107b4c5?s=200&amp;d=mm&amp;r=g 2x'   height="100" width="135" alt="avatar" />
            <?php } ?></div>
        <div class="comment-meta">
            <?php print $author; ?>
            <span>
                <em><?php print format_date($comment->created, 'custom', 'F d, Y') . t(', at ') . format_date($comment->created, 'custom', 'H:i') ?></em>
                <div class="button btn-xs reply"><i class="fa fa-comment"></i> <?php print strip_tags(render($content['links']), '<a>'); ?></div>
            </span>
        </div>
        <p>
            <?php
            hide($content['links']);
            print strip_tags(render($content), '<a>')
            ?>
        </p>
    </li>
<?php } else { ?>
    <p><b> <?php print $author; ?></b>, <?php print format_date($comment->created, 'custom', 'F d, Y'); ?></p>
    <p> <?php
        hide($content['links']);
        print strip_tags(render($content), '<a>')
        ?></p>

    <div class="sep"></div>
<?php } ?>



<!-- end section -->

