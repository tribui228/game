<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/order_item/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.order.item.view')) {
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
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Order Info By Id <?=$_POST['id']?> </div>

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
            <?php include(LOCAL_PATH_ROOT.'/game/admin/order_item/table_header.php');?>
        </div>

        <div class="admin-table-scroll">
            <?php include(LOCAL_PATH_ROOT.'/game/admin/order_item/table_scroll.php');?>
        </div>
    </div>
</div>

<script>
    function reloadOrderItemAdmin() {
        $.ajax({
            url: "order_item/index.php",
            method: "POST",
            data: {
                "id": '<?=$_POST['id']?>'
            },
            success: function(result){
                $("#admin-content").html(result);
            }
        });
    }

    function getOrdersFromCheckboxs() {
        let orderItemIds = [];
        $(".admin-checkbox:not(.all)").each(function() {
            if ($(this)[0].checked) {
                orderItemIds.push(this.dataset.id);
            }
        });
        return orderItemIds;
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

        $.ajax({
            url: "order_item/table_scroll.php",
            method: "POST",
            data: {
                "id": <?=$_POST['id']?>,
                "sortBy": orderColumnSortBy,
                "sortDir": orderColumnSortDir,
            },
            success: function(result){
                $(".admin-table-scroll").html(result);
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
            url: "order_item/remove_order_item.php", 
            method: "POST",
            data: {
                "order_id": '<?=$_POST['id']?>',
                "order_item_id_array": orders
            },
            success: function(result){
                console.log(result);
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                    reloadOrderItemAdmin();
                }else if (result == 0) {
                    callSuccessNotice("Remove Order Item Successfully!");
                    updateSideBar();
                    reloadOrderItemAdmin();
                }else if (result == 1) {
                    callNotice("This order item has already approved!");
                }else if (result == 2) {
                    callNotice("Wrong params!");
                }
                closeLoading();
            }
        });
    });

    $("#admin-header-return").click(function (e) {
        $.ajax({
            url: "order/index.php",
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