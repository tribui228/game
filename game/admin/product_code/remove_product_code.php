<?php
/* 
    0: Success: remove user
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.code.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['code_id_array'])) {
    foreach ($_POST['code_id_array'] as $id) {
        ProductUtil::deleteProductCodeById($id);
    }
    echo 0;
    exit();
}
echo 1;
exit();
?>