<?php
    if(!isset($_SESSION['token']) || $_SESSION['token'] == "" || is_null($_SESSION['token'])){
        header('location: index.php');
        exit();
    }
?>