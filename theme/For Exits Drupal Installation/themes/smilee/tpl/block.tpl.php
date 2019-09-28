<?php

$out = '';
if (!empty($block->block_id)) {

	$id = 'id="'.$block->block_id.'"';

} else {
	$id = '';

}

if ($block->region == 'modal') {

    $out .= $content;


} elseif ($block->region == 'main_menu'||$block->region=='menu_style_2') {

//    $out .= '<div  class="' . $classes . '" ' . $attributes . ' ' . $id . '>';

    $out .= render($title_suffix);

    $out .= $content;

//    $out .= '</div>';
} elseif ($block->region == 'slider') {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';

    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
} elseif ($block->region == 'section') {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';
 if ($block->subject):

        $out .= '<h5 class="heading space40"><span>' . $block->subject . '</span></h5>';

    endif;
    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
} elseif (($block->region == 'footer_first') || ($block->region == 'footer_fourth') || ($block->region == 'footer_second') || ($block->region == 'footer_third')) {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';
    if ($block->subject):

        $out .= '<h5>' . $block->subject . '</h5>';

    endif;
    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
}elseif ($block->region == 'footer') {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';

    $out .= render($title_suffix);
    if ($block->subject):

        $out .= '<div class="footer-form__title-group">'
            . ' <div class="footer__title">' . $block->subject . '</div>'
                . ' <div class="decor-1 decor-1_mod-c"></div></div>';

    endif;

    $out .= $content;

    $out .= '</div>';
}  elseif ($block->region == 'sidebar') {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';

    if ($block->subject):

        $out .= '<h3><span>' . $block->subject . '</span></h3>';
    

    endif;

    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
}elseif ($block->region == 'content') {
    $out .= '<div class="search ' . $classes . '"' . $attributes . ' ' . $id . '>';

    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
}else {

    $out .= '<div class="' . $classes . '"' . $attributes . ' ' . $id . '>';

    $out .= render($title_suffix);

    $out .= $content;

    $out .= '</div>';
}

print $out;
?>