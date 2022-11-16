<?php
/* 
    0: Success: create user
    1: Fail: exist user
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['group']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birth']) && isset($_POST['address'])) {
    if (UserUtil::hasUserName($_POST['username'])) {
        $user = new User($_POST['username'], $_POST['group'], $_POST['firstname'], $_POST['lastname'], $_POST['birth'], $_POST['address'], $_POST['phone'], $_POST['email']);

        UserUtil::updateUser($user);

        if (!empty($_POST['password'])) {
            UserUtil::setUserPassword($_POST['username'], $_POST['password']);
        }
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>