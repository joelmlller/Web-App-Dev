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
 <title>About</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
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

        a {
            color: #0066cc;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
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

<body>
    <div class="container">
        <h1>About balldontlie API</h1>
        <p>The balldontlie API provides basketball data related to NBA (National Basketball Association). The data source includes a wide array of NBA related data, ranging from player information, team details, to game statistics. The data spans from the inception of the NBA in 1946 to the present.</p>

        <h2>Data Source</h2>
        <p>The data is compiled from various reputable sources such as official NBA websites, sports journalism platforms, fan websites, among others. The information is thoroughly verified before being included in our database, however, discrepancies may occasionally occur.</p>

        <h2>API Access</h2>
        <p>The API is free to use, no email or API key required. It provides data from seasons 1946 to the current season. You can get live(ish) game stats which are updated every ~10 minutes. There's a rate limit of 60 requests per minute.</p>

        <h2>Get Started</h2>
        <p>Check out the API documentation and endpoints at <a href="https://www.balldontlie.io/api/v1/">https://www.balldontlie.io/api/v1/</a></p>

        <h2>Contact</h2>
        <p>If you have any questions or issues, feel free to email them at <a href="mailto:hello@balldontlie.io">hello@balldontlie.io</a> or join their discord server. You are also welcome to contribute to the project on GitHub. If you find our service valuable, please consider donating to help support the project.</p>
    </div>
</body>
</html>
