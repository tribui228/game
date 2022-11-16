<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');
include_once (LOCAL_PATH_ROOT.'/game/admin/product/params.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}
?>

<div id="modal-header"> Search Product </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="search-product-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="product-name" value="<?=$searchName?>">
                    <div id="product-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="product-display" value="<?=$searchDisplay?>">
                    <div id="product-display-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Developer </div>
                    <input type="text" class="form-control" id="product-developer" value="<?=$searchDeveloper?>">
                    <div id="product-developer-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Publisher </div>
                    <input type="text" class="form-control" id="product-publisher" value="<?=$searchPublisher?>">
                    <div id="product-publisher-feedback" class="invalid-feedback">
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

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> From Release Date </div>
                    <input type="date" class="form-control" id="product-from-release-date" value="<?=$searchFromReleaseDate?>">
                    <div id="product-from-release-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> To Release Date </div>
                    <input type="date" class="form-control" id="product-to-release-date" value="<?=$searchToReleaseDate?>">
                    <div id="product-to-release-date-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Min Price ($) </div>
                    <input type="number" class="form-control" id="product-min-price" step="0.01" value="<?=$searchMinPrice?>">
                    <div id="product-min-price-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Max Price ($) </div>
                    <input type="number" class="form-control" id="product-max-price" step="0.01" value="<?=$searchMaxPrice?>">
                    <div id="product-max-price-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 form-group">
                    <div class="modal-text"> Sale </div>
                    <select id="product-sale" class="form-select">
                        <option value="" <?=$searchSaleName == '' ? 'selected="selected"' : ''?>> All </option>
                        <?php 
                            $sales = SaleUtil::getSales();
                            foreach ($sales as $sale) :
                                $name = $sale->getName();
                                $display = $sale->getDisplay();
                        ?>
                        <option value="<?=$name?>" <?=$searchSaleName == $name ? 'selected="selected"' : ''?>> <?=$display?> </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="product-sale-feedback" class="invalid-feedback"> </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Image </div>
                    <input type="text" class="form-control" id="product-image" value="<?=$searchImage?>">
                    <div id="product-image-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Background Image </div>
                    <input type="text" class="form-control" id="product-background-image" value="<?=$searchBackgroundImage?>">
                    <div id="product-background-image-feedback" class="invalid-feedback">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="product-confirm" form="search-product-form">
            Search Product
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
        check = updateToReleaseDate() && check;
        if (!check) {
            return;
        }

        var name = $("#product-name")[0].value;
        var display = $("#product-display")[0].value;
        var developer = $("#product-developer")[0].value;
        var publisher = $("#product-publisher")[0].value;
        var fromReleaseDate = $("#product-from-release-date")[0].value;
        var toReleaseDate = $("#product-to-release-date")[0].value;
        var minPrice = $("#product-min-price")[0].value;
        var maxPrice = $("#product-max-price")[0].value;
        var saleName = $("#product-sale")[0].value;
        var image = $("#product-image")[0].value;
        var backgroundImage = $("#product-background-image")[0].value;
        var genres = getProductGenres();

        $.ajax({
            url: "product/index.php", 
            method: "POST",
            data: {
                "searchName": name.replace(/'/g, ''), 
                "searchDisplay": display.replace(/'/g, ''),
                "searchDeveloper": developer.replace(/'/g, ''),
                "searchPublisher": publisher.replace(/'/g, ''),
                "searchFromReleaseDate": fromReleaseDate,
                "searchToReleaseDate": toReleaseDate,
                "searchMinPrice": minPrice,
                "searchMaxPrice": maxPrice,
                "searchSaleName": saleName,
                "searchImage": image.replace(/'/g, ''),
                "searchBackgroundImage": backgroundImage.replace(/'/g, ''),
                "searchGenres": genres
            },
            success: function(response){
                closeModal();
                $("#admin-content").html(response);    
            }
        });
    });
    
    $("#product-from-release-date").focusout(function(e) {
        updateToReleaseDate();
    });

    $("#product-to-release-date").focusout(function(e) {
        updateToReleaseDate();
    });

    function updateToReleaseDate() {
        let $check = $("#product-to-release-date");
        let $check2 = $("#product-from-release-date");
        let $feedback = $("#product-to-release-date-feedback");
        let value = $check[0].value;
        let value2 = $check2[0].value;
        if (value.length == 0 || value2.length == 0) {
            return true;
        }

        let check = Date.parse(value2) <= Date.parse(value);
        if (!check) {
            $feedback.html("Warning: To Release Date cannot be less than From Release Date.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>