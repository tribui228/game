<?php
/* 
    0: Success: create sale
    1: Fail: exist sale
*/

include ($_SERVER['DOCUMENT_ROOT'].'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['name']) && isset($_POST['display']) && isset($_POST['discount']) && isset($_POST['date_begin']) && isset($_POST['date_end'])) {
    if (SaleUtil::hasSaleByDisplay($_POST['display'])) {
        echo 1;
        exit();
    }
    if (!SaleUtil::hasSaleByName($_POST['name'])) {
        $sale = new Sale($_POST['name'], $_POST['display'], $_POST['discount'], $_POST['date_begin'], $_POST['date_end']);

        SaleUtil::addSale($sale);
        echo 0;
        exit();
    }
}
echo 2;
exit();
?>