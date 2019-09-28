<div class="container">
    <div class="row">
        <?php if (isset($header)): ?>
            <?php print $header; ?>
        <?php endif; ?>
        <?php if (isset($rows)): ?>
            <div class="col-md-12">
                <div class="quote-carousel">
                    <?php print $rows; ?>   
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

