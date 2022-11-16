<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$columnArr = ['name', 'display', 'developer', 'publisher', 'release_date', 'price', 'sale_display', 'image', 'background_image'];
$displayArr = array(
    'name' => 'Name', 
    'display' => 'Display',
    'developer' => 'Developer',
    'publisher' => 'Publisher',
    'release_date' => 'Release Date',
    'price' => 'Price ($)',
    'sale_display' => 'Sale',
    'image' => 'Image',
    'background_image' => 'Background Image'
);

$maxInPage = empty($_POST['maxInPage']) ? 25 : $_POST['maxInPage'];
$currentPage = empty($_POST['currentPage']) ? 1 : $_POST['currentPage'];
$sortBy = empty($_POST['sortBy']) ? '' : $_POST['sortBy'];
$sortDir = empty($_POST['sortDir']) ? '' : $_POST['sortDir'];
$searchName = empty($_POST['searchName']) ? '' : $_POST['searchName'];
$searchDisplay = empty($_POST['searchDisplay']) ? '' : $_POST['searchDisplay'];
$searchDeveloper = empty($_POST['searchDeveloper']) ? '' : $_POST['searchDeveloper'];
$searchPublisher = empty($_POST['searchPublisher']) ? '' : $_POST['searchPublisher'];
$searchFromReleaseDate = empty($_POST['searchFromReleaseDate']) ? '' : $_POST['searchFromReleaseDate'];
$searchToReleaseDate = empty($_POST['searchToReleaseDate']) ? '' : $_POST['searchToReleaseDate'];
$searchMinPrice = empty($_POST['searchMinPrice']) ? '' : $_POST['searchMinPrice'];
$searchMaxPrice = empty($_POST['searchMaxPrice']) ? '' : $_POST['searchMaxPrice'];
$searchSaleName = empty($_POST['searchSaleName']) ? '' : $_POST['searchSaleName'];
$searchImage = empty($_POST['searchImage']) ? '' : $_POST['searchImage'];
$searchBackgroundImage = empty($_POST['searchBackgroundImage']) ? '' : $_POST['searchBackgroundImage'];
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
    array_push($whereArr, "product.name LIKE '".$searchName."%'");
}

if (!empty($searchDisplay)) {
    array_push($whereArr, "product.display LIKE '".$searchDisplay."%'");
}

if (!empty($searchDeveloper)) {
    array_push($whereArr, "developer LIKE '".$searchDeveloper."%'");
}

if (!empty($searchPublisher)) {
    array_push($whereArr, "publisher LIKE '".$searchPublisher."%'");
}

if (!empty($searchFromReleaseDate) && !empty($searchToReleaseDate)) {
    array_push($whereArr, "release_date BETWEEN '".$searchFromReleaseDate."' AND '".$searchToReleaseDate."'");
}else if (!empty($searchFromReleaseDate)) {
    array_push($whereArr, "release_date >= '".$searchFromReleaseDate."'");
}else if (!empty($searchToReleaseDate)) {
    array_push($whereArr, "release_date <= '".$searchToReleaseDate."'");
}

if (!empty($searchMinPrice)) {
    array_push($whereArr, "price >= ".$searchMinPrice);
}

if (!empty($searchMaxPrice)) {
    array_push($whereArr, "price <= ".$searchMaxPrice);
}

if (!empty($searchSaleName)) {
    if ($searchSaleName == 'no_discount') {
        array_push($whereArr, "(sale_name = "."'$searchSaleName' OR sale_name IS NULL)");
    }else {
        array_push($whereArr, "sale_name = "."'$searchSaleName'");
    }
}

if (!empty($searchImage)) {
    array_push($whereArr, "image LIKE '".$searchImage."%'");
}

if (!empty($searchBackgroundImage)) {
    array_push($whereArr, "background_image LIKE '".$searchBackgroundImage."%'");
}


if (count($whereArr)) {
    $where = "AND ".implode(" AND ", $whereArr);
}

$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description 
        FROM `product` JOIN `sale` 
        WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
            AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
            AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
            OR (sale.name='no_discount')) $where GROUP BY product.name $orderBy";
$products = ProductUtil::getProductsByQuery($sql);

if (!empty($searchGenres)) {
    $newProducts = array();

    foreach ($products as $product) {
        $productGenres = ProductSQL::getProductGenresByName($product->getName());
        $genres = ProductUtil::getGenresByProduct($productGenres);
        if ((!array_diff($searchGenres, $genres))) {
            array_push($newProducts, $product); 
        }
    }

    $products = $newProducts;
}

$page = new Page(count($products), $maxInPage, 5, $currentPage);
?>