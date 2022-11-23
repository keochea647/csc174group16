<?php
    require("sqlConnect.php");
    $sql = "SELECT * FROM USER";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "uid: " . $row["uid"]. " - Name: " . $row["fname"]. " " . $row["lname"]. " - Sex " .$row["sex"];
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    include("navigation.php");
?> 
