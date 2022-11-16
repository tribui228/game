<?php
/* 
    0: Success: edit genre
    1: Fail: exist genre
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['name']) && isset($_POST['display'])) {
    if (GenreUtil::hasGenreName($_POST['name'])) {
        $genre = new Genre($_POST['name'], $_POST['display']);

        GenreUtil::updateGenre($genre);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>