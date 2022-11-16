<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/include.php');
include_once (LOCAL_PATH_ROOT.'/game/redeem_code/params.php');

$index = 0;
?>

<?php
if ($page->getPages() > 0) {
    $begin = $page->getMinIndex();
    $last = $page->getMaxIndex();
    $index = $begin;

    for ($i = $begin; $i <= $last; $i++) :
        $orderItem = $orderItems[$i];
        $index++;
        $productName = $orderItem->getProductName();
        $product = ProductUtil::getProductByName($productName);
        if (!is_null($product)) {
            $productName = $product->getDisplay();
        }
        $price = $orderItem->getPrice();
        $discount = $orderItem->getDiscount() * 100;
        $code = $orderItem->getCode();
    ?>
    <div class="code-row">
        <div class="code-column"> <?=$index?> </div>
        <div class="code-column"> <?=$productName?> </div>
        <div class="code-column"> <?=$price?> </div>
        <div class="code-column"> <?=$discount?> </div>
        <div class="code-column"> <?=empty($code) ? 'None' : $code?> </div>
    </div>
<?php endfor; } ?>