<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/order_item/params.php');

foreach ($orderItems as $orderItem) :
    $id = $orderItem->getId();
    $orderId = $orderItem->getOrderId();
    $productName = $orderItem->getProductName();
    $code = empty($orderItem->getCode()) ? 'None' : $orderItem->getCode();
    $price = $orderItem->getPrice();
    $discount = $orderItem->getDiscount();
?>

<div class="admin-row" data-id="<?=$id?>">
    <div class="admin-column not-edit checkbox"> <input class="admin-checkbox" type="checkbox" data-id="<?=$id?>"></div>
    <div class="admin-column not-edit"> <?=$productName?> </div>
    <div class="admin-column"> <?=$code?> </div>
    <div class="admin-column"> <?=$price?> </div>
    <div class="admin-column"> <?=$discount*100?> </div>
</div>
    
<?php endforeach;?>

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

        if (parent.dataset.id == null) {
            return;
        }

        let checkbox = $(".admin-checkbox[data-id=" + parent.dataset.id + "]")[0];
        checkbox.checked = !checkbox.checked;
        updateCheckboxAll();
    });
</script>