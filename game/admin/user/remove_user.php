<?php
/* 
    0: Success: remove user
    1: Fail: cannot current account session
    2: Fail: wrong params
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['username_array'])) {
    $currentAccount = false;
    
    foreach ($_POST['username_array'] as $username) {
        if ($_SESSION['username'] == $username) {
            $currentAccount = true;
            continue;
        }

        if (UserUtil::hasUsername($username)) {
            if (!UserUtil::hasPermission($username, 'admin.user.remove.prevent')) {
                UserUtil::deleteUserByUsername($username);
            }
        }
    }
    if ($currentAccount) {
        echo 1;
        exit();
    }

    echo 2;
    exit();
}
echo 1;
exit();
?>