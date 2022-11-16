<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.product.code.edit')) {
    echo 'no_permission';
    exit();
}

if (!isset($_POST['id'])) {
    return;
}

$productCode = ProductUtil::getProductCodeById($_POST['id']);

if (is_null($productCode)) {
    return;
}

$id = $productCode->getId();
$name = $productCode->getProductName();
$code = $productCode->getCode();
$status = $productCode->getStatus();
$dateAdded = $productCode->getDateAdded();
?>

<div id="modal-header"> Edit Code </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Product Name </div>
                    <input type="text" class="form-control" id="product-name" value="<?=$name?>" readonly>
                    <div id="product-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Code </div>
                    <input type="text" class="form-control" id="product-code" value="<?=$code?>" readonly>
                    <div id="product-code-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Status </div>
                    <select id="product-status" class="form-select">
                        <option value="0" <?=$status == 0 ? 'selected="selected"' : ''?>> Not Used </option>
                        <option value="1" <?=$status == 1 ? 'selected="selected"' : ''?>> Used </option>
                    </select>
                    <div id="product-status-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 form-group">
                    <div class="modal-text"> Date Added </div>
                    <input type="text" class="form-control" id="product-date-added" value="<?=$dateAdded?>" readonly>
                    <div id="product-date-added-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 form-group mb-0">
                    <button type="submit" class="form-control admin-submit" id="product-confirm">
                        Save Code
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
        check = updateProductCode() && check;
        if (check) {
            var productName = $("#product-name")[0].value;
            var code = $("#product-code")[0].value;
            var status = $("#product-status")[0].value;
            var dateAdded = $("#product-date-added")[0].value;

            $.ajax({
                url: "product_code/edit_product_code.php", 
                method: "POST",
                data: {
                    "id": "<?=$id?>",
                    "productName": productName,
                    "code": code,
                    "status": status,
                    "dateAdded": dateAdded
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Code Successfully!");

                        reloadProductCodeAdmin();

                        closeModal();
                    }
                }
            });
        }
    });

    $("#product-code").focusout(function(e) {
        updateProductCode();
    });
    
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