<?php
/* 
    0: Success: edit group
    1: Fail: exist group
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['id']) && isset($_POST['group']) && isset($_POST['permission']) && isset($_POST['value'])) {
    if (GroupUtil::hasGroupPermissionByGroup($_POST['group'], $_POST['permission'])) {
        $groupPermission = new GroupPermission($_POST['id'], $_POST['group'], $_POST['permission'], $_POST['value']);

        GroupUtil::updateGroupPermission($groupPermission);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>