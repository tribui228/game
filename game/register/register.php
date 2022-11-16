<?php
/*
    0: Success
    1: Fail: arguments
    2: Fail: username exists
*/
include ($_SERVER['DOCUMENT_ROOT'].'/game/register/include.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (UserUtil::hasUsername($_POST['username'])) {
        echo '1';
        exit();
    }

    $user = new User($_POST['username'], "customer", null, null, null, null, null, null);

    UserUtil::addUser($user);
    UserUtil::setUserPassword($_POST['username'], $_POST['password']);
    echo '0';
    exit();
}

echo '2';
exit();
?>