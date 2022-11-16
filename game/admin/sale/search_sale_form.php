<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/sale/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

$searchFromBeginDate2 = !empty($searchFromBeginDate) ? str_replace(" ", "T", $searchFromBeginDate) : '';
$searchToBeginDate2 = !empty($searchToBeginDate) ? str_replace(" ", "T", $searchToBeginDate) : '';
$searchFromEndDate2 = !empty($searchFromEndDate) ? str_replace(" ", "T", $searchFromEndDate) : '';
$searchToEndDate2 = !empty($searchToEndDate) ? str_replace(" ", "T", $searchToEndDate) : '';
?>

<div id="modal-header"> Search Sale </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-sale-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="sale-name" value="<?=$searchName?>">
                    <div id="sale-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="sale-display" value="<?=$searchDisplay?>">
                    <div id="sale-display-feedback" class="invalid-feedback">
                    </div>
                </div>
                
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Min Discount (%) </div>
                    <input type="number" class="form-control" id="sale-min-discount" value="<?=$searchMinDiscount?>">
                    <div id="sale-min-discount-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Max Discount (%) </div>
                    <input type="number" class="form-control" id="sale-max-discount" value="<?=$searchMaxDiscount?>">
                    <div id="sale-max-discount-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Begin Date </div>
                    <input type="datetime-local" class="form-control" id="sale-from-begin-date" value="<?=$searchFromBeginDate2?>">
                    <div id="sale-from-begin-date-feedback" class="invalid-feedback">
					</div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Begin Date </div>
                    <input type="datetime-local" class="form-control" id="sale-to-begin-date" value="<?=$searchToBeginDate2?>">
                    <div id="sale-to-begin-date-feedback" class="invalid-feedback">
					</div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From End Date </div>
                    <input type="datetime-local" class="form-control" id="sale-from-end-date" value="<?=$searchFromEndDate2?>">
                    <div id="sale-from-end-date-feedback" class="invalid-feedback">
					</div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To End Date </div>
                    <input type="datetime-local" class="form-control" id="sale-to-end-date" value="<?=$searchToEndDate2?>">
                    <div id="sale-to-end-date-feedback" class="invalid-feedback">
					</div>
                </div>

            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="sale-confirm" form="search-sale-form">
            Search Sale
        </button>
    </div>
</div>

<script>
    $("#sale-confirm").click(function() {
        let check = true;
        check = updateToBeginDate() && check;
        check = updateToEndDate() && check;
        if (!check) {
            return;
        }

        var name = $("#sale-name")[0].value;
        var display = $("#sale-display")[0].value;
        var minDiscount = $("#sale-min-discount")[0].value;
        var maxDiscount = $("#sale-max-discount")[0].value;
        var fromBeginDate = $("#sale-from-begin-date")[0].value;
        var toBeginDate = $("#sale-to-begin-date")[0].value;
        var fromEndDate = $("#sale-from-end-date")[0].value;
        var toEndDate = $("#sale-to-end-date")[0].value;
        fromBeginDate = getDateFromInput(fromBeginDate);
        toBeginDate = getDateFromInput(toBeginDate);
        fromEndDate = getDateFromInput(fromEndDate);
        toEndDate = getDateFromInput(toEndDate);

        $.ajax({
            url: "sale/index.php", 
            method: "POST",
            data: {
                "searchName": name.replace(/'/g, ''), 
                "searchDisplay": display.replace(/'/g, ''),
                "searchMinDiscount": minDiscount,
                "searchMaxDiscount": maxDiscount,
                "searchFromBeginDate": fromBeginDate,
                "searchToBeginDate": toBeginDate,
                "searchFromEndDate": fromEndDate,
                "searchToEndDate": toEndDate
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });

    $("#sale-from-begin-date").focusout(function(e) {
        updateToBeginDate();
    });

    $("#sale-to-begin-date").focusout(function(e) {
        updateToBeginDate();
    });

    $("#sale-from-end-date").focusout(function(e) {
        updateToEndDate();
    });

    $("#sale-to-end-date").focusout(function(e) {
        updateToEndDate();
    });

    function updateToBeginDate() {
        let $check = $("#sale-to-begin-date");
        let $check2 = $("#sale-from-begin-date");
        let $feedback = $("#sale-to-begin-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Begin Date cannot be less than From Begin Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateToEndDate() {
        let $check = $("#sale-to-end-date");
        let $check2 = $("#sale-from-end-date");
        let $feedback = $("#sale-to-end-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To End Date cannot be less than From End Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>