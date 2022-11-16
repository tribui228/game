<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.permission.edit')) {
    echo 'no_permission';
    exit();
}

if (!isset($_POST['id'])) {
    return;
}

$userPermission = UserUtil::getUserPermissionById($_POST['id']);

if (is_null($userPermission)) {
    return;
}

$id = $userPermission->getId();
$username = $userPermission->getUsername();
$permission = $userPermission->getPermission();
$value = $userPermission->getValue();
?>

<div id="modal-header"> Edit Permission </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="edit-user-permission-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Permission </div>
                    <input type="text" class="form-control" id="user-permission" value="<?=$permission?>" readonly>
                    <div id="user-permission-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Value </div>
                    <select id="user-value" class="form-select">
                        <option value="1" <?=$value == 1 ? 'selected="selected"' : ''?>> true </option>
                        <option value="0" <?=$value == 0 ? 'selected="selected"' : ''?>> false </option>
                    </select>
                    <div id="user-value-feedback" class="invalid-feedback"> </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="user-confirm" form="edit-user-permission-form">
            Save Permission
        </button>
    </div>
</div>

<script>
    $("#user-confirm").click(function() {
        if (updateUserPermission()) {
            var permission = $("#user-permission")[0].value;
            var value = $("#user-value")[0].value;

            $.ajax({
                url: "user_permission/edit_user_permission.php", 
                method: "POST",
                data: {
                    "id": "<?=$id?>",
                    "username": "<?=$username?>",
                    "permission": permission,
                    "value": value
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Permission Successfully!");

                        $.ajax({
                            url: "user_permission/index.php", 
                            method: "POST",
                            data: {
                                "username": "<?=$username?>"
                            },
                            success: function(result){
                                closeModal();
                                $("#admin-content").html(result);
                            }
                        });

                        closeModal();
                    }
                }
            });
        }
    });

    $("#user-permission").focusout(function(e) {
        updateUserPermission();
    });

    
    function updateUserPermission() {
        let $check = $("#user-permission");
        let $feedback = $("#user-permission-feedback");
        let value = $check[0].value;

        let check = checkPermissionRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out permission field.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _ .).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

</script>