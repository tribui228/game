<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin | ProGame </title>
    <link rel="shortcut icon" type="image/png" href="/game/img/icon.png">
    <link rel="stylesheet" href="/game/css/style.css">
    <link rel="stylesheet" href="/game/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/game/node_modules/jquery/dist/jquery.js"></script>
    <script src="/game/node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="/game/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/game/node_modules/xregexp/xregexp-all.js"></script>
    <script src="/game/node_modules/chart.js/dist/chart.js"></script>
    <script src="/game/js/api.js"></script>
</head>

<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/notice.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/check_login_session.php');

if (!isset($_GET['type'])) {
    $_GET['type'] = '';
}
?>

<style>
.logo-title {
    font-size: 1.6rem;
    font-weight: 700;
    background: -webkit-linear-gradient(left, #1d39be, #0bdad0, #745eed, #e900a7);-webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

#fullscreen {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-flow: column;
    overflow: hidden;
}

#nav {
    width: 100%;
    display: flex;
    flex: 1 1 auto;
    padding: 0.5 1rem;
    background-color: var(--sub-color);
    border-bottom: solid 1px gray;
    z-index: 2;
    min-height: 54px;
}

#admin {
    height: 100%;
    overflow: hidden;
    flex: 1 1 auto;
}

#admin-container {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

#admin-menu {
    position: absolute;
    display: flex;
    flex-flow: column;
    flex: 0 0 14em;
    max-width: 14rem;
    min-width: 14rem;
    z-index: 1;
    top: 50px;
    transition: 1s;
    max-height: calc(100vh - 86px);
}

#admin-menu.hide {
    left: -224px;
}

#admin-menu.show {
    left: 0px;
}

#admin-menu-category-button {
    position: absolute;
    z-index: 1;
    top: 12px;
    left: 20px;
}

#admin-menu-category-button.hide {
    display: unset !important;
}

#admin-menu-category-button.show {
    display: unset !important;
}

.admin-menu-category {
    font-size: 1.4em;
    font-weight: 600;
    display: none;
}

@media (min-width: 768px) {
    .admin-menu-category {
        display: unset;
    }

    #admin-menu {
        position: unset;
    }
    
    #admin-header-menu {
        display: none;
    }

    #admin-menu-category-button {
        display: none;
    }

    .admin-menu-item.title {
        display: flex !important;
    }
}

.admin-menu-item.title {
    display: none;
    min-height: 50px;
    border-right: 0px;
    border-top: 0px;
    padding: 0.5rem 1rem;
}

.admin-menu-sidebar {
    display: flex;
    flex-flow: column;
    height: 100%;
    max-height: calc(100vh - 136.6px);
    overflow-y: auto;
    overflow-x: hidden;
}

@media (max-width: 768px) {
    #admin-menu {
        position: absolute;
        display: flex;
        z-index: 2;
        top: 50px;
        height: 100%;
        background-color: var(--main-color);
    }

    .admin-menu-sidebar {
        border-top: solid 1px gray;
    }
}

#admin-content {
    position: relative;
    display: flex;
    flex: 1 1 auto;
    flex-flow: column;
    background-color: var(--mid-color);
    overflow: hidden;
}

.admin-menu-item-last {
    border-right: solid 1px gray;
    flex: 1;
}

.admin-menu-item {
    display: flex;
    background-color: var(--sub-color);
    padding: 4px 16px;
    border-bottom: solid 1px gray;
    border-right: solid 1px gray;
    justify-content: space-between;
    align-items: center;
    min-height: 48px;
}

.admin-menu-item:hover {
    cursor: pointer;
}

.admin-menu-item.active {   
    background-color: var(--mid-color);
}

.admin-menu-item.title {
    border-right: solid 1px gray;
}

.admin-menu-title {
    -ms-flex-align: center !important;
    align-items: center !important;
    display: -ms-flexbox !important;
    display: flex !important;
    width: 100%;
}

.admin-menu-name {
    font-size: 1.4em;
    font-weight: 600;
}

.admin-menu-count {
    font-size: 1.3em;
    font-weight: 600;
    color: gray;
    padding: 4px;
    margin-right: auto;
}

#footer {
    background-color: var(--sub-color);
}
</style>

<style>
.admin-header {
    display: flex;
    font-size: 1.4rem;
    font-weight: 600;
    padding: 0.5rem 1rem 0.5rem 4rem;
    border-bottom: solid 1px gray;
    background-color: var(--sub-color);
    align-items: center;
}

