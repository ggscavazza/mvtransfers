<?php
    session_start();

    $_SESSION['nome'] = "Teresa Teixeira";
    $_SESSION['token'] = "d467c1382b8921cb0853ce7f94f8761b";
    $_SESSION['tipo'] = 3;

    header("location: home.php");
    exit();