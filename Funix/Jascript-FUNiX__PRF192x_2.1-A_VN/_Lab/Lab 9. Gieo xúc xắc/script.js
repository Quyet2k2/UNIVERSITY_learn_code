// // add, toggle
"use strict";

// // Selecting elements
// const player0El = document.querySelector('.player--0');
// const player1El = document.querySelector('.player--1');
// const score0El = document.querySelector('#score--0');
// const score1El = document.getElementById('score--1');
// const current0El = document.getElementById('current--0');
// const current1El = document.getElementById('current--1');

// const diceEl = document.querySelector('.dice');
// const btnNew = document.querySelector('.btn--new');
// const btnRoll = document.querySelector('.btn--roll');
// const btnHold = document.querySelector('.btn--hold');

// let scores, currentScore, activePlayer, playing;

// // Starting conditions
// const init = function () {
//   scores = [0, 0];
//   currentScore = 0;
//   activePlayer = 0;
//   playing = true;

//   score0El.textContent = 0;
//   score1El.textContent = 0;
//   current0El.textContent = 0;
//   current1El.textContent = 0;

//   diceEl.classList.add('hidden');
//   player0El.classList.remove('player--winner');
//   player1El.classList.remove('player--winner');
//   player0El.classList.add('player--active');
//   player1El.classList.remove('player--active');
// };
// init();

// const switchPlayer = function () {
//   document.getElementById(`current--${activePlayer}`).textContent = 0;
//   currentScore = 0;
//   activePlayer = activePlayer === 0 ? 1 : 0;
//   player0El.classList.toggle('player--active');
//   player1El.classList.toggle('player--active');
// };

// // Rolling dice functionality
// btnRoll.addEventListener('click', function () {
//   if (playing) {
//     // 1. Generating a random dice roll
//     const dice = Math.trunc(Math.random() * 6) + 1;

//     // 2. Display dice
//     diceEl.classList.remove('hidden');
//     diceEl.src = `./Lab 9. Gieo xúc xắc/dice-${dice}.png`;

//     // 3. Check for rolled 1
//     if (dice !== 1) {
//       // Add dice to current score
//       currentScore += dice;
//       document.getElementById(`current--${activePlayer}`).textContent =
//         currentScore;
//     } else {
//       // Switch to next player
//       switchPlayer();
//     }
//   }
// });

// btnHold.addEventListener('click', function () {
//   if (playing) {
//     // 1. Add current score to active player's score
//     scores[activePlayer] += currentScore;
//     // scores[1] = scores[1] + currentScore

//     document.getElementById(`score--${activePlayer}`).textContent =
//       scores[activePlayer];

//     // 2. Check if player's score is >= 100
//     if (scores[activePlayer] >= 100) {
//       // Finish the game
//       playing = false;
//       diceEl.classList.add('hidden');

//       document
//         .querySelector(`.player--${activePlayer}`)
//         .classList.add('player--winner');
//       document
//         .querySelector(`.player--${activePlayer}`)
//         .classList.remove('player--active');
//     } else {
//       // Switch to the next player
//       switchPlayer();
//     }
//   }
// });

// btnNew.addEventListener('click', init);

// /* README: Below here, I code it by myself. */

let dice = 0;
let scores = [0, 0];
const diceEL = document.querySelector(".dice");
const btnNew = document.querySelector(".btn--new");
const btnRoll = document.querySelector(".btn--roll");
const btnHold = document.querySelector(".btn--hold");

let playing = true;
diceEL.classList.add("hidden");
let currentPlayer = 0;
let currentPlayerEL = document.querySelector(`.player--${currentPlayer}`);

let currentScore = 0;
let currentScoreEL = document.getElementById(`current--${currentPlayer}`);

///////////////////////////////////////
function updateScore() {
  for (let i = 0; i < scores.length; i++)
    document.getElementById(`score--${i}`).textContent = scores[i];
}
updateScore();

function switchPlayer() {
  currentScoreEL.textContent = currentScore = 0;
  currentPlayerEL.classList.remove("player--active");

  // switch player
  currentPlayer = currentPlayer === 0 ? 1 : 0;
  currentScoreEL = document.getElementById(`current--${currentPlayer}`);
  currentPlayerEL = document.querySelector(`.player--${currentPlayer}`);
  currentPlayerEL.classList.add("player--active");
}

// Rolling dice functionality
btnRoll.addEventListener("click", function () {
  if (playing) {
    // 1. Generating a random dice roll
    dice = Math.trunc(Math.random() * 6 + 1);

    // 2. Display dice
    diceEL.classList.remove("hidden");
    diceEL.src = `./Lab 9. Gieo xúc xắc/dice-${dice}.png`;

    // 3. Check for rolled 1

    if (dice === 1) switchPlayer(); // Add dice to current score
    else currentScoreEL.textContent = currentScore += dice; // Switch to next player
  }
});

btnHold.addEventListener("click", function () {
  if (playing) {
    // 1. Add current score to active player's score
    scores[currentPlayer] += currentScore;
    updateScore();

    // 2. Check if player's score is >= 100
    if (scores[currentPlayer] >= 100) {
      // Finish the game
      playing = false;
      diceEL.classList.add("hidden");

      currentPlayerEL.classList.add("player--winner");
      // currentPlayerEL.classList.remove("player--active");
    } else {
      // Switch to the next player
      switchPlayer();
    }
  }
});

btnNew.addEventListener("click", function () {
  playing = true;
  scores = [0, 0];
  currentPlayer = 1;
  updateScore();

  diceEL.classList.add("hidden");
  currentScoreEL.textContent = currentScore = 0;
  currentPlayerEL.classList.remove("player--winner");
  currentPlayerEL.classList.remove("player--active");

  currentScoreEL = document.getElementById(`current--${currentPlayer}`);
  currentPlayerEL = document.querySelector(`.player--${currentPlayer}`);
  currentPlayerEL.classList.add("player--active");
});
