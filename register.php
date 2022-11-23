<?php
    require("sqlConnect.php");

    // error messages
    //$errors = array("nameErr"=>"","streetErr"=>"","cityErr"=>"","stateErr"="","zipErr"=>"","emailErr"=>"");
    $nameErr = $streetErr = $cityErr = $stateErr = $zipErr = $emailErr = "";
    $first = $last = $sex = $street = $city = $state = $zip = $email = "";
    $submitted = false;
    $success = true;

    // form validation
    if(isset($_POST['submit'])) {
        $submitted = true;
        if(empty($_POST['first']) || empty($_POST['last'])) {
            $nameErr = "Name required";
            $success = false;
        }
        else {
            $first = test_input($_POST['first']);
            $last = test_input($_POST['last']);
            if(!preg_match("/^[a-zA-Z-' ]*$/",$first) || !preg_match("/^[a-zA-Z-' ]*$/",$last)) {
                $nameErr = "Only letters and white space allowed";
                $success = false;
            }
            else {
                $nameErr="";
            }
        }
        if(empty($_POST['street'])) {
            $streetErr = "Street required";
            $success = false;
        }
        else {
            $street = test_input($_POST['street']);
            $streetErr = "";
        }
        if(empty($_POST['city'])) {
            $cityErr = "City required";
            $success = false;
        }
        else {
            $city = test_input($_POST['city']);
            $cityErr="";
        }
        if(empty($_POST['state'])) {
            $stateErr = "State required";
            $success = false;
        }
        else {
            $state = test_input($_POST['state']);
            if(strlen($state) != 2 || !preg_match("/^[a-zA-Z]*$/",$state)) {
                $stateErr = "State must be 2 letters";
                $success = false;
            }
            else {
                $state = strtoupper($state);
                $stateErr="";
            }
        }
        if(empty($_POST['zip'])) {
            $zipErr = "ZIP required";
            $success = false;
        }
        else {
            $zip = test_input($_POST['zip']);
            if(strlen($zip) != 5 || !preg_match('/^[0-9]*$/',$zip)) {
                $zipErr = "ZIP must be 5 integers long";
                $success = false;
            }
            else {
                $zipErr="";
            }
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email required";
            $success = false;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $success = false;
            }
            else {
                $emailErr="";
            }
        }
        $sex = $_POST['sex'];
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if($success && $submitted) {
        // prepare statement & binding parameters and datatype (s=string,i=integer,d=double,b=BLOB)
        $stmt = $conn->prepare("INSERT INTO USER (fname, lname, sex, street, city, state, zip, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $first, $last, $sex, $street, $city, $state, $zip, $email);
        $stmt->execute();

        // close prepared statement
        $stmt->close();
        echo "Form successfully submitted";
    }

    // close connection
    $conn->close();
    
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
    <h1>Registration</h1>
    <form action="register.php" method="post">
        <fieldset>
            <p>
                <legend>Name</legend>
                <input type="text" name="first" required placeholder="First Name" value="<?php echo $first;?>">
                <input type="text" name="last" required placeholder="Last Name" value="<?php echo $last;?>">
                <?php echo $nameErr;?>
            </p>
            <p>
                <legend>Address</legend>
                <input type="text" name="street" required placeholder="Street" value="<?php echo $street;?>">
                <?php echo $streetErr;?>
            </p>
            <p>
                <input type="text" name="city" required placeholder="City" value="<?php echo $city;?>">
                <?php echo $cityErr;?>
            </p>
            <p>
                <input type="text" name="state" required placeholder="State (##)" value="<?php echo $state;?>">
                <?php echo $stateErr;?>
            </p>
            <p>
                <input type="text" name="zip" required placeholder="ZIP (#####)" value="<?php echo $zip;?>">
                <?php echo $zipErr;?>
            </p>
            <p>
                <legend>Email</legend>
                <input type="text" name="email" required placeholder="Email address" value="<?php echo $email;?>">
                <?php echo $emailErr;?>
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
        include('navigation.php');
    ?>
</body>
</html>
