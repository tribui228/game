<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['name', 'actual_quantity_sold', 'actual_revenue', 'actual_discount', 'actual_total_revenue', 'upcomming_quantity_sold', 'upcomming_revenue', 'upcomming_discount', 'upcomming_total_revenue'];
$displayArr = array(
    'name' => 'Name', 
    'actual_quantity_sold' => 'Actual Quantity Sold',
    'actual_revenue' => 'Actual Revenue',
    'actual_discount' => 'Actual Discount',
    'actual_total_revenue' => 'Actual Total Revenue',
    'upcomming_quantity_sold' => 'Upcomming Quantity Sold',
    'upcomming_revenue' => 'Upcomming Revenue',
    'upcomming_discount' => 'Upcomming Discount',
    'upcomming_total_revenue' => 'Upcomming Total Revenue'
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchName = empty($_POST['searchName']) ? '' : $_POST['searchName'];
$searchFromDate = empty($_POST['searchFromDate']) ? '' : $_POST['searchFromDate'];
$searchToDate = empty($_POST['searchToDate']) ? '' : $_POST['searchToDate'];
$searchGenres = empty($_POST['searchGenres']) ? '' : $_POST['searchGenres'];

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
    array_push($whereArr, "genre.name LIKE '".$searchName."%'");
}

if (!empty($searchFromDate) && !empty($searchToDate)) {
    array_push($whereArr, "(`order`.`date_checked` IS NULL AND (`order`.`date_ordered` BETWEEN '".$searchFromDate."' AND '".$searchToDate."')) OR (`order`.`date_checked` IS NOT NULL AND (`order`.`date_checked` BETWEEN '".$searchFromDate."' AND '".$searchToDate."'))");
}else if (!empty($searchFromDate)) {
    array_push($whereArr, "(`order`.date_checked IS NULL AND `order`.date_ordered >= '".$searchFromDate."') OR (`order`.date_checked IS NOT NULL AND (`order`.`date_checked` >= '".$searchFromDate."'))");
}else if (!empty($searchToDate)) {
    array_push($whereArr, "(`order`.date_checked IS NULL AND `order`.date_ordered <= '".$searchToDate."') OR (`order`.date_checked IS NOT NULL AND (`order`.`date_checked` <= '".$searchToDate."'))");
}

if (count($whereArr)) {
    $where = "WHERE ".implode(" AND ", $whereArr);
}

$sql = "SELECT `genre`.name as 'name', 
        SUM(IF(`status`=1, 1, 0)) as 'actual_quantity_sold',
        SUM(ROUND(IF(`status`=1, `order_item`.price, 0), 2)) as 'actual_revenue',
        SUM(ROUND(IF(`status`=1, (`order_item`.price * `order_item`.discount), 0), 2)) as 'actual_discount',
        SUM(ROUND(IF(`status`=1, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'actual_total_revenue',
        SUM(IF(`status`=0, 1, 0)) as 'upcomming_quantity_sold',
        SUM(ROUND(IF(`status`=0, `order_item`.price, 0), 2)) as 'upcomming_revenue',
        SUM(ROUND(IF(`status`=0, (`order_item`.price * `order_item`.discount), 0), 2)) as 'upcomming_discount',
        SUM(ROUND(IF(`status`=0, `order_item`.price * (1 - `order_item`.discount), 0), 2)) as 'upcomming_total_revenue'
        FROM `order_item` INNER JOIN `product` ON `order_item`.`product_name` = `product`.`name` 
                          INNER JOIN `order` ON `order_item`.`order_id` = `order`.`id` 
                          INNER JOIN `product_genre` ON `product_genre`.`product_name` = `product`.`name`
                          INNER JOIN `genre` ON `product_genre`.`genre_name` = `genre`.`name`
        $where 
        GROUP BY `genre`.name
        $orderBy";

$genres = toArray(execute($sql));

$summaryActualQuantitySold = 0;
$summaryActualRevenue = 0;
$summaryActualDiscount = 0;
$summaryActualTotalRevenue = 0;
$summaryUpcommingQuantitySold = 0;
$summaryUpcommingRevenue = 0;
$summaryUpcommingDiscount = 0;
$summaryUpcommingTotalRevenue = 0;
foreach ($genres as $genre) {
    $summaryActualQuantitySold += $genre['actual_quantity_sold'];
    $summaryActualRevenue += $genre['actual_revenue'];
    $summaryActualDiscount += $genre['actual_discount'];
    $summaryActualTotalRevenue += $genre['actual_total_revenue'];
    $summaryUpcommingQuantitySold += $genre['upcomming_quantity_sold'];
    $summaryUpcommingRevenue += $genre['upcomming_revenue'];
    $summaryUpcommingDiscount += $genre['upcomming_discount'];
    $summaryUpcommingTotalRevenue += $genre['upcomming_total_revenue'];
}

$page = new Page(count($genres), $maxInPage, 5, $currentPage);
?>