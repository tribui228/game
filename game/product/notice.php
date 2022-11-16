<div id="notice"></div>

<?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == '0') {
            echo '<script> callNotice("Out of stock!") </script>';
        }else if ($_GET['status'] == '1') {
            echo '<script> callNotice("Add to cart successfully!") </script>';
        }
    }
?>