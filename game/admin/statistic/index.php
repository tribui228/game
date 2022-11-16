<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.statistic.view')) {
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
    flex: 1 0 200px;
}

.admin-column:nth-child(6) {
    flex: 1 0 200px;
}

.statistic-box {
    display: flex;
    flex-flow: column;
    width: 40vw;
    height: 40vw;
    max-width: 165px;
    max-height: 165px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    background-color: var(--sub-color);
    cursor: pointer;
}

.statistic-box:hover {
    background-color: #1e314a;
}

.statistic-box:active {
    background-color: var(--sub-color);
}

.statistic-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
}

.statistic-text {
    display: flex;
    justify-content: center;
    align-items: start;
    flex: 1;
    font-weight: 600;
    font-size: 1.0rem;
    text-align: center;
    padding: 0rem 1rem;
    text-overflow: ellipsis;
    overflow: hidden;
}

@media (min-width: 576px) {
    .statistic-text {
        font-size: 1.2rem;
    }
}
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Statistic </div>
</div>
<div class="admin-body"> 
    <div class="container d-flex align-items-center justify-content-center"> 
        <div class="row">
            <div class="col-12 d-flex justify-content-center p-3">
                <div id="statistic-by-top" class="statistic-box">
                    <div class="statistic-icon">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"  width="50px" height="50px" viewBox="0 0 512.000000 511.000000"  preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none"> <path d="M1815 4838 c-26 -31 -27 -37 -22 -107 4 -54 14 -90 36 -136 52 -105 170 -231 282 -300 26 -16 35 -32 49 -80 26 -98 60 -155 137 -234 67 -67 72 -76 58 -91 -23 -26 -18 -49 19 -91 35 -38 52 -83 58 -153 3 -38 1 -40 -56 -75 -93 -57 -116 -122 -64 -178 21 -23 26 -23 260 -23 272 0 292 4 304 65 8 46 -18 91 -79 132 -25 17 -52 33 -59 35 -10 4 -9 22 4 89 14 68 23 88 44 103 35 26 46 57 31 95 -11 29 -9 33 49 93 77 81 103 125 130 218 21 74 22 75 79 109 110 64 239 216 277 326 25 72 24 189 -1 214 -23 23 -31 22 -226 -20 l-130 -28 -30 30 -31 29 -354 0 -354 0 -31 -29 -30 -29 -150 34 c-82 18 -155 34 -162 34 -6 0 -23 -15 -38 -32z m243 -102 l82 -28 1 -111 c3 -222 3 -226 -42 -200 -48 28 -128 118 -151 170 -29 66 -36 164 -13 187 10 9 23 15 29 13 6 -2 48 -16 94 -31z m1180 -65 c-3 -46 -12 -90 -23 -111 -36 -69 -173 -195 -192 -176 -4 3 -7 77 -7 163 l-1 158 94 32 c127 43 135 39 129 -66z m-448 -106 l0 -105 -210 0 -210 0 0 98 c0 54 3 102 7 105 3 4 98 7 210 7 l203 0 0 -105z"/> <path d="M2440 4590 c-12 -7 -12 -13 -4 -27 10 -16 28 -18 145 -18 l134 0 3 28 3 27 -133 0 c-73 0 -140 -5 -148 -10z"/> <path d="M1670 3267 c-14 -7 -34 -30 -45 -52 -19 -38 -20 -66 -23 -532 l-4 -493 -668 -2 c-652 -3 -668 -3 -690 -23 -58 -52 -55 -6 -53 -898 2 -640 5 -824 15 -845 27 -56 65 -69 220 -77 79 -3 1104 -5 2278 -3 1960 3 2137 4 2165 19 17 10 39 27 50 39 19 21 20 39 23 594 2 314 0 594 -3 622 -8 71 -38 101 -107 108 -106 11 -363 16 -795 16 l-443 0 0 733 0 733 -38 37 -38 37 -909 0 c-705 0 -916 -3 -935 -13z m987 -214 c20 -26 25 -129 21 -451 -3 -297 -4 -312 -24 -339 -28 -38 -63 -41 -102 -8 l-32 27 -2 274 -3 275 -44 -32 c-101 -72 -172 -85 -192 -32 -14 37 8 64 91 113 85 50 127 85 165 141 42 59 90 72 122 32z m-1577 -1355 c90 -38 139 -112 140 -206 0 -105 -38 -162 -215 -316 -74 -65 -135 -123 -135 -130 0 -10 42 -15 163 -19 158 -7 163 -8 185 -32 27 -32 28 -49 3 -74 -25 -25 -141 -35 -344 -29 -157 4 -187 11 -208 49 -27 52 24 132 171 264 197 177 230 218 230 281 0 36 -36 91 -70 109 -71 37 -149 4 -190 -81 -35 -72 -47 -84 -86 -84 -111 0 -59 196 69 262 81 41 201 44 287 6z m3365 -297 c78 -36 115 -95 115 -182 0 -55 -8 -75 -53 -131 l-30 -37 51 -46 c61 -55 76 -95 70 -179 -6 -70 -22 -107 -69 -154 -55 -56 -103 -75 -200 -80 -108 -5 -148 7 -212 67 -87 81 -111 161 -61 200 49 39 65 30 127 -75 40 -67 67 -84 130 -84 104 0 166 102 123 205 -21 49 -54 66 -147 74 -63 5 -84 11 -95 26 -19 26 -18 32 10 60 15 15 41 26 72 30 93 14 134 51 134 120 -1 62 -47 105 -113 105 -32 0 -46 -7 -76 -38 -20 -20 -44 -52 -53 -70 -14 -27 -23 -32 -52 -32 -79 0 -84 92 -9 166 57 57 104 74 208 74 67 0 100 -5 130 -19z"/> </g> </svg> 
                    </div>

                    <div class="statistic-text">
                        Top Game By Revenue
                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center p-3">
                <div id="statistic-by-genre" class="statistic-box">
                    <div class="statistic-icon">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" viewBox="0 0 860.000000 873.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,873.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none"> <path d="M6930 8324 c-14 -2 -52 -9 -85 -15 -98 -18 -206 -65 -320 -141 -253 -166 -492 -472 -717 -913 l-73 -145 -733 0 c-716 0 -734 0 -795 -21 -65 -22 -145 -67 -213 -118 -21 -17 -861 -853 -1866 -1858 l-1827 -1828 217 -220 c559 -567 894 -907 1462 -1485 924 -940 944 -960 950 -960 11 1 341 328 1969 1954 1076 1074 1695 1699 1733 1749 72 98 124 205 138 288 7 44 10 439 8 1279 l-3 1215 -152 3 -152 3 -15 -30 c-21 -40 -138 -310 -177 -407 -50 -127 -118 -332 -144 -434 -40 -156 -40 -178 -11 -267 42 -129 56 -203 56 -308 0 -346 -211 -638 -544 -751 -503 -171 -1038 215 -1039 751 0 187 67 354 200 495 95 101 171 156 304 219 97 46 279 107 298 99 4 -2 -19 -91 -52 -199 l-59 -197 -37 -11 c-103 -30 -228 -168 -272 -298 -58 -174 44 -385 230 -476 62 -30 72 -32 176 -32 104 0 114 2 176 32 80 39 159 120 197 200 25 53 27 68 26 168 -2 78 -9 142 -27 220 l-26 110 38 110 c21 61 111 294 200 519 170 434 242 582 381 795 183 279 342 429 528 499 59 22 83 25 207 26 166 1 226 -12 363 -80 174 -85 308 -253 383 -477 45 -135 62 -237 62 -377 1 -135 -14 -203 -70 -320 -40 -82 -58 -107 -142 -190 -107 -106 -221 -180 -358 -232 l-83 -31 0 -224 c0 -156 3 -223 11 -223 6 0 51 13 100 30 407 136 790 523 903 912 86 298 45 688 -104 986 -162 324 -437 520 -825 587 -89 15 -346 28 -395 19z"/> <path d="M7408 5623 l-167 -96 -3 -526 -3 -526 -28 -80 c-39 -109 -96 -215 -164 -306 -33 -44 -686 -707 -1528 -1553 -808 -812 -1470 -1481 -1470 -1485 0 -13 436 -461 449 -461 7 0 86 75 176 168 90 92 484 489 874 882 391 393 972 978 1292 1300 320 322 595 606 612 631 49 73 99 178 116 246 14 54 16 166 14 982 l-3 920 -167 -96z"/> </g> </svg>
                    </div>

                    <div class="statistic-text">
                        Statistic By Genres
                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center p-3">
                <div id="statistic-by-product" class="statistic-box">
                    <div class="statistic-icon">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" viewBox="0 0 360.000000 360.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,360.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none"> <path d="M1174 2860 c-298 -60 -549 -252 -683 -524 -62 -126 -81 -207 -126 -526 -20 -140 -45 -314 -55 -387 -33 -216 -25 -305 36 -430 38 -75 142 -180 216 -216 176 -85 369 -73 521 32 87 60 134 126 246 346 l106 210 365 0 365 0 109 -215 c98 -194 115 -221 175 -281 201 -200 510 -200 711 1 99 99 150 217 150 351 0 79 -103 808 -131 932 -68 290 -313 561 -604 666 -159 57 -206 61 -785 60 -466 -1 -535 -3 -616 -19z m1350 -329 c58 -33 82 -120 51 -184 -35 -71 -132 -99 -200 -57 -76 47 -92 151 -32 216 49 54 114 63 181 25z m-1264 -191 l0 -110 110 0 111 0 -3 -102 -3 -103 -107 -3 -108 -3 0 -109 0 -110 -110 0 -110 0 0 110 0 110 -105 0 -105 0 0 105 0 105 105 0 105 0 0 103 c0 57 3 107 7 110 3 4 53 7 110 7 l103 0 0 -110z m978 -96 c43 -28 64 -74 59 -133 -3 -47 -9 -59 -40 -87 -63 -58 -132 -57 -195 1 -35 32 -37 36 -37 98 0 56 4 69 25 92 50 55 130 67 188 29z m582 -4 c117 -83 45 -271 -97 -257 -58 6 -91 30 -115 84 -24 55 -18 99 19 144 52 61 132 73 193 29z m-310 -278 c48 -24 80 -75 80 -127 0 -82 -75 -151 -154 -141 -74 9 -128 68 -128 139 0 112 105 178 202 129z"/></g></svg>
                    </div>

                    <div class="statistic-text">
                        Statistic By Games
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#statistic-by-top").click(function(e) {
        $.ajax({
            url: "statistic/top_product/index.php",
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#admin-content").html(result);
                }
            }
        }); 
    });

    $("#statistic-by-product").click(function(e) {
        $.ajax({
            url: "statistic/by_product/index.php",
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#admin-content").html(result);
                }
            }
        }); 
    });

    $("#statistic-by-genre").click(function(e) {
        $.ajax({
            url: "statistic/by_genre/index.php",
            success: function(result){
                if (result == 'no_permission') {
                    window.alert("You do not have permission to use this!");
                }else {
                    $("#admin-content").html(result);
                }
            }
        }); 
    });
</script>