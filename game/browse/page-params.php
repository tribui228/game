<?php
$GLOBALS['browseCurrentPage'] = 1;
if (isset($_GET['page'])) {
    $GLOBALS['browseCurrentPage'] = $_GET['page'];
}

if (!is_numeric($GLOBALS['browseCurrentPage'])) {
    $GLOBALS['browseCurrentPage'] = 1;
}
$GLOBALS['browsePage'] = new Page(count($GLOBALS['browseProducts']), 12, 5, $GLOBALS['browseCurrentPage']);
$GLOBALS['browseCurrentPage'] = $GLOBALS['browsePage']->getCurrentPage();
?>