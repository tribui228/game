<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!isset($_POST['username'])) {
    return;
}

$user = UserUtil::getUserByUsername($_POST['username']);

if (is_null($user)) {
    return;
}

$username = $user->getUsername();
?>

<div id="modal-header"> Change Password </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Current Password </div>
                    <input type="password" class="form-control" id="user-current-password">
                    <div id="user-current-password-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="modal-text"> New Password </div>
                    <input type="password" class="form-control" id="user-new-password">
                    <div id="user-new-password-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="modal-text"> Confirm New Password </div>
                    <input type="password" class="form-control" id="user-confirm-new-password">
                    <div id="user-confirm-new-password-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 form-group mb-0">
                    <button type="submit" class="form-control btn-confirm" id="user-confirm">
                        Save New Password
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
</div>

<script>
    $("#user-confirm").click(function() {
        let check = true;
        check = updateUserCurrentPassword() && check;
        check = updateUserNewPassword() && check;
        check = updateUserConfirmNewPassword() && check;

        if (check) {
            var currentPassword = $("#user-current-password")[0].value;
            var newPassword = $("#user-new-password")[0].value;

            $.ajax({
                url: "/game/header/login/edit_password.php",
                method: "POST",
                data: {
                    "username": "<?=$_POST['username']?>",
                    "current_password": currentPassword,
                    "new_password": newPassword
                },
                success: function(result){
                    if (result == 0) {
                        callNotice("Save New Password Successfully!");
                        closeModal();
                    }else {
                        let $check = $("#user-current-password");
                        let $feedback = $("#user-current-password-feedback");

                        $feedback.html("Wrong password!");
                        $check.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#user-current-password").focusout(function(e) {
        updateUserCurrentPassword();
    });

    $("#user-new-password").focusout(function(e) {
        updateUserNewPassword();
    });

    $("#user-confirm-new-password").focusout(function(e) {
        updateUserConfirmNewPassword();
    });

    function updateUserCurrentPassword() {
        let $checkPassword = $("#user-current-password");
        let $feedback = $("#user-current-password-feedback");
        let password = $checkPassword[0].value;

        let check = checkPasswordRegex(password);
        if (password.length == 0) {
            $feedback.html("Warning: Please fill out current password field.");
        }else if (password.length < 5) {
            $feedback.html("Invalid Field Length: Password has 5-24 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Password has no space character.");
        }
        $checkPassword.toggleClass("is-invalid", !check);
        return check;
    }


    function updateUserNewPassword() {
        let $checkPassword = $("#user-new-password");
        let $checkCurrentPassword = $("#user-current-password");
        let $feedback = $("#user-new-password-feedback");
        let password = $checkPassword[0].value;
        let currentPassword = $checkCurrentPassword[0].value;

        let check = checkPasswordRegex(password);
        if (password.length == 0) {
            $feedback.html("Warning: Please fill out new password field.");
        }else if (checkPassword(password, currentPassword)) {
            check = false;
            $feedback.html("Warning: New Password must not match Current Password.");
        }else if (password.length < 5) {
            $feedback.html("Invalid Field Length: Password has 5-24 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Password has no space character.");
        }
        $checkPassword.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserConfirmNewPassword() {
        let $confirmUserPassword = $("#user-confirm-new-password");
        let $feedback = $("#user-confirm-new-password-feedback");
        let password = $("#user-new-password")[0].value;
        let confirmPassword = $confirmUserPassword[0].value;

        let check = checkPassword(password, confirmPassword);
        if (!check) {
            $feedback.html("Warning: Password not match.");
        }else {
            $feedback.html("");
        }
        $confirmUserPassword.toggleClass("is-invalid", !check);
        return check;
    }

</script>