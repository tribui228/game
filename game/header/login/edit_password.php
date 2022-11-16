<?php
/* 
    0: Success: create user
    1: Fail: exist user
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['current_password']) && isset($_POST['new_password'])) {
    if (UserUtil::hasUserName($_POST['username'])) {
        if (UserUtil::checkUserPassword($_POST['username'], $_POST['current_password'])) {
            UserUtil::setUserPassword($_POST['username'], $_POST['new_password']);
            echo 0;
            exit();
        }
    }
}
echo 1;
exit();
?>