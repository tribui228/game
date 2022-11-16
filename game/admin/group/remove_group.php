<?php
/* 
    0: Success: remove group
    1: Half Success Half Fail: some can remove some cannot remove
    2: Fail: wrong params
    3: Fail: exist user use group
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['group_array'])) {
    $exist = false;
    $remove = false;

    foreach ($_POST['group_array'] as $name) {
        if ($name == 'default' || $name == 'customer' || $name == 'employee') {
            $exist = true;
            continue;
        }

        if (GroupUtil::hasGroupName($name)) {
            $users = UserUtil::getUsersByGroupName($name);
    
            if (count($users) > 0) {
                $exist = true;
            }else {
                $remove = true;
                
                GroupUtil::deleteGroupPermissionsByGroupName($name);
                GroupUtil::deleteGroupByName($name);
            }
        }
    }

    if ($exist && $remove) {
        echo 1;
        exit();
    }

    if ($remove) {
        echo 0;
        exit();
    }

    if ($exist) {
        echo 2;
        exit();
    }
}
echo 3;
exit();
?>