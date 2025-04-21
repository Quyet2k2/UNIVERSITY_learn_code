"use strict";

let secretNumber = Math.trunc(Math.random() * 20) + 1;
console.log(secretNumber);

let score = 20;
let highScore = 0;

const displayMessage = (message) =>
  (document.querySelector(".message").textContent = message);

document.querySelector(".check").addEventListener("click", function () {
  const guess = Number(document.querySelector(".guess").value);

  // không nhập
  if (!guess) {
    displayMessage("⛔ No number!");
  } else if (document.querySelector(".number").textContent == secretNumber) {
    //   đã thắng và tiếp tục
    displayMessage("🥇 You won the game. Please play again!");
  } else if (guess < 1 || guess > 20) {
    //   sai phạm vi
    displayMessage("😒 Just only guess between 1 and 20!");
  } else if (guess === secretNumber && score > 0) {
    //   đoán đúng
    displayMessage("🎉 Correct number!");
    score > highScore ? (highScore = score) : (highScore = highScore);
    document.querySelector(".highscore").textContent = highScore;

    document.querySelector(".number").textContent = secretNumber;
    document.querySelector(".number").style.width = "30rem";
    document.querySelector("body").style.backgroundColor = "#60b347";
  } else if (score > 1) {
    //   đoán sai, trừ điểm, (score: 2 > 1), hiển thị gợi ý cho lần sau
    displayMessage(guess > secretNumber ? "📈 Too high!" : "📉 Too low!");
    document.querySelector(".score").textContent = --score;
  } else {
    //   thua
    displayMessage("💥 You lost the game!");
    document.querySelector(".score").textContent = score < 1 ? 0 : --score;
  }
  //   console.log(score);
});

document.querySelector(".again").addEventListener("click", function () {
  score = 20;
  secretNumber = Math.trunc(Math.random() * 20) + 1;

  displayMessage("Start guessing...");
  document.querySelector(".number").textContent = "?";
  document.querySelector(".number").style.width = "15rem";
  document.querySelector("body").style.backgroundColor = "#222";
  document.querySelector(".score").textContent = score;
  document.querySelector(".guess").value = "";

  console.clear();
  console.log(secretNumber);
});
