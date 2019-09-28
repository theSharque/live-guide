<?php
$boxed = theme_get_setting('site_layout', 'smilee');
if ($boxed == "boxed") {
    $boxed = 'active';
} else {
    $boxed = '';
    
}
?><input type="hidden" value="<?php print $boxed;?>" id="boxed-wide">
<!-- Start Switcher -->
<div class="b-settings-panel ">
    <div class="settings-section">
        <span>Boxed</span>
        <div class="b-switch">
            <div class="switch-handle <?php print $boxed; ?>"></div>
        </div>
        <span>Wide</span>
    </div>

    <hr class="dashed" style="margin: 15px 0px;">

    <h5>Main Background</h5>
    <div class="settings-section bg-list">
        <div class="bg-wood_pattern"></div>
        <div class="bg-shattered"></div>
        <div class="bg-vichy"></div>
        <div class="bg-random-grey-variations"></div>
        <div class="bg-irongrip"></div>
        <div class="bg-gplaypattern"></div>
        <div class="bg-diamond_upholstery"></div>
        <div class="bg-denim"></div>
        <div class="bg-crissXcross"></div>
        <div class="bg-climpek"></div>
    </div>

    <hr class="dashed" style="margin: 15px 0px;">

    <h5>Color Scheme</h5>
    <div class="settings-section color-list">
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/grass-green.css" style="background: #64be33"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/green.css" style="background: #2bba57" ></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/turquoise.css" style="background: #2eafbb" ></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/blue.css" style="background: #5489de"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/klein-blue.css" style="background: #4874cd"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/purple.css" style="background: #7e47da"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/pink.css" style="background: #ea5192"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/red.css" style="background: #e34735"></div>
        <div data-src="<?php print base_path() . path_to_theme(); ?>/css/color-scheme/orange.css" style="background: #ff6029"></div>
    </div>
    <?php
    $setting_skin = theme_get_setting('built_in_skins', 'smilee');
    if (!empty($setting_skin)) {
        $skin_color = '/css/color-scheme/' . $setting_skin;
    } else {
        $skin_color = '/css/style.css';
    }
    ?>
    <a href="#" data-src="<?php print base_path() . path_to_theme() . $skin_color; ?>" class="reset"><span class="bg-wood_pattern">Reset</span></a>

    <div class="btn-settings"></div>
</div>
<!-- End Switcher -->

