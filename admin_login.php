<?php
include("shared.php");

// clear out session value
if (isset($_GET['logout'])){
    $_SESSION['access'] = false;
}

// check to see if there's a form submission of user name and password
if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // validate user name and password
    // user name and password is hard-coded because client has small staff

    if ($username == "user" && $password == "password") {
        // grant access
        $_SESSION['access'] = true;
        // redirect it to the admin page #1
        header('Location: admin_appointmentList.php');
        exit;
    } else {
        // error message
        $message = "<p class='center'>* The username and password you provided are incorrect. Please try again!</p>";
    }
} else if (isset($_POST['username']) || isset($_POST['password'])){
    $message = "<p class='center'>* Please enter both the username and password.</p>";
}
?>

<?php print $HTMLHeader; ?>

<main id="login">
  <div class="flex">
    <div class="col">
      <img src="images/login.jpg" alt="Distinguish Detail Car Wash" class="login-img1">
    </div>
    <div class="col">
      <br><a href="index.php">Return Home</a>
      <form action="" method="post" class="form-login">
        <h2>Welcome Back</h2>
        <label for="username">Username</label>
        <input type='text' name="username" placeholder="Enter your username">
        <label for="password">Password</label>
        <input type='text' name="password" placeholder="Enter your password">
        <input type="submit" name="submit" value="Log in" class="btn-primary">
      </form>
      <img src="images/login.jpg" alt="Distinguish Detail Car Wash" class="login-img2">
    </div>
  </div>
</main>
</body>
</html>
