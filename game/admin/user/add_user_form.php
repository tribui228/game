<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.add')) {
    echo 'no_permission';
    exit();
}
?>

<div id="modal-header"> Create New User</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Username </div>
                    <input type="text" class="form-control" id="user-username">
                    <div id="user-username-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Group </div>
                    <select id="user-group" class="form-select">
                        <?php
                            $groups = GroupUtil::getGroups();
                            foreach ($groups as $group) : 
                                $name = $group->getName();
                                $display = $group->getDisplay();
                        ?>
                            <option value="<?=$name?>"> <?=$display?> </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="user-group-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Password </div>
                    <input type="password" class="form-control" id="user-password">
                    <div id="user-password-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Confirm Password </div>
                    <input type="password" class="form-control" id="user-confirm-password">
                    <div id="user-confirm-password-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> First Name </div>
                    <input type="text" class="form-control" id="user-firstname">
                    <div id="user-firstname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Last Name </div>
                    <input type="text" class="form-control" id="user-lastname">
                    <div id="user-lastname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Email </div>
                    <input type="text" class="form-control" id="user-email">
                    <div id="user-email-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Phone </div>
                    <input type="text" class="form-control" id="user-phone">
                    <div id="user-phone-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Birth </div>
                    <input type="date" class="form-control" id="user-birth">
                    <div id="user-birth-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Address </div>
                    <input type="text" class="form-control" id="user-address">
                    <div id="user-address-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="user-confirm" form="add-user-form">
            Create User
        </button>   
    </div>
</div>


<script>
    $("#user-confirm").click(function() {
        if (updateUserUsername() && updateUserPassword() && updateUserConfirmPassword() && updateUserFirstname() && updateUserLastname() && updateUserEmail() && updateUserPhone() && updateUserBirth() && updateUserAddress()) {
            var username = $("#user-username")[0].value;
            var group = $("#user-group")[0].value;
            var password = $("#user-password")[0].value;
            var firstname = $("#user-firstname")[0].value;
            var lastname = $("#user-lastname")[0].value;
            var email = $("#user-email")[0].value;
            var phone = $("#user-phone")[0].value;
            var birth = $("#user-birth")[0].value;
            var address = $("#user-address")[0].value;

            $.ajax({
                url: "user/add_user.php", 
                method: "POST",
                data: {
                    "username": username,
                    "group": group,
                    "password": password,
                    "firstname": firstname,
                    "lastname": lastname,
                    "email": email,
                    "phone": phone,
                    "birth": birth,
                    "address": address
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Create New User Successfully!");

                        $.ajax({
                            url: "user/index.php",
                            success: function(result){
                                $("#admin-content").html(result);
                            }
                        });

                        updateSideBar();
                        closeModal();
                    }else {
                        let $name = $("#user-username");
                        let $feedback = $("#user-username-feedback");

                        $feedback.html("Already exist that user name!");
                        $name.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#user-username").focusout(function(e) {
        updateUserUsername();
    });

    $("#user-password").focusout(function(e) {
        updateUserPassword();
    });

    $("#user-confirm-password").focusout(function(e) {
        updateUserConfirmPassword();
    });

    $("#user-firstname").focusout(function(e) {
        updateUserFirstname();
    });

    $("#user-lastname").focusout(function(e) {
        updateUserLastname();
    });

    $("#user-email").focusout(function(e) {
        updateUserEmail();
    });

    $("#user-phone").focusout(function(e) {
        updateUserPhone();
    });

    $("#user-birth").focusout(function(e) {
        updateUserBirth();
    });

    $("#user-address").focusout(function(e) {
        updateUserAddress();
    });

    function updateUserFirstname() {
        let $check = $("#user-firstname");
        let $feedback = $("#user-firstname-feedback");
        let value = $check[0].value;

        let check = checkFirstnameRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out firstname field.");
        }else if (value.length > 64) {
            $feedback.html("Invalid Field Length: First Name has maximum 64 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserLastname() {
        let $check = $("#user-lastname");
        let $feedback = $("#user-lastname-feedback");
        let value = $check[0].value;

        let check = checkLastnameRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out lastname field.");
        }else if (value.length > 64) {
            $feedback.html("Invalid Field Length: Last Name has maximum 64 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserEmail() {
        let $check = $("#user-email");
        let $feedback = $("#user-email-feedback");
        let value = $check[0].value;

        let check = checkEmailRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out email field.");
        }else if (value.length > 64) {
            $feedback.html("Invalid Field Length: Email has maximum 64 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Invalid email (Example: name@email.com).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserBirth() {
        let $check = $("#user-birth");
        let $feedback = $("#user-birth-feedback");
        let value = $check[0].value;

        let check = checkBirthRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out birth date.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Age: Your age must be 18+.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }


    function updateUserAddress() {
        let $check = $("#user-address");
        let $feedback = $("#user-address-feedback");
        let value = $check[0].value;

        let check = checkAddressRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out address field.");
        }else if (value.length > 128) {
            $feedback.html("Invalid Field Length: Address has maximum 128 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Invalid address.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserPhone() {
        let $check = $("#user-phone");
        let $feedback = $("#user-phone-feedback");
        let value = $check[0].value;

        let check = checkPhoneRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out phone field.");
        }else if (value.length < 10 || value.length > 13) {
            $feedback.html("Invalid Field Length: Phone has 10-13 numbers.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only number characters.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserUsername() {
        let $checkUsername = $("#user-username");
        let $feedback = $("#user-username-feedback");
        let username = $checkUsername[0].value;

        let check = checkUsernameRegex(username);
        if (username.length == 0) {
            $feedback.html("Warning: Please fill out username field.");
        }else if (username.length < 5) {
            $feedback.html("Invalid Field Length: Username has 5-16 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $checkUsername.toggleClass("is-invalid", !check);
        return check;
    }

    function updateUserPassword() {
        let $checkPassword = $("#user-password");
        let $feedback = $("#user-password-feedback");
        let password = $checkPassword[0].value;

        let check = checkPasswordRegex(password);
        if (password.length == 0) {
            $feedback.html("Warning: Please fill out password field.");
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

    function updateUserConfirmPassword() {
        let $confirmUserPassword = $("#user-confirm-password");
        let $feedback = $("#user-confirm-password-feedback");
        let password = $("#user-password")[0].value;
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