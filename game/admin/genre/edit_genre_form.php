<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.group.edit')) {
    echo 'no_permission';
    exit();
}

if (!isset($_POST['name'])) {
    return;
}

$genre = GenreUtil::getGenreByName($_POST['name']);

if (is_null($genre)) {
    return;
}
?>

<div id="modal-header"> Edit Genre</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="edit-genre-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="genre-name" value="<?=$genre->getName()?>" readonly>
                    <div id="genre-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="genre-display" value="<?=$genre->getDisplay()?>">
                    <div id="genre-display-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="genre-confirm" form="edit-genre-form">
            Save Genre
        </button>
    </div>
</div>

<script>
    $("#genre-confirm").click(function() {
        if (updateName() && updateDisplay()) {
            var name = $("#genre-name")[0].value;
            var display = $("#genre-display")[0].value;

            $.ajax({
                url: "genre/edit_genre.php", 
                method: "POST",
                data: {"name": name, "display": display},
                success: function(response){
                    if (response == 0) {
                        callNotice("Edit Genre Successfully!");

                        reloadGenreAdmin();
                        updateSideBar();
                        closeModal();
                    }else {
                        let $name = $("#genre-name");
                        let $feedback = $("#genre-name-feedback");

                        $feedback.html("Already exist that genre name!");
                        $name.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#genre-name").focusout(function(e) {
        updateName();
    });

    $("#genre-display").focusout(function(e) {
        updateDisplay();
    });

    function updateName() {
        let $check = $("#genre-name");
        let $feedback = $("#genre-name-feedback");
        let value = $check[0].value;

        let check = checkSimpleTextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out name field.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDisplay() {
        let $check = $("#genre-display");
        let $feedback = $("#genre-display-feedback");
        let value = $check[0].value;

        let check = checkUTF8TextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out display field.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>