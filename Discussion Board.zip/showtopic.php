<?php
// main.html
include 'config.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login.php if not logged in
    exit;
}

doDB();

//check for required info from the query string
if (!isset($_GET['topic_id'])) {
	header("Location: topiclist.php");
	exit;
}

//create safe values for use
$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);

//verify the topic exists
$verify_topic_sql = "SELECT topic_title FROM forum_topics WHERE topic_id = '".$safe_topic_id."'";
$verify_topic_res =  mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_topic_res) < 1) {
	//this topic does not exist
	$display_block = "<p><em>You have selected an invalid topic.<br>
	Please <a href=\"topiclist.php\">try again</a>.</em></p>";
} else {
	//get the topic title
	while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
		$topic_title = stripslashes($topic_info['topic_title']);
	}

	//gather the posts
	$get_posts_sql = "SELECT post_id, post_text, DATE_FORMAT(post_create_time, '%b %e %Y<br>%r') AS fmt_post_create_time, post_owner FROM forum_posts WHERE topic_id = '".$safe_topic_id."' ORDER BY post_create_time ASC";
	$get_posts_res = mysqli_query($mysqli, $get_posts_sql) or die(mysqli_error($mysqli));

	//create the display string
	$display_block = <<<END_OF_TEXT
	<p>Showing posts for the <strong>$topic_title</strong> topic:</p>
	<table>
	<tr>
	<th>AUTHOR</th>
	<th>POST</th>
	</tr>
END_OF_TEXT;

	while ($posts_info = mysqli_fetch_array($get_posts_res)) {
		$post_id = $posts_info['post_id'];
		$post_text = nl2br(stripslashes($posts_info['post_text']));
		$post_create_time = $posts_info['fmt_post_create_time'];
		$post_owner = stripslashes($posts_info['post_owner']);

		//add to display
	 	$display_block .= <<<END_OF_TEXT
		<tr>
		<td><p>$post_owner</p><p>created on:<br>$post_create_time</p></td>
		<td><p>$post_text</p>
		<p><a href="replytopost.php?post_id=$post_id"><strong>REPLY TO POST</strong></a></p></td>
		</tr>
END_OF_TEXT;
	}

	//free results
	mysqli_free_result($get_posts_res);
	mysqli_free_result($verify_topic_res);

	//close connection to MySQL
	mysqli_close($mysqli);

	//close up the table
	$display_block .= "</table>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Posts in Topic</title>
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link href="../style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<style>
  /* Add your custom styles below */
  body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
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

  /* Table styles */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #0066cc;
    color: #fff;
  }

  tr:hover {
    background-color: #f2f2f2;
  }

  /* Additional styling for post content */
  .post-content {
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .post-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
  }

  .post-info p {
    margin: 0;
  }

  .post-info a {
    color: #0066cc;
    text-decoration: none;
  }

  .post-info a:hover {
    text-decoration: underline;
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
  </div>
 <br>
  <br>
   <br>
    <br>
     <br>
      <br>
  <header>
  <div class="wrapper">
    <h1>Posts in Topic</h1>
    <?php echo $display_block; ?>
  </div>
</body>
</html>
