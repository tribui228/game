<?php
/* 
    0: Success: add group permission
    1: Fail: exist group permission
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['productName']) && isset($_POST['code']) && isset($_POST['status'])) {
    if (!ProductUtil::hasProductName($_POST['productName'])) {
        echo 1;
        exit();
    }

    if (!ProductUtil::hasProductCode($_POST['productName'], $_POST['code'])) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $dateAdded = date('Y/m/d H:i:s');
        $productCode = new ProductCode(0, $_POST['productName'], $_POST['code'], $_POST['status'], $dateAdded);

        ProductUtil::addProductCode($productCode);
        echo 0;
        exit();
    }
}
echo 2;
exit();
?>