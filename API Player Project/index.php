<?php
// index.php

require 'config.php';
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>NBA Player Search</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">

  <style>
body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
  background-image: url('back.jpg');
  background-size: cover;
  background-position: center;
}

.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent background color for text visibility */
  padding: 20px;
  border-radius: 10px;
}

a {
  display: block;
  text-align: center;
  margin: 10px;
  padding: 5px 10px; /* decreased padding to make buttons smaller */
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
}

a:hover {
  background-color: #0056b3;
}

a:first-child {
  margin-bottom: 10px;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>NBA Player Search Collection</h1>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>

    <?php
    if (isset($_SESSION['message'])) {
      echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
      unset($_SESSION['message']);
    }
    ?>
  </div>

  <script src="script.js"></script>
</body>
</html>