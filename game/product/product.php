<!DOCTYPE html>
<html lang="en">

<?php
if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $product = ProductUtil::getProductByName($name);

    $image = $product->getBackgroundImage();
    $imageLink = ProductUtil::getProductImage($image);
    $display = $product->getDisplay();
    $developer = $product->getDeveloper();
    $publisher = $product->getPublisher();
    $discount = doubleval($product->getDiscount()) * 100;
    $price = $product->getPrice();
    $price2 = doubleval($product->getPrice()) * (1 - doubleval($product->getDiscount()));
    $releasedate = $product->getReleaseDate();
    $description = $product->getDescription();

    $minimumSystem = ProductUtil::getSystemRequirementsById($product->getMinimumSystemRequirementsId());
    $recommendedSystem = ProductUtil::getSystemRequirementsById($product->getRecommendedSystemRequirementsId());

    $genre = GenreUtil::getGenresByProduct($name);
}
?>

<body>
    <div id="product">
        <div id="product-background">
        </div>
        
        <div class="product-description">
            <div class="container mt-3">
                <div id="product-description-header">
                    <h1 id="product-description-display"> <?=$display;?> </h1>
                    <div id="product-cart">
                        <div class="product-cart-price">
                            <?php
                            if ($discount > 0) {
                                echo '<span class="product-cart-discount float-left badge bg-primary text-white"> -'.$discount.'% </span>';
                            }
                            ?>
                            <span class="float-right badge">
                            
                            <?php
                                if ($discount > 0) {
                                    echo '<span class="product-cart-discount-price text-decoration-line-through text-secondary mr-1"> $'.round($price, 2).' </span>';
                                }
                            ?>
                            <span class="product-cart-final-price text-white"> $<?=round($price2, 2)?> </span>
                            <span class="clearfix"> </span>
                        </div>
                        <form class="product-confirm m-0" action="/game/product/add_cart.php" method="GET" onsubmit="return false;">
                            <button id="add-cart" type="submit" name="name" value="<?=$name?>" class="btn btn-primary w-100 font-weight-bold">
                                Add to cart
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#description">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gamedetails"> Game Details </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#systemrequirements"> System Requirements </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="description" class="container tab-pane active"><br>
                        <h1 class="title"> Description </h1>
                        <?=empty($description) ? '(No description)' : $description?>
                    </div>
                    <div id="gamedetails" class="container tab-pane fade"><br>
                        <div class="content-summary-section">
                            <h1 class="title"> Game Details </h1>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-4 pl-0">
                                        <div class="details-category"> Developer: </div>
                                        <div class="details-content">
                                            <?=$developer?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 pl-0">
                                        <div class="details-category"> Publisher:</div>
                                        <div class="details-content">
                                            <?=$publisher?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 pl-0">
                                        <div class="details-category"> Release Date: </div>
                                        <div class="details-content">
                                            <?=$releasedate?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 pl-0">
                                        <div class="details-category"> Tags: </div>
                                        <div class="details-content">
                                            <?php for($i=0;$i<count($genre);$i++):?>
                                                <a href="/game/browse/?tag=<?=$genre[$i]->getName()?>"><span><?=$genre[$i]->getDisplay()?></span></a>
                                            <?php endfor;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="systemrequirements" class="container tab-pane fade"><br>
                        <div class="content-summary-section">
                            <h1 class=""> System Requirements </h1>
                            
                            <?php if (is_null($minimumSystem) && is_null($recommendedSystem)) : ?>
                                (No information)

                            <?php else: ?>
                            <div class="container">
                                <div class="row">
                                    <?php if (!is_null($minimumSystem)) : ?>
                                    <div class="col-12 col-lg-6 pl-0">
                                        <h4 class="title">Minimum System Requirements</h4>
                                        <table class="product-table table">
                                            <tr>
                                                <td> OS:</td>
                                                <td> <?=$minimumSystem->getOS()?> </td>
                                            </tr>
                                            <tr>
                                                <td> Processsor: </td>
                                                <td> <?=$minimumSystem->getProcessor()?> </td>
                                            </tr>
                                            <tr>
                                                <td>Memory:</td>
                                                <td> <?=$minimumSystem->getMemory()?> </td>
                                            </tr>
                                            <tr>
                                                <td>Graphics:</td>
                                                <td> <?=$minimumSystem->getGraphics()?> </td>
                                            </tr>
                                            <tr>
                                                <td> Sound Card:</td>
                                                <td> <?=$minimumSystem->getSoundCard()?> </td>
                                            </div>
                                            <tr>
                                                <td> Storage: </td>
                                                <td> <?=$minimumSystem->getStorage()?> </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php endif; ?>

                                    <?php if (!is_null($recommendedSystem)) : ?>
                                    <div class="col-12 col-lg-6 pl-0">
                                        <h4 class="title">Recommended System Requirements</h4>
                                        <table class="product-table table">
                                            <tr>
                                                <td> OS:</td>
                                                <td> <?=$recommendedSystem->getOS()?> </td>
                                            </tr>
                                            <tr>
                                                <td> Processsor: </td>
                                                <td> <?=$recommendedSystem->getProcessor()?> </td>
                                            </tr>
                                            <tr>
                                                <td>Memory:</td>
                                                <td> <?=$recommendedSystem->getMemory()?> </td>
                                            </tr>
                                            <tr>
                                                <td>Graphics:</td>
                                                <td> <?=$recommendedSystem->getGraphics()?> </td>
                                            </tr>
                                            <tr>
                                                <td> Sound Card:</td>
                                                <td> <?=$recommendedSystem->getSoundCard()?> </td>
                                            </div>
                                            <tr>
                                                <td> Storage: </td>
                                                <td> <?=$recommendedSystem->getStorage()?> </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $(".nav-tabs a").click(function () {
                        $(this).tab('show');
                    });
                });

                document.getElementById("product-background").style.backgroundImage = "url('<?=$imageLink?>')";
            </script>
        </div>
    </div>
</body>

<script>
    $("#add-cart").click(function (e) {
        $.ajax({
            url: "add_cart.php",
            method: "POST",
            data: {
                "name": "<?=$name?>"
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