<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/include.php');
include_once (LOCAL_PATH_ROOT.'/game/purchase_history/params.php');

$index = 0;
?>

<style>
.a-redeem {
    color: white !important;
    text-decoration: underline !important;
}

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
    $index = $begin;

    for ($i = $begin; $i <= $last; $i++) :
        $order = $orders[$i];
        $index++;
        $id = $order->getId();
        $dateOrdered = $order->getDateOrdered();
        $status = $order->getStatus() == 0 ? 'Not checked' : 'Checked';
        $totalPrice = round($order->getTotalPrice(), 2);
        $quantity = $order->getQuantity();
    ?>
    <div class="history-row">
        <div class="history-column"> <?=$index?> </div>
        <div class="history-column"> <?=$dateOrdered?> </div>
        <div class="history-column special-column"> <span class="status-cell <?=$status == 'Checked' ? "status-success" : "status-danger"?>"> <?=$status?> </span> </div>
        <div class="history-column"> <?=$totalPrice?> </div>
        <div class="history-column"> <?=$quantity?> </div>
        <div class="history-column justify-content-between align-items-center"> 
            <a class="a-redeem" href="/game/redeem_code/?id=<?=$id?>"> Detail </a> 
            <svg class="order-cancel <?=$status == 'Not checked' ? '' : 'd-none'?>" data-id="<?=$id?>" data-index="<?=$index?>" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 352 512"><path fill="black" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
        </div>
    </div>
<?php endfor; } ?>

<script>
    var postData = {
        "sortBy": '<?=$sortBy?>',
        "sortDir": '<?=$sortDir?>',
        "currentPage": <?=$currentPage?>,
        "maxInPage": <?=$maxInPage?>
    };

    $(".order-cancel").click(function(e) {
        let id = e.currentTarget.dataset.id;
        let index = e.currentTarget.dataset.index;

        if (!window.confirm("Are you sure to cancel order #" + index + " ?")) {
            return;
        }

        $.ajax({
            url: "remove_order.php",
            method: "POST",
            data: {"id": id},
            success: function(result) {
                if (result == 0) {
                    callNotice("Order has been cancelled!");
                    $.ajax({
                        url: "history.php",
                        method: "POST",
                        data: postData,
                        success: function(result){
                            $("#history").html(result);
                        }
                    });
                }
            }
        });

    })
</script>