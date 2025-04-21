'use strict';

let secretNumber = Math.trunc(Math.random() * 20) + 1;
console.log(secretNumber);
let score = 20;
let highScore = 0;

// TỐI ƯU CODE
function displayMessage(message) {
  document.querySelector('.message').textContent = message;
}

document.querySelector('.check').addEventListener('click', function () {
  const guess = Number(document.querySelector('.guess').value);

  if (!guess) {
    displayMessage('⛔️ No number');

    //   Trường hợp thắng và vẫn tiếp tục
  } else if (document.querySelector('.number').textContent == secretNumber) {
    displayMessage('🎉 You won, please play again!');

    //   Trường hợp đoán ngoài phạm vi
  } else if (guess < 1 || guess > 20) {
    displayMessage('😒 Number just between 1 and 20!');

    //   Trường hợp đoán đúng và chưa thua
    // } else if (guess === secretNumber && score > 1) { // BUG: bỏ qua điểm 1
  } else if (guess === secretNumber && score > 0) {
    displayMessage('🎉 Correct answer!');
    document.querySelector('.number').textContent = secretNumber;

    document.querySelector('.number').style.width = '30rem';
    document.querySelector('body').style.backgroundColor = '#60b347';

    score > highScore ? (highScore = score) : (highScore = highScore);
    document.querySelector('.highscore').textContent = highScore;

    //   Số đoán sai và chưa thua
  } else if (score > 1) {
    displayMessage(guess > secretNumber ? '📈 Too high!' : '📉 Too low!');
    document.querySelector('.score').textContent = --score;

    //   Trường hợp thua
  } else {
    document.querySelector('.message').textContent = '💥 You lost the game!';
    document.querySelector('.score').textContent = score < 1 ? 0 : --score;
  }
  // console.log(score);
});

// Nhấn nút again để bắt đầu ván chơi mới!
document.querySelector('.again').addEventListener('click', function () {
  score = 20;
  secretNumber = Math.trunc(Math.random() * 20) + 1;

  displayMessage('Start guessing...');
  document.querySelector('.guess').value = '';
  document.querySelector('.number').textContent = '?';
  document.querySelector('.score').textContent = score;

  document.querySelector('.number').style.width = '15rem';
  document.querySelector('body').style.backgroundColor = '#222';

  console.clear();
  console.log(secretNumber);
});

///////////////////////////////// code nguyên thủy
// document.querySelector('.check').addEventListener('click', function () {
//   const guess = Number(document.querySelector('.guess').value);

//   if (!guess) {
//     document.querySelector('.message').textContent = '⛔️ No number';

//     //   Trường hợp đoán đúng
//   } else if (guess === secretNumber && score > 1) {
//     document.querySelector('.message').textContent = '🎉 Correct answer!';
//     document.querySelector('.number').style.width = '30rem';
//     document.querySelector('body').style.backgroundColor = '#60b347';
//     document.querySelector('.number').textContent = secretNumber;
//     score > highScore ? (highScore = score) : (highScore = highScore);
//     document.querySelector('.highscore').textContent = highScore;

//     //   Số đoán lớn hơn số bí mật
//   } else if (guess > secretNumber && score > 1) {
//     document.querySelector('.message').textContent = '📈 Too high!';
//     document.querySelector('.score').textContent = --score;

//     //   Số đoán nhỏ hơn số bí mật
//   } else if (guess < secretNumber && score > 1) {
//     document.querySelector('.message').textContent = '📉 Too low!';
//     document.querySelector('.score').textContent = --score;

//     //   Trường hợp thua
//   } else {
//     document.querySelector('.message').textContent = '💥 You lost the game!';
//     document.querySelector('.score').textContent = 0;
//   }
// });

// // Nhấn nút again để bắt đầu ván chơi mới!
// document.querySelector('.again').addEventListener('click', function () {
//   document.querySelector('.guess').value = '';
//   document.querySelector('.number').textContent = '?';
//   document.querySelector('.number').style.width = '15rem';
//   document.querySelector('body').style.backgroundColor = '#222';
//   document.querySelector('.message').textContent = 'Start guessing...';
//   console.clear();
//   score = 20;
//   document.querySelector('.score').textContent = score;
//   secretNumber = Math.trunc(Math.random() * 20) + 1;
//   console.log(secretNumber);
// });
