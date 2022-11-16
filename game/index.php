<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('LOCAL_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once('./util/date_util.php');
include_once('./util/sql_util.php');
include_once('./object/genre.php');
include_once('./object/product.php');
include_once('./object/product_genre.php');
include_once('./object/system_requirements.php');
include_once('./object/group.php');
include_once('./object/group_permission.php');
include_once('./object/user.php');
include_once('./object/user_permission.php');
include_once('./object/order.php');
include_once('./object/order_item.php');
include_once('./sql/genre_sql.php');
include_once('./sql/product_sql.php');
include_once('./sql/group_sql.php');
include_once('./sql/user_sql.php');
include_once('./sql/order_sql.php');
include_once('./util/group_util.php');
include_once('./util/product_util.php');
include_once('./util/genre_util.php');
include_once('./util/user_util.php');

session_start();
?>

<?php $GLOBALS['headerType'] = 'header'; include ('header/index.php')?>

<?php include ('body.php')?>

<?php include ('footer.php')?>