<?php
    // database information
    $servername = "XXXX";
    $username = "XXXX";
    $password = "XXXX";
    $dbname = "XXXX";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // check if connection works
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?> 