<?php
    // error messages
    $errors = array(
        "nameErr"=>"",
        "streetErr"=>"",
        "cityErr"=>"",
        "stateErr"=>"",
        "zipErr"=>"",
        "emailErr"=>""
    );
    // temp variables to store user's input
    $first = $last = $sex = $street = $city = $state = $zip = $email = "";
    
    // used to determine if input was valid before executing SQL
    $success = true;

    // upon clicking submit button, do form validation and then execute SQL if valid
    if(isset($_POST['submit'])) {
        // sql connection code (in another source file)
        require("sqlConnect.php");

        // get name input & clean
        $first = clean_input($_POST['first']);
        $last = clean_input($_POST['last']);
        // if empty, just put null (not required field)
        if(empty($first)) {
            $first = null;
        }
        // if there's input, check to see if it's valid
        else {
            // ensures only letters, -, and ' are inputted into DB
            if(!preg_match("/^[a-zA-Z-']+$/",$first)) {
                $errors["nameErr"] = "Only letters, -, and ' allowed";
                $success = false;
            }
        }
        // if empty, just put null (not required field)
        if(empty($last)) {
            $last = null;
        }
        // if there's input, check to see if it's valid
        else {
            // ensures only letters, -, and ' are inputted into DB
            if(!preg_match("/^[a-zA-Z-']+$/",$last)) {
                $errors["nameErr"] = "Only letters, -, and ' allowed";
                $success = false;
            }
        }
        // cleaning input for street
        $street = clean_input($_POST['street']);
        // if empty, just put null (not required field)
        if(empty($street)) {
            $street = null;
        }
        // cleaning input for city
        $city = clean_input($_POST['city']);
        // if empty, just put null (not required field)
        if(empty($city)) {
            $city = null;
        }
        // cleaning input for state
        $state = clean_input($_POST['state']);
        // if empty, just put null (not required field)
        if(empty($state)) {
            $state = null;
        }
        else {
            // checks if input is 2 characters long and only has characters
            if(strlen($state) != 2 || !preg_match("/^[a-zA-Z]*$/",$state)) {
                $errors["stateErr"] = "State must be 2 letters";
                $success = false;
            }
            else {
                // converts input to upper case since state name abbrev are usually capitalized
                $state = strtoupper($state);
            }
        }
        // cleaning input for zip
        $zip = clean_input($_POST['zip']);
        // if empty, just put null (not required field)
        if(empty($zip)) {
            $zip = null;
        }
        else {
            // checks if input is 5 integers long
            if(strlen($zip) != 5 || !preg_match('/^[0-9]*$/',$zip)) {
                $errors["zipErr"] = "ZIP must be 5 integers long";
                $success = false;
            }
        }
        // cleaning input for email
        $email = clean_input($_POST["email"]);
        // checks if input is empty (required field)
        if (empty($email)) {
            $errors["emailErr"] = "Email required";
            $success = false;
        } else {
            // check format of email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors["emailErr"] = "Invalid email format";
                $success = false;
            }
        }
        // no input validation needed since using radio buttons
        $sex = $_POST['sex'];

        // executes code if no invalid inputs
        if($success) {
            try {
                // prepare statement & binding parameters and datatype (s=string,i=integer,d=double,b=BLOB)
                $stmt = $conn->prepare("INSERT INTO USER (fname, lname, sex, street, city, state, zip, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $first, $last, $sex, $street, $city, $state, $zip, $email);
                $stmt->execute();
                // close prepared statement
                $stmt->close();
                echo "<h3>Form successfully submitted</h3>";
            } catch(Exception $e) {
                echo "<b>An error has occurred when trying to execute the query.</b><br/>";
                echo "<em>" . $e . "</em><br/>";
            }
        }
        else {
            echo "<h3 class='error'>ERROR! Please fix the marked issues</h3>";
        }
        // close connection
        $conn->close();
    }

    // function to clean white space and avoid possible PHP security issues
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <h1>Registration</h1>
    <p class='error'>* required</p>
    <form action="register.php" method="post">
        <fieldset>
            <p>
                <legend>Email</legend>
                <input type="text" name="email" required placeholder="example@domain.com" value="<?php echo $email;?>">
                <?php echo "<span class='error'>*{$errors['emailErr']}</span>";?>
            </p>
            <p>
                <legend>Name</legend>
                <input type="text" name="first" placeholder="First Name" value="<?php echo $first;?>">
                <input type="text" name="last" placeholder="Last Name" value="<?php echo $last;?>">
                <?php echo "<span class='error'>{$errors['nameErr']}</span>";?>
            </p>
            <p>
                <legend>Address</legend>
                <input type="text" name="street" placeholder="Street" value="<?php echo $street;?>">
                <?php echo "<span class='error'>{$errors['streetErr']}</span>";?>
            </p>
            <p>
                <input type="text" name="city" placeholder="City" value="<?php echo $city;?>">
                <?php echo "<span class='error'>{$errors['cityErr']}</span>";?>
            </p>
            <p>
                <input type="text" name="state" placeholder="State (2 letters)" value="<?php echo $state;?>">
                <?php echo "<span class='error'>{$errors['stateErr']}</span>";?>
            </p>
            <p>
                <input type="text" name="zip" placeholder="ZIP (#####)" value="<?php echo $zip;?>">
                <?php echo "<span class='error'>{$errors['zipErr']}</span>";?>
            </p>
            <p>
                <legend>Sex</legend>
                <label>
                    <input checked type="radio" name="sex" value="M">Male
                </label>
                <label>
                    <input type="radio" name="sex" value="F">Female
                </label>
            </p>
        </fieldset>
        <input type="submit" name = "submit" value="Register Now!">
    </form>
    <?php
        // just contains links to navigate to homepage, table with users stored in DB, and registration page
        include('navigation.php');
    ?>
</body>
</html>