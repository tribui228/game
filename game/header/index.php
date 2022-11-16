<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include LOCAL_PATH_ROOT.'/game/head.php';
?>

<?php
$GLOBALS['headerTypes'] = array('home', 'browse', 'cart', 'login', 'other');
$GLOBALS['headerTypeDefault'] = 'home';
if (isset($GLOBALS['headerType']) && !in_array($GLOBALS['headerType'], $GLOBALS['headerTypes'])) {
    $GLOBALS['headerType'] = $GLOBALS['headerTypeDefault'];
}

if (!isset($GLOBALS['headerType'])) {
    $GLOBALS['headerType'] = $GLOBALS['headerTypeDefault'];
}
?>

<?php include LOCAL_PATH_ROOT.'/game/modal.php';?>
<?php include LOCAL_PATH_ROOT.'/game/notice.php';?>

<div id="header-bar">
    <div class="container">
        <div class="navbar justify-content-end p-0 pr-3">
            <?php
                if (isset($_SESSION['username'])) {
                    include LOCAL_PATH_ROOT.'/game/header/login/has-login.php';
                }else {
                    include LOCAL_PATH_ROOT.'/game/header/login/not-login.php';
                }
            ?>
        </div>
    </div>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark font-weight-bold">
            <div style="width: 80px; height: 40px"> </div>
            <a href="/game/">
                <img src="/game/img/logo.png" width="80" height="80"
                    class="d-inline-block align-top position-absolute" alt="" style="top: -30px; left: 0px">
                <div class="position-absolute text-main" style="top: 32px; left: 3px; background: -webkit-linear-gradient(left, #1d39be, #0bdad0, #745eed, #e900a7);-webkit-background-clip: text; -webkit-text-fill-color: transparent;"> ProGame </div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                        $active = $GLOBALS['headerType'] == 'home' ? 'active' : '';

                        if ($active == 'active') {
                            include LOCAL_PATH_ROOT.'/game/header/home/active-home.php';
                        }else {
                            include LOCAL_PATH_ROOT.'/game/header/home/home.php';
                        }
                    ?>

                    <?php
                        $active = $GLOBALS['headerType'] == 'browse' ? 'active' : '';

                        if ($active == 'active') {
                            include LOCAL_PATH_ROOT.'/game/header/browse/active-browse.php';
                        }else {
                            include LOCAL_PATH_ROOT.'/game/header/browse/browse.php';
                        }
                    ?>

                    <?php
                        $active = $GLOBALS['headerType'] == 'cart' ? 'active' : '';

                        if ($active == 'active') {
                            include LOCAL_PATH_ROOT.'/game/header/cart/active-cart.php';
                        }else {
                            include LOCAL_PATH_ROOT.'/game/header/cart/cart.php';
                        }
                    ?>
                </ul>

                <?php
                    $active = $GLOBALS['headerType'] == 'browse';
                
                    if ($active) {
                        include LOCAL_PATH_ROOT.'/game/header/browse/active-browse-search.php';
                    }else {
                        include LOCAL_PATH_ROOT.'/game/header/browse/browse-search.php';
                    }
                ?>
            </div>
        </nav>
    </div>
</div>