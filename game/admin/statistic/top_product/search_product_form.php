<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once(LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once(LOCAL_PATH_ROOT.'/game/admin/statistic/top_product/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
?>

<div id="modal-header"> Search Top Product </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-product-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 form-group">
                    <div class="modal-text"> Statistic By </div>
                    <div class="form-check d-flex">
                    <input class="form-check-input" type="radio" name="product-by" value="revenue" id="product-by-revenue" <?=$type == 'revenue' ? 'checked="checked"' : ''?>>
                    <label class="form-check-label" for="product-by-revenue">
                        By Revenue
                    </label>
                    </div>

                    <div class="form-check d-flex">
                    <input class="form-check-input" type="radio" name="product-by" value="sales" id="product-by-sales" <?=$type == 'sales' ? 'checked="checked"' : ''?>>
                    <label class="form-check-label" for="product-by-sales">
                        By Sales
                    </label>
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Date </div>
                    <input type="date" class="form-control" id="product-from-date" value="<?=$searchFromDate?>">
                    <div id="product-from-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Date </div>
                    <input type="date" class="form-control" id="product-to-date" value="<?=$searchToDate?>">
                    <div id="product-to-date-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="modal-text"> Choose Genre </div>
                    <div id="product-genres" class="p-2 rounded">
                        <?php
                            $genres = GenreUtil::getGenres();

                            foreach ($genres as $genre) : 
                                $name = $genre->getName();
                                $display = $genre->getDisplay();
                                $check = !empty($searchGenres) ? in_array($name, $searchGenres) : false;
                        ?>
                                <div class="form-check">
                                    <input class="product-genre-group form-check-input" type="checkbox" value="<?=$name?>" id="product-genre-<?=$name?>" data-genre="<?=$name?>" <?=$check ? "checked" : ""?>>
                                    <label for="product-genre-<?=$name?>" class="form-check-label"> <?=$display?> </label>
                                </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="product-genres-feedback" class="invalid-feedback"> </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="product-confirm" form="search-product-form">
            Search Top Product
        </button>
    </div>
</div>

<script>
    function getProductGenres() {
        let arr = [];

        $(".product-genre-group").each(function () {
            if (this.checked) {
                arr.push(this.dataset.genre);
            }
        });

        return arr;
    }

    $("#product-confirm").click(function() {
        let check = true;
        check = updateToDate() && check;
        if (!check) {
            return;
        }

        var fromDate = $("#product-from-date")[0].value;
        var toDate = $("#product-to-date")[0].value;
        var genres = getProductGenres();
        var type = $("#product-by-revenue")[0].checked ? 'revenue' : 'sales';

        $.ajax({
            url: "statistic/top_product/index.php", 
            method: "POST",
            data: {
                "searchFromDate": fromDate,
                "searchToDate": toDate,
                "searchGenres": genres,
                "type": type
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });

    $("#product-from-date").focusout(function(e) {
        updateToDate();
    });

    $("#product-to-date").focusout(function(e) {
        updateToDate();
    });

    function updateToDate() {
        let $check = $("#product-to-date");
        let $check2 = $("#product-from-date");
        let $feedback = $("#product-to-date-feedback");
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