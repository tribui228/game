<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/by_product/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
$searchFrom2 = empty($searchFromDate) ? '*' : $searchFromDate;
$searchTo2 = empty($searchToDate) ? '*' : $searchToDate;
?>

<div id="modal-header"> Product Summary </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-product-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-6 form-group">
                    <span class="modal-text"> From Date: </span>
                    <span> <?=$searchFrom2?> </span>
                </div>
                <div class="col-6 form-group">
                    <span class="modal-text"> To Date: </span>
                    <span> <?=$searchTo2?> </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Actual Quantity Sold: </span>
                    <span> <?=$summaryActualQuantitySold?> </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Actual Revenue: </span>
                    <span> <?=$summaryActualRevenue?>$ </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Actual Discount: </span>
                    <span> <?=$summaryActualDiscount?>$ </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Actual Total Revenue: </span>
                    <span> <?=$summaryActualTotalRevenue?>$ </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Upcomming Quantity Sold: </span>
                    <span> <?=$summaryUpcommingQuantitySold?> </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Upcomming Revenue: </span>
                    <span> <?=$summaryUpcommingRevenue?>$ </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Upcomming Discount: </span>
                    <span> <?=$summaryUpcommingDiscount?>$ </span>
                </div>
                <div class="col-12 form-group">
                    <span class="modal-text"> Upcomming Total Revenue: </span>
                    <span> <?=$summaryUpcommingTotalRevenue?>$ </span>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer" class="mt-3"> 
    <button id="summary-close" type="submit" class="form-control cart-button float-right font-weight-bold ml-3" id="group-confirm" form="add-group-form">
        Close
    </button>
</div>

<script>
    $("#summary-close").click(function (e) {
        closeModal();
    });
</script>