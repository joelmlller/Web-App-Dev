<?php
// main.html
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Add a Topic</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }

    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    nav {
      background-color: #333;
      padding: 10px;
    }

    .content {
      display: none;
    }

    .menu-icon {
      color: #fff;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .links li {
      display: inline-block;
      margin-right: 20px;
    }

    .links li a {
      color: #fff;
      text-decoration: none;
      padding: 5px;
    }

    .links li a:hover {
      text-decoration: underline;
    }

    .search-box {
      display: flex;
      align-items: center;
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 5px;
      border-radius: 5px;
    }

    .search-box input[type="text"] {
      border: none;
      padding: 5px;
      flex: 1;
    }

    .go-icon {
      background-color: #0066cc;
      color: #fff;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .go-icon:hover {
      background-color: #0056b3;
    }

    /* Existing CSS styles from the first page */
    a {
      color: #0066cc;
      text-decoration: none;
    }
        
    a:hover {
      text-decoration: underline;
    }

    .logout-link {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
      background-color: #dc3545;
      border-radius: 5px;
    }

    ol {
      padding-left: 20px; 
    }

    ol li {
      padding: 0;
      margin: 0;
    }

    /* Form styles */
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    form label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    form input[type="email"],
    form input[type="text"],
    form textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 15px;
    }

    form button[type="submit"] {
      background-color: #0066cc;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <nav>
      <input type="checkbox" id="show-search">
      <input type="checkbox" id="show-menu">
      <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
      <div class="content">
        <ul class="links">
          <li><a href="topiclist.php">Home</a></li>
          <li><a href="addtopic.php">Add Topic</a></li>
          <li><a href="searchuser.php">User Search</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="inbox.php">Inbox</a></li>
        </ul>
      </div>
      <a href="logout.php" class="logout-link">Logout</a> 

      <label for="" class=""><i class="#"></i></label>
      <form action="search.php" method="get" class="search-box">
        <input type="text" name="search" placeholder="Type Something to Search..." required>
        <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
      </form>
    </nav>

    <header>
      <h1>Add a Topic</h1>
      <form method="post" action="topicLogic.php">

        <label for="topic_owner">Your Email Address:</label>
        <input type="email" id="topic_owner" name="topic_owner" maxlength="150" required>

        <label for="topic_title">Topic Title:</label>
        <input type="text" id="topic_title" name="topic_title" maxlength="150" required>

        <label for="post_text">Post Text:</label>
        <textarea id="post_text" name="post_text" rows="8" cols="40"></textarea>

        <button type="submit" name="submit" value="submit">Add Topic</button>

      </form>
    </header>
  </div>
</body>
</html>
