<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/user_permission/params.php');
?>

<style>
.special-column {
    padding: 0.4rem 0.7rem;
}

.special-column:hover > .value-cell {
    background-color: #34373a;
}

.value-cell {
    background-color: #212529;
    padding: 0.1rem 0.3rem;
}

.value-cell.value-danger {
    color: #FF6347;
}

.value-cell.value-success {
    color: #94DF03;
}
</style>

<?php
foreach ($userPermissions as $userPermission) :
    $id = $userPermission->getId();
    $permission = $userPermission->getPermission();
    $value = $userPermission->getValue() == 0 ? 'false' : 'true';
?>

<div class="admin-row" data-name="<?=$id?>">
    <div class="admin-column not-edit checkbox"> <input class="admin-checkbox" type="checkbox" data-name="<?=$id?>"></div>
    <div class="admin-column"> <?=$permission?> </div>
    <div class="admin-column special-column"><span class="value-cell <?=$value == 'true' ? "value-success" : "value-danger"?>" data-name="<?=$id?>"> <?=$value?> </span></div>
</div>
    
<?php endforeach;?>

<script>
    function updateCheckboxAll() {
        let all = true;
        $(".admin-checkbox:not(.all)").each(function() {
            if (all && !$(this)[0].checked) {
                all = false;
            }
        });

        $(".admin-checkbox.all").prop('checked', all);
    }

    $(".admin-checkbox").click(function(e) {
        let target = e.currentTarget;

        if (target.classList.contains('all')) {
            $(".admin-checkbox:not(.all)").prop('checked', target.checked);
        }else {
            updateCheckboxAll();
        }
    });

    $(".admin-column:not(.checkbox):not(.special-column)").click(function(e) {
        let parent = e.currentTarget.parentElement;

        if (parent.dataset.name == null) {
            return;
        }

        let checkbox = $(".admin-checkbox[data-name=" + parent.dataset.name + "]")[0];
        checkbox.checked = !checkbox.checked;
        updateCheckboxAll();
    });

    $(".admin-column.special-column").click(function(e) {
        let target = e.currentTarget.childNodes[0];
        
        let id = target.dataset.name;
        $.ajax({
            url: "user_permission/update_user_permission.php",
            method: "POST",
            data: {
                "id": id
            },
            success: function(result){
                if (result != 0 && result != 1) {
                    return;
                }

                $(target).html(result == 0 ? "false" : "true");
                $(target).toggleClass("value-success", result != 0);
                $(target).toggleClass("value-danger", result == 0);

                $.ajax({
                    url: "user_permission/table_scroll.php",
                    method: "POST",
                    data: {
                        "username": "<?=$_POST['username']?>"
                    },
                    success: function(result){
                        $(".admin-table-scroll").html(result);
                    }
                });
            }
        });
    });
</script>