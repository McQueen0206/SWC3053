<?php
// Start the session
include "db_connect.php";

// Connect to the database
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

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            // Set session for authenticated user
            $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username']];
            // Redirect to user's dashboard or any other page
            header('Location: Library_Index.php');
            exit();
        } else {
            $loginError = "Invalid username or password";
        }
    } catch (PDOException $e) {
        $loginError = "Login failed: " . $e->getMessage();
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

   <title>USER LOGIN</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: pink;">
      KETAYAP LIBRARY
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>WELCOME KETAYAPIAN!!!</h3>
         <p class="text-muted">LOGIN HERE</p>
      </div>

    <?php if (isset($loginError)): ?>
    <p style="color: red;"><?php echo $loginError; ?></p>
    <?php endif; ?>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Username:</label>
                  <input type="text" class="form-control" name="username" placeholder="Username" required>
               </div>

               <div class="col">
                  <label class="form-label">Password:</label>
                  <input type="text" class="form-control" name="password" placeholder="Password" required>
               </div>
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="login">LOGIN</button><br>
               Create account ?<br>
               <a href="register_user.php" class="btn btn-dark">Next</a>
            </div>
         </form>
      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
