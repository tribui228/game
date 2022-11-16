<?php
/* 
    0: Success: add group permission
    1: Fail: exist group permission
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['id']) && isset($_POST['productName']) && isset($_POST['code']) && isset($_POST['status']) && isset($_POST['dateAdded'])) {
    if (ProductUtil::hasProductCode($_POST['productName'], $_POST['code'])) {
        $productCode = new ProductCode($_POST['id'], $_POST['productName'], $_POST['code'], $_POST['status'], $_POST['dateAdded']);

        ProductUtil::updateProductCode($productCode);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>