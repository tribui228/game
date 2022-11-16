<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.add')) {
    echo 'no_permission';
    exit();
}
?>

<div id="modal-header"> Create New Group</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-group-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="group-name">
                    <div id="group-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="group-display">
                    <div id="group-display-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="group-confirm" form="add-group-form">
            Create Group
        </button>
    </div>
</div>

<script>
    $("#group-confirm").click(function() {
        if (updateGroupName() && updateGroupDisplay()) {
            var name = $("#group-name")[0].value;
            var display = $("#group-display")[0].value;

            showLoading();
            $.ajax({
                url: "group/add_group.php", 
                method: "POST",
                data: {
                    "name": name,
                    "display": display
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Create New Group Successfully!");

                        $.ajax({
                            url: "group/index.php",
                            success: function(result){
                                $("#admin-content").html(result);
                            }
                        });

                        updateSideBar();
                        closeModal();
                    }else {
                        let $name = $("#group-name");
                        let $feedback = $("#group-name-feedback");

                        $feedback.html("Already exist that group name!");
                        $name.toggleClass("is-invalid", true);
                    }
                    closeLoading();
                }
            });
        }
    });

    $("#group-name").focusout(function(e) {
        updateGroupName();
    });

    $("#group-display").focusout(function(e) {
        updateGroupDisplay();
    });

    function updateGroupName() {
        let $check = $("#group-name");
        let $feedback = $("#group-name-feedback");
        let value = $check[0].value;

        let check = checkNameRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out name field.");
        }else if (value.length < 5) {
            $feedback.html("Invalid Field Length: Name has 5-16 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateGroupDisplay() {
        let $check = $("#group-display");
        let $feedback = $("#group-display-feedback");
        let value = $check[0].value;

        let check = checkDisplayRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out display field.");
        }else if (value.length > 64) {
            $feedback.html("Invalid Field Length: Display has maximum 64 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>