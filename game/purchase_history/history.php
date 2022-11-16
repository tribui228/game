<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/include.php');
include_once (LOCAL_PATH_ROOT.'/game/purchase_history/params.php');
?>
<style>
#history {
    min-height: 100vh;
}

.history-container {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.history-header-container {
    display: flex;
    align-items: center;
    width: 100%;
}


.history-body {
    display: flex;
    flex: 1;
    overflow: hidden;
}

.history-table {
    display: flex;
    flex: 1;
    flex-flow: column;
    overflow: auto;
}

.history-table-header {
    flex: 1;
}

.history-row {
    background-color: #35404e;
    display: flex;
    cursor: pointer;
}

.history-row.history-header {
    font-weight: 600;
}

.history-row:hover:not(.history-header) > .history-column {
    background-color: #404c5a;
}

.history-column:hover {
    background-color: #64707e !important;
}

.history-column {
    display: flex;
    border-bottom: solid 1px var(--main-color);
    padding: 0.5rem 1rem;
    background-color: #35404e;
    align-items: center;
}

.history-column:nth-child(1) {
    flex: 0 0 60px;
}

.history-column:nth-child(2) {
    flex: 1 0 120px;
}

.history-column:nth-child(3) {
    flex: 1 0 80px;
}

.history-column:nth-child(4) {
    flex: 1 0 100px;
}

.history-column:nth-child(5) {
    flex: 1 0 100px;
}

.history-column:nth-child(6) {
    flex: 1 0 150px;
}
</style>

<div class="container">
    <div class="row">
        <div class="history-header-container">
            <h1 class="title mb-0 mr-auto"> Purchase History </h1>
            <form class="mb-0" action="/game/redeem_code_all/">
                <input type="submit" class="form-control btn btn-primary" value="All Redeem Code">
            </form>
            <div class="clearfix"> </div>
        </div>
        <div class="history-container">
            <div class="history-table">
                <div class="history-table-header">
                    <?php include (LOCAL_PATH_ROOT.'/game/purchase_history/table_header.php');?>
                </div>

                <div class="history-table-scroll">
                    <?php include (LOCAL_PATH_ROOT.'/game/purchase_history/table_scroll.php');?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <select id="history-in-page" class="mr-auto">
            <option value="5" <?=$maxInPage==5 ? 'selected="selected"' : ''?>> 5 </option>
            <option value="10" <?=$maxInPage==10 ? 'selected="selected"' : ''?>> 10 </option>
            <option value="25" <?=$maxInPage==25 ? 'selected="selected"' : ''?>> 25 </option>
            <option value="50" <?=$maxInPage==50 ? 'selected="selected"' : ''?>> 50 </option>
            <option value="100" <?=$maxInPage==100 ? 'selected="selected"' : ''?>> 100 </option>
        </select>

        <nav class="disable-select" aria-label="Page navigation example">
            <ul class="page">
                <?php
                    if ($page->getPages() > 0) {
                        $begin = $page->getMinPreviousPage();
                        $last = $page->getMaxNextPage();

                        if ($currentPage > 1) {
                            echo '<li class="page-item"> <a class="a-page-item" href="#code" data-page="'.($currentPage - 1).'"> &laquo; </a> </li>';
                        }
                        if (!$page->isContainMinPage()) {
                            echo '<li class="page-item"> <a class="a-page-item" href="#code" data-page="1"> 1 </a> </li>';
                            echo '...';
                        }
        
                        for ($i = $begin; $i <= $last; $i++) {
                            if ($i == $page->getCurrentPage()) {
                                echo '<li class="page-item active" data-page="-1"> '.$i.' </li>';
                            }else {
                                echo '<li class="page-item"> <a class="a-page-item" data-page="'.$i.'" href="#code"> '.$i.' </a> </li>';
                            }
                        }
        
                        if (!$page->isContainMaxPage()) {
                            echo '...';
                            echo '<li class="page-item"> <a class="a-page-item" href="#code" data-page="'.$page->getPages().'"> '.$page->getPages().'</a> </li>';
                        }
        
                        if ($currentPage < $page->getPages()) {
                            echo '<li class="page-item" <a class="a-page-item" href="#code" data-page="'.($currentPage + 1).'"> &raquo; </a> </li>';
                        }
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>

<script>
    var postData = {
        "sortBy": '<?=$sortBy?>',
        "sortDir": '<?=$sortDir?>',
        "currentPage": <?=$currentPage?>,
        "maxInPage": <?=$maxInPage?>
    };

    $("#history-in-page").change(function(e) {
        postData.maxInPage = e.currentTarget.value;
        $.ajax({
            url: "history.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#history").html(result);
                let id = document.getElementById("history");
                id.scrollIntoView();
            }
        });
    });

    $('.a-page-item').click(function(e) {
        let page = e.currentTarget.dataset.page;

        if (page == -1) {
            return;
        }

        postData.currentPage = page;
        $.ajax({
            url: "history.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#history").html(result);
            }
        });
    });

    var historyColumnSortBy = <?php echo is_null($sortBy) ? 'null' : "'$sortBy'";?>;
    var historyColumnSortDir = <?php echo is_null($sortDir) ? 'null' : "'$sortDir'";?>;
    $('.sort-column').click(function(e) {
        let column = e.currentTarget.dataset.column;

        if (column != historyColumnSortBy) {
            historyColumnSortDir = null;
            $arrow = $('#history-arrow-' + historyColumnSortBy);
            $arrow.remove();
            $(this).append('<div id="history-arrow-' + column + '" class="history-arrow arrow down"> </div>');
        }else {
            $('#history-arrow-' + historyColumnSortBy).toggleClass('down', historyColumnSortDir != 'ASC');
            $('#history-arrow-' + historyColumnSortBy).toggleClass('up', historyColumnSortDir == 'ASC');
        }
        historyColumnSortBy = column;
        historyColumnSortDir = historyColumnSortDir == null ? 'ASC' : (historyColumnSortDir == 'ASC' ? 'DESC' : 'ASC');

        postData.sortBy = historyColumnSortBy;
        postData.sortDir = historyColumnSortDir;
        $.ajax({
            url: "table_scroll.php",
            method: "POST",
            data: postData,
            success: function(result){
                $(".history-table-scroll").html(result);
            }
        });
    });
</script>