<?php
/* 
    0: Success: edit user
    1: Fail: exist user
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['permission']) && isset($_POST['value'])) {
    if (UserUtil::hasUserPermissionByUsername($_POST['username'], $_POST['permission'])) {
        $userPermission = new UserPermission($_POST['id'], $_POST['username'], $_POST['permission'], $_POST['value']);

        UserUtil::updateUserPermission($userPermission);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>