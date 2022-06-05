<?php
    // Including all the required files 

    require 'functions.php';
    require 'confidential.php';

    // Checking cookie and adding session if cookie is available

    if (isset($_COOKIE['username'])) {
        session_start();
        $_SESSION['username'] = $_COOKIE['username'];
        header('location: dashboard_book.php');
    }

    // Collecting the values from form and storing it into variables by checking errors

    $error = [];
    
    if (isset($_POST['login'])) {
        // Collecting username from form
        
        if (updateForm($_POST, 'username')) {
            $username = trim($_POST['username']);
            if (strlen($username) < 4) {
                $error['username'] = 'Enter atleast 8 characters';
            }
        } else {
            $error['username'] = 'Enter username';
        }
        // Collecting password from form

        if (updateForm($_POST, 'password')) {
            $password = $_POST['password'];
        } else {
            $error['password'] = 'Enter password';
        }
        // Initialize the database if there is no error 

        if (count($error) == 0) {
            try {
                // Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
                // Decrypting md5 type password and storing it into variable

                $encpass = md5($password);

                // SQL Query 

                $sql = "select * from tbl_users where username = '$username' and password = '$encpass' and status = 1";
                
                // Query execution and storing query onto variable

                $result = mysqli_query($connection, $sql);

                // Checking if there is data in the variable or not

                if (mysqli_num_rows($result) == 1 ) {
                    // Fetch user records using fetch and store the data into variable
                    // assoc -> Associative array

                    $user = mysqli_fetch_assoc($result);

                    // Initialize session

                    session_start();

                    // Store extra data into session

    				$_SESSION['username'] = $username;
                    $_SESSION['name'] = $user['name'];
	    
                    // If check remember is selected store the data into cookie
		    
                    if (isset($_POST['remember'])) {
					    // Set cookie to store cookie value

					    setcookie('username', $username, time()+(7*24*60*60));
                    }
                    // Redirect to defined page
                
				    header('location: dashboard_book.php');
                } else {
                    $error['login'] = 'No user found';
                }
				
            } catch (Exception $e) {
                // Catching any errors and storing it into variable e 

                $error['database'] = $e -> getMessage();
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
    <link rel="stylesheet" href="styles/styles.css" />
    <title>Login</title>
</head>
<body>
    <!-- Main container -->

    <div class="container">
        <!-- Username and Password form -->

        <h1>Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div>
                <label for="username">username</label>
                <input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" >
            </div>
            <?php echo displayError($error, 'username'); ?><br>

            <div>
                <label for="password">password</label>
                <input type="password" name="password" id="password">
            </div>
            <?php echo displayError($error, 'password'); ?><br>

            <input type="checkbox" name="remember" value="remember"> Remember me
            <button type="submit" name="login">Login</button>

            <!-- Error message -->

            <br><?php echo displayError($error, 'login'); ?>

            <!-- Logout message -->
        
            <?php
                if (isset($_GET['msg']) && $_GET['msg'] == 1) {
                    echo '<b><span class="error">Please login to continue</span></b>';
                } else if (isset($_GET['msg']) && $_GET['msg'] == 2) {
                    echo '<span class="success">' . '<b>Logout successful</b>' . '</span>';
                }
            ?>

            <br><span>Not a member? <a href="register_book.php">Register</a> </span>
        </form>
    </div>

    <script src="lib/jQuery.js"></script>
    <script src="lib/dist/jquery.validate.js"></script>
    <script src="scripts/scripts.js"></script>
</body>
</html>