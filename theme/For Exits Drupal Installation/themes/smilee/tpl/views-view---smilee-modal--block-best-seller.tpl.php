<div class="container">
    <div class="row">

        <?php if (isset($rows)): ?>

            <div class="col-md-3">
                <?php if (isset($header)): ?>
                    <?php print $header; ?>
                <?php endif; ?>
                <div class="f-widget-content">
                    <ul>
                        <?php print $rows; ?>
                    </ul>
                </div>
            </div> 
        <?php endif; ?>
        <?php if (isset($footer)): ?>
            <?php print $footer; ?>
        <?php endif; ?>
    </div>
</div>


