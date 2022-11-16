<?php
/* 
0: Success
1: Cart Empty
other: Some product do not have enough code
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/include.php');
if (!CartUtil::isCartEmpty()) {
    $illegalProduct = CartUtil::getIllegalProductInCart();

    if (count($illegalProduct) > 0) {
        $productAlert = array();

        foreach ($illegalProduct as $key => $value) {
            $product = ProductUtil::getProductByName($key);
            if (is_null($product)) {
                continue;
            }

            array_push($productAlert, array(
                "name" => $product->getName(),
                "display" => $product->getDisplay(),
                "left" => $value
            ));
        }

        echo json_encode($productAlert);
        exit();
    }

    $order = CartUtil::getOrderFromCart();
    $id = OrderUtil::insertOrder($order);

    $orderItems = CartUtil::getOrderItemsFromCartWithoutCheck($id);
    OrderUtil::insertOrderItems($orderItems);

    CartUtil::clearCart();

    echo 0;
    exit();
}

echo 1;
exit();
?>