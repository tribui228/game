<?php
class ProductSQL {
	public static function insertProduct($product) {
		$name = $product->getName();
		$minimumSystemRequirementsId = !is_null($product->getMinimumSystemRequirementsId()) ? $product->getMinimumSystemRequirementsId() : 'NULL';
		$recommendedSystemRequirementsId = !is_null($product->getRecommendedSystemRequirementsId()) ? $product->getRecommendedSystemRequirementsId() : 'NULL';
		$display = $product->getDisplay();
		$developer = $product->getDeveloper();
		$publisher = $product->getPublisher();
		$releaseDate = $product->getReleaseDate();
		$price = $product->getPrice();
		$saleName = $product->getSaleName();
		$image = empty($product->getImage()) ? 'NULL' : "'".$product->getImage()."'";
		$backgroundImage = empty($product->getBackgroundImage()) ? 'NULL' : "'".$product->getBackgroundImage()."'";
		$description = $product->getDescription();

		
		$sql = "INSERT INTO product(name, min_system_require_id, rec_system_require_id, display, developer, publisher, release_date, price, sale_name, image, background_image, description) 
				VALUES('$name', $minimumSystemRequirementsId, $recommendedSystemRequirementsId, '$display', '$developer', '$publisher', '$releaseDate', $price, '$saleName', '$image', '$backgroundImage', '$description')";

		execute($sql);
	}

	public static function insertProductCode($productCode) {
		$name = $productCode->getProductName();
		$code = $productCode->getCode();
		$status = $productCode->getStatus();
		$dateAdded = is_null($productCode->getDateAdded()) ? 'NULL' : "'".$productCode->getDateAdded()."'";
		
		$sql = "INSERT INTO product_code(product_name, code, status, date_added) 
				VALUES('$name', '$code', $status, $dateAdded)";

		execute($sql);
	}

	public static function insertSystemRequirements($systemRequirements) {
		$OS = $systemRequirements->getOS();
		$processor = $systemRequirements->getProcessor();
		$memory = $systemRequirements->getMemory();
		$graphics = $systemRequirements->getGraphics();
		$soundCard = $systemRequirements->getSoundCard();
		$storage = $systemRequirements->getStorage();

		$sql = "INSERT INTO system_requirements(OS, processor, memory, graphics, sound_card, storage)
				VALUES('$OS', '$processor', '$memory', '$graphics', '$soundCard', '$storage')";

		$conn = execute2($sql);
		$id = $conn->insert_id;
		$conn->close();
		return $id;
	}

	public static function insertProductGenres($productGenres) {
		foreach ($productGenres as $productGenre) {
			ProductSQL::insertProductGenre($productGenre);
		}
	}

	public static function insertProductGenre($productGenre) {
		$productName = $productGenre->getProductName();
		$genreName = $productGenre->getGenreName();

		$sql = "INSERT INTO product_genre(product_name, genre_name)
				VALUES('$productName', '$genreName')";
		
		execute($sql);	
	}

	public static function updateProduct($product) {
		$name = $product->getName();
		$minimumSystemRequirementsId = !is_null($product->getMinimumSystemRequirementsId()) ? $product->getMinimumSystemRequirementsId() : 'NULL';
		$recommendedSystemRequirementsId = !is_null($product->getRecommendedSystemRequirementsId()) ? $product->getRecommendedSystemRequirementsId() : 'NULL';
		$display = $product->getDisplay();
		$developer = $product->getDeveloper();
		$publisher = $product->getPublisher();
		$releaseDate = $product->getReleaseDate();
		$price = $product->getPrice();
		$saleName = empty($product->getSaleName()) ? 'NULL' : "'".$product->getSaleName()."'";
		$image = empty($product->getImage()) ? 'NULL' : "'".$product->getImage()."'";
		$backgroundImage = empty($product->getBackgroundImage()) ? 'NULL' : "'".$product->getBackgroundImage()."'";
		$description = $product->getDescription();

		$sql = "UPDATE product 
				SET display='$display', min_system_require_id=$minimumSystemRequirementsId, rec_system_require_id=$recommendedSystemRequirementsId, developer='$developer', publisher='$publisher', release_date='$releaseDate', price=$price, sale_name=$saleName, image=$image, background_image=$backgroundImage, description='$description'
				WHERE name='$name'";

		execute($sql);
	}

