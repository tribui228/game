<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

class OrderUtil{
    public static function getOrderCount() {
        return OrderSQL::getOrderCount();
    }

    public static function insertOrder($order) {
        return OrderSQL::insertOrder($order);
    }

    public static function updateOrder($order) {
        return OrderSQL::updateOrder($order);
    }

    public static function insertOrderItems($orderItems) {
        OrderSQL::insertOrderItems($orderItems);
    }

    public static function getOrdersByQuery($sql) {
        return OrderSQL::getOrdersByQuery($sql);
    }

    public static function getOrderItemsByOrderIdAndOrder($id, $orderBy, $orderDir) {
        return OrderSQL::getOrderItemsByOrderIdAndOrder($id, $orderBy, $orderDir);
    }

    public static function getOrderItemsByUsernameAndOrder($username, $orderBy, $orderDir) {
        return OrderSQL::getOrderItemsByUsernameAndOrder($username, $orderBy, $orderDir);
    }

    public static function getOrdersByOrder($orderBy, $orderDir) {
        return OrderSQL::getOrdersByOrder($orderBy, $orderDir);
    }

    public static function getOrdersByUsernameAndOrder($username, $orderBy, $orderDir) {
        return OrderSQL::getOrdersByUsernameAndOrder($username, $orderBy, $orderDir);
    }

    public static function getOrdersByUsername($username) {
        return OrderSQL::getOrdersByUsername($username);
    }

    public static function getOrders() {
        return OrderSQL::getOrders();
    }

    public static function hasOrderId($id) {
        return OrderSQL::hasOrderId($id);
    }

    public static function getOrderById($id) {
        return OrderSQL::getOrderById($id);
    }

    public static function getOrderItemsByOrderId($orderId) {
        return OrderSQL::getOrderItemsByOrderId($orderId);
    }

    public static function deleteOrderItemsByOrderId($id) {
        OrderSQL::deleteOrderItemsByOrderId($id);
    }

    public static function deleteOrderById($id) {
        OrderSQL::deleteOrderById($id);
    }

    public static function hasOrderItemById($id) {
        return OrderSQL::hasOrderItemById($id);
    }

    public static function getOrderItemById($id) {
        return OrderSQL::getOrderItemById($id);
    }

    public static function getOrderItemsByQuery($sql) {
        return OrderSQL::getOrderItemsByQuery($sql);
    }

    public static function deleteOrderItems($id_array) {
        return OrderSQL::deleteOrderItems($id_array);
    }

    public static function updateOrderItem($orderItem) {
        return OrderSQL::updateOrderItem($orderItem);
    }

    public static function updateOrderById($id) {
        $order = OrderUtil::getOrderById($id);

        $username = $order->getUsername();
        $totalPrice = 0;
        $quantity = 0;
        $status = $order->getStatus();
        $dateOrdered = $order->getDateOrdered();
        $dateChecked = $order->getDateChecked();

        $orderItems = OrderUtil::getOrderItemsByOrderId($id);
        if (!is_null($orderItems)) {
            foreach ($orderItems as $orderItem) {
                $product = ProductUtil::getProductByName($orderItem->getProductName());

                if (is_null($product)) {
                    continue;
                }
                $totalPrice += ($product->getPrice() * (1 - $product->getDiscount()));
                $quantity += 1;
            }
        }

        $totalPrice = round($totalPrice, 2);
        $order = new Order($id, $username, $totalPrice, $quantity, $status, $dateOrdered, $dateChecked);
        
        OrderUtil::updateOrder($order);
        return $order;
    }

    public static function checkOrderApprovalById($orderId) {
        $canApprove = true;

        $orderItems = OrderUtil::getOrderItemsByOrderId($orderId);

        $productCounts = array();
        foreach ($orderItems as $orderItem) {
            if (!isset($productCounts[$orderItem->getProductName()])) {
                $productCounts[$orderItem->getProductName()] = 1;
            }else {
                $productCounts[$orderItem->getProductName()] += 1;
            }
        }

        foreach ($productCounts as $key => $value) {
            $productCodes = ProductUtil::getProductCodesByNameAndStatus($key, 0);

            if (count($productCodes)< $value) {
                return false;
            }
        }

        return $canApprove;
    }

    public static function approveOrderById($orderId) {
        $canApprove = true;

        $orderItems = OrderUtil::getOrderItemsByOrderId($orderId);

        $productCounts = array();
        foreach ($orderItems as $orderItem) {
            if (!isset($productCounts[$orderItem->getProductName()])) {
                $productCounts[$orderItem->getProductName()] = 1;
            }else {
                $productCounts[$orderItem->getProductName()] += 1;
            }
        }

        $orderIndex = 0;
        foreach ($productCounts as $key => $value) {
            $productCodes = ProductUtil::getProductCodesByNameAndStatus($key, 0);

            if (count($productCodes)< $value) {
                return false;
            }
            $product = ProductUtil::getProductByName($key);
    
            for ($i = 0; $i < $value; $i++) {
                $productCodes[$i]->setStatus(1);
                ProductUtil::updateProductCode($productCodes[$i]);
                
                $orderItem = new OrderItem($orderItems[$orderIndex]->getId(), $orderId, $key, $productCodes[$i]->getCode(), $product->getPrice(), $product->getDiscount());
                OrderUtil::updateOrderItem($orderItem);

                $orderIndex++;
            }
        }
        
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $dateChecked = date('Y/m/d H:i:s');
        
        $order = OrderUtil::getOrderById($orderId);
        $order->setStatus(1);
        $order->setDateChecked($dateChecked);
        ORderUtil::updateOrder($order);
    }
}
?>