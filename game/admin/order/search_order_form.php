<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/order/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

$searchFromOrderedDate2 = !empty($searchFromOrderedDate) ? str_replace(" ", "T", $searchFromOrderedDate) : '';
$searchToOrderedDate2 = !empty($searchToOrderedDate) ? str_replace(" ", "T", $searchToOrderedDate) : '';
$searchFromCheckedDate2 = !empty($searchFromCheckedDate) ? str_replace(" ", "T", $searchFromCheckedDate) : '';
$searchToCheckedDate2 = !empty($searchToCheckedDate) ? str_replace(" ", "T", $searchToCheckedDate) : '';
?>

<div id="modal-header"> Search Order </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-order-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Customer </div>
                    <input type="text" class="form-control" id="order-username" value="<?=$searchUsername?>">
                    <div id="order-username-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Status </div>
                    <select id="order-status" class="form-select">
                        <option value="" <?=$searchStatus == '' ? 'selected="selected"' : ''?>> Both </option>
                        <option value="2" <?=$searchStatus == 0 ? 'selected="selected"' : ''?>> Not check </option>
                        <option value="1" <?=$searchStatus == 1 ? 'selected="selected"' : ''?>> Checked </option>
                    </select>
                    <div id="order-status-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Min Total Price </div>
                    <input type="text" class="form-control" id="order-min-total-price" step="0.01" value="<?=$searchMinTotalPrice?>">
                    <div id="order-min-total-price-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Max Total Price </div>
                    <input type="text" class="form-control" id="order-max-total-price" step="0.01" value="<?=$searchMaxTotalPrice?>">
                    <div id="order-max-total-price-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Min Quantity </div>
                    <input type="text" class="form-control" id="order-min-quantity" value="<?=$searchMinQuantity?>">
                    <div id="order-min-quantity-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Max Quantity </div>
                    <input type="text" class="form-control" id="order-max-quantity" value="<?=$searchMaxQuantity?>">
                    <div id="order-max-quantity-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Ordered Date </div>
                    <input type="datetime-local" class="form-control" id="order-from-ordered-date" value="<?=$searchFromOrderedDate2?>">
                    <div id="order-from-ordered-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Ordered Date </div>
                    <input type="datetime-local" class="form-control" id="order-to-ordered-date" value="<?=$searchToOrderedDate2?>">
                    <div id="order-to-ordered-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Checked Date </div>
                    <input type="datetime-local" class="form-control" id="order-from-checked-date" value="<?=$searchFromCheckedDate2?>">
                    <div id="order-from-checked-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Checked Date </div>
                    <input type="datetime-local" class="form-control" id="order-to-checked-date" value="<?=$searchToCheckedDate2?>">
                    <div id="order-to-checked-date-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="order-confirm" form="search-order-form">
            Search Order
        </button>
    </div>
</div>

<script>
    $("#order-confirm").click(function() {
        let check = true;
        check = updateToOrderedDate() && check;
        check = updateToCheckedDate() && check;
        if (!check) {
            return;
        }

        var username = $("#order-username")[0].value;
        var status = $("#order-status")[0].value;
        var minTotalPrice = $("#order-min-total-price")[0].value;
        var maxTotalPrice = $("#order-max-total-price")[0].value;
        var minQuantity = $("#order-min-quantity")[0].value;
        var maxQuantity = $("#order-max-quantity")[0].value;
        var fromOrderedDate = $("#order-from-ordered-date")[0].value;
        var toOrderedDate = $("#order-to-ordered-date")[0].value;
        var fromCheckedDate = $("#order-from-checked-date")[0].value;
        var toCheckedDate = $("#order-to-checked-date")[0].value;
        fromOrderedDate = getDateFromInput(fromOrderedDate);
        toOrderedDate = getDateFromInput(toOrderedDate);
        fromCheckedDate = getDateFromInput(fromCheckedDate);
        toCheckedDate = getDateFromInput(toCheckedDate);

        $.ajax({
            url: "order/index.php", 
            method: "POST",
            data: {
                "searchUsername": username.replace(/'/g, ''), 
                "searchStatus": status,
                "searchMinTotalPrice": minTotalPrice,
                "searchMaxTotalPrice": maxTotalPrice,
                "searchMinQuantity": minQuantity,
                "searchMaxQuantity": maxQuantity,
                "searchFromOrderedDate": fromOrderedDate,
                "searchToOrderedDate": toOrderedDate,
                "searchFromCheckedDate": fromCheckedDate,
                "searchToCheckedDate": toCheckedDate
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });

    $("#order-from-ordered-date").focusout(function(e) {
        updateToOrderedDate();
    });

    $("#order-to-ordered-date").focusout(function(e) {
        updateToOrderedDate();
    });

    $("#order-from-checked-date").focusout(function(e) {
        updateToCheckedDate();
    });

    $("#order-to-checked-date").focusout(function(e) {
        updateToCheckedDate();
    });

    function updateToOrderedDate() {
        let $check = $("#order-to-ordered-date");
        let $check2 = $("#order-from-ordered-date");
        let $feedback = $("#order-to-ordered-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Ordered Date cannot be less than From Ordered Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateToCheckedDate() {
        let $check = $("#order-to-checked-date");
        let $check2 = $("#order-from-checked-date");
        let $feedback = $("#order-to-checked-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Checked Date cannot be less than From Checked Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>