	public static function setMinimumSystemRequirementsId($name, $id) {
		$sql = "UPDATE product
				SET min_system_require_id=$id
				WHERE name='$name'";

		execute($sql);
	}

	public static function setRecommendedSystemRequirementsId($name, $id) {
		$sql = "UPDATE product
				SET rec_system_require_id=$id
				WHERE name='$name'";

		execute($sql);
	}

	public static function updateProductCode($productCode) {
		$id = $productCode->getId();
		$name = $productCode->getProductName();
		$code = $productCode->getCode();
		$status = $productCode->getStatus();
		$dateAdded = is_null($productCode->getDateAdded()) ? 'NULL' : "'".$productCode->getDateAdded()."'";
		
		$sql = "UPDATE product_code
				SET status=$status, date_added=$dateAdded
				WHERE product_name='$name' AND code='$code'";

		execute($sql);
	}


	public static function updateProductGenresFromName($name, $productGenres) {
		ProductSQL::deleteProductGenresByName($name);

		ProductSQL::insertProductGenres($productGenres);
	}

	public static function updateSystemRequirements($systemRequirements) {
		$id = $systemRequirements->getId();
		$OS = $systemRequirements->getOS();
		$processor = $systemRequirements->getProcessor();
		$memory = $systemRequirements->getMemory();
		$graphics = $systemRequirements->getGraphics();
		$soundCard = $systemRequirements->getSoundCard();
		$storage = $systemRequirements->getStorage();

		$sql = "UPDATE system_requirements
				SET OS='$OS', processor='$processor', memory='$memory', graphics='$graphics', sound_card='$soundCard', storage='$storage'
				WHERE id=$id";

		execute($sql);
	}

	public static function deleteProductByName($name) {
		$sql = "DELETE FROM product WHERE name='$name'";

		execute($sql);
	}

	public static function deleteProductGenre($productName, $genreName) {
		$sql = "DELETE FROM product_genre WHERE product_name='$productName' AND genre_name='$genreName'";

		execute($sql);
	}

	public static function deleteProductGenresByName($name) {
		$sql = "DELETE FROM product_genre WHERE product_name='$name'";

		execute($sql);
	}

	public static function deleteProductCode($name, $code) {
		$sql = "DELETE FROM product_code WHERE product_name='$name' AND code='$code'";

		execute($sql);
	}

	public static function deleteProductCodeById($id) {
		$sql = "DELETE FROM product_code WHERE id=$id";

		execute($sql);
	}

	public static function deleteSystemRequirementsById($id) {
		$sql = "DELETE FROM system_requirements WHERE id=$id";

		execute($sql);
	}

	public static function hasProductName($name) {
		$sql = "SELECT * FROM product WHERE name='$name'";
		
		$result = execute($sql);

		$array = toArray($result);

		return count($array) > 0;
	}

	public static function getProductByName($name) {
		$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description 
				FROM `product` JOIN `sale` 
				WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
					AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
					AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
					OR (sale.name='no_discount'))
				AND product.name='$name'";

