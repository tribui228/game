<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/by_product/params.php');

if ($page->getPages() > 0) {
    $begin = $page->getMinIndex();
    $last = $page->getMaxIndex();

    for ($i = $begin; $i <= $last; $i++) :
        $product = $products[$i];
        $name = $product['name'];
        $actualQuantitySold = $product['actual_quantity_sold'];
        $actualRevenue = $product['actual_revenue'];
        $actualDiscount = $product['actual_discount'];
        $actualTotalRevenue = $product['actual_total_revenue'];
        $upcommingQuantitySold = $product['upcomming_quantity_sold'];
        $upcommingRevenue = $product['upcomming_revenue'];
        $upcommingDiscount = $product['upcomming_discount'];
        $upcommingTotalRevenue = $product['upcomming_total_revenue'];
?>

<div class="admin-row" data-name="<?=$name?>">
    <div class="admin-column"> <?=$i + 1?> </div>
    <div class="admin-column"> <?=$name?> </div>
    <div class="admin-column"> <?=$actualQuantitySold?> </div>
    <div class="admin-column"> <?=$actualRevenue?> </div>
    <div class="admin-column"> <?=$actualDiscount?> </div>
    <div class="admin-column"> <?=$actualTotalRevenue?> </div>
    <div class="admin-column"> <?=$upcommingQuantitySold?> </div>
    <div class="admin-column"> <?=$upcommingRevenue?> </div>
    <div class="admin-column"> <?=$upcommingDiscount?> </div>
    <div class="admin-column"> <?=$upcommingTotalRevenue?> </div>
</div>
    
<?php endfor; }?>

<script>
</script>