<div class="col-md-6">
    <?php if (isset($header)): ?>
        <?php print $header; ?>
    <?php endif; ?>
    <?php if (isset($rows)): ?>
        <div class="product-carousel">
            <?php print $rows; ?>
        </div>
    <?php endif; ?>
</div>