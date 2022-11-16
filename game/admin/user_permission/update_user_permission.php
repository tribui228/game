<?php
/* 
    0: Success: remove group
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.permission.edit')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['id'])) {
    $userPermission = UserUtil::getUserPermissionById($_POST['id']);

    $value = $userPermission->getValue() == 0 ? 1 : 0;
    $userPermission->setValue($value);
    UserUtil::updateUserPermission($userPermission);
    echo $value;
    exit();
}
echo 2;
exit();
?>