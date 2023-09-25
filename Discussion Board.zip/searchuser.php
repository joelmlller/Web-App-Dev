<?php
 require 'config2.php';
session_start();
 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}


// Initialize variables
$searchQuery = '';
$users = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_query'])) {
        $searchQuery = $_POST['search_query'];

        // Query the database to search for users matching the search query
        $sql = "SELECT * FROM users WHERE name LIKE :nameQuery OR email LIKE :emailQuery";
        $stmt = $pdo->prepare($sql);
        $searchParam = '%' . $searchQuery . '%';
        $stmt->execute(['nameQuery' => $searchParam, 'emailQuery' => $searchParam]);
        $users = $stmt->fetchAll();
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
       

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
        }

        input[type="text"] {
            padding: 5px;
            width: 300px;
        }

        button[type="submit"] {
            padding: 5px 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2 {
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        img {
            border-radius: 50%;
            margin-right: 10px;
        }

        p {
            text-align: center;
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
    <h1>User Search</h1>
    <form method="POST" action="searchuser.php">
        <label for="search_query">Search for a user:</label>
        <input type="text" name="search_query" id="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit">Search</button>
    </form>

   <?php if ($users): ?>
    <h2>Search Results:</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php if ($user['profile_picture']): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="50">
                <?php endif; ?>
                <?php echo htmlspecialchars($user['name']); ?> (<?php echo htmlspecialchars($user['email']); ?>)
                <a href="privateMessage.php?user_id=<?php echo htmlspecialchars($user['id']); ?>">Send Message</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php elseif ($searchQuery): ?>
    <p>No users found!</p>
<?php endif; ?>
</body>
</html>
