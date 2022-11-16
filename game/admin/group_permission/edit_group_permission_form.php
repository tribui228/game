<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.permission.edit')) {
    echo 'no_permission';
    exit();
}

if (!isset($_POST['id'])) {
    return;
}

$groupPermission = GroupUtil::getGroupPermissionById($_POST['id']);

if (is_null($groupPermission)) {
    return;
}

$id = $groupPermission->getId();
$group = $groupPermission->getGroup();
$permission = $groupPermission->getPermission();
$value = $groupPermission->getValue();
?>

<div id="modal-header"> Edit Permission </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="edit-group-permission-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Permission </div>
                    <input type="text" class="form-control" id="group-permission" value="<?=$permission?>" readonly>
                    <div id="group-permission-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Value </div>
                    <select id="group-value" class="form-select">
                        <option value="1" <?=$value == 1 ? 'selected="selected"' : ''?>> true </option>
                        <option value="0" <?=$value == 0 ? 'selected="selected"' : ''?>> false </option>
                    </select>
                    <div id="group-value-feedback" class="invalid-feedback"> </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="group-confirm" form="edit-group-permission-form">
            Save Permission
        </button>
    </div>
</div>


<script>
    $("#group-confirm").click(function() {
        if (updateGroupPermission()) {
            var permission = $("#group-permission")[0].value;
            var value = $("#group-value")[0].value;

            $.ajax({
                url: "group_permission/edit_group_permission.php", 
                method: "POST",
                data: {
                    "id": "<?=$id?>",
                    "group": "<?=$group?>",
                    "permission": permission,
                    "value": value
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Permission Successfully!");

                        $.ajax({
                            url: "group_permission/index.php", 
                            method: "POST",
                            data: {
                                "group": "<?=$group?>"
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

    $("#group-permission").focusout(function(e) {
        updateGroupPermission();
    });

    
    function updateGroupPermission() {
        let $check = $("#group-permission");
        let $feedback = $("#group-permission-feedback");
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