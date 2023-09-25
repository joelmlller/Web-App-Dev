<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}

require 'config2.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


$sql = "SELECT * FROM users";
$stmt= $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
        $userId = $_SESSION['user_id'];

        // Handle profile picture upload
        if (!empty($_FILES['profile_picture']['name'])) {
            $file = $_FILES['profile_picture'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileError = $file['error'];

            if ($fileError === UPLOAD_ERR_OK) {
                // Move the uploaded file to the uploads directory
                $destination = 'uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $destination);

                // Update the user's profile picture and description in the database
                $sql = "UPDATE users SET description = ?, profile_picture = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$description, $destination, $userId]);

                $_SESSION['message'] = 'Profile updated successfully.';
            } else {
                // Handle any errors during file upload (optional)
                $_SESSION['message'] = 'Error uploading profile picture.';
            }
        } else {
            // No profile picture uploaded, only update description
            $sql = "UPDATE users SET description = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$description, $userId]);

            $_SESSION['message'] = 'Profile updated successfully.';
        }
    }
}

// Fetch the user's profile data directly from the database
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$user = $stmt->fetch();

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
    /* Wrapper styles */
    .wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 20px;
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

    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }

    .wrapper {
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

    .profile-container {
      text-align: center;
      margin: 30px;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .profile-container h1 {
      color: #0066cc;
    }

    .profile-card {
      background-color: #f0f0f0;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .profile-card h2 {
      color: #0066cc;
    }

    .profile-card textarea {
      width: 100%;
      resize: vertical;
      border: 1px solid #ccc;
      padding: 5px;
    }

    .profile-card input[type="submit"] {
      background-color: #0066cc;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .profile-card input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .activity-log {
      margin-top: 30px;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .activity-log h2 {
      color: #0066cc;
    }

    .activity-log table {
      width: 100%;
      border-collapse: collapse;
    }

    .activity-log th,
    .activity-log td {
      padding: 8px;
      border-bottom: 1px solid #ccc;
    }

    .activity-log th {
      background-color: #f0f0f0;
      text-align: left;
    }

    .success-message {
      color: green;
      font-weight: bold;
      margin-top: 10px;
    }

    #footer {
      text-align: center;
      background-color: #333;
      color: #fff;
      padding: 10px;
    }
.profile-card input[type="file"] {
      background-color: #0066cc;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .profile-card input[type="file"]:hover {
      background-color: #0056b3;
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
          <li><a href="searchuser.php">Search</a></li>
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
  <div class="profile-container">
    <h1>User Profile</h1>

<?php if ($user['profile_picture']): ?>
  <img class="profile-picture" src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="200">
<?php endif; ?>

<?php if ($user): ?>
  <div class="profile-card">
    <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
    <form method="POST" action="profile.php" enctype="multipart/form-data">
      <label for="description">About Me:</label><br>
      <textarea id="description" name="description" rows="4" cols="50"><?php echo htmlspecialchars($user['description']); ?></textarea><br>
      <label for="profile_picture">Profile Picture: REQUIRED (jpg, jpeg, png)</label>
      <input type="file" name="profile_picture" id="profile_picture" accept=".jpg, .jpeg, .png">
      <input type="submit" value="Update Profile">
    </form>
  </div>
<?php endif; ?>


    <div class="activity-log">
      <h2>Activity Log</h2>
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
    </div>

    <?php if (isset($_SESSION['message'])): ?>
      <p class="success-message"><?php echo $_SESSION['message']; ?></p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
  </div>

 
</body>
</html>
