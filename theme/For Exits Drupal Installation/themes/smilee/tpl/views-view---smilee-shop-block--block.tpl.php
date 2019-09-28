<div class="container">
    <div class="row">
        <?php if (isset($header)): ?>
            <?php print $header; ?>
        <?php endif; ?>
        <?php if (isset($rows)): ?>
            <div id="isotope" class="isotope">
                <?php print $rows; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

