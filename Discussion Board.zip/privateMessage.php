<?php
// private_message.php
require 'config2.php';
session_start(); // Start the session


function getUserDetails($pdo, $userId) {
    $sql = "SELECT * FROM users WHERE id = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userid' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Check if the user ID is provided in the URL
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    
    // Get the user's details
    $user = getUserDetails($pdo, $userId);

    if ($user) {
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Assuming you have a table named 'messages' to store the messages
            $recipientId = $userId;
            $senderId = $_SESSION['user_id'];
            $messageContent = $_POST['message_content'];

            // Validate the message content (make sure it's not empty)
            if (empty($messageContent)) {
                $error = "Message content cannot be empty.";
            } else {
                // Insert the message into the 'messages' table
                $sql = "INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (:senderId, :recipientId, :messageContent, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['senderId' => $senderId, 'recipientId' => $recipientId, 'messageContent' => $messageContent]);

                // Display a success message
                $success = "Message sent successfully!";
            }
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
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <style>
                body {
                    font-family: Arial, sans-serif;
                }

                h1 {
                    color: #333;
                }

                .container {
                    width: 50%;
                    margin: auto;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                textarea {
                    width: 100%;
                    height: 100px;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    resize: vertical;
                }

                .success {
                    color: green;
                }

                .error {
                    color: red;
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
            <div class="container">
                <h1>Private Messaging</h1>
                <p>Send a private message to <?= $user['name'] ?></p>
                <form action="" method="post">
                    <div class="form-group">
                        <textarea rows="5" name="message_content" placeholder="Compose your message..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Send Message</button>
                    </div>
                </form>

                <?php if (isset($success)) : ?>
                    <div class="success"><?= $success ?></div>
                <?php endif; ?>

                <?php if (isset($error)) : ?>
                    <div class="error"><?= $error ?></div>
                <?php endif; ?>
            </div>
        </body>
        </html>

        <?php
    } else {
        // User with the given ID not found, handle this accordingly (e.g., display an error message)
        echo "User not found.";
    }
} else {
    // No user ID provided in the URL, handle this accordingly (e.g., redirect to the search page)
    echo "Invalid request.";
}
?>
