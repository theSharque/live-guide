
<div class="row">
    <?php if (isset($header)): ?>
        <div class="col-md-3">
            <?php print $header; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($rows)): ?>
        <div class="col-md-6">
            <div class="home-carousel">
                <?php print $rows; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($footer)): ?>
        <div class="col-md-3">
            <?php print $footer; ?>
        </div>
    <?php endif; ?>
</div>