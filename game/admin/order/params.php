<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['username', 'total_price', 'quantity', 'status', 'date_ordered', 'date_checked'];
$displayArr = array(
    'username' => 'Customer', 
    'total_price' => 'Total Price ($)',
    'quantity' => 'Quantity',
    'status' => 'Status',
    'date_ordered' => 'Date Ordered',
    'date_checked' => 'Date Checked',
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchUsername = empty($_POST['searchUsername']) ? '' : $_POST['searchUsername'];
$searchMinTotalPrice = empty($_POST['searchMinTotalPrice']) ? '' : $_POST['searchMinTotalPrice'];
$searchMaxTotalPrice = empty($_POST['searchMaxTotalPrice']) ? '' : $_POST['searchMaxTotalPrice'];
$searchMinQuantity = empty($_POST['searchMinQuantity']) ? '' : $_POST['searchMinQuantity'];
$searchMaxQuantity = empty($_POST['searchMaxQuantity']) ? '' : $_POST['searchMaxQuantity'];
$searchStatus = empty($_POST['searchStatus']) ? '' : $_POST['searchStatus'];
$searchFromOrderedDate = empty($_POST['searchFromOrderedDate']) ? '' : $_POST['searchFromOrderedDate'];
$searchToOrderedDate = empty($_POST['searchToOrderedDate']) ? '' : $_POST['searchToOrderedDate'];
$searchFromCheckedDate = empty($_POST['searchFromCheckedDate']) ? '' : $_POST['searchFromCheckedDate'];
$searchToCheckedDate = empty($_POST['searchToCheckedDate']) ? '' : $_POST['searchToCheckedDate'];

$orderBy = "";

if (!empty($sortBy)) {
    $sortBy = $_POST['sortBy'];
    $orderBy = "ORDER BY `$sortBy`";
    if (!empty($sortDir)) {
        $orderBy = $orderBy.' '.$sortDir;
    }
}

$whereArr = array();
$where = "";

if (!empty($searchUsername)) {
    array_push($whereArr, "username LIKE '".$searchUsername."%'");
}

if (($searchStatus) != '') {
    if ($searchStatus == 2) {
        array_push($whereArr, "status = 0");
    }else {
        array_push($whereArr, "status = ".$searchStatus."");
    }
}

if (!empty($searchMinTotalPrice)) {
    array_push($whereArr, "total_price >= ".$searchMinTotalPrice);
}

if (!empty($searchMaxTotalPrice)) {
    array_push($whereArr, "total_price <= ".$searchMaxTotalPrice);
}

if (!empty($searchMinQuantity)) {
    array_push($whereArr, "quantity >= ".$searchMinQuantity);
}

if (!empty($searchMaxQuantity)) {
    array_push($whereArr, "quantity <= ".$searchMaxQuantity);
}

if (!empty($searchFromOrderedDate) && !empty($searchToOrderedDate)) {
    array_push($whereArr, "date_ordered BETWEEN '".$searchFromOrderedDate."' AND '".$searchToOrderedDate."'");
}else if (!empty($searchFromOrderedDate)) {
    array_push($whereArr, "date_ordered > '".$searchFromOrderedDate."'");
}else if (!empty($searchToOrderedDate)) {
    array_push($whereArr, "date_ordered > '".$searchToOrderedDate."'");
}

if (!empty($searchFromCheckedDate) && !empty($searchToCheckedDate)) {
    array_push($whereArr, "date_checked BETWEEN '".$searchFromCheckedDate."' AND '".$searchToCheckedDate."'");
}else if (!empty($searchFromCheckedDate)) {
    array_push($whereArr, "date_checked > '".$searchFromCheckedDate."'");
}else if (!empty($searchToCheckedDate)) {
    array_push($whereArr, "date_checked > '".$searchToCheckedDate."'");
}

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT * FROM `order` $where $orderBy";

$orders = OrderUtil::getOrdersByQuery($sql);
$page = new Page(count($orders), $maxInPage, 5, $currentPage);
?>