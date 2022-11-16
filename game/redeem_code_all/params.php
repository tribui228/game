<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

$columnArr = ['date_ordered', 'product_name', 'price', 'discount', 'code'];
$displayArr = array(
    'date_ordered' => 'Date Ordered',
    'product_name' => 'Game', 
    'price' => 'Price ($)',
    'discount' => 'Discount (%)',
    'code' => 'Code',
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];

$orderBy = "";

$where = "";
$whereArr = array();

if (!empty($sortBy)) {
    $sortBy = $_POST['sortBy'];
    $orderBy = "ORDER BY `$sortBy`";
    if (!empty($sortDir)) {
        $orderBy = $orderBy.' '.$sortDir;
    }
}

array_push($whereArr, "username = '".$_SESSION['username']."'");

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT order_item.id, order_item.order_id, order_item.product_name, order_item.code, order_item.price, order_item.discount, `order`.date_ordered FROM `order_item` INNER JOIN `order` ON order_item.order_id = `order`.id $where $orderBy";
$orderItems = OrderUtil::getOrderItemsByQuery($sql);
$page = new Page(count($orderItems), $maxInPage, 5, $currentPage);
?>