<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <h1>Users</h1>
    <!-- table headers creation -->
    <table>
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
            </tr>
        </thead>
        <?php
            // database connection code (in another source file)
            require("sqlConnect.php");
            // SQL code to get all users
            $sql = "SELECT * FROM USER";
            $result = $conn->query($sql);

            // checks if there's any records returned
            if ($result->num_rows > 0) {
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
            } else {
                echo "0 results";
            }
            // closes connection
            $conn->close();

            // navigation links (in another source file)
            include("navigation.php");
        ?> 
    </table>
    </body>
</html>
