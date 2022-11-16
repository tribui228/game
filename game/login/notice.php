<div id="notice"></div>

<?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == '1') {
            echo '<script> callNotice("Login to new account!") </script>';
        }
    }
?>