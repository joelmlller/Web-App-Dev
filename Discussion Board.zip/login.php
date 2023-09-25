<?php
// login.php



require 'config2.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['locked'] === 1) {
            $_SESSION['message'] = 'Account is locked. Please reset your password.';
            header("Location: resetpassword.php");
            exit;
        }

        if (password_verify($password, $user['password'])) {
            // Update last_login_time and increment login_count
            $sql = "UPDATE users SET last_login_time = NOW(), login_count = login_count + 1, login_fail_count = 0 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user['id']]);

            $_SESSION['user_id'] = $user['id']; // Store the user ID in the session
            header("Location: topiclist.php"); // Redirect back to the index page
            exit;
        } else {
            // Update login_fail_count and lock the account if 3 failures occur
            $sql = "UPDATE users SET login_fail_count = login_fail_count + 1 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user['id']]);

            if ($user['login_fail_count'] + 1 >= 3) {
                $sql = "UPDATE users SET locked = 1 WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user['id']]);
            }

            $_SESSION['message'] = 'Invalid email or password.';
        }
    } else {
        $_SESSION['message'] = 'User not found. Please register first.';
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    form {
      max-width: 300px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    form label,
    form input {
      display: block;
      margin-bottom: 10px;
    }

    form input[type="email"],
    form input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    form input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background-color: #0056b3;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 10px;
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    p.error-message {
      color: #ff0000;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <form method="POST" action="login.php">
    <h1 style="text-align: center;">Login</h1>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Enter your email">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter your password">
    <input type="submit" value="Login">
  </form>
  <a href="resetpassword.php">Forgot password?</a>
  <br>
  <a href="register.php">Register a Different Account</a>

  <!-- Display the message if it exists in the session -->
  <?php
  if (isset($_SESSION['message'])) {
      echo '<p class="error-message">' . $_SESSION['message'] . '</p>';
      unset($_SESSION['message']);
  }
  ?>

</body>
</html>
