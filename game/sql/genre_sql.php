<?php
class GenreSQL {
	public static function insertGenre($genre) {
		$name = $genre->getName();
		$display = $genre->getDisplay();

		$sql = "INSERT INTO genre(name, display) values('$name', '$display')";

		execute($sql);
	}

	public static function updateGenre($genre) {
		$name = $genre->getName();
		$display = $genre->getDisplay();

		$sql = "UPDATE genre SET display='$display' WHERE name='$name'";

		execute($sql);
	}

	public static function deleteGenreByName($name) {
		$sql = "DELETE FROM genre WHERE name='$name'";

		execute($sql);
	}

	public static function hasGenreName($name) {
		$sql = "SELECT * FROM genre WHERE name='$name'";

		$arr = toArray(execute($sql));

		return count($arr) > 0;
	}

	public static function getGenreByName($name) {
		$sql = "SELECT * FROM genre WHERE name='$name'";

		$arr = toArray(execute($sql));

		if (count($arr) > 0) {
			$row = $arr[0];

			return new Genre($row['name'], $row['display']);
		}
		return null;
	}

	public static function getGenresByOrder($orderBy, $orderDir) {
		$sql = "SELECT * FROM genre ORDER BY $orderBy $orderDir";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Genre($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGenresByQuery($sql) {
		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Genre($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGenres() {
		$sql = "SELECT * FROM genre";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Genre($row['name'], $row['display']));
		}
		return $arr2;
	}

	public static function getGenreCount() {
		$sql = "SELECT * FROM genre";
		
		$result = execute($sql);

		return $result->num_rows;
	}

	public static function getGenresByProduct($name) {
		$sql = "SELECT * FROM genre,product_genre WHERE genre.name=product_genre.genre_name and product_genre.product_name='$name' ";

		$arr = toArray(execute($sql));

		$arr2 = array();

		foreach ($arr as $row) {
			array_push($arr2, new Genre($row['name'], $row['display']));
		}
		return $arr2;
	}
}
?>