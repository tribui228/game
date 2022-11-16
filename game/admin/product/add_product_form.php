<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include_once (LOCAL_PATH_ROOT.'/game/admin/include.php');

if(session_status() == PHP_SESSION_NONE){    
    session_start();
}

if (!UserUtil::hasPermission($_SESSION['username'], 'admin.user.add')) {
    echo 'no_permission';
    exit();
}
?>

<div id="modal-header"> Create New Product </div>

<div id="modal-body"> 
    <div id="modal-alert" class="alert alert-primary d-none" role="alert">
    
    </div>

    <form id="image-upload-form" action="/game/admin/product/check_file_upload.php" method="post" enctype="multipart/form-data" onsubmit="return false;"></form>
    <form id="background-image-upload-form" action="/game/admin/product/check_file_upload.php" method="post" enctype="multipart/form-data" onsubmit="return false;"></form>
    <form id="add-user-form" onsubmit="return false;">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Name </div>
                    <input type="text" class="form-control" id="product-name">
                    <div id="product-name-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Display </div>
                    <input type="text" class="form-control" id="product-display">
                    <div id="product-display-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Developer </div>
                    <input type="text" class="form-control" id="product-developer">
                    <div id="product-developer-feedback" class="invalid-feedback">
                    </div>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Publisher </div>
                    <input type="text" class="form-control" id="product-publisher">
                    <div id="product-publisher-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col form-group">
                    <div class="modal-text"> Choose Genre </div>
                    <div id="product-genres" class="p-2 rounded">
                        <?php
                            $genres = GenreUtil::getGenres();
                            foreach ($genres as $genre) : 
                                $name = $genre->getName();
                                $display = $genre->getDisplay();
                        ?>
                                <div class="form-check">
                                    <input class="product-genre-group form-check-input" type="checkbox" value="<?=$name?>" id="product-genre-<?=$name?>" data-genre="<?=$name?>">
                                    <label for="product-genre-<?=$name?>" class="form-check-label"> <?=$display?> </label>
                                </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="product-genres-feedback" class="invalid-feedback"> </div>
                </div>

                <div class="col-12 form-group">
                    <div class="modal-text"> Release Date </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Date of publication </span>
                            </div>
                            <input type="date" class="form-control" id="product-release-date">
                            <div id="product-release-date-feedback" class="invalid-feedback">
                            </div>
                        </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Price ($) </div>
                    <input type="number" class="form-control" id="product-price" step="0.01">
                    <div id="product-price-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 col-md-6 form-group">
                    <div class="modal-text"> Sale </div>
                    <select id="product-sale" class="form-select">
                        <?php 
                            $sales = SaleUtil::getSales();
                            foreach ($sales as $sale) :
                                $name = $sale->getName();
                                $display = $sale->getDisplay();
                        ?>
                        <option value="<?=$name == 'no_discount' ? '' : $name?>" <?=$name == 'no_discount' ? 'selected="selected"' : ""?>> <?=$display?> </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="product-sale-feedback" class="invalid-feedback"> </div>
                </div>

                <div class="col-12 form-group">
                    <div class="modal-text"> Image </div>
                    <div id="product-image" class="input-group">
                        <div class="custom-file">
                            <input type="file" name="fileupload" id="product-image-input" form="image-upload-form">
                            <label id="product-image-label" class="custom-file-label" for="product-image-input">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button id="image-upload-submit" class="btn btn-primary" type="submit" form="image-upload-form"> Upload </button>
                        </div>
                    </div>
                    <div id="product-image-feedback" class="invalid-feedback"> </div>
                    <div id="product-image-valid-feedback" class="valid-feedback"> </div>
                </div>

                <div class="col-12 form-group">
                <div class="modal-text"> Background Image </div>
                    <div id="product-background-image" class="input-group">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" name="fileupload" id="product-background-image-input" accept="image" form="background-image-upload-form">
                            <label id="product-background-image-label" class="custom-file-label" for="product-background-image-input">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button id="background-image-upload-submit" class="btn btn-primary" type="submit" form="background-image-upload-form"> Upload </button>
                        </div>
                    </div>
                    <div id="product-background-image-feedback" class="invalid-feedback"> </div>
                    <div id="product-background-image-valid-feedback" class="valid-feedback"> </div>
                </div>

                <div class="col-12 form-group">
                    <div class="modal-text"> Description </div>
                    <textarea type="text" class="form-control" id="product-description"  rows="5"></textarea>
                    <div id="product-description-feedback" class="invalid-feedback">
                    </div>
                </div>

                <div class="col-12 form-group">
                    <div class="modal-text"> 
                        Minimum System Requirements
                        <input id="min-system-require-checkbox" type='checkbox' data-toggle='collapse' data-target='#min-system-require-collapse'>
                    </div>
                    <div id="min-system-require-collapse" class="col-12 form-group collapse">
                        <div class="col-12 form-group">
                            <div class="modal-text-small">OS</div>
                            <input type="text" class="form-control system-requirements" id="product-os-min">
                            <div id="product-os-min-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Processor</div>
                            <input type="text" class="form-control system-requirements" id="product-processor-min">
                            <div id="product-processor-min-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Memory</div>
                            <input type="text" class="form-control system-requirements" id="product-memory-min">
                            <div id="product-memory-min-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Graphics</div>
                            <input type="text" class="form-control system-requirements" id="product-graphics-min">
                            <div id="product-graphics-min-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Sound Card</div>
                            <input type="text" class="form-control system-requirements" id="product-sound-card-min">
                            <div id="product-sound-card-min-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Storage</div>
                            <input type="text" class="form-control system-requirements" id="product-storage-min">
                            <div id="product-storage-min-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="modal-text"> 
                        Recommended System Requirements
                        <input id="rec-system-require-checkbox" type='checkbox' data-toggle='collapse' data-target='#rec-system-require-collapse'>
                    </div>
                    <div id="rec-system-require-collapse" class="col-12 form-group collapse">
                        <div class="col-12 form-group">
                            <div class="modal-text-small" >OS</div>
                            <input type="text" class="form-control system-requirements" id="product-os-rec">
                            <div id="product-os-rec-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Processor</div>
                            <input type="text" class="form-control system-requirements" id="product-processor-rec">
                            <div id="product-processor-rec-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Memory</div>
                            <input type="text" class="form-control system-requirements" id="product-memory-rec">
                            <div id="product-memory-rec-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Graphics</div>
                            <input type="text" class="form-control system-requirements" id="product-graphics-rec">
                            <div id="product-graphics-rec-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Sound Card</div>
                            <input type="text" class="form-control system-requirements" id="product-sound-card-rec">
                            <div id="product-sound-card-rec-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="modal-text-small">Storage</div>
                            <input type="text" class="form-control system-requirements" id="product-storage-rec">
                            <div id="product-storage-rec-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modal-footer"> 
    <div class="col-12 form-group mb-0 pr-0 pl-0">
        <button type="submit" class="form-control admin-submit" id="product-confirm" form="add-user-form">
            Create product
        </button>
    </div>
