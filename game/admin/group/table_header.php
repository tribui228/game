<div class="admin-row header">
    <div class="admin-column not-edit checkbox" data-column="checkbox"><input class="admin-checkbox all" type="checkbox"></div>
    <?php
        foreach ($columnArr as $column) :
    ?>
        <div class="admin-column not-edit sort-column" data-column="<?=$column?>">
            <div class="mr-auto"> <?=$displayArr[$column]?> </div>    
        
            <?php 
                if (!is_null($sortBy) && !is_null($sortDir) && $sortBy == $column) {
                    $direction = $sortDir == 'ASC' ? 'down' : 'up';

                    echo '<div id="admin-arrow-'.$column.'" class="admin-arrow arrow '.$direction.'"> </div>';
                }
            ?>      

        </div>
    <?php endforeach;?>
</div>