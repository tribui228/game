<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/browse/include.php');
?>

<div class="container">
    <div class="row">
        <?php
            $page = $GLOBALS['browsePage'];
            if ($page->getPages() > 0) {
                $begin = $page->getMinIndex();
                $last = $page->getMaxIndex();

                $products = $GLOBALS['browseProducts'];

                for ($i = $begin; $i <= $last; $i++) :?>

                <?php
                    $emptyImage = ProductUtil::getEmptyImage();
                    $product = $products[$i];
                    $name = $product->getName();
                    $image = $product->getImage();
                    $display = $product->getDisplay();
                    $developer = $product->getDeveloper();
                    $discount = doubleval($product->getDiscount()) * 100;
                    $price = $product->getPrice();
                    $price2 = doubleval($product->getPrice()) * (1 - doubleval($product->getDiscount()));
                ?>

                <div class="disable-select product-item col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card card-product h-100" role="button">
                        <div class="card-quick-cart">
                            <svg class="card-quick-add" data-name="<?=$name?>" version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200.000000 200.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,200.000000) scale(0.100000,-0.100000)" fill="white" stroke="none"> <path d="M773 1875 c-320 -83 -567 -331 -649 -652 -34 -135 -34 -311 0 -446 82 -322 331 -571 653 -653 135 -34 311 -34 446 0 322 82 571 331 653 653 34 135 34 311 0 446 -82 322 -331 571 -653 653 -134 34 -317 33 -450 -1z m394 -160 c264 -62 480 -278 547 -546 21 -86 21 -252 0 -338 -67 -268 -277 -478 -545 -545 -86 -21 -252 -21 -338 0 -268 67 -484 283 -546 547 -19 81 -19 254 0 337 9 36 37 108 62 160 40 80 61 109 137 186 77 76 106 98 186 137 52 26 122 53 155 61 80 19 263 20 342 1z"/> <path d="M890 1290 l0 -180 -180 0 -180 0 0 -110 0 -110 180 0 180 0 0 -180 0 -180 110 0 110 0 0 180 0 180 180 0 180 0 0 110 0 110 -180 0 -180 0 0 180 0 180 -110 0 -110 0 0 -180z"/> </g> </svg>
                        </div>
                        <a class="h-100 d-flex flex-column" href="/game/product?name=<?=$name?>">
                            <img id="product-image-<?=$i?>" src="<?=$emptyImage?>" alt="" class="card-img">
                            <div>
                                <div class="card-text text-truncate text-white font-weight-bold"> <?=$display?> </div>
                                <div class="card-text text-truncate text-white-50"> <?=$developer?> </div>
                                <div class="card-text mt-2">
                                    <?php
                                        if ($discount > 0) {
                                            echo '<span class="product-discount float-left badge bg-primary text-white"> -'.$discount.'% </span>';
                                        }
                                    ?>
                                    <span class="float-right badge">
                
                                    <?php    
                                        if ($discount > 0) {
                                            echo '<span class="product-discount-price text-decoration-line-through text-secondary mr-1"> $'.number_format($price, 2, '.', '').' </span>';
                                        }
                                    ?>

                                    <span class="product-final-price text-white"> $ <?=number_format($price2, 2, '.', '')?> </span>
                                    <span class="clearfix"> </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <script>
                    function loadImageProduct() {
                        let _img_<?=$i?> = document.getElementById('product-image-<?=$i?>');
                        let newImg = new Image;
                        newImg.onload = function() {
                            _img_<?=$i?>.src = this.src;
                        };
                        newImg.src = "<?=ProductUtil::getProductImage($image)?>";
                    }

                    loadImageProduct();
                </script>
        <?php endfor; } ?>
    </div>
</div>

<script>
    $(".card-quick-add").click(function (e) {
        let name = e.currentTarget.dataset.name;

        $.ajax({
            url: "/game/product/add_cart.php",
            method: "POST",
            data: {
                "name": name
            }, 
            success: function(result) {
                if (result == 0) {
                    callSuccessNotice("Successful add to cart!");
                }else {
                    callDangerNotice("Out of stock!");
                }
            }
        });
    })
</script>