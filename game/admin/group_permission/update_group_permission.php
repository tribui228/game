<?php
/* 
    0: Success: remove group
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.permission.edit')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['id'])) {
    $groupPermission = GroupUtil::getGroupPermissionById($_POST['id']);

    $value = $groupPermission->getValue() == 0 ? 1 : 0;
    $groupPermission->setValue($value);
    GroupUtil::updateGroupPermission($groupPermission);
    echo $value;
    exit();
}
echo 2;
exit();
?>