<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/sale/params.php');

if ($page->getPages() > 0) {
    $begin = $page->getMinIndex();
    $last = $page->getMaxIndex();

    for ($i = $begin; $i <= $last; $i++) :
        $sale = $sales[$i];
        $name = $sale->getName();
        if ($name == 'no_discount') {
            continue;
        }

        $display = $sale->getDisplay();
        $discount = $sale->getDiscount() * 100;
        $dateBegin = empty($sale->getDateBegin()) ? "*" : $sale->getDateBegin();
        $dateEnd = empty($sale->getDateEnd()) ? "*" : $sale->getDateEnd();
?>

<div class="admin-row" data-name="<?=$name?>">
    <div class="admin-column not-edit checkbox"> <input class="admin-checkbox" type="checkbox" data-name="<?=$name?>"></div>
    <div class="admin-column not-edit"> <?=$name?> </div>
    <div class="admin-column"> <?=$display?> </div>
    <div class="admin-column"> <?=$discount?> </div>
    <div class="admin-column"> <?=$dateBegin?> </div>
    <div class="admin-column"> <?=$dateEnd?> </div>
</div>
    
<?php endfor; } ?>

<script>
    function updateCheckboxAll() {
        let all = true;
        $(".admin-checkbox:not(.all)").each(function() {
            if (all && !$(this)[0].checked) {
                all = false;
            }
        });

        $(".admin-checkbox.all").prop('checked', all);
    }

    $(".admin-checkbox").click(function(e) {
        let target = e.currentTarget;

        if (target.classList.contains('all')) {
            $(".admin-checkbox:not(.all)").prop('checked', target.checked);
        }else {
            updateCheckboxAll();
        }
    });

    $(".admin-column:not(.checkbox)").click(function(e) {
        let parent = e.currentTarget.parentElement;

        if (parent.dataset.name == null) {
            return;
        }

        let checkbox = $(".admin-checkbox[data-name=" + parent.dataset.name + "]")[0];
        checkbox.checked = !checkbox.checked;
        updateCheckboxAll();
    });
</script>