<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['product_name', 'code', 'price', 'discount'];
$displayArr = array(
    'product_name' => 'Product', 
    'code' => 'Code',
    'price' => 'Price ($)',
    'discount' => 'Discount (%)',
);
$dirArr = ['ASC', 'DESC'];

$orderItems = null;
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
        $orderItems = OrderUtil::getOrderItemsByOrderIdAndOrder($_POST['id'], $sortBy, $sortDir);
    }
}

if (is_null($orderItems)) {
    $orderItems = OrderUtil::getOrderItemsByOrderId($_POST['id']);
}
?>