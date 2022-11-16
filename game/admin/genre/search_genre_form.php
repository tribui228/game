<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/genre/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
?>

<div id="modal-header"> Search Genre</div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-genre-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="genre-name" value="<?=$searchName?>">
                    <div id="genre-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="genre-display" value="<?=$searchDisplay?>">
                    <div id="genre-display-feedback" class="invalid-feedback">
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
    $("#genre-confirm").click(function() {
        var name = $("#genre-name")[0].value;
        var display = $("#genre-display")[0].value;

        $.ajax({
            url: "genre/index.php", 
            method: "POST",
            data: {
                "searchName": name.replace(/'/g, ''), 
                "searchDisplay": display.replace(/'/g, '')
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });
</script>