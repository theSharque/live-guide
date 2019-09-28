
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <?php if (isset($header)): ?>
                        <?php print $header; ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <?php if (isset($rows)): ?>
                        <?php print $rows; ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <?php if (isset($footer)): ?>
                        <?php print $footer; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>