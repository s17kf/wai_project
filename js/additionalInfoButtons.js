
const PLAYERS_CLASS = "playersInfoJs";
const AGE_CLASS = "ageInfoJs";
const TIME_CLASS = "timeIndoJs";

function showAndSetupButtons() {

  let playersButton = document.getElementById("playersButton");
  let ageButton = document.getElementById("ageButton");
  let timeButton = document.getElementById("timeButton");

  playersButton.style.display = "inline";
  ageButton.style.display = "inline";
  timeButton.style.display = "inline";

  playersButton.addEventListener("click", () => {
    if (playersButton.textContent === "Pokaż graczy")
      showPlayers(playersButton, PLAYERS_CLASS, PLAYERS, s => "L. graczy: " + s);
    else
      hidePlayers(playersButton, PLAYERS_CLASS);
  });
  ageButton.addEventListener("click", () => {
    if (ageButton.textContent === "Pokaż wiek")
      showPlayers(ageButton, AGE_CLASS, AGES, s => "Wiek graczy: " + s);
    else
      hidePlayers(ageButton, AGE_CLASS);
  });
  timeButton.addEventListener("click", () => {
    if (timeButton.textContent === "Pokaż czas gry")
      showPlayers(timeButton, TIME_CLASS, TIMES, s => "Czas gry: " + s);
    else
      hidePlayers(timeButton, TIME_CLASS);
  });
}


function showPlayers(button, pClass, dict, decorator) {
  for (let game in dict) {
    let players = dict[game];
    console.log(game + " => " + players);
    let div = document.getElementById(game);
    let p = document.createElement("p");
    p.className = pClass;
    p.textContent = decorator(players);
    div.insertBefore(p, div.childNodes[2]);
  }
  button.textContent = button.textContent.replace("Pokaż", "Ukryj");
}

function hidePlayers(button, pClass) {
  let playersInfos = document.getElementsByClassName(pClass);
  while (playersInfos[0]) {
    let playersInfo = playersInfos[0];
    let parent = playersInfo.parentElement;
    parent.removeChild(playersInfo);
    console.log("removed players for " + parent.id);
  }
  let playersButton = document.getElementById("playersButton");
  button.textContent = button.textContent.replace("Ukryj", "Pokaż");
}

const PLAYERS = {
  "catan": "3-4",
  "cytadela": "2-8",
  "mars-terraformation": "1-5",
  "unicorns": "2-8"
}

const AGES = {
  "catan": "10+",
  "cytadela": "10+",
  "mars-terraformation": "12+",
  "unicorns": "14+"
}

const TIMES = {
  "catan": "75min",
  "cytadela": "30-60min",
  "mars-terraformation": "90-120min",
  "unicorns": "30-60min"
}
