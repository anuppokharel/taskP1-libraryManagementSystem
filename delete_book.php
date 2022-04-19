<?php
    // Checking if user has session or not, if not redirecting user to login page

    session_start();
    if (!isset($_SESSION['username'])) {
        header('location: login_book.php?msg=1');
    }

    // Get the id from url and add it to varaible

    $token = $_GET['id'];

    try {
        //Database connection function
        $connection = mysqli_connect('localhost', 'root', '', 'db_forphp');

        //SQL to select data
        $sql = "delete from tbl_books where id = $token";

        //Query execution
        mysqli_query($connection, $sql);
        header('location: list_book.php');
    } catch (Exception $e) {
        die ('Database error :-' . e->getMessage());
    }

?>