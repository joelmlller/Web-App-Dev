// Get DOM elements
const audioPlayer = document.getElementById('file-name');
const playlist = document.getElementById('playlist');
const playPauseBtn = document.getElementById('play-pause-btn');
const rewindBtn = document.getElementById('rewind-btn');
const forwardBtn = document.getElementById('forward-btn');
const currentTimeDisplay = document.getElementById('current-time');
const addTitleBtn = document.getElementById('add-title-btn');
const removeTitleBtn = document.getElementById('remove-title-btn');

// Create an array to store titles
let titles = [
  { title: 'Title 1', time: 0 },
  { title: 'Title 2', time: 120 },
  { title: 'Title 3', time: 240 },
  // Add more titles as needed
];

// Function to display the playlist
function displayPlaylist() {
  playlist.innerHTML = '';
  titles.forEach((title, index) => {
    const button = document.createElement('button');
    button.textContent = title.title;
    button.addEventListener('click', () => {
      playSegment(title.time);
    });
    playlist.appendChild(button);
  });
}

// Function to play a segment of the audio
function playSegment(time) {
  audioPlayer.currentTime = time;
  audioPlayer.play();
}

// Function to rewind 5 seconds
function rewind() {
  audioPlayer.currentTime -= 5;
}

// Function to forward 5 seconds
function forward() {
  audioPlayer.currentTime += 5;
}

// Function to toggle play/pause
function togglePlayPause() {
  if (audioPlayer.paused) {
    audioPlayer.play();
    playPauseBtn.textContent = 'Pause';
  } else {
    audioPlayer.pause();
    playPauseBtn.textContent = 'Play';
  }
}

// Function to display current time
function displayCurrentTime() {
  currentTimeDisplay.textContent = `Current Time: ${audioPlayer.currentTime.toFixed(2)}s`;
}

// Function to add a new title
function addTitle() {
  const newTitle = prompt('Enter the title:');
  if (newTitle) {
    const currentTime = audioPlayer.currentTime;
    const newTitleObj = { title: newTitle, time: currentTime };
    titles.push(newTitleObj);
    titles.sort((a, b) => a.time - b.time);
    displayPlaylist();
  }
}

// Function to remove the current title
function removeTitle() {
  const currentTitleIndex = titles.findIndex((title) => title.time === audioPlayer.currentTime);
  if (currentTitleIndex !== -1) {
    titles.splice(currentTitleIndex, 1);
    displayPlaylist();
  }
}
// ...

// Function to display the file name
function displayFileName() {
    const filePath = audioPlayer.src;
    const fileName = filePath.substring(filePath.lastIndexOf('/') + 1);
    const fileNameDisplay = document.getElementById('file-name');
    fileNameDisplay.textContent = fileName;
  }
  
  // Event listeners
  // ...
  
  audioPlayer.addEventListener('loadedmetadata', displayFileName);
  
  // ...
  
// Event listeners
audioPlayer.addEventListener('timeupdate', displayCurrentTime);
playPauseBtn.addEventListener('click', togglePlayPause);
rewindBtn.addEventListener('click', rewind);
forwardBtn.addEventListener('click', forward);
addTitleBtn.addEventListener('click', addTitle);
removeTitleBtn.addEventListener('click', removeTitle);

// Initial setup
displayPlaylist();
