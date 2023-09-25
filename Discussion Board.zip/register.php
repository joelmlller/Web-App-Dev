<?php
// register.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';
session_start();

// Call the doDB() function to establish the mysqli connection
doDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $security_question = $_POST['security_question'];
    $security_answer = $_POST['security_answer'];

    // Use $mysqli instead of $pdo for the query
    $sql = "INSERT INTO users (name, email, password, security_question, security_answer, creation_time) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $security_question, $security_answer);
    $stmt->execute();

    $_SESSION['message'] = 'Registration successful. Please login.';
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
  <title>Final Project</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">

  <style>
  .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
    text-align: center;
  }

  .alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
  }
  
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

    p.success-message {
      color: #00aa00;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <form method="POST" action="register.php">
    <h1 style="text-align: center;">Register</h1>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required placeholder="Enter your name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required placeholder="Enter your email">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter your password">

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

    <input type="submit" value="Register">
  </form>
  <a href="login.php">Already have an account?</a>

  <!-- Display the message if it exists in the session -->
  <?php
  if (isset($_SESSION['message'])) {
    echo '<p class="success-message">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
  }
  ?>

</body>

</html>





