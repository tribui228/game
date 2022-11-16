<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ProGame </title>
    <link rel="shortcut icon" type="image/png" href="/game/img/icon.png">
    <link rel="stylesheet" href="/game/css/style.css">
    <link rel="stylesheet" href="/game/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/game/node_modules/jquery/dist/jquery.js"></script>
    <script src="/game/node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="/game/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/game/node_modules/xregexp/xregexp-all.js"></script>
    <script src="/game/js/api.js"></script>
</head>