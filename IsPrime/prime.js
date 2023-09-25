// Joel Miller
// June 19, 2023
// CPSC 3750
// Program Exam #1
// Grade Level A

let primes = [];
let nonPrimes = [];

function isPrime(num) {
    for (let i = 2; i < num; i++) {
        if (num % i === 0) {
            return false;
        }
    }
    return num > 1;
} 

let previousNum = 0; // Track the previously entered number

function generateLists() {
    let num = Number(document.getElementById('number').value);

    // Check if the current number is the same as the previous number
    if (num === previousNum) {
        return; // Exit the function without clearing the lists
    }

    previousNum = num; // Update the previous number

    primes = [];
    nonPrimes = [];

    for (let i = 1; i <= num; i++) {
        if (isPrime(i)) {
            primes.push(i);
        } else {
            nonPrimes.push(i);
        }
    }

    document.getElementById('primeList').innerHTML = primes.join(', ');
    document.getElementById('nonPrimeList').innerHTML = nonPrimes.join(', ');

    document.getElementById('primeSum').innerHTML = ''; // Clear prime sum
    document.getElementById('nonPrimeSum').innerHTML = ''; // Clear non-prime sum
}



function calculateSum(list) {
    let sum = 0;
    if (list === 'prime') {
        sum = primes.reduce((a, b) => a + b, 0);
        document.getElementById('primeSum').innerHTML = `Sum of prime numbers: ${sum}`; // Update prime sum
    } else {
        sum = nonPrimes.reduce((a, b) => a + b, 0);
        document.getElementById('nonPrimeSum').innerHTML = `Sum of non-prime numbers: ${sum}`; // Update non-prime sum
    }
}


// Change list colors every 5 seconds
setInterval(() => {
    let randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
    document.getElementById('primeList').style.color = randomColor;

    randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
    document.getElementById('nonPrimeList').style.color = randomColor;
}, 5000);
