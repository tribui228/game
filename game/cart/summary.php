<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<?php 
$totalPrice = 0;
$totalDiscount = 0;
$totalFinal = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $product = ProductUtil::getProductByName($key); 
        $discount = doubleval($product->getDiscount()) * 100;
        $price = round($product->getPrice() * $value, 2);
        $price2 = round(doubleval($product->getPrice()) * (1 - doubleval($product->getDiscount())), 2) * $value;    
        
        $totalPrice += $price; 
        $totalDiscount += $price - $price2;
        $totalFinal += $price2; 
    }

    if ($totalDiscount > 0) {
        $totalDiscount = '-'.$totalDiscount;
    }
}
?>

<style>
.cart-text {
    font-size: 1.0rem;
    font-weight: 600;
}

.cart-checkout {
    color: white;
    background-color: var(--primary);
    border: 1px solid var(--primary);
    margin-top: 1rem;
}

.cart-not-checkout {
    border: 1px solid var(--primary);
    margin-top: 1rem;
}

.cart-checkout:focus {
    color: var(--sub-color);
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}

.cart-checkout-lock {
    color: white;
    background-color: var(--danger);
    height: unset;
}

.cart-checkout-lock.form-control:focus {
    color: white;
    background-color: var(--danger);
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
</style>

<div>
    <div class="float-left cart-text"> Total Price </div>
    <div class="float-right cart-text"> <?=number_format($totalPrice, 2, '.', '')?> </div>
    <div class="clearfix"> </div>
</div>

<div>
    <div class="float-left cart-text"> Total Discount </div>
    <div class="float-right cart-text"> <?=number_format($totalDiscount, 2, '.', '')?> </div>
    <div class="clearfix"> </div>
</div>

<hr />

<div>
    <div class="float-left cart-text"> Final Price </div>
    <div class="float-right cart-text"> <?=number_format($totalFinal, 2, '.', '')?> </div>
    <div class="clearfix"> </div>

    <?php if (!CartUtil::isCartEmpty()) { ?>
        <?php if (!isset($_SESSION['username'])) : ?>
            <a href="/game/login">
                <button class="cart-not-checkout form-control font-weight-bold"> Login to check out </button>
            </a>
        <?php elseif (!UserUtil::checkFullInformationUser($_SESSION['username'])) : ?>
            <button id="cart-edit-information" class="cart-not-checkout form-control font-weight-bold"> Full fill your information </button>
        <?php elseif (UserUtil::hasPermission($_SESSION['username'], 'user.checkout.lock')) : ?>
            <button id="cart-checkout-lock" class="cart-not-checkout form-control font-weight-bold cart-checkout-lock"> Your account has been locked in payment </button>
        <?php else : ?>
            <button class="cart-checkout form-control bg-primary font-weight-bold"> Check out </button>
        <?php endif ?>
    <?php } ?>
</div>

<script>
    function updateSummary() {
        $.ajax({
            url: "summary.php", 
            success: function(result){
                $(".cart-summary").html(result);
            }
        });
    }

    $('.cart-checkout-lock').click(function() {
        window.alert("Maybe you have violated our purchase rules so we're locked your account on checkout!");
    })

    $('.cart-checkout').click(function() {
        $.ajax({
            url: "order_information.php",
            success: function(result) {
                $("#modal-content").html(result);
                showModal();
            }
        });
    });

    <?php if (isset($_SESSION['username'])) : ?>
    $("#cart-edit-information").click(function() {
        $.ajax({
            url: "/game/header/login/edit_information_form.php",
            method: "POST",
            data: {"username": "<?=$_SESSION['username']?>", "reload": 1},
            success: function(result){
                $("#modal-content").html(result);
                showModal();
            }
        });
    });
    <?php endif; ?>
</script>