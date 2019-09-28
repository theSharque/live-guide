<?php if (isset($rows)): ?> 
    <ul class="filter" data-option-key="filter">
        <li><a class="selected" href="#filter" data-option-value="*">All</a></li>
        <?php print $rows; ?>
    </ul>
<?php endif; ?>

