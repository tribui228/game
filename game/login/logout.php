<?php
/* 
    0: Success: Unset username session and password session
    1: Fail: Nothing to do
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/login/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    echo 0;
    exit();
}
echo 1;
exit();
?>