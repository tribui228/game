<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/product_code/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

?>

<div id="modal-header"> Search Product Code </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-product-code-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Product Name </div>
                    <input type="text" class="form-control" id="product-code-name" value="<?=$searchProductName?>">
                    <div id="product-code-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Code </div>
                    <input type="text" class="form-control" id="product-code-code" value="<?=$searchCode?>">
                    <div id="product-code-code-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Status </div>
                    <select id="product-code-status" class="form-select">
                        <option value="" <?=empty($searchStatus) || $searchStatus == "" ? 'selected="selected"' : ''?>> Both </option>
                        <option value="0" <?=!empty($searchStatus) && $searchStatus == 0 ? 'selected="selected"' : ''?>> Not Used </option>
                        <option value="1" <?=$searchStatus == 1 ? 'selected="selected"' : ''?>> Used </option>
                    </select>
                    <div id="product-code-status-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Added Date </div>
                    <input type="date" class="form-control" id="product-code-from-added-date" value="<?=$searchFromAddedDate?>">
                    <div id="product-code-from-added-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Added Date </div>
                    <input type="date" class="form-control" id="product-code-to-added-date" value="<?=$searchToAddedDate?>">
                    <div id="product-code-to-added-date-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="product-code-confirm" form="search-product-code-form">
            Search Product code
        </button>
    </div>
</div>

<script>
    $("#product-code-confirm").click(function() {
        let check = true;
        check = updateToAddedDate() && check;
        if (!check) {
            return;
        }

        var productName = $("#product-code-name")[0].value;
        var code = $("#product-code-code")[0].value;
        var status = $("#product-code-status")[0].value;
        var fromAddedDate = $("#product-code-from-added-date")[0].value;
        var toAddedDate = $("#product-code-to-added-date")[0].value;

        $.ajax({
            url: "product_code/index.php", 
            method: "POST",
            data: {
                "searchProductName": productName.replace(/'/g, ''),
                "searchCode": code.replace(/'/g, ''), 
                "searchStatus": status.replace(/'/g, ''),
                "searchFromAddedDate": fromAddedDate,
                "searchToAddedDate": toAddedDate,
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });

    $("#product-code-from-added-date").focusout(function(e) {
        updateToAddedDate();
    });

    $("#product-code-to-added-date").focusout(function(e) {
        updateToAddedDate();
    });

    function updateToAddedDate() {
        let $check = $("#product-code-to-added-date");
        let $check2 = $("#product-code-from-added-date");
        let $feedback = $("#product-code-to-added-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Added Date cannot be less than From Added Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>