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
 <title>NBA Player Search Stats</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
   <link href="styles.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
      <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

   /* Wrapper styles */
    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 20px;
    }

 

    .logout-link {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
      background-color: #dc3545;
      border-radius: 5px;
    }

    </style>
    
    <script>
        window.onload = function() {
            fetch('https://www.balldontlie.io/api/v1/stats')
                .then(response => response.json())
                .then(data => {
                    const meta = data.meta;
                    document.getElementById('total_pages').innerText = meta.total_pages;
                    document.getElementById('current_page').innerText = meta.current_page;
                    document.getElementById('next_page').innerText = meta.next_page;
                    document.getElementById('per_page').innerText = meta.per_page;
                    document.getElementById('total_count').innerText = meta.total_count;
                })
                .catch(error => console.error(error));
        };
    </script>
</head>


<body>
 <div class="wrapper">
    <nav>
      <input type="checkbox" id="show-search">
      <input type="checkbox" id="show-menu">
      <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
      <div class="content">
        <ul class="links">
               <li><a href="main.php">Home</a></li>
           <li><a href="my_collection.php">Your Collection</a></li>
          <li><a href="stats.php">Stats</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="master.php">Master User List</a></li>
           <li><a href="master2.php">Master Collection List</a></li>
      </div>
        <a href="logout.php" class="logout-link">Logout</a> <!-- Add a link to logout.php to handle logout -->

    <label for="" class=""><i class="#"></i></label>
      <form action="#" class="search-box">
        <input type="text" placeholder="Type Something to Search..." required>
        <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
      </form>
    </nav>
  </div>
<br>
<br>
<br>
<br>
<br>
<br>
    <div class="container">
        <h1>Stats Metadata</h1>
        <p>Total Pages: <span id="total_pages"></span></p>
        <p>Current Page: <span id="current_page"></span></p>
        <p>Next Page: <span id="next_page"></span></p>
        <p>Results Per Page: <span id="per_page"></span></p>
        <p>Total Count: <span id="total_count"></span></p>
    </div>
</body>
</html>
