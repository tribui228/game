<?php
class SaleUtil {
  public static function addSale($sale) {
    if (!SaleSQL::hasSaleByName($sale->getName())) {
        SaleSQL::insertSale($sale);
    }
}

    public static function insertSale($sale) {
        SaleSQL::insertSale($sale);
    }

    public static function updateSale($sale) {
        SaleSQL::updateSale($sale);
    }

    public static function getSaleByName($name) {
		return SaleSQL::getSaleByName($name);
    }

    public static function hasSaleByName($name) {
        return SaleSQL::hasSaleByName($name);
    }

    public static function hasSaleByDisplay($display) {
      return SaleSQL::hasSaleByDisplay($display);
    }

    public static function getSales() {
		return SaleSQL::getSales();
	}

    public static function getSalesByQuery($sql) {
		return SaleSQL::getSalesByQuery($sql);
	}

    public static function getSalesByOrder($orderBy, $orderDir) {
		return SaleSQL::getSalesByOrder($orderBy, $orderDir);
	}

  public static function getSaleCount() {
		$count = SaleSQL::getSaleCount();
    return $count > 0 ? $count - 1 : $count;
  }
}
?>