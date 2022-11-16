<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/product/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.view')) {
    echo 'no_permission';
    exit();
}
?>

<style>
.admin-column:nth-child(1) {
    flex: 0 0 auto;
}

.admin-column:nth-child(2) {
    flex: 1 0 200px;
}

.admin-column:nth-child(3) {
    flex: 1 0 200px;
}

.admin-column:nth-child(4) {
    flex: 1 0 150px;
}

.admin-column:nth-child(5) {
    flex: 1 0 200px;
}

.admin-column:nth-child(6) {
    flex: 1 0 150px;
}

.admin-column:nth-child(7) {
    flex: 1 0 150px;
}

.admin-column:nth-child(8) {
    flex: 1 0 150px;
}

.admin-column:nth-child(9) {
    flex: 1 0 150px;
}

.admin-column:nth-child(10) {
    flex: 1 0 250px;
}
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Product Manager </div>
    <div id="admin-header-search" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 225.000000 225.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M631 2234 c-35 -7 -110 -36 -165 -63 -178 -87 -299 -208 -387 -386 -63 -129 -79 -204 -79 -380 0 -176 16 -251 79 -380 84 -171 202 -291 371 -378 134 -70 228 -91 395 -91 168 0 260 21 398 92 l89 45 347 -347 347 -346 73 0 c72 0 74 1 112 39 38 38 39 40 39 112 l0 73 -346 347 -347 347 45 89 c71 138 92 230 92 398 0 116 -4 154 -23 225 -47 168 -149 328 -279 436 -82 68 -244 149 -337 169 -90 19 -336 19 -424 -1z m334 -299 c104 -27 184 -72 261 -149 220 -220 220 -542 0 -762 -220 -220 -542 -220 -762 0 -218 219 -218 543 0 762 138 137 327 193 501 149z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-add" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512.000000 512.000000"  preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
            fill="currentColor" stroke="none">
                <path d="M2255 5108 c-396 -44 -826 -207 -1155 -437 -243 -169 -482 -408 -651 -651 -235 -336 -394 -762 -438 -1172 -14 -125 -14 -451 0 -576 128 -1180 1081 -2133 2261 -2261 125 -14 451 -14 576 0 1186 128 2140 1088 2263 2277 17 170 7 546 -20 695 -103 579 -366 1064 -791 1462 -390 365 -917 606 -1452 664 -115 13 -479 12 -593 -1z m574 -653 c574 -84 1075 -419 1377 -923 121 -202 213 -461 248 -699 21 -146 21 -400 0 -546 -109 -748 -660 -1372 -1389 -1572 -170 -46 -315 -65 -505 -65 -190 0 -335 19 -505 65 -647 178 -1162 693 -1340 1340 -18 66 -40 170 -49 232 -21 144 -21 401 -1 542 98 671 544 1242 1171 1501 135 55 304 103 444 124 131 19 416 20 549 1z"/>
                <path d="M2240 3360 l0 -480 -480 0 -480 0 0 -320 0 -320 480 0 480 0 0 -480 0 -480 320 0 320 0 0 480 0 480 480 0 480 0 0 320 0 320 -480 0 -480 0 0 480 0 480 -320 0 -320 0 0 -480z"/>
            </g>
        </svg>
    </div>

    <div id="admin-header-edit" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M4292 5101 c-84 -25 -177 -73 -236 -123 -48 -41 -2320 -2522 -2363 -2581 -12 -16 -87 -222 -165 -456 -136 -406 -143 -430 -143 -506 0 -95 24 -155 90 -221 76 -75 213 -105 315 -69 98 35 808 350 842 374 55 40 2326 2532 2379 2611 66 99 91 181 96 315 9 202 -44 343 -181 480 -139 140 -272 196 -466 194 -69 0 -126 -7 -168 -18z m275 -457 c15 -11 40 -37 57 -57 39 -49 48 -135 20 -190 -11 -20 -457 -515 -992 -1102 l-974 -1065 -96 89 c-54 48 -118 108 -145 132 l-47 44 978 1070 c605 662 992 1078 1013 1088 47 24 148 19 186 -9z m-2304 -2649 c59 -54 104 -102 100 -106 -4 -4 -98 -47 -208 -94 -110 -48 -208 -91 -217 -96 -12 -7 2 48 58 214 41 122 76 228 79 236 4 11 15 5 43 -20 20 -20 86 -80 145 -134z"/>
                <path d="M833 4635 c-353 -64 -650 -316 -767 -651 -59 -169 -57 -95 -54 -1694 l3 -1465 22 -77 c102 -360 358 -616 719 -720 l79 -23 1515 0 1515 0 86 27 c180 57 316 137 438 259 121 121 202 258 259 439 l27 85 3 1045 c2 740 0 1056 -8 1083 -14 49 -65 106 -115 128 -52 24 -138 24 -190 0 -43 -19 -99 -76 -118 -120 -9 -19 -13 -293 -17 -1051 -5 -941 -6 -1029 -22 -1068 -74 -183 -185 -295 -352 -354 l-81 -28 -1430 0 -1430 0 -81 28 c-135 47 -244 140 -308 262 -70 133 -66 34 -66 1583 0 1244 2 1406 16 1461 44 172 176 317 350 384 l69 27 1055 5 c1005 5 1057 6 1090 24 133 71 168 235 72 346 -73 86 18 80 -1162 79 -812 -1 -1061 -4 -1117 -14z"/>
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
            <?php include(LOCAL_PATH_ROOT.'/game/admin/product/table_header.php');?>
        </div>

        <div class="admin-table-scroll">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/product/table_scroll.php');?>
        </div>
    </div>