		$result = execute($sql);
		
		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			return $product;
		}

		return null;
	}

	public static function getProductGenresByName($name) {
		$sql = "SELECT * FROM product_genre WHERE product_name='$name'";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductGenre($row['product_name'], $row['genre_name']));
		}

		return $arr2;
	}

	public static function getProductCodesByName($name) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name'";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']));
		}

		return $arr2;
	}

	public static function getProductCodesByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']));
		}

		return $arr2;
	}

	public static function getProductCodesByNameAndOrder($name, $orderBy, $orderDir) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name' ORDER BY $orderBy $orderDir";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']));
		}

		return $arr2;
	}

	public static function hasProductCodeByName($name) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name'";
		
		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function hasProductCode($name, $code) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name' AND BINARY code='$code'";
		
		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function hasProductCodeById($id) {
		$sql = "SELECT * FROM product_code WHERE id=$id";
		
		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function getProductCodeById($id) {
		$sql = "SELECT * FROM product_code WHERE id=$id";
		
		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']);
		}

		return null;
	}

	public static function getProductCode($name, $code) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name' AND code='$code'";
		
		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']);
		}

		return null;
	}

	public static function getProductCodesByNameAndStatus($name, $status) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name' AND status=$status";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']));
		}

		return $arr2;
	}

	public static function getProductCodesByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM product_code ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductCode($row['id'], $row['product_name'], $row['code'], $row['status'], $row['date_added']));
		}

		return $arr2;
	}


	public static function hasProductCodeByNameAndStatus($name, $status) {
		$sql = "SELECT * FROM product_code WHERE product_name='$name' AND status=$status";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		return count($arr2) > 0;
	}

	public static function getProductGenresByGenreName($genreName) {
		$sql = "SELECT * FROM product_genre WHERE genre_name='$genreName'";
		
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new ProductGenre($row['product_name'], $row['genre_name']));
		}

		return $arr2;
	}

	public static function getSystemRequirementsById($id) {
		if (is_null($id)) {
			return null;
		}

		$sql = "SELECT * FROM system_requirements WHERE id=$id";
		
		$result = execute($sql);
		
		$array = toArray($result);

		if (count($array) > 0) {
			$row = $array[0];

			return new SystemRequirements($row['id'], $row['OS'], $row['processor'], $row['memory'], $row['graphics'], $row['sound_card'], $row['storage']);
		}

		return null;
	}

	public static function getProducts() {
		$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description 
				FROM `product` JOIN `sale` 
				WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
					AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
					AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
					OR (sale.name='no_discount'))";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			array_push($arr2, $product);
		}

		return $arr2;
	}

	public static function getProductsBySaleName($saleName) {
		$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description 
				FROM `product` JOIN `sale` 
				WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
					AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
					AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
					OR (sale.name='no_discount'))
					AND product.sale_name='$saleName'";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			array_push($arr2, $product);
		}

		return $arr2;
	}

	public static function getProductsByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			array_push($arr2, $product);
		}

		return $arr2;
	}


	public static function getProductsByOrder($orderBy, $orderDir) {
		$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description 
				FROM `product` JOIN `sale` 
				WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
					AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
					AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
					OR (sale.name='no_discount'))
				ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			array_push($arr2, $product);
		}

		return $arr2;
	}

	public static function getProductsBySearch($search) {
		$basicSearch = $search->getBasicSearch();
		$advancedSearch = $search->getAdvancedSearch();
		$sortBy = $search->getSortBy();
		$sortDir = $search->getSortDir();

		$where = "";
		if ($sortBy == 'date') {
			$sortBy = 'release_date';
		}else if ($sortBy == "title") {
			$sortBy = "product.display";
		}else if ($sortBy == "price") {
			$sortBy = "total_price";
		} 
		if (!is_null($basicSearch)) {
			$basicSearch2 = str_replace("'", "''", $basicSearch);
			$where = "AND product.display LIKE '%$basicSearch2%'";
		}

		if (!is_null($advancedSearch)) {
			$advancedSearch2 = str_replace("'", "''", $advancedSearch);
			if ($where != "") {
				$where = $where." AND product.display LIKE '%$advancedSearch2%'";
			}else {
				$where = "AND product.display LIKE '%$advancedSearch2%'";
			}
		}
		
		$sql = "SELECT product.name, min_system_require_id, rec_system_require_id, product.display, developer, publisher, release_date, price, sale_name, sale.display as 'sale_display', discount, image, background_image, description, price*(1-discount) AS total_price 
				FROM `product` JOIN `sale` INNER JOIN product_genre ON product.name=product_genre.product_name
				WHERE ((IFNULL(product.sale_name, 'no_discount')=sale.name 
					AND (sale.date_begin IS NULL OR sale.date_begin <= NOW()) 
					AND (sale.date_end IS NULL OR sale.date_end >= NOW()))
					OR (sale.name='no_discount'))
					$where
				GROUP BY product_name
				ORDER BY $sortBy $sortDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			$product = new Product($row['name'], $row['min_system_require_id'], $row['rec_system_require_id'], $row['display'], $row['developer'], $row['publisher'], $row['release_date'], $row['price'], $row['sale_name'], $row['image'], $row['background_image'], $row['description']);
			$product->setSaleDisplay($row['sale_display']);
			$product->setDiscount($row['discount']);
			array_push($arr2, $product);
		}

		return $arr2;
	}

	public static function getProductCount() {
		$sql = "SELECT * FROM product";
		
		$result = execute($sql);

		return $result->num_rows;
	}

	public static function getProductCodeCount() {
		$sql = "SELECT * FROM product_code";
		
		$result = execute($sql);

		return $result->num_rows;
	}
}
?>