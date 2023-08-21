const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search-input');
const playerList = document.getElementById('player-list');

searchForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const searchQuery = searchInput.value;
  playerList.innerHTML = ''; // Clear previous results

  if (searchQuery) {
    const players = await searchPlayers(searchQuery);
    displayPlayers(players);
  }
});

async function searchPlayers(query) {
  const response = await fetch(`https://www.balldontlie.io/api/v1/players?search=${query}&per_page=100`);
  const data = await response.json();
  return data.data;
}

function displayPlayers(players) {
  if (players.length === 0) {
    playerList.innerHTML = '<p>No players found.</p>';
    return;
  }

  const list = document.createElement('ol');
  players.forEach((player) => {
    const listItem = document.createElement('li');
    listItem.classList.add('player-item');

    const link = document.createElement('a');
    link.href = `players.html?id=${player.id}`; // Link to player's stats page
    link.textContent = `${player.first_name} ${player.last_name}`;

    listItem.appendChild(link);
    list.appendChild(listItem);
  });

  playerList.appendChild(list);
}
