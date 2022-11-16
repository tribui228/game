<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/include.php');
include_once (LOCAL_PATH_ROOT.'/game/redeem_code_all/params.php');
?>

<div class="code-row code-header">
    <div class="code-column not-edit"> # </div>
    <?php
        foreach ($columnArr as $column) :
    ?>
        <div class="code-column not-edit sort-column" data-column="<?=$column?>">
            <div class="mr-auto"> <?=$displayArr[$column]?> </div>
        
            <?php 
                if (!is_null($sortBy) && !is_null($sortDir) && $sortBy == $column) {
                    $direction = $sortDir == 'ASC' ? 'down' : 'up';

                    echo '<div id="code-arrow-'.$column.'" class="code-arrow arrow '.$direction.'"> </div>';
                }
            ?>      

        </div>
    <?php endforeach;?>
</div>