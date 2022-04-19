<?php
    require 'functions.php';
    require_once 'confidential.php';

    // Collecting the values from form and storing it into variables by checking errors

    $error = [];
    $name = $username = $email = $password = $address = $phone = $dob = $country = $gender = $image = $bio = "";

    if (isset($_POST['submit'])) {
        if (updateForm($_POST, 'name')) {
            $name = $_POST['name'];
            if(!preg_match ("/^[a-z A-Z]+$/", $name)) {
                $error['name'] = "Name must only contain letters.";
            }
        } else {
            $error['name'] = "Enter your name.";
        }
        
        if (updateForm($_POST, 'username')) {
            $username = $_POST['username'];
        } else {
            $error['username'] = "Enter your username.";
        }

        if (updateForm($_POST, 'email')) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Enter validate E-Mail.";
            }
        } else {
            $error['email'] = "Enter your E-Mail address.";
        }

        // Encrypting password using md5

        if (updateForm($_POST, 'password')) {
            $password = md5($_POST['password']);
        } else {
            $error['password'] = "Enter your password";
        }

        if (updateForm($_POST, 'address')) {
            $address = $_POST['address'];
        } else {
            $error['address'] = "Enter your address.";
        }

        if (updateForm($_POST, 'phone')) {
            $phone = $_POST['phone'];
        } else {
            $error['phone'] = "Enter your phone.";
        }

        if (updateForm($_POST, 'dob')) {
            $dob = $_POST['dob'];
        } else {
            $error['dob'] = "Enter your Date of Birth.";
        }

        // if (updateForm($_POST, 'country')) {
        //     $country = $_POST['country'];
        // } else {
        //     $error['country'] = "Select your Country.";
        // }

        if (updateForm($_POST, 'gender')) {
            $gender = $_POST['gender'];
        } else {
            $error['gender'] = "Select your Gender.";
        }
        
        // If there is no error then initialize process to store the data from form to database table

        if(count($error) == 0) {
            try {
                // Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Insert into SQL

                $sql = "insert into tbl_users (name, username, email, password, address, phone, dob, gender) values ('$name', '$username', '$email', '$password', '$address', '$phone', '$dob', '$gender');";

                // Query execution

                if (mysqli_query($connection, $sql)) {
                    $successmsg = 'You have successfully registered.';
                }

            } catch (Exception $e) {
                $error['register'] = $e -> getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Register</title>
</head>
<body>
    <!-- Main container -->

    <div class="container">
        <!-- Collecting the informations for registration data -->

        <h1>Register</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
            </div>
            <?php echo displayError($error, 'name'); ?><br>
            
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>">
            </div>
            <?php echo displayError($error, 'username'); ?><br>

            <div>
                <label for="email">E-Mail</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <?php echo displayError($error, 'email'); ?><br>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password">
            </div>
            <?php echo displayError($error, 'password'); ?><br>

            <div>
                <label for="address">Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>">
            </div>
            <?php echo displayError($error, 'address'); ?><br>

            <div>
                <label for="phone">Phone</label>
                <input type="number" name="phone" id="phone" value="<?php echo $phone; ?>">
            </div>
            <?php echo displayError($error, 'phone'); ?><br>

            <div>
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $dob; ?>">
            </div>
            <?php echo displayError($error, 'dob'); ?><br>

            <div>
                <label for="gender">Gender:</label>
                <input type="radio" name="gender" value="Male" <?php if($gender == "Male") { echo "checked";} ?>>Male
                <input type="radio" name="gender" value="Female" <?php if($gender == "Female") { echo "checked";} ?>>Female
                <input type="radio" name="gender" value="Others" <?php if($gender == "Others") { echo "checked";} ?>>Others
            </div>
            <?php echo displayError($error, 'gender'); ?><br>

            <button type="submit" name="submit">Register</button>

            <!-- Error message -->

            <br><?php echo displayError($error, 'register'); ?>

            <!-- Registered Message -->

            <?php if (isset($successmsg)) { ?>
                <h3 class="success"><?php echo $successmsg; ?></h3>
            <?php } ?>

            <br><span>Already a member? <a href="login_book.php">Log In</a> </span>
        </form>
    </div>

    <script src="scripts.js"></script>
</body>
</html>