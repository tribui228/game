<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

$ROOT_DIRECTORY = $_SERVER['DOCUMENT_ROOT'].'/game';
include_once($ROOT_DIRECTORY.'/util/date_util.php');
include_once($ROOT_DIRECTORY.'/util/sql_util.php');
include_once($ROOT_DIRECTORY.'/object/genre.php');
include_once($ROOT_DIRECTORY.'/object/sale.php');
include_once($ROOT_DIRECTORY.'/object/product.php');
include_once($ROOT_DIRECTORY.'/object/product_genre.php');
include_once($ROOT_DIRECTORY.'/object/product_search.php');
include_once($ROOT_DIRECTORY.'/object/product_code.php');
include_once($ROOT_DIRECTORY.'/object/system_requirements.php');
include_once($ROOT_DIRECTORY.'/object/order.php');
include_once($ROOT_DIRECTORY.'/object/order_item.php');
include_once($ROOT_DIRECTORY.'/object/page.php');
include_once($ROOT_DIRECTORY.'/object/group.php');
include_once($ROOT_DIRECTORY.'/object/group_permission.php');
include_once($ROOT_DIRECTORY.'/object/user.php');
include_once($ROOT_DIRECTORY.'/object/user_permission.php');
include_once($ROOT_DIRECTORY.'/sql/genre_sql.php');
include_once($ROOT_DIRECTORY.'/sql/sale_sql.php');
include_once($ROOT_DIRECTORY.'/sql/product_sql.php');
include_once($ROOT_DIRECTORY.'/sql/group_sql.php');
include_once($ROOT_DIRECTORY.'/sql/user_sql.php');
include_once($ROOT_DIRECTORY.'/sql/order_sql.php');
include_once($ROOT_DIRECTORY.'/util/genre_util.php');
include_once($ROOT_DIRECTORY.'/util/sale_util.php');
include_once($ROOT_DIRECTORY.'/util/product_util.php');
include_once($ROOT_DIRECTORY.'/util/group_util.php');
include_once($ROOT_DIRECTORY.'/util/user_util.php');
include_once($ROOT_DIRECTORY.'/util/order_util.php');
?>