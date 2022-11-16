<?php
if (isset($_GET['search'])) {
    $GLOBALS['basicSearch'] = $_GET['search'];
}else {
    $GLOBALS['basicSearch'] = null;
}

if (isset($_GET['search2'])) {
    $GLOBALS['advancedSearch'] = $_GET['search2'];
}else {
    $GLOBALS['advancedSearch'] = null;
}
?>