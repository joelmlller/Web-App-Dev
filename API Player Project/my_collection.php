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
  <div id="collection-list"></div>
    
  <script>
    // Your existing script.js code...

    // Function to fetch and display the collection list
    async function displayCollectionList() {
      const response = await fetch('get_collection2.php');
      const collection = await response.json();
      const collectionList = document.getElementById('collection-list');

      collectionList.innerHTML = '<h2>My Collection</h2>';
      if (collection.length === 0) {
        collectionList.innerHTML += '<p>Your collection is empty.</p>';
      } else {
        const list = document.createElement('ul');
        collection.forEach((item) => {
          const listItem = document.createElement('li');
          listItem.textContent = `${item.player_name} - Added on ${item.date_added}`;

          const removeButton = document.createElement('button');
          removeButton.textContent = 'Remove';
          removeButton.addEventListener('click', () => removeFromCollection(item.id));

          listItem.appendChild(removeButton);
          list.appendChild(listItem);
        });

        collectionList.appendChild(list);
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
