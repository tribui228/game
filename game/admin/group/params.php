<?php
$columnArr = ['name', 'display'];
$displayArr = array('name' => 'Name', 'display' => 'Display');

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchName = empty($_POST['searchName']) ? '' : $_POST['searchName'];
$searchDisplay = empty($_POST['searchDisplay']) ? '' : $_POST['searchDisplay'];

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

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT * FROM `group` $where $orderBy";
$groups = GroupUtil::getGroupsByQuery($sql);
$page = new Page(count($groups), $maxInPage, 5, $currentPage);
?>