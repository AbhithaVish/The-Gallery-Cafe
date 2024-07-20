<?php
session_start();
include_once('connection.php');

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Please fill in both username and password';
        header('Location: welcome.php');
        exit;
    }

    $sql = "SELECT * FROM `admin_tbl` WHERE `username`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) { // Consider using password_hash and password_verify in production
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $row['username'];
            header('Location: Admin/index.php');
            exit;
        }
    }

    $_SESSION['error'] = 'Invalid username or password';
    header('Location: welcome.php');
    exit;
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