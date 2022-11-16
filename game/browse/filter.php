<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/browse/include.php');
?>

<button id="filter-header" class="filter-header w-100 btn bg-main p-0 border-0 text-white text-left" type="button" data-toggle="collapse" data-target="#filter-body" role="button" aria-expanded="true" aria-controls="filter-body"> 
    <span class="filter-header-title float-left"> Filter </span>
    <span class="filter-header-arrow mr-1 float-right"> <i id="filter-body-arrow" class="arrow up"></i> </span>
</button>
<div id="filter-body" class="filter-body transition-all collapse show disable-select">
    <hr>
    <button id="genre-button" class="filter-header w-100 btn bg-main p-0 border-0 text-white text-left" type="button" data-toggle="collapse" data-target="#genre-menu" role="button" aria-expanded="true" aria-controls="genre-menu"> 
        <span class="filter-header-title float-left"> Tag </span>
        <span class="filter-header-arrow mr-1 float-right"> <i id="genre-menu-arrow" class="arrow up"></i> </span>
    </button>

    <div id="genre-menu" class="filter-body transition-all collapse show disable-select">
        <?php
            $genres = GenreUtil::getGenres();

            foreach ($genres as $genre) :?>

                <?php
                    $name = $genre->getName();
                    $display = $genre->getDisplay();
                    
                    $checked = in_array($name, $GLOBALS['filterGenre']) ? "checked" : "";
                ?>

                <div class="genre-item">
                    <div class="genre-display float-left <?=$checked?>">
                        <label for="filter-genre-<?=$name?>"> <?=$display?> </label>
                    </div>
                    <div class="genre-checkbox float-right">
                        <input id="filter-genre-<?=$name?>" class="filter-genre btn" type="checkbox" data-name="<?=$name?>" <?=$checked?>>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            
        <?php endforeach; ?>
    </div>

    <hr>
    <button id="price-button" class="filter-header w-100 btn bg-main p-0 border-0 text-white text-left" type="button" data-toggle="collapse" data-target="#price-menu" role="button" aria-expanded="true" aria-controls="price-menu"> 
        <span class="filter-header-title float-left"> Price </span>
        <span class="filter-header-arrow mr-1 float-right"> <i id="price-menu-arrow" class="arrow up"></i> </span>
    </button>

    <div id="price-menu" class="filter-body transition-all collapse show">
        <?php
            $price_types = $GLOBALS['filterPriceTypes'];
            foreach ($price_types as $price_type) :?>
                <?php
                    $name = $price_type[0];
                    $display = $price_type[1];
                    $checked = $name == $GLOBALS['filterPrice'] ? "checked" : "";
                ?>

                <div class="genre-item">
                    <div class="genre-display float-left <?=$checked?>">
                        <label for="filter-price-<?=$name?>"> <?=$display?> </label>
                    </div>
                    <div class="genre-checkbox float-right">
                        <input id="filter-price-<?=$name?>" class="filter-price btn" type="checkbox" data-name="<?=$name?>" <?=$checked?>>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            
        <?php endforeach; ?>
    </div>
</div>

<script>
    $('.filter-body').on('show.bs.collapse', function (e) {
        $('#' + e.target.id + '-arrow').toggleClass('up', true).toggleClass('down', false);
    });

    $('.filter-body').on('hide.bs.collapse', function (e) {
        $('#' + e.target.id + '-arrow').toggleClass('down', true).toggleClass('up', false);
    });

    function toggleTagToURL(tag, url) {
        let currentTag = url.searchParams.get("tag");
        if (currentTag == null) {
            currentTag = "";
        }
        let tags = currentTag.split("|");
        if (tags[0] == "") {
            tags = [];
        }

        // Add tag if not have in parameter and remove if have 
        let find = false;

        for (let i = 0; i < tags.length; i++) {
            if (tags[i] == tag) {
                tags.splice(i--, 1);
                find = true;
            }
        }

        if (!find) {
            tags.push(tag);
        }

        if (tags.length == 0) {
            url.searchParams.delete('tag');
        }else {
            url.searchParams.set("tag", tags.join('|'));
        }
    }

    var lastFilterGenreClickTime = Date.now();
    $('.filter-genre').click(function(e) {
        let tag = e.target.dataset.name;

        // Delay Click
        if (Date.now() - lastFilterGenreClickTime < 500) {
            e.preventDefault();
            return;
        }
        lastFilterGenreClickTime = Date.now();

        let currentUrl = new URL(window.location);
        // Add or remove new tag to param
        toggleTagToURL(tag, currentUrl);

        $.ajax({url: "filter.php" + currentUrl.search, success: function(result){
            $("#browse-filter").html(result);
        }});
        $.ajax({url: "product.php" + currentUrl.search, success: function(result){
			$("#product-items").html(result);
		}});
        $.ajax({url: "page.php" + currentUrl.search, success: function(result){
			$("#product-pages").html(result);
		}});
		window.history.pushState({}, '', currentUrl);
    });

    var lastFilterPriceClickTime = Date.now();
    $('.filter-price').click(function(e) {
        let price = e.target.dataset.name;

        // Delay Click
        if (Date.now() - lastFilterPriceClickTime < 500) {
            e.preventDefault();
            return;
        }
        lastFilterPriceClickTime = Date.now();

        let currentUrl = new URL(window.location);
        if (e.target.checked) {
            currentUrl.searchParams.set("price", price);
        }else {
            currentUrl.searchParams.delete("price");
        }

        $.ajax({url: "filter.php" + currentUrl.search, success: function(result){
            $("#browse-filter").html(result);
        }});
        $.ajax({url: "product.php" + currentUrl.search, success: function(result){
			$("#product-items").html(result);
		}});
        $.ajax({url: "page.php" + currentUrl.search, success: function(result){
			$("#product-pages").html(result);
		}});
		window.history.pushState({}, '', currentUrl);
    });
</script>