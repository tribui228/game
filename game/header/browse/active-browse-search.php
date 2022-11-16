<div id="search-bar" class="form-inline my-2 my-md-0">
    <div class="input-group rounded">
        <input id="basic-search" type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
            aria-describedby="search-addon" value="<?php $search = isset($_GET['search']) ? $_GET['search'] : ''; echo $search?>" />
    </div>
</div>

<script>
    var basicSearch;
    var $basicSearchInput = $("#basic-search");

    $("input#basic-search[type=search]").on("search", function (e) {
        updateBasicSearchBox(e);
    });

    $basicSearchInput.on("keydown", function (e) {
        updateBasicSearchBox(e);
    });

    function updateBasicSearchBox(e) {
        clearTimeout(basicSearch);
        basicSearch = setTimeout(function () {
            let currentUrl = new URL(window.location);
            if (e.target.value == "") {
                currentUrl.searchParams.delete("search");
            }else {
                currentUrl.searchParams.set("search", e.target.value);
            }
            currentUrl.searchParams.delete("search2");

            if (e.target.value == "") {
                $("#search-title").html("");
            }else {
                $("#search-title").html("Search for \"" + e.target.value + "\"");
            }

            $.ajax({url: "product.php" + currentUrl.search, success: function(result){
                $("#product-items").html(result);
            }});
            $.ajax({url: "page.php" + currentUrl.search, success: function(result){
                $("#product-pages").html(result);
            }});
            window.history.pushState({}, "", currentUrl);
        }, 200);
    }
</script>