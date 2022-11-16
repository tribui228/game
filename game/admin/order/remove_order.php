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

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['order_id_array'])) {
    $remove = false;
    $check = false;

    foreach ($_POST['order_id_array'] as $id) {
        $order = OrderUtil::getOrderById($id);

        if ($order->getStatus() == 1) {
            $check = true;
            continue;
        }
        OrderUtil::deleteOrderItemsByOrderId($id);
        OrderUtil::deleteOrderById($id);
        $remove = true;
    }

    if ($remove && $check) {
        echo 1;
        exit();
    }
    if ($check) {
        echo 2;
        exit();
    }
    echo 0;
    exit();
}
echo 3;
exit();
?>