@media (min-width: 768px) {
    .admin-header {
        padding: 0.5rem 1rem;
    }
}

.admin-body {
    display: flex;
    flex: 1;
    background-color: #35404e;
    overflow: hidden;
}

.admin-footer {
    display: flex;
    border-top: solid 1px gray;
    justify-content: space-between;
    background-color: #35404e;
    padding: 0.2rem;
}

.admin-table {
    display: flex;
    flex: 1;
    flex-flow: column;
    overflow: auto;
}

.admin-table-header {
    top: 0px;
    position: sticky;
    z-index: 1;
}

.admin-header-title {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.admin-row.header > .admin-column {
    background-color: #35404e;
}

.admin-table-scroll {
    flex: 1;
    -webkit-box-flex: 1;
}

.admin-row {
    display: flex;
    cursor: pointer;
}

.admin-row.header {
    font-weight: 600;
}

.admin-row:hover:not(.header) > .admin-column {
    background-color: #404c5a;
}

.admin-column {
    display: flex;
    flex: 1 0 100px;
    padding: 0.5rem 1rem;
    word-break: break-all;
    border-bottom: solid 1px var(--main-color);
    align-items: center;
    -webkit-box-pack: justify;
}

.admin-column input[type="checkbox"] {
    width: 20px;
    height: 20px;
}

.admin-column input[type=text] {
    width: 100%;
    border: 0;
    background: rgba(0,0,0,.2);
    border-radius: 2px;
    padding: .2rem .5rem;
    color: #fff;
    font-size: 1.0em;
    line-height: 1.5;
}

.admin-column:hover {
    background-color: #64707e !important;
}

.manager-button {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding-left: 1rem;
    opacity: 0.5;
}

.manager-button:hover {
    opacity: 1;
}

.admin-submit {
    color: white;
    background-color: var(--primary);
    border: 1px solid var(--primary);
    cursor: pointer;
}

.form-control.admin-submit:focus {
    color: white;
    background-color: var(--primary);
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
}
</style>

<?php include_once (LOCAL_PATH_ROOT.'/game/image.php');?>
<?php include_once (LOCAL_PATH_ROOT.'/game/loading.php');?>
<?php include_once (LOCAL_PATH_ROOT.'/game/modal.php');?>

<div id="fullscreen">
    <!-- <nav id="nav" class="justify-content-between">
        <a href="/game/">
            <div class="d-flex align-items-center">
                <img src="/game/img/logo.png" width="40" height="40">
                <div class="logo-title"> ProGame </div>
            </div>
        </a>

        <a id="admin-logout" class="d-flex text-danger font-weight-bold" href="#"> 
            <div class="d-flex align-items-center">
                Log out
                <svg style="padding-top: 2px" version="1.0" xmlns="http://www.w3.org/2000/svg"
                width="25px" height="25px" viewBox="0 0 512.000000 512.000000"
                preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                    fill="currentColor" stroke="none">
                        <path d="M724 4786 l-34 -34 0 -1786 0 -1786 28 -29 c17 -19 318 -181 814 -440 604 -316 795 -411 822 -411 25 0 45 9 68 29 l33 29 3 376 3 376 384 0 384 0 36 31 35 31 0 718 0 718 -35 31 c-48 42 -92 42 -140 0 l-35 -31 0 -639 0 -639 -315 0 -315 0 -2 1310 -3 1310 -25 23 c-14 14 -257 145 -540 292 -283 148 -542 283 -575 302 l-60 33 918 0 917 0 0 -619 0 -619 26 -31 c22 -27 32 -31 76 -31 41 0 54 5 79 29 l29 29 0 700 0 700 -35 31 -36 31 -1235 0 -1236 0 -34 -34z"/>
                        <path d="M3724 3840 c-48 -19 -71 -100 -43 -151 6 -12 102 -151 215 -311 112 -159 204 -291 204 -294 0 -2 -316 -4 -702 -4 -451 0 -716 -4 -740 -10 -76 -22 -105 -117 -54 -177 l24 -28 741 -5 741 -5 -175 -247 c-277 -394 -265 -374 -265 -425 0 -63 40 -103 102 -103 24 0 53 7 65 15 12 8 102 129 200 268 422 600 393 555 393 602 0 47 29 2 -393 602 -98 139 -188 260 -200 268 -23 16 -79 19 -113 5z"/>
                    </g>
                </svg>
            </div>
        </a>
    </nav> -->

    <nav id="nav" class="navbar navbar-expand-md navbar-dark font-weight-bold justify-content-end position-relative">
        <a href="/game/">
            <div class="d-flex align-items-center position-absolute" style="top: 5px; left: 7px">
                <img src="/game/img/logo.png" width="40" height="40">
                <div class="logo-title"> ProGame </div>
            </div>
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <!-- class="collapse navbar-collapse" -->
        <div class="" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="d-flex justify-content-center">
                    <a id="admin-logout" class="d-flex text-danger font-weight-bold" href="#"> 
                        <div class="d-flex align-items-center">
                            Log out
                            <svg style="padding-top: 2px" version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                fill="currentColor" stroke="none">
                                    <path d="M724 4786 l-34 -34 0 -1786 0 -1786 28 -29 c17 -19 318 -181 814 -440 604 -316 795 -411 822 -411 25 0 45 9 68 29 l33 29 3 376 3 376 384 0 384 0 36 31 35 31 0 718 0 718 -35 31 c-48 42 -92 42 -140 0 l-35 -31 0 -639 0 -639 -315 0 -315 0 -2 1310 -3 1310 -25 23 c-14 14 -257 145 -540 292 -283 148 -542 283 -575 302 l-60 33 918 0 917 0 0 -619 0 -619 26 -31 c22 -27 32 -31 76 -31 41 0 54 5 79 29 l29 29 0 700 0 700 -35 31 -36 31 -1235 0 -1236 0 -34 -34z"/>
                                    <path d="M3724 3840 c-48 -19 -71 -100 -43 -151 6 -12 102 -151 215 -311 112 -159 204 -291 204 -294 0 -2 -316 -4 -702 -4 -451 0 -716 -4 -740 -10 -76 -22 -105 -117 -54 -177 l24 -28 741 -5 741 -5 -175 -247 c-277 -394 -265 -374 -265 -425 0 -63 40 -103 102 -103 24 0 53 7 65 15 12 8 102 129 200 268 422 600 393 555 393 602 0 47 29 2 -393 602 -98 139 -188 260 -200 268 -23 16 -79 19 -113 5z"/>
                                </g>
                            </svg>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <main id="admin">
        <div id="admin-container">
            <div id="admin-menu-category-button" class="manager-button pl-0 mr-3">
                <svg width="25px" height="25px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" class=""></path></svg>
            </div>
            <div id="admin-menu" class="show">
                <?php include ('sidebar.php')?>
            </div>

            <div id="admin-content">
            <div class="admin-header">
                <div class="admin-header-title mr-auto"> Manager </div>
                <div class="d-flex align-items-center justify-content-center h3 center w-100 text-center px-2 mt-3"> 
                    <svg class="mt-1 mr-2" width="25px" height="25px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg>
                    <span> Choose from the side bar </span>
                </div>
            </div>
        </div>
    </main>
    
    <footer id="footer">
        <div class="d-flex p-1 pl-2 font-weight-bold"> 
            ProGame © 2021 All rights reserved.
        </div>
    </footer>
</div>

<script>
    var sideBarType = null;
    function updateSideBar() {
        $.ajax({
            url: "sidebar.php?type=" + sideBarType, 
            success: function(result){
                $('#admin-menu').html(result);
            }
        });
    }

    $("#admin-menu-category-button").click(function() {
        $adminMenu = $('#admin-menu');
        $has = $adminMenu.hasClass('show');
        $adminMenu.toggleClass('hide', $has);
        $adminMenu.toggleClass('show', !$has);
    });

    $(document).mouseup(function(e) {
        var container = $("#admin-menu");
        var container2 = $("#admin-menu-category-button");
        $adminMenu = $('#admin-menu');

        if (!container.is(e.target) && container.has(e.target).length === 0
        && !container2.is(e.target) && container2.has(e.target).length === 0) {
            $adminMenu.toggleClass('hide', true);
            $adminMenu.toggleClass('show', false);
        }
    });

    $("#admin-logout").click(function() {
        $.ajax({
            url: "/game/login/logout.php", 
            success: function(response){
                if (response == 0) {
                    window.location.href = "/game/admin/login/";
                }
            }
        });
    });
</script>