<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/product/params.php');

if ($page->getPages() > 0) {
    $begin = $page->getMinIndex();
    $last = $page->getMaxIndex();

    for ($i = $begin; $i <= $last; $i++) :
        $product = $products[$i];
        $name = $product->getName();
        $display = $product->getDisplay();
        $developer = $product->getDeveloper();
        $publisher = $product->getPublisher();
        $releaseDate = $product->getReleaseDate();
        $price = $product->getPrice();
        $saleDisplay = $product->getSaleDisplay();
        $image = $product->getImage();
        $backgroundImage = $product->getBackgroundImage();
        $imageSrc = ProductUtil::getProductImage($image);
        $backgroundImageSrc = ProductUtil::getProductImage($backgroundImage);
?>

<div class="admin-row" data-name="<?=$name?>">
    <div class="admin-column not-edit checkbox"> <input class="admin-checkbox" type="checkbox" data-name="<?=$name?>"></div>
    <div class="admin-column not-edit"> <?=$name?> </div>
    <div class="admin-column"> <?=$display?> </div>
    <div class="admin-column"> <?=$developer?> </div>
    <div class="admin-column"> <?=$publisher?> </div>
    <div class="admin-column"> <?=$releaseDate?> </div>
    <div class="admin-column"> <?=$price?> </div>
    <div class="admin-column"> <?=$saleDisplay?> </div>
    <div class="admin-column admin-image disable-click" data-src="<?=$imageSrc?>"> <?=$image?> </div>
    <div class="admin-column admin-background-image disable-click" data-src="<?=$backgroundImageSrc?>"> <?=$backgroundImage?> </div>
</div>
    
<?php endfor; }?>

<script>
    function updateCheckboxAll() {
        let all = true;
        $(".admin-checkbox:not(.all)").each(function() {
            if (all && !$(this)[0].checked) {
                all = false;
            }
        });

        $(".admin-checkbox.all").prop('checked', all);
    }

    $(".admin-image").click(function(e) {
        let src = e.currentTarget.dataset.src;
        
        showImageWithVerticalSrc(src);
    });

    $(".admin-background-image").click(function(e) {
        let src = e.currentTarget.dataset.src;
        
        showImageWithSrc(src);
    });

    $(".admin-checkbox").click(function(e) {
        let target = e.currentTarget;

        if (target.classList.contains('all')) {
            $(".admin-checkbox:not(.all)").prop('checked', target.checked);
        }else {
            updateCheckboxAll();
        }
    });

    $(".admin-column:not(.checkbox):not(.disable-click)").click(function(e) {
        let parent = e.currentTarget.parentElement;

        if (parent.dataset.name == null) {
            return;
        }

        let checkbox = $(".admin-checkbox[data-name=" + parent.dataset.name + "]")[0];
        checkbox.checked = !checkbox.checked;
        updateCheckboxAll();
    });
</script>