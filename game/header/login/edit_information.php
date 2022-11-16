<?php
/* 
    0: Success: create user
    1: Fail: exist user
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birth']) && isset($_POST['address'])) {
    if (UserUtil::hasUserName($_POST['username'])) {
        $user = UserUtil::getUserByUsername($_POST['username']);

        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        $user->setEmail($_POST['email']);
        $user->setPhone($_POST['phone']);
        $user->setBirth($_POST['birth']);
        $user->setAddress($_POST['address']);

        UserUtil::updateUser($user);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>