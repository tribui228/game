<?php 
include ($_SERVER['DOCUMENT_ROOT'].'/game/head.php');
include ($_SERVER['DOCUMENT_ROOT'].'/game/register/include.php');

session_start();
if (isset($_SESSION['username'])) {
    echo '<script> window.location.href = "/game/?login_status=1" </script>';
    exit();
}
?>

<style>
.register-screen {
    width: 100vw;
    height: 100vh;
    background-color: var(--sub-color);
    overflow: auto;
}

.register-box {
    width: 100%;
    padding: 10px 30px 10px 30px;
    background-color: var(--sub-color);
    border-radius: 10px;
    overflow: auto;
}

.register-header {
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: 600;
}

.register-logo-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-control.register {
    width: 100%;
}

.form-control.divide {
    width: 49%;
}

#register-remember {
    width: 12px;
    height: 12px;
}

#register-confirm {
    font-size: 1rem;
    font-weight: 600;
    background-color: var(--sub3-color);
    border: 1px solid var(--sub3-color);
    transition: 0.5s;
    cursor: unset;
}

#register-confirm.active {
    color: white;
    background-color: var(--primary);
    border: 1px solid var(--primary);
    cursor: pointer;
}

@media (min-width: 576px) {
    .register-screen {
        background-color: var(--main-color);
    }

    .register-box {
        height: unset;
        width: 395px;
    }
}
</style>

<div class="register-screen disable-select">
    <div class="register-box center">
        <div class="register-logo-layout">
            <a href="/game/">
                <img class="ml-auto mr-auto" src="/game/img/logo.png" width="75px" height="75px">
            </a>
        </div>

        <div id="register-warn-box">
        </div>
        <form id="register-form" onsubmit="return false;">
            <div class="register-header">
                SIGN UP
            </div>
            <div class="form-group">
                <input type="text" class="form-control register" id="register-username" placeholder="Username">
                <div id="register-username-feedback" class="invalid-feedback">
                </div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control register" id="register-password" placeholder="Password">
                <div id="register-password-feedback" class="invalid-feedback">
                </div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control register" id="register-confirm-password" placeholder="Confirm Password">
                <div id="register-confirm-password-feedback" class="invalid-feedback">
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" id="register-term" required>
                <label for="register-term"> I agree to terms & conditions. </label>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control register" id="register-confirm">
                    REGISTER
                </button>
            </div>
            <div class="form-group text-center font-weight-bold">
                Already have an account ? <a href="/game/login/"> Sign In </a>
            </div>
        </form>
    </div>
</div>

<script>
    $("#register-confirm").click(function (e) {
        if ($("#register-confirm").hasClass("active")) {
            let username = $("#register-username")[0].value;
            let password = $("#register-password")[0].value;

            $.ajax({
                url: "register.php", 
                method: "POST",
                data: { "username": username, 
                        "password": password
                },
                success: function(response){
                    if (response == 0) {
                        window.location.href = "/game/login/?status=1";
                    }else if (response == 1) {
                        let $registerUsername = $("#register-username");
                        let $feedback = $("#register-username-feedback");

                        $feedback.html("Username already exists!");
                        $registerUsername.toggleClass("is-invalid", true);
                    }
                }});
        }else {
            updateRegisterUsername();
            updateRegisterPassword();
            updateRegisterConfirmPassword();
        }
    });

    $("#register-username").focusout(function(e) {
        updateRegisterUsername();
    });

    $("#register-password").focusout(function(e) {
        updateRegisterPassword();

        if ($("#register-confirm-password")[0].value.length > 0) {
            updateRegisterConfirmPassword();
        }
    });

    $("#register-confirm-password").focusout(function(e) {
        updateRegisterConfirmPassword();
    });

    $("#register-username").on("keyup", function(e) {
        updateConfirmButton();
    });

    $("#register-password").on("keyup", function(e) {
        updateConfirmButton();
    });

    $("#register-confirm-password").on("keyup", function(e) {
        updateConfirmButton();
    });

    $("#register-term").change(function() {
        updateConfirmButton();
    });

    function updateRegisterUsername() {
        let $registerUsername = $("#register-username");
        let $feedback = $("#register-username-feedback");
        let username = $registerUsername[0].value;

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
        $registerUsername.toggleClass("is-invalid", !check);
        return check;
    }

    function updateRegisterPassword() {
        let $registerPassword = $("#register-password");
        let $feedback = $("#register-password-feedback");
        let password = $registerPassword[0].value;

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
        $registerPassword.toggleClass("is-invalid", !check);
        return check;
    }

    function updateRegisterConfirmPassword() {
        let $confirmRegisterPassword = $("#register-confirm-password");
        let $feedback = $("#register-confirm-password-feedback");
        let password = $("#register-password")[0].value;
        let confirmPassword = $confirmRegisterPassword[0].value;

        let check = checkPassword(password, confirmPassword);
        if (!check) {
            $feedback.html("Warning: Password not match.");
        }else {
            $feedback.html("");
        }
        $confirmRegisterPassword.toggleClass("is-invalid", !check);
        return check;
    }

    
    function checkRegisterRegex() {
        let termChecked = $("#register-term")[0].checked;
        let username = $("#register-username")[0].value;
        let password = $("#register-password")[0].value;
        let confirmPassword = $("#register-confirm-password")[0].value;

        return termChecked && checkUsernameRegex(username) && checkPasswordRegex(password) && checkPassword(password, confirmPassword);
    }

    function updateConfirmButton() {
        if (checkRegisterRegex()) {
            $("#register-confirm").toggleClass("active", true);
        }else {
            $("#register-confirm").toggleClass("active", false);
        }
    }
</script>