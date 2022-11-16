<div id="notice"></div>

<?php
    if (isset($_GET['login_status']) && isset($_SESSION['username'])) {
        if ($_GET['login_status'] == '1') {
            echo '<script> callNotice("Welcome, '.$_SESSION['username'].'!") </script>';
        }
    }
?>