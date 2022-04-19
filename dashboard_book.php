<?php 
    // Checking if user has session or not, if not redirecting user to login page

    session_start();
    if (!isset($_SESSION['username'])) {
        header('location: login_book.php?msg=1');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Dashboard</title>
</head>
<body>
    <!-- Main container -->
    <div class="container">
        <h2>Home</h2>
        <?php require_once 'menu.php'; ?>
        <p>Welcome <?php echo $_SESSION['name']; ?></p>
    </div>
</body>
</html>
