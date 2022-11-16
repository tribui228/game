<?php
/* 
    0: Success: has username and password
    1: Fail: wrong username or password
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/login/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (UserUtil::checkUserPassword($_POST['username'], $_POST['password'])) {
        if (UserUtil::hasPermission($_POST['username'], 'admin.login')) {
            $_SESSION['username'] = $_POST['username'];
            echo 0;
            exit();
        }
    }
}
echo 1;
exit();
?>