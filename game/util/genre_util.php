<?php
class GenreUtil {
    public static function addGenre($genre) {
        if (!GenreSQL::hasGenreName($genre->getName())) {
            GenreSQL::insertGenre($genre);
        }
    }

    public static function updateGenre($genre) {
        if (GenreSQL::hasGenreName($genre->getName())) {
            GenreSQL::updateGenre($genre);
        }
    }

    public static function getGenresByQuery($sql) {
        return GenreSQL::getGenresByQuery($sql);
    }

    public static function getGenreByName($name) {
        return GenreSQL::getGenreByName($name);
    }

    public static function getGenres() {
        return GenreSQL::getGenres();
    }

    public static function getGenreCount() {
		return GenreSQL::getGenreCount();
	}

    public static function hasGenreName($name) {
        return GenreSQL::hasGenreName($name);
    }

    public static function deleteGenreByName($name) {
        if (GenreSQL::hasGenreName($name)) {
            GenreSQL::deleteGenreByName($name);
            return 0;
        }
	}
    
    public static function getGenresByOrder($orderBy, $orderDir) {
        return GenreSQL::getGenresByOrder($orderBy, $orderDir);
    }

    public static function getGenresByProduct($name) {
        return GenreSQL::getGenresByProduct($name);
    }

    public static function getGenreNameArray($genres) {
        $genreArray = array();

        foreach ($genres as $genre) {
            array_push($genreArray, $genre->getName());
        }

        return $genreArray;
    }

}
?>