<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/product_code/params.php');
?>

<style>
.special-column {
    padding: 0.4rem 0.7rem;
}

.special-column:hover > .status-cell {
    background-color: #34373a;
}

.status-cell {
    background-color: #212529;
    padding: 0.1rem 0.3rem;
}

.status-cell.status-danger {
    color: #FF6347;
}

.status-cell.status-success {
    color: #94DF03;
}
</style>

<?php
if ($page->getPages() > 0) {
    $begin = $page->getMinIndex();
    $last = $page->getMaxIndex();

    for ($i = $begin; $i <= $last; $i++) :
        $productCode = $productCodes[$i];
        $id = $productCode->getId();
        $productName = $productCode->getProductName();
        $code = $productCode->getCode();
        $status = $productCode->getStatus() == 0 ? 'Not Used' : 'Used';
        $dateAdded = $productCode->getDateAdded();
?>

<div class="admin-row" data-name="<?=$id?>">
    <div class="admin-column not-edit checkbox"> <input class="admin-checkbox" type="checkbox" data-name="<?=$id?>"></div>
    <div class="admin-column"> <?=$productName?> </div>
    <div class="admin-column"> <?=$code?> </div>
    <div class="admin-column special-column"><span class="status-cell <?=$status == 'Used' ? "status-success" : "status-danger"?>" data-name="<?=$id?>"> <?=$status?> </span></div>
    <div class="admin-column"> <?=$dateAdded?> </div>
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

    $(".admin-column:not(.checkbox):not(.special-column)").click(function(e) {
        let parent = e.currentTarget.parentElement;

        if (parent.dataset.name == null) {
            return;
        }

        let checkbox = $(".admin-checkbox[data-name=" + parent.dataset.name + "]")[0];
        checkbox.checked = !checkbox.checked;
        updateCheckboxAll();
    });

    $(".admin-column.special-column").click(function(e) {
        let target = e.currentTarget.childNodes[0];
        
        let id = target.dataset.name;
        $.ajax({
            url: "product_code/update_product_code.php",
            method: "POST",
            data: {
                "id": id
            },
            success: function(result){
                if (result != 0 && result != 1) {
                    return;
                }

                $(target).html(result == 0 ? "Not used" : "Used");
                $(target).toggleClass("status-success", result != 0);
                $(target).toggleClass("status-danger", result == 0);

                $.ajax({
                    url: "product_code/table_scroll.php",
                    method: "POST",
                    data: postData,
                    success: function(result){
                        $(".admin-table-scroll").html(result);
                    }
                });
            }
        });
    });
</script>