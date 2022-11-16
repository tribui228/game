<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/top_product/params.php');

// if (!UserUtil::hasPermission($_SESSION['username'], 'admin.statistic.top.view')) {
//     echo 'no_permission';
//     exit();
// }
?>

<style>
.statistic-wrapper {
    display: flex;
    flex-flow: column;
    width: 100%;
    overflow-x: hidden;
    overflow-y: auto;
}

.statistic-content {
    flex: 1;
}
</style>

<div class="admin-header">
    <div class="admin-header-title mr-auto"> Statistic </div>
    <div id="admin-header-search" class="manager-button">
        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 225.000000 225.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                <path d="M631 2234 c-35 -7 -110 -36 -165 -63 -178 -87 -299 -208 -387 -386 -63 -129 -79 -204 -79 -380 0 -176 16 -251 79 -380 84 -171 202 -291 371 -378 134 -70 228 -91 395 -91 168 0 260 21 398 92 l89 45 347 -347 347 -346 73 0 c72 0 74 1 112 39 38 38 39 40 39 112 l0 73 -346 347 -347 347 45 89 c71 138 92 230 92 398 0 116 -4 154 -23 225 -47 168 -149 328 -279 436 -82 68 -244 149 -337 169 -90 19 -336 19 -424 -1z m334 -299 c104 -27 184 -72 261 -149 220 -220 220 -542 0 -762 -220 -220 -542 -220 -762 0 -218 219 -218 543 0 762 138 137 327 193 501 149z"/>
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
    <div class="statistic-wrapper">
        <div class="statistic-content">
            <canvas id="myChart" width="600" height="250"> </canvas>
        </div>
    </div>
</div>

<script>
    var chart = null;
    function loadChart() {
        if (chart) {
            chart.destroy();
        }

        let labels = [];
        <?php foreach ($topProducts as $row) :
            $productDisplay = $row['display'];
        ?>
        labels.push("<?=$productDisplay?>");
        <?php endforeach; ?>

        let data = {};
        data.labels = labels;

        let datasets = [];
        let dataset = {};
        let label = 'From <?=$searchFromDate?> To <?=$searchToDate?>';
        let data2 = [];
        let backgroundColor = [];
        let borderColor = [];
        let borderWidth = 1;

        let rgb;
        <?php 
            for ($i = 0; $i < count($topProducts); $i++) :
                $row = $topProducts[$i];
                $totalPrice = $row['total_price'];
        ?>
            data2.push(parseInt(<?=$totalPrice?>));
            rgb = hexToRgb(colorArray[<?=$i?>]);
            backgroundColor.push('rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ', 0.5)');
            borderColor.push(colorArray[<?=$i?>]);
        <?php
            endfor; 
        ?>
        
        dataset.label = label;
        dataset.data = data2;
        dataset.backgroundColor = backgroundColor;
        dataset.borderColor = borderColor;
        dataset.borderWidth = borderWidth;
        datasets.push(dataset);
        data.datasets = datasets;

        const config = {
            type: 'bar',
            data: data,
            responsive: true,
            options: {
                indexAxis: 'y',
                plugins: {
                    title: {
                        display: true,
                        text: '<?=$title?>',
                        color: 'white',
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 15
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        position: 'top',
                        ticks: {
                            color: 'white'
                        },
                        title: {
                            display: true,
                            text: '<?=$xTitle?>',
                            align: 'start',
                            color: 'white'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white',
                            callback: function(value, index, values) {
                                return getShortName(this.getLabelForValue(value));
                            }
                        },
                        title: {
                            display: true,
                            text: 'Game',
                            align: 'end',
                            color: 'white'
                        }
                    }
                }
            }
        };
        
        let id = document.getElementById('myChart');
        id.setAttribute("height", Math.max(250 ,250 * <?=count($topProducts)?>/10));
        chart = new Chart(id, config);
    }

    loadChart();

    var postData = {
        "searchFromDate": '<?=$searchFromDate?>',
        "searchToDate": '<?=$searchToDate?>',
        "searchGenres": <?=json_encode($searchGenres)?>,
        "type": '<?=$type?>'
    };


    $("#admin-header-search").click(function(e) {
        $.ajax({
            url: "statistic/top_product/search_product_form.php",
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