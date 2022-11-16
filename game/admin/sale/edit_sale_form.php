<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.edit')) {
    echo 'no_permission';
    exit();
}

if (!isset($_POST['name'])) {
    return;
}

$sale = SaleUtil::getSaleByName($_POST['name']);

if (is_null($sale)) {
    return;
}

$name = $sale->getName();
$display = $sale->getDisplay();
$discount = $sale->getDiscount() * 100;
$beginDate = empty($sale->getDateBegin()) ? "" : date('Y-m-d\TH:i:s', strtotime($sale->getDateBegin()));
$endDate = empty($sale->getDateEnd()) ? "" : date('Y-m-d\TH:i:s', strtotime($sale->getDateEnd()));
?>

<div id="modal-header"> Edit Sale</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="edit-sale-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="sale-name" value="<?=$name?>" readonly>
                    <div id="sale-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="sale-display" value="<?=$display?>">
                    <div id="sale-display-feedback" class="invalid-feedback">
                    </div>
                </div>
                
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Discount (%) </div>
                    <input type="number" class="form-control" id="sale-discount" value="<?=$discount?>">
                    <div id="sale-discount-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Begin Date </div>
                    <input type="datetime-local" class="form-control" id="sale-begin-date" value="<?=$beginDate?>">
                    <div id="sale-begin-date-feedback" class="invalid-feedback">
					</div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> End Date </div>
                    <input type="datetime-local" class="form-control" id="sale-end-date" value="<?=$endDate?>">
                    <div id="sale-end-date-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="sale-confirm" form="edit-sale-form">
            Save Sale
        </button>
    </div>
</div>

<script>
    $("#sale-confirm").click(function() {
        let check = true;
        check = updateName() && check;
        check = updateDisplay() && check;
        check = updateDiscount() && check;
        if (check) {
            var name = $("#sale-name")[0].value;
            var display = $("#sale-display")[0].value;
            var discount = $("#sale-discount")[0].value/100;
            var beginDate = $("#sale-begin-date")[0].value;
            if (beginDate.length != 0) {
                beginDate = beginDate.replace(/T/g, ' ');
            }
            var endDate = $("#sale-end-date")[0].value;
            if (endDate.length != 0) {
                endDate = endDate.replace(/T/g, ' ');
            }

            $.ajax({
                url: "sale/edit_sale.php", 
                method: "POST",
                data: {
                    "name": name, 
                    "display": display,
                    "discount": discount,
                    "date_begin": beginDate,
                    "date_end": endDate
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Sale Successfully!");

                        reloadSaleAdmin();
                        updateSideBar();
                        closeModal();
                    }else if (response == 1) {
                        let $name = $("#sale-display");
                        let $feedback = $("#sale-display-feedback");

                        $feedback.html("Already exist that sale display!");
                        $name.toggleClass("is-invalid", true);
                    }else {
                        let $name = $("#sale-name");
                        let $feedback = $("#sale-name-feedback");

                        $feedback.html("Already exist that sale name!");
                        $name.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#sale-name").focusout(function(e) {
        updateName();
    });

    $("#sale-display").focusout(function(e) {
        updateDisplay();
    });

    $("#sale-discount").focusout(function(e) {
        updateDiscount();
    });

    function updateName() {
        let $check = $("#sale-name");
        let $feedback = $("#sale-name-feedback");
        let value = $check[0].value;

        let check = checkSimpleTextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out name field.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDisplay() {
        let $check = $("#sale-display");
        let $feedback = $("#sale-display-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out display field.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDiscount() {
        let $check = $("#sale-discount");
        let $feedback = $("#sale-discount-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out discount field.");
        }else if (isNaN(value) || parseInt(value) < 0 || parseInt(value) > 100) {
            check = false;
            $feedback.html("Invalid Format: Accept only number between 0 to 100.");
        }else {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>