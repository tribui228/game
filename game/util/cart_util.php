<?php
class CartUtil {
    public static function isCartEmpty() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            return true;
        }
        
        $empty = true;
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value > 0) {
                return false;
            }
        }
        return true;
    }

    public static function clearCart() {
        unset($_SESSION['cart']);
    }

    public static function getOrderFromCart() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        $username = $_SESSION['username'];
        $totalPrice = 0;
        $quantity = 0;
        $status = 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $dateOrdered = date('Y/m/d H:i:s');
        $dateChecked = NULL;

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                $product = ProductUtil::getProductByName($key);

                if (is_null($product)) {
                    continue;
                }
                $totalPrice += ($product->getPrice() * (1 - $product->getDiscount()))*$value;
                $quantity += $value;
            }
        }

        $totalPrice = round($totalPrice, 2);
        $order = new Order(0, $username, $totalPrice, $quantity, $status, $dateOrdered, $dateChecked);
        return $order;
    }

    public static function getOrderItemsFromCartWithoutCheck($orderId = 0) {
        $orderItems = array();

        if (isset($_SESSION['cart'])) {
            
            foreach ($_SESSION['cart'] as $key => $value) {
                $productCodes = ProductUtil::getProductCodesByNameAndStatus($key, 0);
                $product = ProductUtil::getProductByName($key);

                if (is_null($product)) {
                    continue;
                }

                for ($i = 0; $i < $value; $i++) {
                    array_push($orderItems, new OrderItem(0, $orderId, $key, NULL, $product->getPrice(), $product->getDiscount()));
                }
            }
        }
        return $orderItems;
    }

    public static function getOrderItemsFromCart($orderId = 0) {
        $orderItems = array();

        if (isset($_SESSION['cart'])) {
            
            foreach ($_SESSION['cart'] as $key => $value) {
                $productCodes = ProductUtil::getProductCodesByNameAndStatus($key, 0);
                $product = ProductUtil::getProductByName($key);

                if (is_null($product)) {
                    continue;
                }

                for ($i = 0; $i < $value; $i++) {
                    $productCodes[$i]->setStatus(1);
                    ProductUtil::updateProductCode($productCodes[$i]);
                    
                    array_push($orderItems, new OrderItem(0, $orderId, $key, $productCodes[$i]->getCode(), $product->getPrice(), $product->getDiscount()));
                }
            }
        }
        return $orderItems;
    }

    public static function getIllegalProductInCart() {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        $illegal = array();
        foreach ($_SESSION['cart'] as $key => $value) {
            $inStock = ProductUtil::getCountProductCodeByNameAndStatus($key, 0);
            if ($inStock < $value) {
                $illegal[$key] = $inStock;
            }
        }
        return $illegal;
    }
}
?>