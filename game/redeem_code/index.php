<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/include.php');
if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: /game/login/");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: /game/purchase_history/");
    exit();
}
$order = OrderUtil::getOrderById($_GET['id']);

if ($order->getUsername() != $_SESSION['username']) {
    header("Location: /game/purchase_history/");
    exit();
}
?>
<?php $GLOBALS['headerType'] = 'other'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<body>
    <div id="code">
    <?php include 'code.php';?>
    </div>
</body>

<?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>
</html>