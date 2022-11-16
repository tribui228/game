<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['permission', 'value'];
$displayArr = array(
    'permission' => 'Permission',
    'value' => 'Value',
);
$dirArr = ['ASC', 'DESC'];

$userPermissions = null;
if (!isset($_POST['username'])) {
    return;
}

$sortBy = null;
$sortDir = null;

if (isset($_POST['sortBy']) && isset($_POST['sortDir'])) {
    $sortBy = $_POST['sortBy'];
    $sortDir = $_POST['sortDir'];
    
    if (!in_array($sortBy, $columnArr)) {
        $sortBy = null;
    }

    if (!in_array($sortDir, $dirArr)) {
        $sortDir = null;
    }

    if (!is_null($sortBy) && !is_null($sortDir)) {
        $userPermissions = UserUtil::getUserPermissionsByUsernameAndOrder($_POST['username'], $sortBy, $sortDir);
    }
}

if (is_null($userPermissions)) {
    $userPermissions = UserUtil::getUserPermissionsByUsername($_POST['username']);
}
?>