<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

$columnArr = ['date_ordered', 'status', 'total_price', 'quantity'];
$displayArr = array(
    'date_ordered' => 'Date Ordered', 
    'status' => 'Status',
    'total_price' => 'Total Price ($)',
    'quantity' => 'Quantity',
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

$sql = "SELECT * FROM `order` $where $orderBy";
$orders = OrderUtil::getOrdersByQuery($sql);
$page = new Page(count($orders), $maxInPage, 5, $currentPage);
?>