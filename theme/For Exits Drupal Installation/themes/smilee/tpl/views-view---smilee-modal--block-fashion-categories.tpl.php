<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($header)): ?>
                <?php print $header; ?>
            <?php endif; ?>
            <div class="row">
                <?php if (isset($rows)): ?>
                    <?php print $rows; ?>
                <?php endif; ?>
                <div class="col-md-4">
                    <?php if ($attachment_after): ?>
                        <?php print $attachment_after; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>