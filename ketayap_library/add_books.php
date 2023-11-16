<?php
$host = 'localhost';
$dbname = 'library';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST["submit"])) {
    $entry_number = $_POST['entry_number'];
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn_number = $_POST['isbn_number'];
    $version = $_POST['version'];
    $shelf = $_POST['shelf'];

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO `books`(`id`, `entry_number`, `book_name`, `author`, `publisher`, `isbn_number`, `version`, `shelf`) VALUES (NULL,?,?,?,?,?,?,?)");
        $stmt->execute([$entry_number, $book_name, $author, $publisher, $isbn_number, $version, $shelf]);

        header("Location: admin_only.php?msg=New record created successfully");
        exit();
    } catch (PDOException $e) {
        echo "Failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>ADD BOOK</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: pink;">
      KETAYAP LIBRARY
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New Book</h3>
         <p class="text-muted">Complete the form below to add a new book</p>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Entry Number:</label>
                  <input type="text" class="form-control" name="entry_number" placeholder="Entry Number">
               </div>

               <div class="col">
                  <label class="form-label">Book Name:</label>
                  <input type="text" class="form-control" name="book_name" placeholder="Book Name">
               </div>
            </div>

            <div class="mb-3">
               <label class="form-label">Author:</label>
               <input type="text" class="form-control" name="author" placeholder="author">
            </div>


            <div class="mb-3">
               <label class="form-label">Publisher:</label>
               <input type="text" class="form-control" name="publisher" placeholder="Publisher">
            </div>


            <div class="mb-3">
               <label class="form-label">ISBN number:</label>
               <input type="text" class="form-control" name="isbn_number" placeholder="ISBN Number">
            </div>


            <div class="mb-3">
               <label class="form-label">Version:</label>
               <input type="text" class="form-control" name="version" placeholder="Version">
            </div>


            <div class="mb-3">
               <label class="form-label">Shelf:</label>
               <input type="text" class="form-control" name="shelf" placeholder="Shelf">
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit">Add</button>
               <a href="admin_only.php" class="btn btn-danger">Cancel</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
