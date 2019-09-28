<div class="col-md-6">
    <?php if (isset($header)): ?>
        <?php print $header; ?>
    <?php endif; ?>
    <div class="clients-carousel2">  
        <?php if (isset($rows)): ?>
            <div>
                <?php print $rows; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($footer)): ?>
            <?php print $footer; ?>
        <?php endif; ?>
    </div>
</div>

