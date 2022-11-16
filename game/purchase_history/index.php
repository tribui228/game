<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/include.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /game/login/");
    exit();
}
?>
<?php $GLOBALS['headerType'] = 'other'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<body>
    <div id="history">
        <?php include 'history.php';?>
    </div>
</body>

<?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>
</html>