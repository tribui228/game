<?php
/* 
    0: Success: add group permission
    1: Fail: exist group permission
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['group']) && isset($_POST['permission']) && isset($_POST['value'])) {
    if (!GroupUtil::hasGroupPermissionByGroup($_POST['group'], $_POST['permission'])) {
        $groupPermission = new GroupPermission(0, $_POST['group'], $_POST['permission'], $_POST['value']);

        GroupUtil::addGroupPermission($groupPermission);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>