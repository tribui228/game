<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/by_genre/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

// if (!UserUtil::hasPermission($_SESSION['username'], 'admin.statistic.genre.view')) {
//     echo 'no_permission';
//     exit();
// }
?>

<style>
.admin-column:nth-child(1) {
    flex: 0 0 60px;
}

.admin-column:nth-child(2) {
    flex: 1 0 200px;
}

.admin-column:nth-child(3) {
    flex: 1 0 200px;
}

.admin-column:nth-child(4) {
    flex: 1 0 200px;
}

.admin-column:nth-child(5) {
    flex: 1 0 200px;
}

.admin-column:nth-child(6) {
    flex: 1 0 200px;
}

.admin-column:nth-child(7) {
    flex: 1 0 230px;
}

.admin-column:nth-child(8) {
    flex: 1 0 200px;
}

.admin-column:nth-child(9) {
    flex: 1 0 200px;
}

.admin-column:nth-child(10) {
    flex: 1 0 230px;
}
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Statistic By Genre </div>
    <div id="admin-header-search" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 225.000000 225.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M631 2234 c-35 -7 -110 -36 -165 -63 -178 -87 -299 -208 -387 -386 -63 -129 -79 -204 -79 -380 0 -176 16 -251 79 -380 84 -171 202 -291 371 -378 134 -70 228 -91 395 -91 168 0 260 21 398 92 l89 45 347 -347 347 -346 73 0 c72 0 74 1 112 39 38 38 39 40 39 112 l0 73 -346 347 -347 347 45 89 c71 138 92 230 92 398 0 116 -4 154 -23 225 -47 168 -149 328 -279 436 -82 68 -244 149 -337 169 -90 19 -336 19 -424 -1z m334 -299 c104 -27 184 -72 261 -149 220 -220 220 -542 0 -762 -220 -220 -542 -220 -762 0 -218 219 -218 543 0 762 138 137 327 193 501 149z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-info" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 256.000000 256.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,256.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
            <path d="M1105 2433 c-145 -22 -314 -86 -444 -165 -117 -72 -297 -252 -369 -369 -59 -97 -112 -220 -144 -336 -19 -67 -22 -105 -22 -278 -1 -176 2 -210 22 -284 59 -224 147 -376 312 -541 165 -165 318 -253 541 -312 73 -20 109 -23 279 -23 170 0 206 3 279 23 202 53 369 145 513 282 177 166 278 336 341 573 19 71 22 108 22 277 0 170 -3 206 -23 279 -59 223 -147 376 -312 541 -127 127 -229 197 -372 255 -155 63 -224 76 -418 80 -96 2 -188 1 -205 -2z m370 -139 c383 -73 685 -352 802 -739 25 -84 27 -102 27 -275 0 -173 -2 -191 -27 -275 -72 -237 -211 -433 -401 -566 -183 -130 -373 -190 -596 -190 -465 0 -857 297 -997 756 -25 84 -27 102 -27 275 0 172 2 191 27 275 158 526 664 840 1192 739z"/>
            <path d="M1192 1944 c-56 -29 -86 -77 -90 -149 -8 -117 51 -186 163 -193 117 -8 186 51 193 163 5 76 -15 124 -66 163 -45 34 -148 42 -200 16z"/>
            <path d="M1192 1364 c-18 -10 -45 -33 -60 -52 l-27 -35 -3 -304 c-3 -340 -2 -349 66 -401 31 -24 44 -27 112 -27 68 0 81 3 112 27 66 50 68 62 68 388 0 326 -2 338 -68 388 -45 34 -148 42 -200 16z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-return" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"  width="25px" height="25px" viewBox="0 0 512.000000 512.000000"  preserveAspectRatio="xMidYMid meet"> 
            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none"> 
                <path d="M2132 4513 c-30 -10 -148 -105 -405 -326 -199 -171 -558 -479 -797 -685 -570 -489 -554 -475 -575 -518 -43 -92 -24 -178 56 -247 686 -599 1655 -1423 1697 -1444 115 -56 193 -36 242 62 25 50 25 50 28 386 l3 336 107 26 c59 14 144 31 190 38 109 15 383 6 482 -16 251 -56 493 -185 710 -378 278 -246 544 -645 709 -1062 51 -130 92 -163 129 -104 14 22 42 166 69 352 25 179 25 687 0 842 -121 737 -514 1262 -1198 1606 -228 114 -482 203 -754 264 -132 29 -359 65 -417 65 l-38 0 0 343 c0 381 -2 394 -69 450 -38 32 -98 35 -169 10z"/> 
            </g> 
        </svg>
    </div> 
