<?php
$GLOBALS['filterGenre'] = array();

if (isset($_GET['tag'])) {
    $GLOBALS['filterGenre'] = explode("|", $_GET['tag']);
    $GLOBALS['filterGenre'] = array_unique($GLOBALS['filterGenre']);
}

$GLOBALS['filterPrice'] = '';
if (isset($_GET['price'])) {
    $GLOBALS['filterPrice'] = $_GET['price'];
}

$GLOBALS['filterPriceTypes'] = array (
	array("u5", "Under $5"),
	array("u10", "Under $10"),
	array("u15", "Under $15"),
    array("u25", "Under $25"),
    array("a25", "$25+"),
    array("discounted", "Discounted"),
);
?>