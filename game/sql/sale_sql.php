<?php
class SaleSQL {
    public static function insertSale($sale) {
        $name = $sale->getName();
        $display = $sale->getDisplay();
        $discount = $sale->getDiscount();
        $dateBegin = $sale->getDateBegin() == NULL ? 'NULL' : "'".$sale->getDateBegin()."'";
		$dateEnd = $sale->getDateEnd() == NULL ? 'NULL' : "'".$sale->getDateEnd()."'";

        $sql = "INSERT INTO sale(name, display, discount, date_begin, date_end) VALUES 
                ('$name', '$display', $discount, $dateBegin, $dateEnd)";
        execute($sql);
    }

    public static function updateSale($sale) {
        $name = $sale->getName();
        $display = $sale->getDisplay();
        $discount = $sale->getDiscount();
        $dateBegin = $sale->getDateBegin() == NULL ? 'NULL' : "'".$sale->getDateBegin()."'";
		$dateEnd = $sale->getDateEnd() == NULL ? 'NULL' : "'".$sale->getDateEnd()."'";

        $sql = "UPDATE sale 
                SET display='$display', discount=$discount, date_begin=$dateBegin, date_end=$dateEnd 
                WHERE name='$name'";
        execute($sql);
    }

    public static function getSaleByName($name) {
        $sql = "SELECT * FROM sale WHERE name='$name'";
		
		$result = execute($sql);

		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new Sale($row['name'], $row['display'], $row['discount'], $row['date_begin'], $row['date_end']);
		}

		return null;
    }

    public static function hasSaleByName($name) {
        $sql = "SELECT * FROM sale WHERE name='$name'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
    }

	public static function hasSaleByDisplay($display) {
        $sql = "SELECT * FROM sale WHERE display='$display'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
    }

    public static function getSales() {
		$sql = "SELECT * FROM sale";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Sale($row['name'], $row['display'], $row['discount'], $row['date_begin'], $row['date_end']));
		}

		return $arr2;
	}

    public static function getSalesByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Sale($row['name'], $row['display'], $row['discount'], $row['date_begin'], $row['date_end']));
		}

		return $arr2;
	}

    public static function getSalesByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM sale ORDER BY `$orderBy` $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Sale($row['name'], $row['display'], $row['discount'], $row['date_begin'], $row['date_end']));
		}
		return $arr2;
	}

    public static function getSaleCount() {
		$sql = "SELECT * FROM sale";
		
		$result = execute($sql);

		return $result->num_rows;
	}
}
?>