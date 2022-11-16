<?php
/* 
    0: Success: remove group
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.code.edit')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['id'])) {
    $productCode = ProductUtil::getProductCodeById($_POST['id']);

    $status = $productCode->getStatus() == 0 ? 1 : 0;
    $productCode->setStatus($status);
    ProductUtil::updateProductCode($productCode);
    echo $status;
    exit();
}
echo 2;
exit();
?>