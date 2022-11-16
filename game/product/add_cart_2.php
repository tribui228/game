<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/product/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_GET['name'])) {
    $product = ProductUtil::getProductByName($_GET['name']);
    $name = $_GET['name'];

    if (isset($product)) {
        $oldAmount = 0;

        if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$name])) {
            $oldAmount = $_SESSION['cart'][$name];
            $_SESSION['cart'][$name] += 1;
        }else {
            $oldAmount = 0;
            $_SESSION['cart'][$name] = 1;
        }
        
        if (!ProductUtil::hasProductCodeByNameAndStatusWithAmount($name, 0, $_SESSION['cart'][$name])) {
            if ($oldAmount != 0) {
                $_SESSION['cart'][$name] = $oldAmount;
            }else {
                unset($_SESSION['cart'][$name]);
            }
            header("Location: /game/product/?name=$name&status=0");
            exit();
        }
        header("Location: /game/product/?name=$name&status=1");
        exit();
    }
}
header("Location: /game/browse/");
?>