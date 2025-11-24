<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
  <div class="form">
    <div class="login-box">
      <h1>Sign in</h1>
      <?php
          if (isset($_SESSION['error'])) {
            echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
          }
        ?>
      <form action="proses_login.php" method="post">
        <div class="input-box">
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-box">
          <input type="text" name="password" placeholder="Password" required>
        </div>
        <div class="input-box btn">
          <input type="submit" value="login">
        </div>
      </form>
    </div>
  </div>
  <div class="right">
    <div class="satelite signup">
      <a href="signup.php">
        <span>Sign up</span>
      </a>
    </div>
    <div class="satelite forget">
      <a href="forget.php">
        <span>Forget</span>
      <span>Password</span>
    </a>
    </div>
  </div>
</div>
</body>
</html>