</div>
<div class="admin-body"> 
    <div class="admin-table">
        <div class="admin-table-header">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/statistic/by_genre/table_header.php');?>
        </div>

        <div class="admin-table-scroll">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/statistic/by_genre/table_scroll.php');?>
        </div>
    </div>
</div>

<div class="admin-footer">
    <select id="genre-in-page">
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
                    echo '<li class="page-item" data-page="'.($currentPage - 1).'"> &laquo; </a> </li>';
                }
                if (!$page->isContainMinPage()) {
                    echo '<li class="page-item" data-page="1"> 1 </li>';
                    echo '...';
                }

                for ($i = $begin; $i <= $last; $i++) {
                    if ($i == $page->getCurrentPage()) {
                        echo '<li class="page-item active" data-page="-1"> '.$i.' </li>';
                    }else {
                        echo '<li class="page-item" data-page="'.$i.'"> '.$i.' </li>';
                    }
                }

                if (!$page->isContainMaxPage()) {
                    echo '...';
                    echo '<li class="page-item" data-page="'.$page->getPages().'"> '.$page->getPages().' </li>';
                }

                if ($currentPage < $page->getPages()) {
                    echo '<li class="page-item" data-page="'.($currentPage + 1).'"> &raquo; </li>';
                }
            }
        ?>
    </ul>
</nav>
</div>

<script>
    var postData = {
        "sortBy": '<?=$sortBy?>',
        "sortDir": '<?=$sortDir?>',
        "searchName": '<?=$searchName?>',
        "searchFromDate": '<?=$searchFromDate?>',
        "searchToDate": '<?=$searchToDate?>',
        "currentPage": <?=$currentPage?>,
        "maxInPage": <?=$maxInPage?>
    };

    $("#genre-in-page").change(function(e) {
        postData.maxInPage = e.currentTarget.value;
        $.ajax({
            url: "statistic/by_genre/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    });

    $('.page-item:not(.active)').click(function(e) {
        postData.currentPage = e.currentTarget.dataset.page;
        $.ajax({
            url: "statistic/by_genre/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    });

    function reloadStatisticByProduct() {
        $.ajax({
            url: "statistic/by_genre/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    }

    var genreColumnSortBy = <?php echo is_null($sortBy) ? 'null' : "'$sortBy'";?>;
    var genreColumnSortDir = <?php echo is_null($sortDir) ? 'null' : "'$sortDir'";?>;
    $('.sort-column').click(function(e) {
        let column = e.currentTarget.dataset.column;

        if (column != genreColumnSortBy) {
            genreColumnSortDir = null;
            $arrow = $('#admin-arrow-' + genreColumnSortBy);
            $arrow.remove();
            $(this).append('<div id="admin-arrow-' + column + '" class="admin-arrow arrow down"> </div>');
        }else {
            $('#admin-arrow-' + genreColumnSortBy).toggleClass('down', genreColumnSortDir != 'ASC');
            $('#admin-arrow-' + genreColumnSortBy).toggleClass('up', genreColumnSortDir == 'ASC');
        }
        genreColumnSortBy = column;
        genreColumnSortDir = genreColumnSortDir == null ? 'ASC' : (genreColumnSortDir == 'ASC' ? 'DESC' : 'ASC');

        postData.sortBy = genreColumnSortBy;
        postData.sortDir = genreColumnSortDir;
		$.ajax({
            url: "statistic/by_genre/table_scroll.php",
            method: "POST",
            data: postData,
            success: function(result){
                $(".admin-table-scroll").html(result);
            }
        });
    });

    $("#admin-header-search").click(function(e) {
        $.ajax({
            url: "statistic/by_genre/search_genre_form.php",
            method: "POST",
            data: postData,
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#modal-content").html(result);
                    showModal();
                }
            }
        });
    });

    $("#admin-header-info").click(function(e) {
        $.ajax({
            url: "statistic/by_genre/summary_form.php",
            method: "POST",
            data: postData,
            success: function(result) {
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#modal-content").html(result);
                    showModal();
                }
            }
        });
    });

    $("#admin-header-return").click(function (e) {
        $.ajax({
            url: "statistic/index.php",
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $('#admin-menu').toggleClass('show', false);
                    $('#admin-menu').toggleClass('hide', true);
                    $('.admin-menu-item').toggleClass('active', false);
                    $current.toggleClass('active', true);
                    $("#admin-content").html(result);
                    sideBarType = type;
                }
            }
        });
    });
</script>