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
$firstname = $user->getFirstname();
$lastname = $user->getLastname();
$birth = $user->getBirth();
$address = $user->getAddress();
$email = $user->getEmail();
$phone = $user->getPhone();
?>

<div id="modal-header"> Edit Information</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="add-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> First Name </div>
                    <input type="text" class="form-control" id="user-firstname" value="<?=$firstname?>">
                    <div id="user-firstname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Last Name </div>
                    <input type="text" class="form-control" id="user-lastname" value="<?=$lastname?>">
                    <div id="user-lastname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Email </div>
                    <input type="text" class="form-control" id="user-email" value="<?=$email?>">
                    <div id="user-email-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Phone </div>
                    <input type="text" class="form-control" id="user-phone" value="<?=$phone?>">
                    <div id="user-phone-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Birth </div>
                    <input type="date" class="form-control" id="user-birth" value="<?=$birth?>">
                    <div id="user-birth-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Address </div>
                    <input type="text" class="form-control" id="user-address"  value="<?=$address?>">
                    <div id="user-address-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 form-group mb-0">
                    <button type="submit" class="form-control btn-confirm" id="user-confirm">
                        Save Information
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
        if (updateUserFirstname() && updateUserLastname() && updateUserEmail() && updateUserPhone() && updateUserBirth() && updateUserAddress()) {
            var firstname = $("#user-firstname")[0].value;
            var lastname = $("#user-lastname")[0].value;
            var email = $("#user-email")[0].value;
            var phone = $("#user-phone")[0].value;
            var birth = $("#user-birth")[0].value;
            var address = $("#user-address")[0].value;

            $.ajax({
                url: "/game/header/login/edit_information.php",
                method: "POST",
                data: {
                    "username": "<?=$_POST['username']?>",
                    "firstname": firstname,
                    "lastname": lastname,
                    "email": email,
                    "phone": phone,
                    "birth": birth,
                    "address": address
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Information Successfully!");
                        closeModal();

                        <?php
                            if (isset($_POST['reload']) && $_POST['reload'] == 1) {
                                echo "location.reload();";
                            }
                        ?>
                    }else {
                        callNotice("Update Information Fail!");
                    }
                }
            });
        }
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
</script>