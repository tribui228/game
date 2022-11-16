<?php
if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

$whereArr = array();

date_default_timezone_set('Asia/Ho_Chi_Minh');
$type = empty($_POST['type']) ? 'revenue' : $_POST['type'];
$searchFromDate = empty($_POST['searchFromDate']) ? date("Y-m-d",strtotime("-1 month")) : $_POST['searchFromDate'];
$searchToDate = empty($_POST['searchToDate']) ? date('Y-m-d') : $_POST['searchToDate'];
$searchGenres = empty($_POST['searchGenres']) ? '' : $_POST['searchGenres'];

if (!empty($searchFromDate) && !empty($searchToDate)) {
    array_push($whereArr, "`order`.`date_checked` BETWEEN '".$searchFromDate."' AND '".$searchToDate."'");
}else if (!empty($searchFromDate)) {
    array_push($whereArr, "`order`.`date_checked` >= '".$searchFromDate."'");
}else if (!empty($searchToDate)) {
    array_push($whereArr, "`order`.`date_checked` <= '".$searchToDate."'");
}

$where = "";
if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$typeSQL = "";
$title = "";
$xTitle = "";

if ($type == 'revenue') {
    $typeSQL = "SUM(ROUND(`order_item`.price * (1-`order_item`.`discount`), 2))";
    $title = "Top Game By Revenue";
    $xTitle = "Dollar ($)";
}else {
    $typeSQL = "COUNT(`product`.name)";
    $title = "Top Game By Sales";
    $xTitle = "Quantity";
}

$sql = "SELECT `order_item`.`product_name`, `product`.display, $typeSQL AS total_price 
        FROM `order_item` INNER JOIN `product` ON `order_item`.`product_name` = `product`.`name` 
                            INNER JOIN `order` ON `order_item`.`order_id` = `order`.`id` 
        $where
        GROUP BY `order_item`.product_name 
        ORDER BY `total_price` DESC";

$topProducts = toArray(execute($sql));

if (!empty($searchGenres)) {
    $newProducts = array();
    foreach ($topProducts as $row) {
        $productGenres = ProductSQL::getProductGenresByName($row['product_name']);
        $genres = ProductUtil::getGenresByProduct($productGenres);
        if ((!array_diff($searchGenres, $genres))) {
            array_push($newProducts, $row); 
        }
    }
    $topProducts = $newProducts;
}
?>