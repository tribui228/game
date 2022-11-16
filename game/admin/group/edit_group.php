<?php
/* 
    0: Success: create group
    1: Fail: exist group
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['name']) && isset($_POST['display'])) {
    if (GroupUtil::hasGroupName($_POST['name'])) {
        $group = new Group($_POST['name'], $_POST['display']);

        GroupUtil::updateGroup($group);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>