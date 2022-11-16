<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/include.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /game/login/");
    exit();
}
?>

<style>
#code {
    min-height: 100vh;
}

.code-container {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.code-header-container {
    display: flex;
    align-items: center;
    width: 100%;
}


.code-body {
    display: flex;
    flex: 1;
    overflow: hidden;
}

.code-table {
    display: flex;
    flex: 1;
    flex-flow: column;
    overflow: auto;
}

.code-table-header {
    flex: 1;
}

.code-row {
    background-color: #35404e;
    display: flex;
    cursor: pointer;
}

.code-row.code-header {
    font-weight: 600;
}

.code-row:hover:not(.code-header) > .code-column {
    background-color: #404c5a;
}

.code-column:hover {
    background-color: #64707e !important;
}

.code-column {
    display: flex;
    border-bottom: solid 1px var(--main-color);
    padding: 0.5rem 1rem;
    background-color: #35404e;
    align-items: center;
}

.code-column:nth-child(1) {
    flex: 0 0 60px;
}

.code-column:nth-child(2) {
    flex: 1 0 200px;
}

.code-column:nth-child(3) {
    flex: 1 0 200px;
}

.code-column:nth-child(4) {
    flex: 1 0 100px;
}

.code-column:nth-child(5) {
    flex: 1 0 100px;
}

.code-column:nth-child(6) {
    flex: 1 0 150px;
}

.code-column:nth-child(7) {
    flex: 1 0 150px;
}

.code-return-icon {
    color: white;
}
</style>

<?php $GLOBALS['headerType'] = 'other'; include (LOCAL_PATH_ROOT.'/game/header/index.php')?>

<body>
    <div id="code">
        <?php include 'code.php';?>
    </div>
</body>

<?php include (LOCAL_PATH_ROOT.'/game/footer.php');?>
</html>