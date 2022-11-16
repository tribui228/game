<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/user_permission/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

?>

<div id="modal-header"> Search User Permission </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-user-permission-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Code </div>
                    <input type="text" class="form-control" id="user-permission-code" value="<?=$searchCode?>">
                    <div id="user-permission-code-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Status </div>
                    <select id="user-permission-status" class="form-select">
                        <option value="" <?=$searchStatus == "" ? 'selected="selected"' : ''?>> Both </option>
                        <option value="0" <?=$searchStatus == 0 ? 'selected="selected"' : ''?>> Not Used </option>
                        <option value="1" <?=$searchStatus == 1 ? 'selected="selected"' : ''?>> Used </option>
                    </select>
                    <div id="user-permission-status-feedback" class="invalid-feedback"> </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Added Date </div>
                    <input type="date" class="form-control" id="user-permission-from-added-date" value="<?=$searchFromAddedDate?>">
                    <div id="user-permission-from-added-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Added Date </div>
                    <input type="date" class="form-control" id="user-permission-to-added-date" value="<?=$searchToAddedDate?>">
                    <div id="user-permission-to-added-date-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="user-permission-confirm" form="search-user-permission-form">
            Search User Permission
        </button>
    </div>
</div>

<script>
    $("#user-permission-confirm").click(function() {
        var permission = $("#user-permission-code")[0].value;
        var status = $("#user-permission-status")[0].value;
        var fromAddedDate = $("#user-permission-from-added-date")[0].value;
        var toAddedDate = $("#user-permission-to-added-date")[0].value;

        $.ajax({
            url: "user_permission/index.php", 
            method: "POST",
            data: {
                "username": '<?=$_POST['username']?>',
                "searchPermission": permission.replace(/'/g, ''), 
                "searchStatus": status.replace(/'/g, ''),
                "searchFromBirthDate": fromAddedDate,
                "searchToBirthDate": toAddedDate,
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });
</script>