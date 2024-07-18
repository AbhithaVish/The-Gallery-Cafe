<?php
session_start();
include_once('connection.php');

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) && empty($password)) {
        $_SESSION['error'] = 'Please fill in both username and password';
        header('Location: welcome.php');
        exit;
    } elseif (empty($password)) {
        $_SESSION['error'] = 'Please fill in the password';
        header('Location: welcome.php');
        exit;
    } elseif (empty($username)) {
        $_SESSION['error'] = 'Please fill in the username';
        header('Location: welcome.php');
        exit;
    } else {
        $sql = "SELECT * FROM `login_tbl` WHERE `username`='$username' AND `password`='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
            $storedUsername = $row['username'];
            $storedPassword = $row['password'];

            if ($username == $storedUsername && $password == $storedPassword) {
                $_SESSION['name'] = $name;
                $_SESSION['username'] = $username;
                header('Location: customer/index.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: welcome.php');
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . $_SESSION['error'] .
            '<button type="button" id="search-icon" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
             </button>
        </div>';
        unset($_SESSION['error']);
    }
?>


  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <h1 class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3">The Gallery Cafe</h1>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form action="login.php" method="post">
            
            <!-- <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3">Login </p> -->

            <!-- Email input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example13"> <i class="bi bi-person-circle"></i> Username</label>
              <input type="text" id="form1Example13" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="enter your username" style="border-radius:25px ;" />

            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form1Example23"><i class="bi bi-chat-left-dots-fill"></i> Password</label>
              <input type="password" id="form1Example23" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="enter your password" style="border-radius:25px ;" />

            </div>


            <!-- Signin button -->
            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
              <input type="submit" value="Sign in" name="login" class="btn btn-warning btn-lg text-light my-2 py-3" style="width:100% ; border-radius: 30px; font-weight:600; background-color: #3333ff; border-color: #3333ff; color: #FFFFFF;" />
          
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </section>



</body>

</html>