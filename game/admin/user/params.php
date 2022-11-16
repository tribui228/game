<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['username', 'group', 'firstname', 'lastname', 'birth', 'address', 'phone', 'email'];
$displayArr = array(
    'username' => 'Username', 
    'group' => 'Group',
    'firstname' => 'Firstname',
    'lastname' => 'Lastname',
    'birth' => 'Birth',
    'address' => 'Address',
    'phone' => 'Phone',
    'email' => 'Email',
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchUsername = empty($_POST['searchUsername']) ? '' : $_POST['searchUsername'];
$searchGroup = empty($_POST['searchGroup']) ? '' : $_POST['searchGroup'];
$searchFirstname = empty($_POST['searchFirstname']) ? '' : $_POST['searchFirstname'];
$searchLastname = empty($_POST['searchLastname']) ? '' : $_POST['searchLastname'];
$searchFromBirthDate = empty($_POST['searchFromBirthDate']) ? '' : $_POST['searchFromBirthDate'];
$searchToBirthDate = empty($_POST['searchToBirthDate']) ? '' : $_POST['searchToBirthDate'];
$searchAddress = empty($_POST['searchAddress']) ? '' : $_POST['searchAddress'];
$searchPhone = empty($_POST['searchPhone']) ? '' : $_POST['searchPhone'];
$searchEmail = empty($_POST['searchEmail']) ? '' : $_POST['searchEmail'];

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

if (!empty($searchGroup)) {
    array_push($whereArr, "`group` LIKE '".$searchGroup."%'");
}

if (!empty($searchFirstname)) {
    array_push($whereArr, "firstname LIKE '".$searchFirstname."%'");
}

if (!empty($searchLastname)) {
    array_push($whereArr, "lastname LIKE '".$searchLastname."%'");
}

if (!empty($searchFromBirthDate) && !empty($searchToBirthDate)) {
    array_push($whereArr, "birth BETWEEN '".$searchFromBirthDate."' AND '".$searchToBirthDate."'");
}else if (!empty($searchFromBirthDate)) {
    array_push($whereArr, "birth > '".$searchFromBirthDate."'");
}else if (!empty($searchToBirthDate)) {
    array_push($whereArr, "birth > '".$searchToBirthDate."'");
}

if (!empty($searchAddress)) {
    array_push($whereArr, "address LIKE '".$searchAddress."%'");
}

if (!empty($searchPhone)) {
    array_push($whereArr, "phone LIKE '".$searchPhone."%'");
}

if (!empty($searchEmail)) {
    array_push($whereArr, "email LIKE '".$searchEmail."%'");
}

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT * FROM user $where $orderBy";
$users = UserUtil::getUsersByQuery($sql);
$page = new Page(count($users), $maxInPage, 5, $currentPage);
?>