// script.js
const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search-input');
const playerList = document.getElementById('player-list');
const collectionList = document.getElementById('collection-list');


searchForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const searchQuery = searchInput.value;
  playerList.innerHTML = ''; // Clear previous search results

  if (searchQuery) {
    const players = await searchPlayers(searchQuery);
    displayPlayers(players);
  }
});

async function searchPlayers(query) {
  const response = await fetch(`https://www.balldontlie.io/api/v1/players?search=${query}&per_page=100`);
  const data = await response.json();

  // If the query is a single character, filter players whose names start with that letter and sort them
  if (query.length === 1) {
    const queryUppercase = query.toUpperCase();
    data.data = data.data.filter((player) => {
      const name = `${player.first_name} ${player.last_name}`.toUpperCase();
      return name.startsWith(queryUppercase);
    }).sort((a, b) => {
      const nameA = `${a.first_name} ${a.last_name}`.toUpperCase();
      const nameB = `${b.first_name} ${b.last_name}`.toUpperCase();
      if (nameA < nameB) {
        return -1;
      }
      if (nameA > nameB) {
        return 1;
      }
      return 0;
    });
  }

  return data.data;
}



function displayPlayers(players) {
  if (players.length === 0) {
    playerList.innerHTML = '<p>No players found.</p>';
    return;
  }

  const list = document.createElement('ul');
  players.forEach((player) => {
    const listItem = document.createElement('li');
    
    // Create a checkbox for each player
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = `player_${player.id}`;

    // Label for the checkbox with the player's name
    const label = document.createElement('label');
    label.textContent = `${player.first_name} ${player.last_name}`;
    label.setAttribute('for', `player_${player.id}`);

    // Create a stats button for each player
    const statsButton = document.createElement('button');
    statsButton.textContent = 'Stats';
    statsButton.addEventListener('click', () => {
      window.location.href = `players.php?id=${player.id}`; // Navigate to the player's stats page
    });

    listItem.appendChild(checkbox);
    listItem.appendChild(label);
    listItem.appendChild(statsButton); // Append the Stats button to the list item

    list.appendChild(listItem);
  });

  // Button to add selected players to the collection
  const addButton = document.createElement('button');
  addButton.textContent = 'Add Selected Players to Collection';
  addButton.addEventListener('click', addToCollection);

  playerList.appendChild(list);
  playerList.appendChild(addButton);

  // Save the players array to a global variable for later use in addToCollection function
  window.players = players;
}



async function addToCollection() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const selectedPlayers = [];

  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      const playerId = checkbox.id.replace('player_', '');
      const player = window.players.find((p) => p.id.toString() === playerId);
      if (player) {
        selectedPlayers.push({
          player_id: player.id,
          player_name: `${player.first_name} ${player.last_name}`
        });
      } else {
        console.log(`Player with id ${playerId} not found in the players array.`);
      }
    }
  });

  if (selectedPlayers.length === 0) {
    console.log('No players selected.');
    return;
  }

  const response = await fetch('add_to_collection.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(selectedPlayers),
  });

  if (response.ok) {
    // Players added successfully, update the collection list
    updateCollectionList();
  } else {
    console.error('Failed to add players to collection.');
  }
}




async function updateCollectionList() {
  const response = await fetch('get_collection2.php');
  const collection = await response.json();

  collectionList.innerHTML = '<h2>My Collection</h2>';
  if (collection.length === 0) {
    collectionList.innerHTML += '<p>Your collection is empty.</p>';
  } else {
    const list = document.createElement('ul');
    collection.forEach((item) => {
  const listItem = document.createElement('li');
  listItem.textContent = `${item.player_name} - ${item.date_added}`;

  const removeButton = document.createElement('button');
  removeButton.textContent = 'Remove';
  removeButton.setAttribute('data-item-id', item.id); // Add the item ID as a data attribute
  removeButton.addEventListener('click', removeFromCollection); // Register the click event

  listItem.appendChild(removeButton);
  list.appendChild(listItem);
});


  
    collectionList.appendChild(list);
  }
}
async function removeFromCollection(event) {
  const itemId = event.target.getAttribute('data-item-id'); // Get the item ID from the data attribute
  const response = await fetch('remove_from_collection.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ id: itemId }),
  });

  if (response.ok) {
    // Item removed successfully, update the collection list
    updateCollectionList();
  } else {
    console.error('Failed to remove item from collection.');
  }
}



// Initial update of the collection list
document.addEventListener('DOMContentLoaded', () => {
  updateCollectionList();
});
