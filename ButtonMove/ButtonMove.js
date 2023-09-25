var runningTotal = 0;
var isMoving = false;
var buttons = [];

document.getElementById('makeButton').addEventListener('click', function() {
    var viewingArea = document.getElementById('viewingArea');
    var selectedColor = document.getElementById('colorSelect').value;
    var button = document.createElement('button');

    button.style.backgroundColor = selectedColor;
    button.style.left = Math.random() * (viewingArea.offsetWidth - button.offsetWidth) + 'px'; 
    button.style.top = Math.random() * (viewingArea.offsetHeight - button.offsetHeight) + 'px';
    var buttonText = Math.floor(Math.random() * 99) + 1;
    button.textContent = buttonText;

    button.addEventListener('click', function() {
        button.style.backgroundColor = document.getElementById('colorSelect').value;
        runningTotal += buttonText;
        document.getElementById('runningTotal').textContent = "Total: " + runningTotal;
    });

    buttons.push({
        button: button,
        dx: Math.random() > 0.5 ? 1 : -1,
        dy: Math.random() > 0.5 ? 1 : -1,
    });

    viewingArea.appendChild(button);
});

document.getElementById('moveButton').addEventListener('click', function() {
    isMoving = !isMoving;
    this.textContent = isMoving ? 'PAUSE' : 'MOVE';

    if(isMoving) {
        requestAnimationFrame(moveButtons);
    }
});

function moveButtons() {
    var viewingArea = document.getElementById('viewingArea');
    buttons.forEach(function(b) {
        var x = parseInt(b.button.style.left, 10);
        var y = parseInt(b.button.style.top, 10);
        var dx = b.dx;
        var dy = b.dy;
        var nextX = x + dx;
        var nextY = y + dy;

        if(nextX < 0 || nextX + b.button.offsetWidth > viewingArea.offsetWidth) {
            dx = -dx;
        }

        if(nextY < 0 || nextY + b.button.offsetHeight > viewingArea.offsetHeight) {
            dy = -dy;
        }

        b.button.style.left = x + dx + 'px';
        b.button.style.top = y + dy + 'px';
        b.dx = dx;
        b.dy = dy;
    });

    if(isMoving) {
        requestAnimationFrame(moveButtons);
    }
}
