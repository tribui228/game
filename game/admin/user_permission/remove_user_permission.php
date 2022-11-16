<?php
/* 
    0: Success: remove user
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.permission.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['id_array'])) {
    foreach ($_POST['id_array'] as $id) {
        if (UserUtil::hasUserPermissionById($id)) {
            UserUtil::deleteUserPermissionById($id);
        }
    }
    echo 0;
    exit();
}
echo 1;
exit();
?>