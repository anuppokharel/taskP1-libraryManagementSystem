<?php
    require_once 'session.php';
    require 'functions.php';
    require 'confidential.php';
    
    // This specifies which error to show to users
    
    error_reporting(E_ERROR);

    // Collecting the values from form and storing it into variables by checking errors

    $error = [];
    $title = $author = $publication = $price = $page = $edition = $isbn = '';

    if(isset($_POST['btnSave'])) {
        
        if (updateForm($_POST, 'title')) {
            $title = $_POST['title'];
        } else {
            $error['title'] = 'Enter title';
        }

        if (updateForm($_POST, 'author')) {
            $author = $_POST['author'];
        } else {
            $error['author'] = 'Enter author';
        }

        if (updateForm($_POST, 'publication')) {
            $publication = $_POST['publication'];
        } else {
            $error['publication'] = 'Enter publication';
        }

        if (updateForm($_POST, 'price')) {
            $price = $_POST['price'];
        } else {
            $error['price'] = 'Enter price';
        }

        if (updateForm($_POST, 'page')) {
            $page = $_POST['page'];
        } else {
            $error['page'] = 'Enter page';
        }

        if (updateForm($_POST, 'edition')) {
            $edition = $_POST['edition'];
        } else {
            $error['edition'] = 'Enter edition';
        }

        if (updateForm($_POST, 'isbn')) {
            $isbn = $_POST['isbn'];
        } else {
            $error['isbn'] = 'Enter isbn';
        }
        
        // If there is no error initialize process to upload the files to database

        if(count($error) == 0) {

            try {
                //Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // $connection = mysqli_connect('localhost', 'root', '', 'db_forphp');

                $sql = "insert into tbl_books(title, author, price, page, edition, publication, isbn) values('$title', '$author', '$price', '$page', '$edition', '$publication', '$isbn')";
                
                // Query execution

                if(mysqli_query($connection, $sql)) {
                    $successmsg = 'Book created successfully';
                }

            } catch (Exception $e) {
                die('Database connection error' . '<br>' . $e->getMessage());

            }
        
        }
    }

// mysql : outdated
// mysqli : (function, object)
// pdo : PHP data object

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Books</title>
</head>
<body>
    <!-- Main container -->
    
    <div class="container">
        <h1>Add Books</h1>

        <?php require_once 'menu.php'; ?>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div>
                <label for="title">title</label>
                <input type="text" name="title" id="title" value="<?php echo $title ?>">
            </div>
            <?php echo displayError($error, 'title'); ?><br>
            
            <div>
                <label for="author">author</label>
                <input type="text" name="author" id="author" value="<?php echo $author ?>">
            </div>
            <?php echo displayError($error, 'author'); ?><br>
            
            <div>
                <label for="publication">publication</label>
                <input type="text" name="publication" id="publication" value="<?php echo $publication ?>">
            </div>
            <?php echo displayError($error, 'publication'); ?><br>
            
            <div>
                <label for="price">price</label>
                <input type="text" name="price" id="price" value="<?php echo $price ?>">
            </div>
            <?php echo displayError($error, 'price'); ?><br>
            
            <div>
                <label for="page">page</label>
                <input type="number" name="page" id="page" value="<?php echo $page ?>">
            </div>
            <?php echo displayError($error, 'page'); ?><br>
            
            <div>
                <label for="edition">edition</label>
                <input type="text" name="edition" id="edition" value="<?php echo $edition ?>">
            </div>
            <?php echo displayError($error, 'edition'); ?><br>
            
            <div>
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="<?php echo $isbn ?>">
            </div>
            <?php echo displayError($error, 'isbn'); ?><br>
            
            <button type="submit" name="btnSave">Add Book</button>

            <?php if(isset($successmsg)) { ?>
                <h3 class="success"><?php echo $successmsg; ?></h3>
            <?php } ?>
        </form>
    </div>

    <script src="scripts.js"></script>
</body>
</html>