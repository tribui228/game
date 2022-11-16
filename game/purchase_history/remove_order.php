<?php
/* 
    0: Success: remove genre
    1: Half Success Half Fail: some can remove some cannot remove
    2: Fail: wrong params
    3: Fail: exist product use genre
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    OrderUtil::deleteOrderItemsByOrderId($id);
    OrderUtil::deleteOrderById($id);
    echo 0;
    exit();
}
echo 1;
exit();
?>