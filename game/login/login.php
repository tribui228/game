<?php
/* 
    0: Success: has username and password
    1: Fail: wrong username or password
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/login/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (UserUtil::hasPermission($_POST['username'], 'user.lock') && !UserUtil::hasPermission($_POST['username'], 'admin.login')) {
        echo 2;
        exit();
    }
    if (!UserUtil::hasPermission($_POST['username'], 'user.login')) {
        echo 1;
        exit();
    }
    if (UserUtil::checkUserPassword($_POST['username'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        echo 0;
        exit();
    }
}
echo 3;
exit();
?>