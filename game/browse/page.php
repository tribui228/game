<?php
defined('LOCAL_PATH_ROOT') or define("LOCAL_PATH_ROOT", $_SERVER["DOCUMENT_ROOT"]);
defined('HTTP_PATH_ROOT') or define("HTTP_PATH_ROOT", isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : (isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '_UNKNOWN_'));

include (LOCAL_PATH_ROOT.'/game/browse/include.php');
?>

<span class="float-left text-white">
    <?php
        $page = $GLOBALS['browsePage'];
        
        if ($page->getPages() <= 0) {
            echo "Not found any game";
        }else {
            $begin = $page->getMinIndex() + 1;
            $last = $page->getMaxIndex() + 1;
            $maxProduct = $page->getQuantity();
            echo "Showing $begin-$last of $maxProduct results";
        }
    ?>
</span>
<nav class="float-right disable-select" aria-label="Page navigation example">
    <ul class="page">
        <?php
            $page = $GLOBALS['browsePage'];
            
            if ($page->getPages() > 0) {
                $currentPage = $page->getCurrentPage();
                
                $begin = $page->getMinPreviousPage();
                $last = $page->getMaxNextPage();

                if ($currentPage > 1) {
                    echo '<li class="page-item"> <a class="a-page-item" href="#browse-sort" data-page="'.($currentPage - 1).'"> &laquo; </a> </li>';
                }
                if (!$page->isContainMinPage()) {
                    echo '<li class="page-item"> <a class="a-page-item" href="#browse-sort" data-page="1"> 1 </a> </li>';
                    echo '...';
                }

                for ($i = $begin; $i <= $last; $i++) {
                    if ($i == $page->getCurrentPage()) {
                        echo '<li class="page-item active" data-page="-1"> '.$i.' </li>';
                    }else {
                        echo '<li class="page-item"> <a class="a-page-item" data-page="'.$i.'" href="#browse-sort"> '.$i.' </a> </li>';
                    }
                }

                if (!$page->isContainMaxPage()) {
                    echo '...';
                    echo '<li class="page-item"> <a class="a-page-item" href="#browse-sort" data-page="'.$page->getPages().'"> '.$page->getPages().'</a> </li>';
                }

                if ($currentPage < $page->getPages()) {
                    echo '<li class="page-item" <a class="a-page-item" href="#browse-sort" data-page="'.($currentPage + 1).'"> &raquo; </a> </li>';
                }
            }
        ?>
    </ul>
</nav>

<div class="clearfix"> </div>

<script>
    $('.a-page-item').click(function(e) {
        let page = e.target.dataset.page;

        if (page == -1) {
            return;
        }

        let currentUrl = new URL(window.location);
        currentUrl.searchParams.set("page", page);

        $.ajax({url: "product.php" + currentUrl.search, success: function(result){
			$("#product-items").html(result);
		}});

        $.ajax({url: "page.php" + currentUrl.search, success: function(result){
			$("#product-pages").html(result);
		}});
		window.history.pushState({}, '', currentUrl);
    });
</script>