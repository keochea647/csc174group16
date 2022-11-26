<?php
    /*
        BELOW: database credentials that's stored in dbCred.php
        $servername = "XXXX";
        $username = "XXXX";
        $password = "XXXX";
        $dbname = "XXXX";
    */
    require("dbCred.php");

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // check if connection works
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?> 
