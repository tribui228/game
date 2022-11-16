<?php
/* 
    0: Success: create user
    1: Fail: exist user
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['name']) && isset($_POST['display']) && isset($_POST['developer']) && isset($_POST['publisher']) && isset($_POST['release_date']) &&  isset($_POST['price']) && isset($_POST['sale_name']) && isset($_POST['image']) && isset($_POST['background_image']) && isset($_POST['description']) &&  isset($_POST['genres'])) {
    if (!ProductUtil::hasProductName($_POST['name'])) {
        $minSystemRequireId = NULL;
        if (!empty($_POST['min_system_require'])) {
            $system = $_POST['min_system_require'];
            $minSystemRequireId = ProductUtil::insertSystemRequirements(new SystemRequirements(0, $system[0], $system[1], $system[2], $system[3], $system[4], $system[5]));
        }

        $recSystemRequireId = NULL;
        if (!empty($_POST['rec_system_require'])) {
            $system = $_POST['rec_system_require'];
            $recSystemRequireId = ProductUtil::insertSystemRequirements(new SystemRequirements(0, $system[0], $system[1], $system[2], $system[3], $system[4], $system[5]));
        }

        $product = new Product($_POST['name'], $minSystemRequireId, $recSystemRequireId, $_POST['display'], $_POST['developer'], $_POST['publisher'], $_POST['release_date'], $_POST['price'], $_POST['sale_name'], $_POST['image'], $_POST['background_image'], $_POST['description']);

        ProductUtil::addProduct($product);

        $productGenres = ProductUtil::getProductGenresByGenreArray($_POST['name'], $_POST['genres']);
        ProductUtil::updateProductGenresFromName($_POST['name'], $productGenres);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>