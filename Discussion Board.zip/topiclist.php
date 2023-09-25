<?php
include 'config.php';
// topiclist.php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}


doDB();

// Check if a search term is submitted
$search_term = '';
if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($mysqli, $_GET['search']);
}

// Gather the topics with search filter if applicable
$get_topics_sql = "SELECT topic_id, topic_title, DATE_FORMAT(topic_create_time, '%b %e %Y at %r') as fmt_topic_create_time, topic_owner 
                   FROM forum_topics";
if (!empty($search_term)) {
    // Add the search condition to the query
    $get_topics_sql .= " WHERE topic_title LIKE '%$search_term%' ";
}
$get_topics_sql .= " ORDER BY topic_create_time DESC";

$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_topics_res) < 1) {
    // There are no topics matching the search criteria
    $display_block = "<p><em>No topics found.</em></p>";
} else {
    // Create the display string
    $display_block = <<<END_OF_TEXT
    <form method="GET" action="topiclist.php">
        <label for="search">Search Topics:</label>
        <input type="text" id="search" name="search" value="{$search_term}">
        <input type="submit" value="Search">
    </form>
    <table id="myTable">
    <thead>
    <tr>
    <th><a href="javascript:sortTable(myTable,0,0);">TOPIC TITLE</a></th>
    <th><a href="javascript:sortTable(myTable,1,0);"># of POSTS</a></th>
    </tr>
    </thead>
    <tbody>
END_OF_TEXT;

    while ($topic_info = mysqli_fetch_array($get_topics_res)) {
        $topic_id = $topic_info['topic_id'];
        $topic_title = stripslashes($topic_info['topic_title']);
        $topic_create_time = $topic_info['fmt_topic_create_time'];
        $topic_owner = stripslashes($topic_info['topic_owner']);

        //get number of posts
        $get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM forum_posts WHERE topic_id = '".$topic_id."'";
        $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

        while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
            $num_posts = $posts_info['post_count'];
        }

        //add to display
        $display_block .= <<<END_OF_TEXT
        <tr>
        <td><a href="showtopic.php?topic_id=$topic_id"><strong>$topic_title</strong></a><br>
        Created on $topic_create_time by $topic_owner</td>
        <td class="num_posts_col">$num_posts</td>
        </tr>
END_OF_TEXT;
    }
    //free results
    mysqli_free_result($get_topics_res);
    mysqli_free_result($get_num_posts_res);

    //close up the table
    $display_block .= "</tbody>
    </table>";
}

//close connection to MySQL
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>New Topic Added</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Your additional CSS styles go here */
  

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

    /* Additional CSS styles for the table */
    table {
      border: 1px solid black;
      border-collapse: collapse;
    }

    th {
      border: 1px solid black;
      padding: 6px;
      font-weight: bold;
      background: #ccc;
    }

    td {
      border: 1px solid black;
      padding: 6px;
    }

    .num_posts_col {
      text-align: center;
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
      <a href="logout.php" class="logout-link">Logout</a> <!-- Add a link to logout.php to handle logout -->

      <label for="" class=""><i class="#"></i></label>
      <form action="search.php" method="get" class="search-box">
        <input type="text" name="search" placeholder="Type Something to Search..." required>
        <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
      </form>
    </nav>

    <header>
      <h1>New Topic Added</h1>
    </header>

    <div class="message">
      <?php echo $display_block; ?>
    </div>
  <p>Would you like to <a href="addtopic.php">add a topic</a>?</p>
  </div>
</body>
</html>
