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
        <a href="logout.php" class="logout-link">Logout</a> <!-- Add a link to logout.php to handle logout -->
      </div>
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
  <header>
    <h1>NBA Player Search</h1>
    <form id="search-form">
      <input type="text" id="search-input" placeholder="Search players...">
      <button type="submit">Search</button>
    </form>
    <main id="player-list"></main>
  </header>

  <script src="script.js"></script>

  <main id="player-stats"></main>
  
  <div id="additional-stats"></div>

  <label for="year-input">Enter Year:</label>
  <input type="number" id="year-input" min="2003" max="2023" step="1" placeholder="Year">
  <button id="search-button">Search</button>

  <script>
    async function getPlayerStats(id, year) {
        const playerResponse = await fetch(`https://www.balldontlie.io/api/v1/players/${id}`);
        const playerData = await playerResponse.json();
  
        let statsUrl = `https://www.balldontlie.io/api/v1/stats?player_ids[]=${id}&per_page=20`;
        if (year) {
          statsUrl += `&seasons[]=${year}`;
        }
        const statsResponse = await fetch(statsUrl);
        const statsData = await statsResponse.json();
  
        displayPlayerStats(playerData, statsData);
      }
  
      function displayPlayerStats(player, stats) {
        const playerStats = document.getElementById('player-stats');
        const additionalStats = document.getElementById('additional-stats');
      
        // Handle null values in player stats with the || operator
        playerStats.innerHTML = `
          <h2>${player.first_name} ${player.last_name}</h2>
          <p>Position: ${player.position || 0}</p>
          <p>Height: ${(player.height_feet || 0)}' ${(player.height_inches || 0)}"</p>
          <p>Weight: ${(player.weight_pounds || 0)} lbs</p>
          <p>Team: ${(player.team && player.team.full_name) || 'Unknown'}</p>
        `;
      
        additionalStats.innerHTML = `
          <h3>Additional Stats</h3>
          <ul>
            ${stats.data.map(stat => `
              <li>
                <strong>Date:</strong> ${new Date(stat.game.date).toDateString()}<br>
                <strong>Opponent:</strong> ${stat.team.full_name}<br>
                <strong>Points:</strong> ${stat.pts || 0}<br>
                <strong>Assists:</strong> ${stat.ast || 0}<br>
                <strong>Rebounds:</strong> ${stat.reb || 0}<br>
                <strong>Blocks:</strong> ${stat.blk || 0}<br>
                <strong>Steals:</strong> ${stat.stl || 0}<br>
                <strong>Minutes:</strong> ${stat.min || 0}<br>
              </li>
            `).join('')}
          </ul>
        `;
      }

    const urlParams = new URLSearchParams(window.location.search);
    const playerId = urlParams.get('id');
    const searchButton = document.getElementById('search-button');

    if (playerId) {
      getPlayerStats(playerId);
    }

    searchButton.addEventListener('click', function() {
      const yearInput = document.getElementById('year-input').value;
      if (yearInput) {
        getPlayerStats(playerId, yearInput);
      }
    });
  </script>
</body>
</html>
