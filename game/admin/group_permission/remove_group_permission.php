<?php
/* 
    0: Success: remove group
    1: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.permission.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['id_array'])) {
    foreach ($_POST['id_array'] as $id) {
        if (GroupUtil::hasGroupPermissionById($id)) {
            GroupUtil::deleteGroupPermissionById($id);
        }
    }
    echo 0;
    exit();
}
echo 1;
exit();
?>