<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

class ProductUtil{
    public static function addProduct($product) {
        if (!ProductSQL::hasProductName($product->getName())) {
            ProductSQL::insertProduct($product);
        }
    }

    public static function addProductCode($productCode) {
        if (!ProductSQL::hasProductCode($productCode->getProductName(), $productCode->getCode())) {
            ProductSQL::insertProductCode($productCode);
        }
    }

    public static function getProductsByQuery($sql) {
        return ProductSQL::getProductsByQuery($sql);
    }

    public static function getProductCodesByQuery($sql) {
        return ProductSQL::getProductCodesByQuery($sql);
    }

    public static function deleteProductByName($name) {
        ProductSQL::deleteProductByName($name);
    }

    public static function deleteProductGenresByName($name) {
        ProductSQL::deleteProductGenresByName($name);
    }

    public static function deleteProductCode($name, $code) {
        ProductSQL::deleteProductCode($name, $code);
    }

    public static function hasProductCodeByName($name) {
        return ProductSQL::hasProductCodeByName($name);
    }

    public static function hasProductCode($name, $code) {
        return ProductSQL::hasProductCode($name, $code);
    }

    public static function updateProduct($product) {
        ProductSQL::updateProduct($product);
    }

    public static function updateProductCode($productCode) {
        ProductSQL::updateProductCode($productCode);
    }

    public static function insertSystemRequirements($systemRequirements) {
        return ProductSQL::insertSystemRequirements($systemRequirements);
    }
    
    public static function setMinimumSystemRequirementsId($name, $id) {
        return ProductSQL::setMinimumSystemRequirementsId($name, $id);
	}

	public static function setRecommendedSystemRequirementsId($name, $id) {
        return ProductSQL::setRecommendedSystemRequirementsId($name, $id);
	}

    public static function updateSystemRequirements($systemRequirements) {
        ProductSQL::updateSystemRequirements($systemRequirements);
    }

    public static function hasProductName($name) {
        return ProductSQL::hasProductName($name);
    }

    public static function getProductGenresByGenreName($genreName) {
        return ProductSQL::getProductGenresByGenreName($genreName);
    }

    public static function getProductsBySaleName($saleName) {
        return ProductSQL::getProductsBySaleName($saleName);
    }

    public static function getProductGenresByGenreArray($name, $genres) {
        $arr = array();
        foreach ($genres as $genre) {
            array_push($arr, new ProductGenre($name, $genre));
        }

        return $arr;
    }

    public static function updateProductGenresFromName($name, $productGenres) {
        return ProductSQL::updateProductGenresFromName($name, $productGenres);
    }

    public static function getSystemRequirementsById($id) {
        return ProductSQL::getSystemRequirementsById($id);
    }

    public static function getProducts() {
        return ProductSQL::getProducts();
    }

    public static function getProductByName($name) {
        return ProductSQL::getProductByName($name);
    }

    public static function hasProductCodeById($id) {
        return ProductSQL::hasProductCodeById($id);
    }

    public static function getProductCodeById($id) {
        return ProductSQL::getProductCodeById($id);
    }

    public static function getProductCodesByNameAndOrder($name, $orderBy, $orderDir) {
        return ProductSQL::getProductCodesByNameAndOrder($name, $orderBy, $orderDir);
    }

    public static function getProductCodesByNameAndStatus($name, $status) {
        return ProductSQL::getProductCodesByNameAndStatus($name, $status);
    }

    public static function getProductCode($name, $code) {
        return ProductSQL::getProductCode($name, $code);
    }

    
    public static function getProductCodesByOrder($orderBy, $orderDir) {
        return ProductSQL::getProductCodesByOrder($orderBy, $orderDir);
    }
    
    public static function getProductCodesByName($name) {
        return ProductSQL::getProductCodesByName($name);
    }
    
    public static function deleteProductCodeById($id) {
        ProductSQL::deleteProductCodeById($id);
    }

    public static function getCountProductCodeByNameAndStatus($name, $status) {
        $productCodes = ProductSQL::getProductCodesByNameAndStatus($name, $status);

        return count($productCodes);
    }

    public static function hasProductCodeByNameAndStatus($name, $status) {
        return ProductSQL::hasProductCodeByNameAndStatus($name, $status);
    }

    public static function hasProductCodeByNameAndStatusWithAmount($name, $status, $amount) {
        $productCodes = ProductSQL::getProductCodesByNameAndStatus($name, $status);

        return count($productCodes) >= $amount;
    }

    public static function getProductsBySearch($search) {
        $products = ProductSQL::getProductsBySearch($search);

        $filterGenre = $search->getFilterGenres();

        $newProducts = array();

        $empty = empty($filterGenre);

        $price_type = $search->getFilterPrice();
        foreach ($products as $product) {
            $productGenres = ProductSQL::getProductGenresByName($product->getName());
            $genres = ProductUtil::getGenresByProduct($productGenres);
            if (($empty || !array_diff($filterGenre, $genres)) && ProductUtil::checkPrice($product, $price_type)) {
                array_push($newProducts, $product); 
            }
        }

        return $newProducts;
    }

    public static function checkPrice($product, $price_type) {
        switch($price_type) {
            case "u5":
                return $product->getFinalPrice() < 5;
            case "u10":
                return $product->getFinalPrice() < 10;
            case "u15":
                return $product->getFinalPrice() < 15;
            case "u20":
                return $product->getFinalPrice() < 25;
            case "a25":
                return $product->getFinalPrice() >= 25;
            case "discounted":
                return $product->getDiscount() > 0;
        }
        return true;
    }

    public static function getProductGenresByName($name) {
        return ProductSQL::getProductGenresByName($name);
    }

    public static function getGenresByProduct($productGenres) {
        $genres = array();

        if (!is_null($productGenres)) {
            foreach ($productGenres as $productGenre) {
                array_push($genres, $productGenre->getGenreName());
            }
        }

        return $genres;
    }

    public static function getProductCount() {
		return ProductSQL::getProductCount();
	}

    public static function getProductCodeCount() {
		return ProductSQL::getProductCodeCount();
	}

    public static function getProductsByOrder($orderBy, $orderDir) {
        return ProductSQL::getProductsByOrder($orderBy, $orderDir);
    }

    public static function getProductImage($image) {
        if (!ProductUtil::isExistProductImage($image)) {
            return ProductUtil::getEmptyImage();
        }

        return '/game/img/game/'.$image;
    }

    public static function getEmptyImage() {
        return '/game/img/blank.png';
    }

    public static function getProductImagePath() {
        return '/game/img/game/';
    }

    public static function isExistProductImage($image) {
        if (is_null($image)) {
            return false;
        }
        return file_exists($_SERVER["DOCUMENT_ROOT"].ProductUtil::getProductImagePath().$image);
    }
}
?>