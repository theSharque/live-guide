<?php
global $base_root, $base_url;

if (isset($node->field_post_format) && !empty($node->field_post_format)) {
    $post_format = $node->field_post_format['und'][0]['value'];
} else {
    $post_format = 'image';
}

if (!empty($node->field_image) && isset($node->field_image)) {
    $imageone = $node->field_image['und'][0]['uri'];
    $images = $node->field_image['und'];
    $count = count($images);
} else {
    $images='';
    $imageone = '';
    $count = 0;
}
$i = 0;
if (!$page) {
    ?>
    <article class="blogpost">
        <?php if ($post_format == 'quote' && isset($node->field_quote) && !empty($node->field_quote)) { ?>
            <blockquote class="style2">
                <span class="icon-quote"></span>
                <div class="quote-one-right">
                    <p> <?php print strip_tags(render($content['field_quote'])); ?></p>
                </div>
            </blockquote>
            <div class="quote-meta">
                <div class="post-meta">
                    <span><i class="fa fa-calendar"></i> <?php print format_date($node->created, 'custom', 'F d, Y'); ?></span>
                    <span><i class="fa fa-user"></i> <?php print strip_tags($name); ?></span>
                    <span><i class="fa fa-folder"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?>  </span>
                    <span><i class="fa fa-comments"></i> <?php print $comment_count; ?> Comments</span>
                </div>
                <div class="space10"></div>
                <a href="<?php print $node_url; ?>" class="btn-black"><?php print t('Read more  '); ?><i class="fa fa-angle-right"></i></a>
            </div>
        <?php } else { ?>

            <h2 class="post-title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
            <div class="post-meta">
                <span><i class="fa fa-calendar"></i> <?php print format_date($node->created, 'custom', 'F d, Y'); ?></span>
                <span><i class="fa fa-user"></i> <?php print strip_tags($name); ?></span>
                <span><i class="fa fa-folder"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?>  </span>
                <span><i class="fa fa-comments"></i> <?php print $comment_count; ?> Comment</span>
            </div>
            <div class="space20"></div>
            <div class="post-media">
                <?php if ($post_format == 'video' && isset($node->field_video_embed) && !empty($node->field_video_embed)): ?>
                    <div class="video">
                        <?php print render($content['field_video_embed']); ?>
                    </div>

                <?php else : ?>
                    <?php if ($post_format != 'no_image'): ?>
                        <?php if ($count == 1): ?>

                            <img src="<?php print file_create_url($imageone); ?>" class="img-responsive" alt="<?php print $title; ?>">         
                        <?php elseif ($count > 1): ?>

                            <div class="blog-slider">
                                <?php
                                foreach ($images as $key => $value) :
                                    $url = $node->field_image['und'][$key]['uri'];  //full url 
                                    ?>    
                                    <div class="item"> <?php print theme('image_style', array('path' => $url, 'style_name' => 'image848x460', 'attributes' => array('alt' => $title, 'class' => 'img-responsive'))); ?></div>                          
                                    <?php
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?> 
                <?php endif; ?> 
            </div>
            <div class="space20"></div>
            <div class="post-excerpt">
                <?php print render($content['body']); ?>   
            </div>
            <a href="<?php print $node_url; ?>" class="btn-black">Read More&nbsp;&nbsp;<i class="fa fa-angle-right"></i></a>
        <?php }
        ?>
    </article>
    <div class="blog-sep"></div>
<?php } else {
    ?>
    <div class="blog-single">
        <article class="blogpost">
            <?php if ($post_format == 'quote' && isset($node->field_quote) && !empty($node->field_quote)) { ?> 
                <blockquote class="style2">
                    <span class="icon-quote"></span>
                    <div class="quote-one-right">
                        <p> <?php print strip_tags(render($content['field_quote'])); ?></p>
                    </div>
                </blockquote>
                <div class="quote-meta">
                    <div class="post-meta">
                        <span><i class="fa fa-calendar"></i> <?php print format_date($node->created, 'custom', 'F d, Y'); ?></span>
                        <span><i class="fa fa-user"></i> <?php print strip_tags($name); ?></span>
                        <span><i class="fa fa-folder"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?>  </span>
                        <span><i class="fa fa-comments"></i> <?php print $comment_count; ?> Comments</span>
                    </div>
                    <div class="space10"></div>
                    <a href="<?php print $node_url; ?>" class="btn-black"><?php print t('Read more  '); ?><i class="fa fa-angle-right"></i></a>
                </div>
            <?php } else { ?>
                <h2 class="post-title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
                <div class="post-meta">
                    <span><i class="fa fa-calendar"></i> <?php print format_date($node->created, 'custom', 'F d, Y'); ?></span>
                    <span><i class="fa fa-user"></i> <?php print strip_tags($name); ?></span>
                    <span><i class="fa fa-folder"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?></span>
                    <span><i class="fa fa-comments"></i> <?php print $comment_count; ?> Comments</span>
                </div>
                <div class="space30"></div>
                <!-- Media Gallery -->
                <div class="post-media">
                    <?php if ($post_format == 'video' && isset($node->field_video_embed) && !empty($node->field_video_embed)): ?>
                        <div class="video">
                            <?php print render($content['field_video_embed']); ?>
                        </div>

                    <?php else : ?>
                        <?php if ($post_format != 'no_image'): ?>
                            <?php if ($count == 1): ?>

                                <img src="<?php print file_create_url($imageone); ?>" class="img-responsive" alt="<?php print $title; ?>">         
                            <?php elseif ($count > 1): ?>

                                <div class="blog-slider">
                                    <?php
                                    foreach ($images as $key => $value) :
                                        $url = $node->field_image['und'][$key]['uri'];  //full url 
                                        ?>    
                                        <div class="item"> <?php print theme('image_style', array('path' => $url, 'style_name' => 'image848x460', 'attributes' => array('alt' => $title, 'class' => 'img-responsive'))); ?></div>                          
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?> 
                    <?php endif; ?> 
                </div>
            <?php } ?>
            <div class="space30"></div>
            <?php print render($content['body']); ?>   
        </article>
    </div>
    <?php print render($content['comments']); ?>
    <!-- end comments-list -->


<?php } ?>

