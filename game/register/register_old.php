<?php
/*
    0: Success
    1: Fail: arguments
    2: Fail: username exists
*/
include ($_SERVER['DOCUMENT_ROOT'].'/game/register/include.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birth']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['email'])) {
    if (UserUtil::hasUsername($_POST['username'])) {
        echo '2';
        exit();
    }

    $user = new User($_POST['username'], "customer", $_POST['lastname'], $_POST['firstname'], $_POST['birth'], $_POST['address'], $_POST['phone'], $_POST['email']);

    UserUtil::addUser($user);
    UserUtil::setUserPassword($_POST['username'], $_POST['password']);
    echo '0';
    exit();
}

echo '1';
exit();
?>