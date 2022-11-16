<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/by_genre/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
?>

<div id="modal-header"> Search Genre </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-genre-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="genre-name" value="<?=$searchName?>">
                    <div id="genre-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Date </div>
                    <input type="date" class="form-control" id="genre-from-date" value="<?=$searchFromDate?>">
                    <div id="genre-from-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Date </div>
                    <input type="date" class="form-control" id="genre-to-date" value="<?=$searchToDate?>">
                    <div id="genre-to-date-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="genre-confirm" form="search-genre-form">
            Search Genre
        </button>
    </div>
</div>

<script>
    function getGenreGenres() {
        let arr = [];

        $(".genre-genre-group").each(function () {
            if (this.checked) {
                arr.push(this.dataset.genre);
            }
        });

        return arr;
    }

    $("#genre-confirm").click(function() {
        let check = true;
        check = updateToDate() && check;
        if (!check) {
            return;
        }

        var name = $("#genre-name")[0].value;
        var fromDate = $("#genre-from-date")[0].value;
        var toDate = $("#genre-to-date")[0].value;
        var genres = getGenreGenres();

        $.ajax({
            url: "statistic/by_genre/index.php", 
            method: "POST",
            data: {
                "searchName": name,
                "searchFromDate": fromDate,
                "searchToDate": toDate,
                "searchGenres": genres
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });

    $("#genre-from-date").focusout(function(e) {
        updateToDate();
    });

    $("#genre-to-date").focusout(function(e) {
        updateToDate();
    });

    function updateToDate() {
        let $check = $("#genre-to-date");
        let $check2 = $("#genre-from-date");
        let $feedback = $("#genre-to-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Date cannot be less than From Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>