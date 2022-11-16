<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['product_name', 'code', 'status', 'date_added'];
$displayArr = array(
    'product_name' => 'Product Name',
    'code' => 'Code',
    'status' => 'Status',
    'date_added' => 'Date Added'
);

$productCodes = null;

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchProductName = empty($_POST['searchProductName']) ? '' : $_POST['searchProductName'];
$searchCode = empty($_POST['searchCode']) ? '' : $_POST['searchCode'];
$searchStatus = empty($_POST['searchStatus']) ? '' : $_POST['searchStatus'];
$searchFromAddedDate = empty($_POST['searchFromAddedDate']) ? '' : $_POST['searchFromAddedDate'];
$searchToAddedDate = empty($_POST['searchToAddedDate']) ? '' : $_POST['searchToAddedDate'];
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

if (!empty($searchProductName)) {
    array_push($whereArr, "code LIKE '%".$searchProductName."%'");
}

if (!empty($searchCode)) {
    array_push($whereArr, "code LIKE '%".$searchCode."%'");
}

if (!empty($searchStatus)) {
    array_push($whereArr, "status LIKE '%".$searchStatus."%'");
}

if (!empty($searchFromAddedDate) && !empty($searchToAddedDate)) {
    array_push($whereArr, "date_added BETWEEN '".$searchFromAddedDate."' AND '".$searchToAddedDate."'");
}else if (!empty($searchFromAddedDate)) {
    array_push($whereArr, "date_added >= '".$searchFromAddedDate."'");
}else if (!empty($searchToAddedDate)) {
    array_push($whereArr, "date_added <= '".$searchToAddedDate."'");
}

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT * FROM product_code $where $orderBy";
$productCodes = ProductUtil::getProductCodesByQuery($sql);
$page = new Page(count($productCodes), $maxInPage, 5, $currentPage);
?>