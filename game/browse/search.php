<div class="input-group rounded">
    <input id="advanced-search" type="search" class="search form-control rounded" name="search2" placeholder="Search" aria-label="Search"
        aria-describedby="search-addon" />
</div>

<script>
    var advancedSearch;
    var $advancedSearchInput = $("#advanced-search");

    $('input#advanced-search[type=search]').on('search', function (e) {
        updateAdvancedSearchBox(e);
    });

    $advancedSearchInput.on("keydown", function (e) {
        updateAdvancedSearchBox(e);
    });

    function updateAdvancedSearchBox(e) {
        clearTimeout(advancedSearch);
        advancedSearch = setTimeout(function () {
            let currentUrl = new URL(window.location);
            if (e.target.value == "") {
                currentUrl.searchParams.delete("search2");
            }else {
                currentUrl.searchParams.set("search2", e.target.value);
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