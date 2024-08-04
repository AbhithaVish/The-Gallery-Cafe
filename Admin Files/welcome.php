<?php
session_start();

include_once('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style-login.css">
  
</head>

<body>

<?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert">'
            . $_SESSION['error'] .
            '<span class="close" onclick="this.parentElement.style.display=\'none\';">&times;</span>
        </div>';
        unset($_SESSION['error']);
    }
?>

<section>
  <div class="container">
    <h1 class="text-center">The Gallery Cafe</h1>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="off" placeholder="Enter your username" />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="off" placeholder="Enter your password" />
      </div>

      <div>
        <input type="submit" value="Sign in" name="login" class="btn" />
      </div>
    </form>
  </div>
</section>

</body>
</html>
