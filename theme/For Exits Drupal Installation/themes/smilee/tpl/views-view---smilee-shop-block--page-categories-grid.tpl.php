<div class="filter-wrap">
    <div class="row">
        <?php if (isset($header)): ?>
            <?php print $header; ?>
        <?php endif; ?>
        <?php if ($exposed): ?>
            <div class="col-md-7">
                <?php print $exposed; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="space50"></div>
<?php if (isset($rows)): ?>
    <div class="row">
        <?php print $rows; ?>
    </div>
<?php endif; ?>
<div class="space30 border-top"></div>

<?php if (isset($pager)): ?>
    <?php print $pager; ?>
<?php endif; ?>


