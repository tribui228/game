<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/browse/include.php');
session_start();
?>

<?php $GLOBALS['headerType'] = 'browse'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<body>
    <div id="browse" class="container">
        <div id="search-title">
        </div>

        <div id="browse-container">
            <div id="browse-filter">
                <?php include 'filter.php'?>
            </div>

            <div id="browse-sort">
                <div id="sort-item">
                    <?php include 'sort.php'?>
                </div>

                <div id="advanced-search-item">
                    <?php include 'search.php'?>
                </div>
                <div class="clearfix"> </div>
            </div>

            <div id="browse-product">
                <div id="product-items">
                    <?php include 'product.php'?>
                </div>

                <div id="product-pages">
                    <?php include 'page.php'?>
                </div>
            </div>
        </div>
    </div>

    <?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>
</body>
</html>