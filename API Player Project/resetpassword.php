<?php
// reset_password.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
     $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($security_answer === $user['security_answer']) {
            // Update password and unlock the account
            $sql = "UPDATE Users SET password = ?, locked = 0, login_fail_count = 0 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$new_password, $user['id']]);

            $_SESSION['message'] = 'Password has been reset. Please login with your new password.';
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message'] = 'Incorrect security answer.';
        }
    } else {
        $_SESSION['message'] = 'User not found.';
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
  <title>NBA Player Search - Reset Password</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    form label,
    form input,
    form select {
      display: block;
      margin-bottom: 10px;
      width: 100%;
    }

    form input[type="submit"] {
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

    form select,
    form input[type="text"],
    form input[type="password"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
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
  <form method="POST" action="resetpassword.php">
    <h1 style="text-align: center;">NBA Player Search - Reset Password</h1>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Enter your email">

    <label for="security_question">Security Question:</label>
    <select id="security_question" name="security_question" required>
      <option value="" disabled selected>Select a security question</option>
      <option value="What is your favorite color?">What is your favorite color?</option>
      <option value="What is the name of your first pet?">What is the name of your first pet?</option>
      <option value="What city were you born in?">What city were you born in?</option>
      <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
      <option value="What is your favorite book?">What is your favorite book?</option>
    </select>

    <label for="security_answer">Security Answer:</label>
    <input type="text" id="security_answer" name="security_answer" required placeholder="Enter your security answer">

    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password" required placeholder="Enter your new password">

    <input type="submit" value="Reset Password">
  </form>
  <a href="index.php">Back to Login</a>

  <!-- Display the message if it exists in the session -->
  <?php
  if (isset($_SESSION['message'])) {
    echo '<p class="error-message">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
  }
  ?>

</body>

</html>