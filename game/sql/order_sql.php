<?php
class OrderSQL {
	public static function insertOrder($order) {
		$username = $order->getUsername();
		$totalPrice = $order->getTotalPrice();
		$quantity = $order->getQuantity();
		$status = $order->getStatus();
		$dateOrdered = $order->getDateOrdered() == NULL ? 'NULL' : "'".$order->getDateOrdered()."'";
		$dateChecked = $order->getDateChecked() == NULL ? 'NULL' : "'".$order->getDateChecked()."'";

		$sql = "INSERT INTO `order`(username, total_price, quantity, status, date_ordered, date_checked) 
				VALUES('$username', $totalPrice, $quantity, $status, $dateOrdered, $dateChecked)";

		$conn = execute2($sql);
		$id = $conn->insert_id;
		$conn->close();
		return $id;
	}

	public static function updateOrder($order) {
		$id = $order->getId();
		$username = $order->getUsername();
		$totalPrice = $order->getTotalPrice();
		$quantity = $order->getQuantity();
		$status = $order->getStatus();
		$dateOrdered = $order->getDateOrdered();
		$dateChecked = $order->getDateChecked();

		$sql = "UPDATE `order`
				SET username='$username', total_price=$totalPrice, quantity=$quantity, status=$status, date_ordered='$dateOrdered', date_checked='$dateChecked'
				WHERE id=$id";

		execute($sql);
	}

	public static function deleteOrderItems($id_array) {
		foreach ($id_array as $id) {
			$conn = execute2("DELETE FROM order_item WHERE id=$id");
		}
		closeConnect($conn);
	}


	public static function deleteOrderById($id) {
		$sql = "DELETE FROM `order` WHERE id=$id";

		execute($sql);
	}

	public static function deleteOrderItemById($id) {
		$sql = "DELETE FROM `order_item` WHERE id=$id";

		execute($sql);
	}

	public static function deleteOrderItemsByOrderId($id) {
		$sql = "DELETE FROM `order_item` WHERE order_id=$id";

		execute($sql);
	}

	public static function hasOrderId($id) {
		$sql = "SELECT * FROM `order` WHERE id=$id";

		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function hasOrderItemById($id) {
		$sql = "SELECT * FROM `order_item` WHERE id=$id";

		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function getOrderById($id) {
		$sql = "SELECT * FROM `order` WHERE id=$id";

		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']);
		}

		return null;
	}

	public static function getOrders() {
		$sql = "SELECT * FROM `order`";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']));
		}

		return $arr2;
	}

	public static function insertOrderItem($orderItem) {
		$orderId = $orderItem->getOrderId();
		$productName = $orderItem->getProductName();
		$code = $orderItem->getCode() == NULL ? 'NULL' : "'".$orderItem->getCode()."'";
		$price = $orderItem->getPrice();
		$discount = $orderItem->getDiscount();

		$sql = "INSERT INTO order_item(order_id, product_name, code, price, discount)
				VALUES($orderId, '$productName', $code, '$price', '$discount')";

		$conn = execute2($sql);
		$id = $conn->insert_id;
		$conn->close();
		return $id;
	}

	public static function insertOrderItems($orderItems) {
		foreach ($orderItems as $orderItem) {
			OrderSQL::insertOrderItem($orderItem);
		}
	}

	public static function updateOrderItem($orderItem) {
		$id = $orderItem->getId();
		$orderId = $orderItem->getOrderId();
		$productName = $orderItem->getProductName();
		$code = $orderItem->getCode() == NULL ? 'NULL' : "'".$orderItem->getCode()."'";
		$price = $orderItem->getPrice();
		$discount = $orderItem->getDiscount();

		$sql = "UPDATE order_item
				SET order_id=$orderId, product_name='$productName', code=$code, price=$price, discount=$discount
				WHERE id=$id";

		execute($sql);
	}
	
	public static function deleteOrderItem($id) {
		$sql = "DELETE FROM order_item WHERE id=$id";

		execute($sql);
	}

	public static function getOrderItemsByOrderId($orderId) {
		$sql = "SELECT * FROM `order_item` WHERE order_id=$orderId";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']));
		}

		return $arr2;
	}

	public static function getOrderItemById($id) {
		$sql = "SELECT * FROM `order_item` WHERE id=$id";

		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']);
		}

		return null;
	}


	public static function getOrdersByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM `order` ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']));
		}

		return $arr2;
	}

	public static function getOrdersByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']));
		}

		return $arr2;
	}

	public static function getOrdersByUsernameAndOrder($username, $orderBy, $orderDir) {
		$sql = "SELECT * FROM `order` WHERE username='$username' ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']));
		}

		return $arr2;
	}

	public static function getOrdersByUsername($username) {
		$sql = "SELECT * FROM `order` WHERE username='$username'";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Order($row['id'], $row['username'], $row['total_price'], $row['quantity'], $row['status'], $row['date_ordered'], $row['date_checked']));
		}

		return $arr2;
	}


	public static function getOrderItemsByOrderIdAndOrder($orderId, $orderBy, $orderDir) {
		$sql = "SELECT * FROM `order_item` WHERE order_id=$orderId ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']));
		}

		return $arr2;
	}

	public static function getOrderItemsByUsernameAndOrder($username, $orderBy, $orderDir) {
		$sql = "SELECT order_item.id, order_item.order_id, order_item.product_name, order_item.code, order_item.price, order_item.discount, `order`.date_ordered FROM `order_item` INNER JOIN `order` ON order_item.order_id = `order`.id WHERE username='$username' ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$orderItem = new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']);
			$orderItem->setDateOrdered($row['date_ordered']);
			array_push($arr2, $orderItem);
		}

		return $arr2;
	}

	public static function getOrderItemsByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM `order_item` ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']));
		}

		return $arr2;
	}

	public static function getOrderItemsByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$orderItem = new OrderItem($row['id'], $row['order_id'], $row['product_name'], $row['code'], $row['price'], $row['discount']);
			$orderItem->setDateOrdered($row['date_ordered']);
			array_push($arr2, $orderItem);
		}

		return $arr2;
	}


	public static function getOrderCount() {
		$sql = "SELECT * FROM `order`";
		
		$result = execute($sql);

		return $result->num_rows;
	}
}
?>