<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/order/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.order.view')) {
    echo 'no_permission';
    exit();
}
?>

<style>
.admin-column:nth-child(1) {
    flex: 0 0 auto;
}

.admin-column:nth-child(2) {
    flex: 1 0 150px;
}

.admin-column:nth-child(3) {
    flex: 1 0 150px;
}

.admin-column:nth-child(4) {
    flex: 1 0 150px;
}

.admin-column:nth-child(5) {
    flex: 1 0 150px;
}

.admin-column:nth-child(6) {
    flex: 1 0 180px;
}

.admin-column:nth-child(7) {
    flex: 1 0 180px;
}
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Order Manager </div>

    <div id="admin-header-search" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 225.000000 225.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M631 2234 c-35 -7 -110 -36 -165 -63 -178 -87 -299 -208 -387 -386 -63 -129 -79 -204 -79 -380 0 -176 16 -251 79 -380 84 -171 202 -291 371 -378 134 -70 228 -91 395 -91 168 0 260 21 398 92 l89 45 347 -347 347 -346 73 0 c72 0 74 1 112 39 38 38 39 40 39 112 l0 73 -346 347 -347 347 45 89 c71 138 92 230 92 398 0 116 -4 154 -23 225 -47 168 -149 328 -279 436 -82 68 -244 149 -337 169 -90 19 -336 19 -424 -1z m334 -299 c104 -27 184 -72 261 -149 220 -220 220 -542 0 -762 -220 -220 -542 -220 -762 0 -218 219 -218 543 0 762 138 137 327 193 501 149z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-check" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 900.000000 900.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,900.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M841 8494 c-168 -45 -304 -190 -340 -362 -15 -72 -16 -5305 -1 -5383 36 -190 200 -349 390 -379 76 -12 2584 -14 2578 -2 -2 4 -18 35 -36 69 -55 107 -77 258 -53 380 l8 43 -1201 2 -1201 3 -2 2573 -3 2572 2580 0 2580 0 0 -1982 0 -1982 244 240 243 239 2 1797 c1 1737 0 1798 -18 1857 -48 154 -175 274 -336 317 -78 21 -5356 19 -5434 -2z"/>
                <path d="M3294 7296 c-200 -38 -392 -116 -541 -218 -88 -61 -236 -214 -281 -290 -18 -31 -45 -89 -60 -130 -24 -65 -26 -88 -27 -208 0 -128 1 -138 28 -193 36 -72 107 -146 172 -177 65 -32 210 -40 281 -16 63 21 133 77 196 155 29 36 89 102 133 147 106 107 155 127 310 128 105 1 113 -1 177 -32 82 -40 149 -111 179 -190 17 -47 20 -71 16 -135 -6 -97 -39 -167 -103 -227 -66 -61 -149 -95 -327 -134 -101 -23 -176 -45 -209 -63 -56 -30 -101 -85 -119 -142 -15 -48 -21 -487 -9 -581 12 -93 45 -162 107 -223 70 -70 138 -99 249 -105 264 -14 423 151 424 440 0 47 0 47 43 58 383 95 638 299 746 596 40 110 61 225 68 374 27 581 -323 1020 -922 1155 -97 22 -435 29 -531 11z"/>
                <path d="M8124 5146 c-275 -63 -663 -344 -1256 -909 -406 -388 -1014 -1036 -1448 -1545 -57 -67 -106 -121 -110 -119 -3 2 -106 53 -230 114 -492 243 -788 341 -1001 331 -113 -6 -184 -33 -243 -94 -93 -96 -119 -246 -59 -335 10 -14 79 -82 153 -151 427 -398 772 -858 1206 -1603 190 -326 186 -319 236 -343 54 -27 110 -28 164 -3 35 16 94 75 94 94 0 3 40 102 89 219 424 1016 933 1891 1536 2643 252 313 369 442 785 855 218 217 411 416 428 442 85 125 83 238 -7 328 -76 76 -207 105 -337 76z"/>
                <path d="M3375 4423 c-118 -42 -225 -137 -273 -241 -114 -248 25 -537 292 -608 235 -63 485 105 528 354 32 189 -69 380 -249 469 -66 32 -85 37 -161 40 -65 3 -100 -1 -137 -14z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-approve" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="33px" height="33px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M2760 4565 c-265 -45 -519 -166 -715 -341 l-60 -54 -627 0 -628 0 0 -1825 0 -1825 1405 0 1405 0 0 668 0 668 58 28 c413 202 707 589 788 1038 22 125 22 362 0 487 -107 597 -574 1058 -1172 1156 -108 18 -349 18 -454 0z m366 -280 c90 -8 235 -50 331 -95 331 -155 564 -450 639 -810 24 -116 25 -317 1 -430 -64 -301 -241 -563 -487 -722 -109 -71 -156 -94 -260 -130 -281 -95 -600 -74 -863 58 -137 69 -300 204 -391 324 -327 429 -310 1008 42 1423 166 195 423 339 672 376 129 19 165 20 316 6z m-1397 -467 c-149 -287 -196 -658 -120 -970 l18 -78 -98 0 -99 0 0 -145 0 -145 159 0 159 0 28 -47 c36 -63 99 -150 137 -190 l31 -33 -257 0 -257 0 0 -145 0 -145 440 0 441 0 60 -30 c117 -60 279 -108 437 -131 82 -11 339 -7 410 7 l32 6 0 -481 0 -481 -1115 0 -1115 0 0 1540 0 1540 374 0 373 0 -38 -72z"/>
                <path d="M3193 3318 l-413 -413 -243 243 -242 242 -103 -103 -102 -102 345 -345 345 -345 517 517 518 518 -100 100 c-55 55 -102 100 -105 100 -3 0 -191 -186 -417 -412z"/>
                <path d="M1430 1510 l0 -140 700 0 700 0 0 140 0 140 -700 0 -700 0 0 -140z"/>
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

    <div id="admin-header-remove" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M2354 5101 c-262 -71 -463 -274 -539 -543 l-16 -58 -497 0 c-284 0 -525 -4 -562 -10 -158 -25 -307 -136 -381 -285 -101 -204 -66 -437 90 -595 75 -76 139 -113 249 -141 73 -18 128 -19 1851 -19 1486 0 1787 3 1842 14 100 21 184 69 259 145 73 75 112 140 135 226 19 73 19 213 1 280 -36 135 -140 259 -268 320 -131 62 -156 65 -718 65 l-505 0 -18 67 c-62 238 -250 437 -492 519 -69 24 -99 28 -220 31 -114 2 -153 -1 -211 -16z m352 -271 c140 -48 260 -172 299 -307 l6 -23 -470 0 -470 0 11 31 c51 147 202 278 361 314 77 18 185 11 263 -15z m1670 -609 c96 -44 158 -134 158 -231 0 -98 -60 -195 -149 -243 l-40 -22 -1780 -3 c-1985 -3 -1825 -8 -1907 66 -62 56 -83 104 -83 192 0 57 5 84 22 115 28 53 78 99 133 124 45 20 56 21 1825 21 1709 0 1782 -1 1821 -19z"/>

                <path d="M803 3180 c-22 -13 -35 -31 -43 -59 -7 -28 -10 -415 -8 -1273 l3 -1233 24 -70 c92 -272 287 -460 545 -525 77 -19 115 -20 1221 -20 1293 0 1210 -5 1385 82 69 35 103 60 180 138 106 106 156 183 198 305 l27 80 3 1263 2 1264 -34 34 c-31 31 -39 34 -93 34 -38 0 -67 -6 -82 -16 -53 -37 -51 9 -51 -1276 0 -1312 3 -1253 -62 -1381 -61 -122 -209 -231 -349 -257 -37 -7 -431 -10 -1155 -8 l-1099 3 -60 23 c-131 50 -225 134 -288 261 l-42 84 -5 1241 c-4 964 -8 1246 -17 1263 -37 63 -133 84 -200 43z"/>
                <path d="M1612 3020 c-44 -10 -70 -35 -83 -79 -7 -24 -9 -399 -7 -1144 l3 -1109 31 -28 c46 -40 103 -48 152 -20 78 44 72 -54 72 1195 l0 1117 -34 34 c-19 19 -43 34 -54 34 -11 0 -26 2 -34 4 -7 2 -28 0 -46 -4z"/>
                <path d="M2510 3019 c-52 -11 -87 -57 -95 -121 -3 -29 -5 -532 -3 -1118 3 -1141 1 -1100 52 -1134 64 -41 148 -22 194 44 l22 33 0 1099 c0 1185 2 1148 -52 1181 -31 20 -76 26 -118 16z"/>
                <path d="M3402 3020 c-44 -10 -70 -35 -82 -79 -14 -50 -14 -2183 0 -2233 28 -100 164 -115 231 -25 l24 32 0 1110 c0 1045 -1 1112 -18 1138 -32 50 -91 71 -155 57z"/>
            </g>
        </svg>
    </div>
