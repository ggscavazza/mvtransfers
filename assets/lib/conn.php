<?php
    $servername = "162.240.13.168";
    $database = "mvtransfers_app";
    $username = "mvtransfers_admin";
    $password = "mv@2023@transfers";

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    $table_prefix = "sistema";
?>