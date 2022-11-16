<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Manager Login </title>
    <link rel="shortcut icon" type="image/png" href="/game/img/icon.png">
    <link rel="stylesheet" href="/game/css/style.css">
    <link rel="stylesheet" href="/game/node_modules/bootstrap/dist/css/bootstrap.css">
    <script src="/game/node_modules/jquery/dist/jquery.js"></script>
    <script src="/game/node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="/game/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/game/node_modules/xregexp/xregexp-all.js"></script>
    <script src="/game/js/api.js"></script>
</head>
<div id="notice"></div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/game/login/include.php');

session_start();

if (isset($_SESSION['username'])) {
    header('Location: https://'.HTTP_PATH_ROOT.'/game/admin/');
    exit();
}
?>

<style>
.login-screen {
    width: 100vw;
    height: 100vh;
    background-color: var(--sub-color);
}

.login-box {
    width: 100%;
    padding: 10px 30px 10px 30px;
    background-color: var(--sub-color);
    border-radius: 10px;
}

.login-header {
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: 600;
}

.login-logo-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-control.login {
    width: 100%;
}

#login-remember {
    width: 12px;
    height: 12px;
}

#login-confirm {
    font-size: 1rem;
    font-weight: 600;
    background-color: var(--sub3-color);
    border: 1px solid var(--sub3-color);
    transition: 0.5s;
    cursor: unset;
}

#login-confirm.active {
    color: white;
    background-color: var(--primary);
    border: 1px solid var(--primary);
    cursor: pointer;
}

@media (min-width: 576px) {
    .login-screen {
        background-color: var(--main-color);
    }

    .login-box {
        height: unset;
        width: 375px;
    }
}
</style>

<div class="login-screen position-relative disable-select">
    <div class="login-box center">
        <div class="login-logo-layout">
            <a href="https://<?=HTTP_PATH_ROOT?>/game/">
                <img class="ml-auto mr-auto" src="https://<?=HTTP_PATH_ROOT?>/game/img/logo.png" width="75px" height="75px">
            </a>
        </div>

        <div id="login-warn-box">
        </div>
        <form id="login-form" onsubmit="return false;">
            <div class="login-header">
                MANAGER LOGIN
            </div>
            <div class="form-group">
                <input type="text" class="form-control login" id="login-username" placeholder="Username">
                <div id="login-username-feedback" class="invalid-feedback">
                </div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control login" id="login-password" placeholder="Password">
                <div id="login-password-feedback" class="invalid-feedback">
                </div>
            </div>
            <div class="form-group">
                <div class="float-left">
                    <input type="checkbox" id="login-remember">
                    <label for="login-remember"> Remember me </label>
                </div>

                <div class="float-right">
                    <a> Forgot your password </a>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control login" id="login-confirm">
                    LOG IN NOW
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $("#login-confirm").click(function (e) {
        if ($("#login-confirm").hasClass("active")) {
            let username = $("#login-username")[0].value;
            let password = $("#login-password")[0].value;

            $.ajax({
                url: "check_login.php", 
                method: "POST",
                data: {"username": username, "password": password},
                success: function(response){
                    console.log(response);
                    if (response == 0) {
                        window.location.href = "https://<?=HTTP_PATH_ROOT?>/game/admin/";
                    }else {
                        let $loginUsername = $("#login-username");
                        let $feedback = $("#login-username-feedback");

                        $feedback.html("Your account does not have permission to access this site!");
                        $loginUsername.toggleClass("is-invalid", true);
                    }
                }
            });
        }else {
            updateLoginUsername();
            updateLoginPassword();
        }
    });

    $("#login-username").on("keyup", function(e) {
        updateConfirmButton();
    });

    $("#login-username").focusout(function(e) {
        updateLoginUsername();
    });

    function updateLoginUsername() {
        let $loginUsername = $("#login-username");
        let $feedback = $("#login-username-feedback");
        let username = $loginUsername[0].value;

        let check = checkLoginUsernameRegex(username);
        if (username.length == 0) {
            $feedback.html("Warning: Please fill out username field.");
        }else if (username.length < 5) {
            $feedback.html("Invalid Field Length: Username has 5-16 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $loginUsername.toggleClass("is-invalid", !check);
        return check;
    }

    function checkLoginUsernameRegex(username) {
        return /^[\w\d_]{5,16}$/g.test(username);
    }

    $("#login-password").on("keyup", function(e) {
        updateConfirmButton();
    });

    $("#login-password").focusout(function(e) {
        updateLoginPassword();
    });

    function updateLoginPassword() {
        let $loginPassword = $("#login-password");
        let $feedback = $("#login-password-feedback");
        let password = $loginPassword[0].value;

        let check = checkLoginPasswordRegex(password);
        if (password.length == 0) {
            $feedback.html("Warning: Please fill out password field.");
        }else if (password.length < 5) {
            $feedback.html("Invalid Field Length: Password has 5-24 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Password has no space character.");
        }
        $loginPassword.toggleClass("is-invalid", !check);
        return check;
    }

    function checkLoginPasswordRegex(password) {
        return /^[\S]{5,24}$/g.test(password);
    }
    
    function checkLoginRegex(username, password) {
        return checkLoginUsernameRegex(username) && checkLoginPasswordRegex(password);
    }

    function updateConfirmButton() {
        let $username = $("#login-username");
        let $password = $("#login-password");
        let username = $username[0].value;
        let password = $password[0].value;
        
        if (username.length > 0 && password.length > 0 && checkLoginRegex(username, password)) {
            $("#login-confirm").toggleClass("active", true);
        }else {
            $("#login-confirm").toggleClass("active", false);
        }
    }
</script>