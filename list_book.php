<?php
    require_once 'session.php';
    require_once 'confidential.php';

    $books = [];
    try {
        // Database connection function

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // SQL to select data

        $sql = "select * from tbl_books";

        // Query execution and return result object

        $result = mysqli_query($connection, $sql);

        //Check no of rows

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            
                array_push($books, $row);
            
            }
        }
    } catch (Exception $e) {
        die ('Database error :-' . e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Document</title>
</head>
<body>
    <!-- Main container -->

    <div class="container">
        <h1>List book</h1>
        <?php require_once 'menu.php'; ?>
        <table border="1">
            <tr>
                <th>SN</th>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Edition</th>
                <th>ISBN</th>
                <th>Edition</th>
                <th>Action</th>
            </tr>
            <?php foreach($books as $key => $book) {?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $book['id'] ?></td>
                    <td><?php echo $book['title'] ?></td>
                    <td><?php echo $book['author'] ?></td>
                    <td><?php echo $book['publication'] ?></td>
                    <td><?php echo $book['edition'] ?></td>
                    <td><?php echo $book['isbn'] ?></td>
                    <td><?php echo $book['edition'] ?></td>
                    <td>
                        <a href="delete_book.php?id=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if(count($books) == 0) { ?>
                <tr>    
                    <th colspan="9">Books not available.</th>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>