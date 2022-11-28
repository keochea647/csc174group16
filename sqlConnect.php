<?php
    /*
        BELOW: database credentials that's stored in dbCred.php
        $servername = "XXXX";
        $username = "XXXX";
        $password = "XXXX";
        $dbname = "XXXX";
    */
    require("dbCred.php");

    try {
        // create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    } catch(Exception $e) {
        // if connection failed
        die("<b>Connection failed: </b>" . $e);
    }
?> 
