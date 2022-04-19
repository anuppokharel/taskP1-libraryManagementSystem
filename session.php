<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header('location: login_book.php?msg=1');
    }
    
?>