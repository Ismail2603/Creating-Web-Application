<?php
include_once"phpenhancements.php";
checkSession();
if (isset($_GET['action'])) {
    destroy();
    
    header("location: login.php");
} else {
    header("location: index.php");
}
