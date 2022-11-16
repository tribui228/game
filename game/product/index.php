<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/product/include.php');
session_start();

if (!isset($_GET['name'])) {
    header("Location: /game/browse/");
    exit();
}
$product = ProductUtil::getProductByName($_GET['name']);

if (!isset($product)) {
    header("Location: /game/browse/");
    exit();
}
?>
<link rel="stylesheet" href="/game/css/product.css">
<?php $GLOBALS['headerType'] = 'other'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<?php include 'notice.php'?>
<body>
    <?php
        include 'product.php';
    ?>
</body>
<?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>
</html>