<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php if (isset($header)): ?>
                <?php print $header; ?>
            <?php endif; ?>
            <?php if (isset($rows)): ?>
                <?php print $rows; ?>
            <?php endif; ?>
        </div>
        <?php if (isset($footer)): ?>
            <?php print $footer; ?>
        <?php endif; ?>
    </div>
</div>

