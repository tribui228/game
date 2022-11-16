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
    if (!GroupUtil::hasGroupName($_POST['name'])) {
        $group = new Group($_POST['name'], $_POST['display']);

        GroupUtil::addGroup($group);


        include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/group_permission/suggest_group_permission.php');
        $groupPermissions = array();
        foreach ($groupPermissionSuggests as $groupPermissionSuggest) {
            $groupPermission = new GroupPermission(0, $_POST['name'], $groupPermissionSuggest, false);
            array_push($groupPermissions, $groupPermission);
        }
        GroupUtil::insertGroupPermissions($groupPermissions);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>