</div>

<script>
    var productImageSubmitStatus = false;
    var productBackgroundImageSubmitStatus = false;
    var productImageFileName = null;
    var productBackgroundImageFileName = null;
    $('#product-image-input').on('change',function(e){
        let fileName = e.target.files[0].name;
        productImageSubmitStatus = false;
        $('#product-image-label').html(fileName);
        $('#product-image').toggleClass("is-valid", false);
        $('#product-image').toggleClass("is-invalid", false);
        $('#product-image-feedback').html("");
        $('#product-image-valid-feedback').html("");
    })

    $('#product-background-image-input').on('change',function(e){
        let fileName = e.target.files[0].name;
        productBackgroundImageSubmitStatus = false;
        $('#product-background-image-label').html(fileName);
        $('#product-background-image').toggleClass("is-valid", false);
        $('#product-background-image').toggleClass("is-invalid", false);
        $('#product-background-image-feedback').html("");
        $('#product-background-image-valid-feedback').html("");
    })

    $('#image-upload-form').submit(
        function(e) {
            if (productImageSubmitStatus) {
                $('#product-image-valid-feedback').html("Already upload image!");
                return;
            }

            $.ajax( {
                url: '/game/admin/product/file_upload.php',
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                success: function(result){
                    if (result.startsWith("Success")) {
                        productImageFileName = result.split(": ")[1];
                        $('#product-image').toggleClass("is-invalid", false);
                        $('#product-image').toggleClass("is-valid", true);
                        $('#product-image-feedback').html("");
                        $('#product-image-valid-feedback').html("Upload image successfully!");
                        productImageSubmitStatus = true;
                    }else {
                        $('#product-image').toggleClass("is-valid", false);
                        $('#product-image').toggleClass("is-invalid", true);
                        $('#product-image-feedback').html("Error: " + result);
                        $('#product-image-valid-feedback').html("");
                        productImageSubmitStatus = false;
                    }
                }
            } );
            e.preventDefault();
        } 
    );

    $('#background-image-upload-form' ).submit(
        function(e) {
            if (productBackgroundImageSubmitStatus) {
                $('#product-background-image-valid-feedback').html("Already upload image!");
                return;
            }

            $.ajax( {
                url: '/game/admin/product/file_upload.php',
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                success: function(result){
                    if (result.startsWith("Success")) {
                        productBackgroundImageFileName = result.split(": ")[1];
                        $('#product-background-image').toggleClass("is-valid", true);
                        $('#product-background-image').toggleClass("is-invalid", false);
                        $('#product-background-image-feedback').html("");
                        $('#product-background-image-valid-feedback').html("Upload background image successfully!");
                        productBackgroundImageSubmitStatus = true;
                    }else {
                        $('#product-background-image').toggleClass("is-invalid", true);
                        $('#product-background-image').toggleClass("is-valid", false);
                        $('#product-background-image-feedback').html("Error: " + result);
                        $('#product-background-image-valid-feedback').html("");
                        productBackgroundImageSubmitStatus = false;
                    }
                }
            } );
            e.preventDefault();
        } 
    );

    function getGenresCheckBox() {
        let genres = [];
        $(".product-genre-group").each(function () {
            if (this.checked) {
                genres.push(this.dataset.genre);
            }
        });
        return genres;
    }

    function getMinimumSystemRequirements() {
        let data = [];
        if ($('#min-system-require-checkbox')[0].checked) {
            data.push($('#product-os-min')[0].value);
            data.push($('#product-processor-min')[0].value);
            data.push($('#product-memory-min')[0].value);
            data.push($('#product-graphics-min')[0].value);
            data.push($('#product-sound-card-min')[0].value);
            data.push($('#product-storage-min')[0].value);
        }
        return data;
    }

    function getRecommendedSystemRequirements() {
        let data = [];
        if ($('#rec-system-require-checkbox')[0].checked) {
            data.push($('#product-os-rec')[0].value);
            data.push($('#product-processor-rec')[0].value);
            data.push($('#product-memory-rec')[0].value);
            data.push($('#product-graphics-rec')[0].value);
            data.push($('#product-sound-card-rec')[0].value);
            data.push($('#product-storage-rec')[0].value);
        }
        return data;
    }

    $("#product-confirm").click(function() {
        let check = true;
        check = updateName() && check;
        check = updateDisplay() && check;
        check = updateDeveloper() && check;
        check = updatePublisher() && check;
        check = updateGenres() && check;
        check = updateReleaseDate() && check;
        check = updatePrice() && check;
        // check = updateImage() && check;
        // check = updateBackgroundImage() && check;
        check = updateDescription() && check;
        check = updateMinimumSystemRequirement() && check;
        check = updateRecommendedSystemRequirement() && check;
        if (check) {
            var name = $("#product-name")[0].value;
            var display = $("#product-display")[0].value;
            var developer = $("#product-developer")[0].value;
            var publisher = $("#product-publisher")[0].value;
            var releaseDate = $("#product-release-date")[0].value;
            var price = $("#product-price")[0].value;
            var saleName = $("#product-sale")[0].value;
            var description = $("#product-description")[0].value;
            var genres = getGenresCheckBox();

            $.ajax({
                url: "product/add_product.php", 
                method: "POST",
                data: {
                    "name": name,
                    "display": display,
                    "developer": developer,
                    "publisher": publisher,
                    "release_date": releaseDate,
                    "price": price,
                    "sale_name": sale,
                    "image": productImageFileName,
                    "background_image": productBackgroundImageFileName,
                    "description": description,
                    "genres": genres,
                    "min_system_require": getMinimumSystemRequirements(),
                    "rec_system_require": getRecommendedSystemRequirements()
                },
                success: function(response){
                    if (response == 0) {
                        callNotice("Create New Product Successfully!");

                        $.ajax({
                            url: "product/index.php",
                            success: function(result){
                                $("#admin-content").html(result);
                            }
                        });

                        updateSideBar();
                        closeModal();
                    }else {
                        let $name = $("#product-name");
                        let $feedback = $("#product-name-feedback");

                        $feedback.html("Already exist that product name!");
                        $name.toggleClass("is-invalid", true);
                    }
                }
            });
        }
    });

    $("#product-name").focusout(function(e) {
        updateName();
    });

    $("#product-display").focusout(function(e) {
        updateDisplay();
    });

    $("#product-developer").focusout(function(e) {
        updateDeveloper();
    });

    $("#product-publisher").focusout(function(e) {
        updatePublisher();
    });

    $("#product-release-date").focusout(function(e) {
        updateReleaseDate();
    });

    $("#product-price").focusout(function(e) {
        updatePrice();
    });

    $("#product-discount").focusout(function(e) {
        updateDiscount();
    });

    $("#product-description").focusout(function(e) {
        updateDescription();
    });

    $(".system-requirements").focusout(function(e) {
        updateSystemRequirement($(this).attr('id'));
    });

    function updateGenres() {
        let $check = $("#product-genres");
        let $feedback = $("#product-genres-feedback");

        let check = getGenresCheckBox().length > 0;
        if (!check) {
            $feedback.html("Warning: Choose at least one genre.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateImage() {
        let $check = $("#product-image");
        let $feedback = $("#product-image-feedback");
        let value = $check[0].value;

        let check = productImageSubmitStatus;
        if (!check) {
            $feedback.html("Warning: Please post an image and upload.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateBackgroundImage() {
        let $check = $("#product-background-image");
        let $feedback = $("#product-background-image-feedback");
        let value = $check[0].value;

        let check = productBackgroundImageSubmitStatus;
        if (!check) {
            $feedback.html("Warning: Please post an image and upload.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateName() {
        let $check = $("#product-name");
        let $feedback = $("#product-name-feedback");
        let value = $check[0].value;

        let check = checkSimpleTextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out name field.");
        }else if (value.length > 255) {
            check = false;
            $feedback.html("Invalid Field Length: Name has maximum 255 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only characters (a-z A-Z 0-9 _).");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDisplay() {
        let $check = $("#product-display");
        let $feedback = $("#product-display-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out display field.");
        }else if (value.length > 255) {
            check = false;
            $feedback.html("Invalid Field Length: Display has maximum 255 characters.");
        }else {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDeveloper() {
        let $check = $("#product-developer");
        let $feedback = $("#product-developer-feedback");
        let value = $check[0].value;

        let check = checkUTF8TextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out developer field.");
        }else if (value.length > 255) {
            check = true;
            $feedback.html("Invalid Field Length: Name has maximum 255 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updatePublisher() {
        let $check = $("#product-publisher");
        let $feedback = $("#product-publisher-feedback");
        let value = $check[0].value;

        let check = checkUTF8TextRegex(value);
        if (value.length == 0) {
            $feedback.html("Warning: Please fill out publisher field.");
        }else if (value.length > 255) {
            check = true;
            $feedback.html("Invalid Field Length: Name has maximum 255 characters.");
        }else if (check) {
            $feedback.html("");
        }else {
            $feedback.html("Invalid Format: Accept only alphabet characters and single space between word.");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateReleaseDate() {
        let $check = $("#product-release-date");
        let $feedback = $("#product-release-date-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill in the date of publication.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updatePrice() {
        let $check = $("#product-price");
        let $feedback = $("#product-price-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out price field.");
        }else if (isNaN(value) || parseFloat(value) < 0 || parseFloat(value) > 1000) {
            check = false;
            $feedback.html("Invalid Format: Accept only float number between 0 to 1000.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateDescription() {
        let $check = $("#product-description");
        let $feedback = $("#product-description-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out description field.");
        }else if (value.length > 65535) {
            check = false;
            $feedback.html("Invalid Field Length: Description has maximum 65535 characters.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }

    function updateMinimumSystemRequirement() {
        let check = true;
        if ($('#min-system-require-checkbox')[0].checked) {
            check = updateSystemRequirement('product-os-min') && check;
            check = updateSystemRequirement('product-processor-min') && check;
            check = updateSystemRequirement('product-memory-min') && check;
            check = updateSystemRequirement('product-graphics-min') && check;
            check = updateSystemRequirement('product-sound-card-min') && check;
            check = updateSystemRequirement('product-storage-min') && check;
        }
        return check;
    }

    function updateRecommendedSystemRequirement() {
        let check = true;
        if ($('#rec-system-require-checkbox')[0].checked) {
            check = updateSystemRequirement('product-os-rec') && check;
            check = updateSystemRequirement('product-processor-rec') && check;
            check = updateSystemRequirement('product-memory-rec') && check;
            check = updateSystemRequirement('product-graphics-rec') && check;
            check = updateSystemRequirement('product-sound-card-rec') && check;
            check = updateSystemRequirement('product-storage-rec') && check;
        }
        return check;
    }

    function updateSystemRequirement(id) {
        let $check = $("#" + id);
        let $feedback = $("#" + id + "-feedback");
        let value = $check[0].value;

        let check = true;
        if (value.length == 0) {
            check = false;
            $feedback.html("Warning: Please fill out this field.");
        }else if (value.length > 255) {
            check = false;
            $feedback.html("Invalid Field Length: This field has maximum 255 characters.");
        }else if (check) {
            $feedback.html("");
        }
        $check.toggleClass("is-invalid", !check);
        return check;
    }
</script>