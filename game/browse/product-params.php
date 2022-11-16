<?php
$GLOBALS['browseProducts'] = ProductUtil::getProductsBySearch(new ProductSearch($GLOBALS['basicSearch'], $GLOBALS['advancedSearch'], $GLOBALS['sortBy'], $GLOBALS['sortDir'], $GLOBALS['filterGenre'], $GLOBALS['filterPrice']));
?>