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

if (isset($_POST['order_id'])) {
    $order = OrderUtil::getOrderById($_POST['order_id']);

    if ($order->getStatus() == 1) {
        echo 2;
        exit();
    }
    if (!OrderUtil::checkOrderApprovalById($_POST['order_id'])) {
        echo 1;
        exit();
    }
    OrderUtil::approveOrderById($_POST['order_id']);
    echo 0;
    exit();
}
echo 3;
exit();
?>