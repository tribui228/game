<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/include.php');
?>

<div class="container">
    <div class="row">
        <div class="code-header-container code-return disable-select">
            <a class="code-return-icon pr-2" href="/game/purchase_history">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 500.000000 500.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)"
                    fill="currentColor" stroke="none">
                    <path d="M3551 4964 c-80 -21 -158 -67 -236 -137 -767 -688 -2191 -1981 -2223 -2019 -150 -178 -160 -390 -26 -586 42 -60 2272 -2086 2352 -2136 86 -54 147 -70 257 -71 88 0 107 3 156 26 114 54 188 162 197 289 9 125 -44 260 -141 364 -36 37 -1806 1644 -1980 1796 -4 4 410 384 920 845 510 462 965 875 1011 919 137 133 184 228 185 376 1 73 -3 94 -28 148 -72 161 -255 237 -444 186z"/>
                    </g>
                </svg>
            </a>
            <h1 class="title mb-0 mr-auto"> All Redeem Code </h1>
        </div>
        <div class="code-container">
            <div class="code-table">
                <div class="code-table-header">
                    <?php include (LOCAL_PATH_ROOT.'/game/redeem_code_all/table_header.php');?>
                </div>

                <div class="code-table-scroll">
                    <?php include (LOCAL_PATH_ROOT.'/game/redeem_code_all/table_scroll.php');?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <select id="order-items-in-page" class="mr-auto">
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

    $("#order-items-in-page").change(function(e) {
        postData.maxInPage = e.currentTarget.value;
        $.ajax({
            url: "code.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#code").html(result);
                let id = document.getElementById("code");
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
            url: "code.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#code").html(result);
            }
        });
    });

    var codeColumnSortBy = <?php echo is_null($sortBy) ? 'null' : "'$sortBy'";?>;
    var codeColumnSortDir = <?php echo is_null($sortDir) ? 'null' : "'$sortDir'";?>;
    $('.sort-column').click(function(e) {
        let column = e.currentTarget.dataset.column;

        if (column != codeColumnSortBy) {
            codeColumnSortDir = null;
            $arrow = $('#code-arrow-' + codeColumnSortBy);
            $arrow.remove();
            $(this).append('<div id="code-arrow-' + column + '" class="code-arrow arrow down"> </div>');
        }else {
            $('#code-arrow-' + codeColumnSortBy).toggleClass('down', codeColumnSortDir != 'ASC');
            $('#code-arrow-' + codeColumnSortBy).toggleClass('up', codeColumnSortDir == 'ASC');
        }
        codeColumnSortBy = column;
        codeColumnSortDir = codeColumnSortDir == null ? 'ASC' : (codeColumnSortDir == 'ASC' ? 'DESC' : 'ASC');

        postData.sortBy = codeColumnSortBy;
        postData.sortDir = codeColumnSortDir;
        $.ajax({
            url: "table_scroll.php",
            method: "POST",
            data: postData,
            success: function(result){
                $(".code-table-scroll").html(result);
            }
        });
    });
</script>