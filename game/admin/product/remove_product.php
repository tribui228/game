<?php
/* 
    0: Success: remove genre
    1: Half Success Half Fail: some can remove some cannot remove
    2: Fail: wrong params
    3: Fail: exist product use genre
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.remove')) {
    echo 'no_permission';
    exit();
}

if (isset($_POST['product_array'])) {
    $exist = false;
    $remove = false;

    foreach ($_POST['product_array'] as $name) {
        if (ProductUtil::hasProductName($name)) {
            $has = ProductUtil::hasProductCodeByName($name);
    
            if ($has) {
                $exist = true;
            }else {
                $remove = true;
                
                ProductUtil::deleteProductGenresByName($name);
                ProductUtil::deleteProductByName($name);
            }
        }
    }

    if ($exist && $remove) {
        echo 1;
        exit();
    }

    if ($remove) {
        echo 0;
        exit();
    }

    if ($exist) {
        echo 2;
        exit();
    }
}
echo 3;
exit();
?>