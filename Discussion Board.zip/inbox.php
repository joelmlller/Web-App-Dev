<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}

require 'config2.php';
function getUserDetails($pdo, $userId) {
    $sql = "SELECT * FROM users WHERE id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userid' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMessagesForUser($pdo, $userId) {
    $sql = "SELECT m.message, m.id as message_id, u.name as sender_name, u.email as sender_email
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE receiver_id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userid' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Get the logged-in user ID
$loggedInUserId = $_SESSION['user_id'];


// Fetch messages for the current user
$messages = getMessagesForUser($pdo, $loggedInUserId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Final Project</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
        
        h1 {
            color: #4285F4;
        }
        p {
            color: #777;
        }
        h2 {
            margin-top: 30px;
            color: #4285F4;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        
        strong {
            color: #4285F4;
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
    body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
  </div>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
    <h1>Inbox</h1>
    <p>Welcome!</p>

    <!-- Display messages -->
    <h2>Received Messages</h2>
    <?php if (count($messages) > 0): ?>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li>
                    <strong><?php echo $message['sender_name'];?></strong> (<?php echo $message['sender_email'];?>): <?php echo $message['message']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p>Error: <?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>

</body>
</html>
