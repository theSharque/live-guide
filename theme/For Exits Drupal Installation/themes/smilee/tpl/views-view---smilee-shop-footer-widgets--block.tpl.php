<div class="col-md-3">
    <?php if (isset($header)): ?>
        <?php print $header; ?>
    <?php endif; ?>
    <div class="f-widget-content">
        <?php if (isset($rows)): ?>
            <ul>
                <?php print $rows; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
