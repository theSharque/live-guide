<?php $sale = trim(strip_tags(render($content['product:field_commerce_saleprice_on_sale']))); ?>

<?php $instock = trim(strip_tags(render($content['product:field_in_stock']))); ?>

<?php

if ((isset($content['product:field_image']['#items'])) && (!empty($content['product:field_image']['#items']))) {

    $image_one_uri = $content['product:field_image']['#items'];

//    $imageone = file_create_url($image_one_uri);

} else {

    $image_one_uri = '';

}

//print_r($node->nid);

$nid = $node->nid;

?>



<?php if (!$page): ?>

    <div class="col-md-4">

        <div class="product-item">

            <div class="item-thumb">



                <?php $imageoneuri = $image_one_uri[0]['uri']; ?>

                <?php print theme('image_style', array('path' => $imageoneuri, 'style_name' => 'image500x650', 'attributes' => array('alt' => $title, 'class' => 'img-responsive'))); ?>



                <div class="overlay-rmore fa fa-search quickview" data-toggle="modal" data-target="#Modal<?php print $nid; ?>"></div>



            </div>

            <div class="product-info">

                <h4 class="product-title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>

                <span class="product-price">  <?php if ($sale == '1') { ?>



                        <?php print strip_tags(render($content['product:field_commerce_saleprice'])); ?> 

                    <?php } else { ?>

                        <?php print strip_tags(render($content['product:commerce_price'])); ?>

                    <?php } ?><em>- <?php if ($instock == '1') { ?>

                            <?php print strip_tags(render($content['product:field_in_stock'])); ?>



                        <?php } else { ?>

                            <?php print t(' Pre order'); ?>

                        <?php } ?></em></span>

                <div class="ratings">

                    <?php print render($content['field_rating']); ?>

                </div>

            </div>

        </div>

    </div>

<?php else: ?>

    <div class="row modal1 " >

        <div class="col-md-5">

            <div class="ps-slider">

                <?php

                foreach ($image_one_uri as $key => $value) {

                    $image_uri = $image_one_uri[$key]['uri'];

                    $image_url = file_create_url($image_uri);

                    ?>

                    <div class="ps-img ps-img<?php print $key + 1; ?>">

                        <?php print theme('image_style', array('path' => $image_uri, 'style_name' => 'image500x650', 'attributes' => array('alt' => $title))); ?>



                        <span>

                            <a href="<?php print $image_url ?>" onclick="window.open('<?php print $image_url ?>', 'newwindow', 'width=600, height=650');

                                            return false;"><i class="fa fa-arrows-alt"></i> View Full Screen</a>

                        </span>

                    </div>



                <?php } ?>



            </div>

            <div class="ps-slider-nav">

                <ul>

                    <?php

                    foreach ($image_one_uri as $key => $value) {

                        $image_uri = $image_one_uri[$key]['uri'];

                        $image_url = file_create_url($image_uri);

                        ?>

                        <li id="ps-img<?php print $key + 1; ?>">  <?php print theme('image_style', array('path' => $image_uri, 'style_name' => 'image500x650', 'attributes' => array('alt' => $title, 'class' => 'img-responsive'))); ?>

                        </li>

                    <?php } ?> 

                </ul>

            </div>

        </div>

        <div class="col-md-7">

            <div class="product-single">

                <div class="ps-header">

                     <?php if ($sale == '1') { print t('<span class="badge offer">Sale!</span>');} ?>

                    <h3><?php print $title; ?></h3>

                    <div class="ratings-wrap">

                        <div class="ratings">

                            <?php print render($content['field_rating']); ?>

                        </div>



                    </div>

                    <div class="ps-price">

                        <?php if ($sale == '1') { ?>

                        <span><?php print strip_tags(render($content['product:commerce_price'])); ?></span>  

                        <?php print strip_tags(render($content['product:field_commerce_saleprice'])); ?> 

                        <?php } else { ?>

                        <?php print strip_tags(render($content['product:commerce_price'])); ?>

                        <?php } ?>



                    </div>

                    <?php print render($content['product:field_product_description']); ?>

                    <br>

                    <div class="ps-stock">

                        <?php if ($instock == '1') { ?>

                        Available: In stock 



                        <?php } else { ?>

                        <?php print t('Available: Pre order'); ?>

                        <?php } ?>



                    </div>

                    <div class="sep"></div>



                    <div class="select-wraps">

                        <?php print render($content['field_product']); ?> 



                    </div>

                </div>

            </div>

        </div>

        <div class="clearfix space40"></div>

        <div role="tabpanel">

            <!-- Nav tabs -->

            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php print t('Product Description'); ?></a></li>

                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php print t('Customer Review'); ?></a></li>



            </ul>

            <!-- Tab panes -->

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="home">

                    <?php print render($content['product:field_product_details']); ?>

                </div>

                <div role="tabpanel" class="tab-pane" id="profile">

                    <div class="reviews-tab">

                        <?php print render($content['comments']); ?>

                        <!-- end comments-list -->

                    </div>

                </div>



            </div>

        </div>

        <div class="clearfix space40"></div>

    </div>



<?php endif; ?>



