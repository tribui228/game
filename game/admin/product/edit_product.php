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
    if (ProductUtil::hasProductName($_POST['name'])) {
        $minSystemRequireId = NULL;
        if (!empty($_POST['min_system_require'])) {
            $system = $_POST['min_system_require'];
            $require = new SystemRequirements($system[0], $system[1], $system[2], $system[3], $system[4], $system[5], $system[6]);
            if (empty($system[0])) {
                $minSystemRequireId = ProductUtil::insertSystemRequirements($require);
            }else {
                $minSystemRequireId = $system[0];
                ProductUtil::updateSystemRequirements($require);
            }
        }

        $recSystemRequireId = NULL;
        if (!empty($_POST['rec_system_require'])) {
            $system = $_POST['rec_system_require'];
            $require = new SystemRequirements($system[0], $system[1], $system[2], $system[3], $system[4], $system[5], $system[6]);
            if (empty($system[0])) {
                $recSystemRequireId = ProductUtil::insertSystemRequirements($require);
            }else {
                $recSystemRequireId = $system[0];
                ProductUtil::updateSystemRequirements($require);
            }
        }

        $product = new Product($_POST['name'], $minSystemRequireId, $recSystemRequireId, $_POST['display'], $_POST['developer'], $_POST['publisher'], $_POST['release_date'], $_POST['price'], $_POST['sale_name'], $_POST['image'], $_POST['background_image'], $_POST['description']);

        ProductUtil::updateProduct($product);

        $productGenres = ProductUtil::getProductGenresByGenreArray($_POST['name'], $_POST['genres']);
        ProductUtil::updateProductGenresFromName($_POST['name'], $productGenres);
        echo 0;
        exit();
    }
}
echo 1;
exit();
?>