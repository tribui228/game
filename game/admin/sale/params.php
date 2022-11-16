<?php
$columnArr = ['name', 'display', 'discount', 'date_begin', 'date_end'];
$displayArr = array(
    'name' => 'Name', 
    'display' => 'Display',
    'discount' => 'Discount',
    'date_begin' => 'Date Begin',
    'date_end' => 'Date End',
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchName = empty($_POST['searchName']) ? '' : $_POST['searchName'];
$searchDisplay = empty($_POST['searchDisplay']) ? '' : $_POST['searchDisplay'];
$searchMinDiscount = empty($_POST['searchMinDiscount']) ? '' : $_POST['searchMinDiscount'];
$searchMaxDiscount = empty($_POST['searchMaxDiscount']) ? '' : $_POST['searchMaxDiscount'];
$searchFromBeginDate = empty($_POST['searchFromBeginDate']) ? '' : $_POST['searchFromBeginDate'];
$searchToBeginDate = empty($_POST['searchToBeginDate']) ? '' : $_POST['searchToBeginDate'];
$searchFromEndDate = empty($_POST['searchFromEndDate']) ? '' : $_POST['searchFromEndDate'];
$searchToEndDate = empty($_POST['searchToEndDate']) ? '' : $_POST['searchToEndDate'];

$orderBy = "";

if (!empty($sortBy)) {
    $sortBy = $_POST['sortBy'];
    $orderBy = "ORDER BY $sortBy";
    if (!empty($sortDir)) {
        $orderBy = $orderBy.' '.$sortDir;
    }
}

$whereArr = array();
$where = "";

if (!empty($searchName)) {
    array_push($whereArr, "name LIKE '".$searchName."%'");
}

if (!empty($searchDisplay)) {
    array_push($whereArr, "display LIKE '".$searchDisplay."%'");
}

if (!empty($searchMinDiscount)) {
    array_push($whereArr, "discount >= ".$searchMinDiscount/100);
}

if (!empty($searchMaxDiscount)) {
    array_push($whereArr, "discount <= ".$searchMaxDiscount/100);
}

if (!empty($searchFromBeginDate) && !empty($searchToBeginDate)) {
    array_push($whereArr, "(date_begin IS NULL OR (date_begin BETWEEN '".$searchFromBeginDate."' AND '".$searchToBeginDate."'))");
}else if (!empty($searchFromBeginDate)) {
    array_push($whereArr, "(date_begin IS NULL OR (date_begin >= '".$searchFromBeginDate."'))");
}else if (!empty($searchToBeginDate)) {
    array_push($whereArr, "(date_begin IS NULL OR (date_begin <= '".$searchToBeginDate."'))");
}

if (!empty($searchFromEndDate) && !empty($searchToEndDate)) {
    array_push($whereArr, "((date_end IS NULL AND DATE(NOW()) BETWEEN '".$searchFromEndDate."' AND '".$searchToEndDate."') OR (date_end IS NOT NULL AND (date_end BETWEEN '".$searchFromEndDate."' AND '".$searchToEndDate."')))");
}else if (!empty($searchFromEndDate)) {
    array_push($whereArr, "((date_end IS NULL AND DATE(NOW()) >= '".$searchFromEndDate."') OR (date_end IS NOT NULL AND (date_end >= '".$searchFromEndDate."')))");
}else if (!empty($searchToEndDate)) {
    array_push($whereArr, "((date_end IS NULL AND DATE(NOW()) <= '".$searchToEndDate."') OR (date_end IS NOT NULL AND (date_end <= '".$searchToEndDate."')))");
}

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT * FROM sale $where $orderBy";
$sales = SaleUtil::getSalesByQuery($sql);
$page = new Page(count($sales), $maxInPage, 5, $currentPage);
?>