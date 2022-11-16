<?php
/* 
    0: Success: remove genre
    1: Half Success Half Fail: some can remove some cannot remove
    2: Fail: wrong params
    3: Fail: exist product use genre
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.order.item.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['order_id']) && isset($_POST['order_item_id_array'])) {
    $order = OrderUtil::getOrderById($_POST['order_id']);

    if ($order->getStatus() == 1) {
        echo 1;
        exit();
    }

    OrderUtil::deleteOrderItems($_POST['order_item_id_array']);
    OrderUtil::updateOrderById($_POST['order_id']);
    echo 0;
    exit();
}
echo 2;
exit();
?>