<?php
// main.html
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}
?>

<?php
require 'config.php';

// Fetch the logged-in user's data
$userSql = "SELECT * FROM Users WHERE id = :user_id";
$userStmt = $pdo->prepare($userSql);
$userStmt->bindValue(':user_id', $_SESSION['user_id']);
$userStmt->execute();
$user = $userStmt->fetch();
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
    /* Add your custom CSS here */
    ...

    #collection-items .username-item {
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #ccc;
      font-weight: bold;
      font-size: 1.2em;
    }

    #collection-items .collection-item {
      margin-bottom: 10px;
    }

    /* Add a divider line between different users */
    .divider {
      border-bottom: 1px solid #ccc;
      margin-bottom: 15px;
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
  <br>
  <br>
  <br>


  <div class="container">
    <!-- Display the user's name and email -->

    <!-- Display the collection list -->
    <div id="collection-list">
      <ul id="collection-items"></ul>
    </div>
  </div>

  <script>
    // Your existing script.js code...

    // Function to fetch and display the collection list
 async function displayCollectionList() {
      const response = await fetch('get_collection.php');
      const collections = await response.json();
      const collectionItems = document.getElementById('collection-items');

      collectionItems.innerHTML = ''; // Clear previous list items
      if (collections.length === 0) {
        collectionItems.innerHTML = '<li>No collections found</li>';
      } else {
        let currentUsername = '';
        collections.forEach((item) => {
          if (item.username !== currentUsername) {
            if (currentUsername !== '') { // Do not add a divider before the first user
              const divider = document.createElement('li');
              divider.className = 'divider';
              collectionItems.appendChild(divider);
            }

            const usernameItem = document.createElement('li');
            usernameItem.className = 'username-item'; // Add a class to the username items
            usernameItem.innerHTML = `<strong>Username:</strong> ${item.username}`;
            collectionItems.appendChild(usernameItem);
            currentUsername = item.username;
          }

          const listItem = document.createElement('li');
          listItem.className = 'collection-item'; // Add a class to the collection items
          listItem.innerHTML = `<strong>Collection Name:</strong> ${item.player_name}<br/>Added on ${item.date_added}`;
          collectionItems.appendChild(listItem);
        });
      }
    }

    // Function to remove an item from the collection
    async function removeFromCollection(itemId) {
      const response = await fetch('remove_from_collection.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: itemId }),
      });

      if (response.ok) {
        // Item removed successfully, update the collection list
        displayCollectionList();
      } else {
        console.error('Failed to remove item from collection.');
      }
    }

    // Initial update of the collection list
    document.addEventListener('DOMContentLoaded', () => {
      displayCollectionList();
    });
  </script>
</body>
</html>