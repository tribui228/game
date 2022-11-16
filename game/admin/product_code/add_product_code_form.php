<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.code.add')) {
    echo 'no_permission';
    exit();
}
?>

<div id="modal-header"> Add New Code </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-product-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Product Name </div>
                    <input type="text" class="form-control" id="product-name">
                    <div id="product-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Code </div>
                    <input type="text" class="form-control" id="product-code">
                    <div id="product-code-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Status </div>
                    <select id="product-status" class="form-select">
                        <option value="0" selected> Not Used </option>
                        <option value="1"> Used </option>
                    </select>
                    <div id="product-status-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 form-group mb-0">
                    <button type="submit" class="form-control admin-submit" id="product-confirm">
                        Add Code
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
</div>

<script>
    $("#product-confirm").click(function() {
        let check = true;
        name = updateProductName() && check;
        check = updateProductCode() && check;
        if (check) {
            var productName = $("#product-name")[0].value;
            var code = $("#product-code")[0].value;
            var status = $("#product-status")[0].value;

            $.ajax({
                url: "product_code/add_product_code.php", 
                method: "POST",
                data: {
                    "productName": productName,
                    "code": code,
                    "status": status
                },
                success: function(response){
                    console.log(response);
                    if (response == 0) {
                        callNotice("Add New Code Successfully!");

                        reloadProductCodeAdmin();

                        closeModal();
                    }else if (response == 1) {
                        let $name = $("#product-name");
                        let $feedback = $("#product-name-feedback");

                        $feedback.html("Not exist that product name!");
                        $name.toggleClass("is-invalid", true);
                    }else if (response == 2) {
                        let $name = $("#product-code");
                        let $feedback = $("#product-code-feedback");

                        $feedback.html("Already exist that code!");
                        $name.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#product-name").focusout(function(e) {
        updateProductName();
    });

    $("#product-code").focusout(function(e) {
        updateProductCode();
    });
    
    function updateProductName() {
        let $check = $("#product-name");
        let $feedback = $("#product-name-feedback");
        let value = $check[0].value;

        let check = checkSimpleTextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out product name field.");
        }else if (value.length > 255) {
            check = false;
            $feedback.html("Invalid Field Length: Product Name has maximum 255 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _ .).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateProductCode() {
        let $check = $("#product-code");
        let $feedback = $("#product-code-feedback");
        let value = $check[0].value;

        let check = checkProductCodeRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out code field.");
        }else if (value.length != 10) {
            $feedback.html("Invalid Field Length: Code has 10 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _ .).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>