<?php
include ($_SERVER['DOCUMENT_ROOT'].'/game/browse/include.php');
?>

<span class="dropdown">
	<button class="btn bg-main dropdown-toggle text-white-after pl-1" type="button" id="sortByMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="text-secondary"> 
			Sort by:
		</span> 
		<span class="text-white"> 
			<?php echo $GLOBALS['sortDisplay']; ?> 
		</span>
	</button>

	<div class="browse-sort-items dropdown-menu bg-sub text-white" aria-labelledby="sortByMenuButton">
		<?php
			foreach ($GLOBALS['sortArray'] as $sort) {
				$line = '<a id="sort-%sort_by%-%sort_dir%" class="browse-sort-item dropdown-item bg-sub text-white %sort_active%" href="#" data-sortBy="%sort_by%" data-sortDir="%sort_dir%"> %sort_display% </a>';
				$line = str_replace("%sort_by%", $sort[0], $line);
				$line = str_replace("%sort_dir%", $sort[1], $line);
				$line = str_replace("%sort_display%", $sort[2], $line);
				if ($sort[0] == $sortBy && $sort[1] == $sortDir) {
					$line = str_replace("%sort_active%", "active", $line);
				}else {
					$line = str_replace("%sort_active%", "", $line);
				}
				echo $line;
			}
		?>
	</div>
</span>
<script>
	$(".browse-sort-item").click(function(e) {
		let sortBy = e.target.dataset.sortby;
		let sortDir = e.target.dataset.sortdir;

		let currentUrl = new URL(window.location);
		currentUrl.searchParams.set("sortBy", sortBy);
		currentUrl.searchParams.set("sortDir", sortDir);

		$.ajax({url: "sort.php" + currentUrl.search, success: function(result){
			$("#sort-item").html(result);
		}});

		$.ajax({url: "product.php" + currentUrl.search, success: function(result){
			$("#product-items").html(result);
		}});
		window.history.pushState({}, '', currentUrl);
	});
</script>