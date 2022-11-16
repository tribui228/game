<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/user/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
?>

<div id="modal-header"> Search User </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Username </div>
                    <input type="text" class="form-control" id="user-username" value="<?=$searchUsername?>">
                    <div id="user-username-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Group </div>
                    <input type="text" class="form-control" id="user-group" value="<?=$searchGroup?>">
                    <div id="user-group-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> First Name </div>
                    <input type="text" class="form-control" id="user-firstname" value="<?=$searchFirstname?>">
                    <div id="user-firstname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Last Name </div>
                    <input type="text" class="form-control" id="user-lastname" value="<?=$searchLastname?>">
                    <div id="user-lastname-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Birth Date </div>
                    <input type="date" class="form-control" id="user-from-birth-date" value="<?=$searchFromBirthDate?>">
                    <div id="user-from-birth-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Birth Date </div>
                    <input type="date" class="form-control" id="user-to-birth-date" value="<?=$searchToBirthDate?>">
                    <div id="user-to-birth-date-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Email </div>
                    <input type="text" class="form-control" id="user-email" value="<?=$searchEmail?>">
                    <div id="user-email-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Phone </div>
                    <input type="text" class="form-control" id="user-phone" value="<?=$searchPhone?>">
                    <div id="user-phone-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="modal-text"> Address </div>
                    <input type="text" class="form-control" id="user-address" value="<?=$searchAddress?>">
                    <div id="user-address-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="user-confirm" form="search-user-form">
            Search User
        </button>
    </div>
</div>

<script>
    $("#user-confirm").click(function() {
        var username = $("#user-username")[0].value;
        var group = $("#user-group")[0].value;
        var firstname = $("#user-firstname")[0].value;
        var lastname = $("#user-lastname")[0].value;
        var fromBirthDate = $("#user-from-birth-date")[0].value;
        var toBirthDate = $("#user-to-birth-date")[0].value;
        var email = $("#user-email")[0].value;
        var phone = $("#user-phone")[0].value;
        var address = $("#user-address")[0].value;

        $.ajax({
            url: "user/index.php", 
            method: "POST",
            data: {
                "searchUsername": username.replace(/'/g, ''), 
                "searchGroup": group.replace(/'/g, ''),
                "searchFirstname": firstname.replace(/'/g, ''),
                "searchLastname": lastname.replace(/'/g, ''),
                "searchFromBirthDate": fromBirthDate,
                "searchToBirthDate": toBirthDate,
                "searchEmail": email.replace(/'/g, ''),
                "searchPhone": phone.replace(/'/g, ''),
                "searchAddress": address.replace(/'/g, ''),
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });
</script>