</div>
<div class="admin-body"> 
    <div class="admin-table">
        <div class="admin-table-header">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/order/table_header.php');?>
        </div>

        <div class="admin-table-scroll">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/order/table_scroll.php');?>
        </div>
    </div>
</div>

<div class="admin-footer">
    <select id="order-in-page">
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
        "searchUsername": '<?=$searchUsername?>',
        "searchStatus": '<?=$searchStatus?>',
        "searchMinTotalPrice": '<?=$searchMinTotalPrice?>',
        "searchMaxTotalPrice": '<?=$searchMaxTotalPrice?>',
        "searchMinQuantity": '<?=$searchMinQuantity?>',
        "searchMaxQuantity": '<?=$searchMaxQuantity?>',
        "searchFromOrderedDate": '<?=$searchFromOrderedDate?>',
        "searchToOrderedDate": '<?=$searchToOrderedDate?>',
        "searchFromCheckedDate": '<?=$searchFromCheckedDate?>',
        "searchToCheckedDate": '<?=$searchToCheckedDate?>',
        "currentPage": <?=$currentPage?>,
        "maxInPage": <?=$maxInPage?>
    };

    $("#order-in-page").change(function(e) {
        postData.maxInPage = e.currentTarget.value;
        $.ajax({
            url: "order/index.php",
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
            url: "order/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    });

    function reloadOrderAdmin() {
        $.ajax({
            url: "order/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    }

    function getOrdersFromCheckboxs() {
        let orderNames = [];
        $(".admin-checkbox:not(.all)").each(function() {
            if ($(this)[0].checked) {
                orderNames.push(this.dataset.name);
            }
        });
        return orderNames;
    }

    var orderColumnSortBy = <?php echo is_null($sortBy) ? 'null' : "'$sortBy'";?>;
    var orderColumnSortDir = <?php echo is_null($sortDir) ? 'null' : "'$sortDir'";?>;
    $('.sort-column').click(function(e) {
        let column = e.currentTarget.dataset.column;

        if (column != orderColumnSortBy) {
            orderColumnSortDir = null;
            $arrow = $('#admin-arrow-' + orderColumnSortBy);
            $arrow.remove();
            $(this).append('<div id="admin-arrow-' + column + '" class="admin-arrow arrow down"> </div>');
        }else {
            $('#admin-arrow-' + orderColumnSortBy).toggleClass('down', orderColumnSortDir != 'ASC');
            $('#admin-arrow-' + orderColumnSortBy).toggleClass('up', orderColumnSortDir == 'ASC');
        }
        orderColumnSortBy = column;
        orderColumnSortDir = orderColumnSortDir == null ? 'ASC' : (orderColumnSortDir == 'ASC' ? 'DESC' : 'ASC');

        postData.sortBy = orderColumnSortBy;
        postData.sortDir = orderColumnSortDir;
		$.ajax({
            url: "order/table_scroll.php",
            method: "POST",
            data: postData,
            success: function(result){
                $(".admin-table-scroll").html(result);
            }
        });
    });

    $("#admin-header-check").click(function(e) {
        let orders = getOrdersFromCheckboxs();

        if (orders.length != 1) {
            alert("You must choose one row!");
            return;
        }

        let id = orders[0];
        $.ajax({
            url: "order/check_order.php",
            method: "POST",
            data: {
                "order_id": id
            },
            success: function(result) {
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else if (result == 0) {
                    callSuccessNotice("This order can be approved!"); 
                }else if (result == 1) {
                    callNotice("This order has already approved!"); 
                }else {
                    callDangerNotice("Not enough product code to approve!"); 
                }
            }
        });
    });

    $("#admin-header-approve").click(function(e) {
        let orders = getOrdersFromCheckboxs();

        if (orders.length != 1) {
            alert("You must choose one row!");
            return;
        }

        let id = orders[0];
        if (!window.confirm("Are you sure to approve this order?")) {
            return;
        }

        showLoading();
        $.ajax({
            url: "order/approve_order.php",
            method: "POST",
            data: {
                "order_id": id
            },
            success: function(result) {
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else if (result == 0) {
                    $.ajax({
                        url: "order/table_scroll.php",
                        method: "POST",
                        data: postData,
                        success: function(result){
                            $(".admin-table-scroll").html(result);
                        }
                    });
                    callSuccessNotice("Success approve order!"); 
                }else if (result == 1) {
                    callDangerNotice("Not enough product code to approve!");
                }else if (result == 2) {
                    callNotice("This order has already approved!"); 
                }else {
                    callNotice("Cannot approve order!"); 
                }
                closeLoading();
            }
        });
    });

    $("#admin-header-search").click(function(e) {
        $.ajax({
            url: "order/search_order_form.php",
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
        let orders = getOrdersFromCheckboxs();

        if (orders.length != 1) {
            alert("You must choose one row!");
            return;
        }

        let id = orders[0];

        $.ajax({
            url: "order_item/index.php",
            method: "POST",
            data: {"id": id},
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#admin-content").html(result);
                }
            }
        });
    });

    $("#admin-header-remove").click(function (e) {
        let orders = getOrdersFromCheckboxs();

        if (orders.length == 0) {
            alert("You must choose at least one row!");
            return;
        }

        if (!window.confirm("Are you sure to remove?")) {
            return;
        }

        showLoading();
        $.ajax({
            url: "order/remove_order.php", 
            method: "POST",
            data: {"order_id_array": orders},
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else if (result == 0) {
                    callNotice("Remove Order Successfully!");
                    updateSideBar();
                    reloadOrderAdmin();
                }else if (result == 1) {
                    callNotice("Some can remove, some cannot!");
                    updateSideBar();
                    reloadOrderAdmin();
                }else if (result == 2) {
                    callNotice("Cannot remove order approved!");
                }else if (result == 3) {
                    callNotice("Wrong params!");
                }
                closeLoading();
            }
        });
    });
</script>