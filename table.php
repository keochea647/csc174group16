<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <h1>Users</h1>
    <!-- table headers creation -->
    <?php
        // database connection code (in another source file)
        require("sqlConnect.php");
        // SQL code to get all users
        $sql = "SELECT * FROM USER";
            
        try {
            $result = $conn->query($sql);
            // checks if there's any records returned
            if ($result->num_rows > 0) {
                // creates table if there are any records
                echo "<table>
                <thead>
                <tr>
                    <th>UID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Sex</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>ZIP</th>
                    <th>Email</th>
                </tr>";
                // goes through returned records and adds them to the table
                while($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
                            <td>{$row['uid']}</td>
                            <td>{$row['fname']}</td>
                            <td>{$row['lname']}</td>
                            <td>{$row['sex']}</td>
                            <td>{$row['street']}</td>
                            <td>{$row['city']}</td>
                            <td>{$row['state']}</td>
                            <td>{$row['zip']}</td>
                            <td>{$row['email']}</td>
                        </tr>\n";
                }
                echo "</table>";
            } 
            // if no records returned, will just display '0 results'
            else {
                echo "0 results <br/>";
            }
        } catch(Exception $e) {
            echo "<b>An error has occurred when trying to execute the query: </b>" . $sql . "<br/>";
            echo "<em>" . $e . "</em><br/>";
        }
        // closes connection
        $conn->close();
        // navigation links (in another source file)
        include("navigation.php");
        ?> 
    </body>
</html>
