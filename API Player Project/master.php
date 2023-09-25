<?php
require 'config.php';

$sql = "SELECT * FROM Users";
$stmt= $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>NBA Player Search</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link href="styles.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
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
    
    /* Table styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
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
        </ul>
      </div>
      <a href="logout.php" class="logout-link">Logout</a> <!-- Add a link to logout.php to handle logout -->

      <label for="" class=""><i class="#"></i></label>
      <form action="search.php" method="get" class="search-box">
        <input type="text" name="search" placeholder="Type Something to Search..." required>
        <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
      </form>
    </nav>
  </div>
  <br>
    <br>

  <br>

  <br>

  <br>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time of Creation</th>
                <th>Date/Time of Last Login</th>
                <th>Number of Logins</th>
                <th>Number of Failed Attempts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['creation_time']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_login_time']); ?></td>
                    <td><?php echo htmlspecialchars($user['login_count']); ?></td>
                    <td><?php echo htmlspecialchars($user['login_fail_count']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
