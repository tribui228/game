<?php
$GLOBALS['sortByArray'] = array("date", "title", "price");
$GLOBALS['sortDirArray'] = array("ASC", "DESC");
$GLOBALS['sortArray'] = array (
	array("date", "DESC", "Date Release: Newest"),
	array("date", "ASC", "Date Release: Oldest"),
	array("title", "ASC", "Alphabetical: A-Z"),
	array("title", "DESC", "Alphabetical: Z-A"),
	array("price", "ASC", "Price: Low to High"),
	array("price", "DESC", "Price: High to Low")
);

$GLOBALS['sortByDefault'] = "date";
$GLOBALS['sortDirDefault'] = "DESC";

$GLOBALS['sortBy'] = $sortByDefault;
$GLOBALS['sortDir'] = $sortDirDefault;

if (isset($_GET['sortBy'])) {
	$GLOBALS['sortBy'] = $_GET['sortBy'];

	if (!in_array($GLOBALS['sortBy'], $GLOBALS['sortByArray'])) {
		$GLOBALS['sortBy'] = $sortByDefault;
	}
}

if (isset($_GET['sortDir'])) {
	$GLOBALS['sortDir'] = $_GET['sortDir'];

	if (!in_array($GLOBALS['sortDir'], $GLOBALS['sortDirArray'])) {
		$GLOBALS['sortDir'] = $sortDirDefault;
	}
}

foreach ($GLOBALS['sortArray'] as $sort) {
	if ($sort[0] == $GLOBALS['sortBy'] && $sort[1] == $GLOBALS['sortDir']) {
		$GLOBALS['sortDisplay'] = $sort[2];
	}
}
?>