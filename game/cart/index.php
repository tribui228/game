<?php
include ($_SERVER['DOCUMENT_ROOT'].'/game/include.php');
session_start();
?>

<?php $GLOBALS['headerType'] = 'cart'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<style>
#cart {
    min-height: 100vh;
}

.cart-container {
    display: flex;
    flex-flow: column;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .cart-container {
        flex-flow: row;
    }
}

.cart-shopping-container {
    flex: 1;
    margin-bottom: 1.5rem;
}

.cart-summary-container {
    width: 100%;
}

.cart-title {
    font-size: 1rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-bottom: solid 1px var(--sub-color);
    background-color: var(--sub-color);
}

.cart-products {
    border: solid 1px var(--sub-color);
}

.cart-summary {
    padding: 0.5rem 1rem;
    border: solid 1px var(--sub-color);
}
</style>

<?php include_once (LOCAL_PATH_ROOT.'/game/loading.php');?>
<?php include_once (LOCAL_PATH_ROOT.'/game/modal.php');?>

<div id="cart" class="cart-wrapper container">
    <div class="mt-4"> </div>

    <div class="cart-container">
        <div class="cart-shopping-container">
            <div class="cart-title">
                Cart Shopping
            </div>
            
            <div class="cart-products">
                <?php include 'list_cart.php'?>
            </div>
        </div>

        <div class="cart-summary-container">
            <div class="cart-title">
                <div class="float-left"> Summary </div>
                <div class="float-right"> $ </div>
                <div class="clearfix"> </div>
            </div>

            <div class="cart-summary">
                <?php include 'summary.php'?>
            </div>
        </div>
    </div>
</div>

<?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>