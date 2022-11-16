<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: https://'.HTTP_PATH_ROOT.'/game/admin/login/');
    exit();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.login')) {
    header('Location: https://'.HTTP_PATH_ROOT.'/game/');
    exit();
}
?>