</div>

<div class="admin-footer">
    <select id="product-in-page">
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
        "searchDisplay": '<?=$searchDisplay?>',
        "searchDeveloper": '<?=$searchDeveloper?>',
        "searchPublisher": '<?=$searchPublisher?>',
        "searchFromReleaseDate": '<?=$searchFromReleaseDate?>',
        "searchToReleaseDate": '<?=$searchToReleaseDate?>',
        "searchMinPrice": '<?=$searchMinPrice?>',
        "searchMaxPrice": '<?=$searchMaxPrice?>',
        "searchSaleName": '<?=$searchSaleName?>',
        "searchImage": '<?=$searchImage?>',
        "searchBackgroundImage": '<?=$searchBackgroundImage?>',
        "searchGenres": <?=json_encode($searchGenres)?>,
        "currentPage": <?=$currentPage?>,
        "maxInPage": <?=$maxInPage?>
    };

    $("#product-in-page").change(function(e) {
        postData.maxInPage = e.currentTarget.value;
        $.ajax({
            url: "product/index.php",
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
            url: "product/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    });

    function reloadProductAdmin() {
        $.ajax({
            url: "product/index.php",
            method: "POST",
            data: postData,
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    }

    function getProductsFromCheckboxs() {
        let productNames = [];
        $(".admin-checkbox:not(.all)").each(function() {
            if ($(this)[0].checked) {
                productNames.push(this.dataset.name);
            }
        });
        return productNames;
    }

    var productColumnSortBy = <?php echo is_null($sortBy) ? 'null' : "'$sortBy'";?>;
    var productColumnSortDir = <?php echo is_null($sortDir) ? 'null' : "'$sortDir'";?>;
    $('.sort-column').click(function(e) {
        let column = e.currentTarget.dataset.column;

        if (column != productColumnSortBy) {
            productColumnSortDir = null;
            $arrow = $('#admin-arrow-' + productColumnSortBy);
            $arrow.remove();
            $(this).append('<div id="admin-arrow-' + column + '" class="admin-arrow arrow down"> </div>');
        }else {
            $('#admin-arrow-' + productColumnSortBy).toggleClass('down', productColumnSortDir != 'ASC');
            $('#admin-arrow-' + productColumnSortBy).toggleClass('up', productColumnSortDir == 'ASC');
        }
        productColumnSortBy = column;
        productColumnSortDir = productColumnSortDir == null ? 'ASC' : (productColumnSortDir == 'ASC' ? 'DESC' : 'ASC');

        postData.sortBy = productColumnSortBy;
        postData.sortDir = productColumnSortDir;
		$.ajax({
            url: "product/table_scroll.php",
            method: "POST",
            data: postData,
            success: function(result){
                $(".admin-table-scroll").html(result);
            }
        });
    });

    $("#admin-header-search").click(function(e) {
        $.ajax({
            url: "product/search_product_form.php",
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

    $("#admin-header-add").click(function(e) {
        $.ajax({
            url: "product/add_product_form.php",
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

    $("#admin-header-edit").click(function(e) {
        let products = getProductsFromCheckboxs();

        if (products.length != 1) {
            alert("You must choose one row!");
            return;
        }

        let name = products[0];

        $.ajax({
            url: "product/edit_product_form.php",
            method: "POST",
            data: {"name": name},
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

    $("#admin-header-remove").click(function (e) {
        let products = getProductsFromCheckboxs();

        if (products.length == 0) {
            alert("You must choose at least one row!");
            return;
        }

        if (!window.confirm("Are you sure to remove?")) {
            return;
        }

        showLoading();
        $.ajax({
            url: "product/remove_product.php", 
            method: "POST",
            data: {"product_array": products},
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else if (result == 0) {
                    callNotice("Remove Product Successfully!");
                    updateSideBar();
                    reloadProductAdmin();
                }else if (result == 1) {
                    callNotice("Some product can remove, some cannot!");
                    updateSideBar();
                    reloadProductAdmin();
                } else if (result == 2) {
                    callNotice("Delete all code of this product first!");
                } else if (result == 3) {
                    callNotice("Wrong params!");
                }
                closeLoading();
            }
        });
    });
</script>