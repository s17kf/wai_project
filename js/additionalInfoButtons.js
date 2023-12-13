
class ButtonData {
  constructor(id, relatedClass, data, prefix) {
    this._id = id;
    this.buttonElement = document.getElementById(id);
    this.relatedClass = relatedClass;
    this.data = data;
    this.decorator = s => prefix + s;
    this.active = false;
  }
}

function showAndSetupButtons() {
  let playersButton =
    new ButtonData("playersButton", "playersInfoJs", PLAYERS, "L. graczy: ");
  let ageButton =
    new ButtonData("ageButton", "ageInfoJs", AGES, "Wiek graczy: ");
  let timeButton =
    new ButtonData("timeButton", "timeInfoJs", TIMES, "Czas gry: ");

  let buttons = [playersButton, ageButton, timeButton];
  if (window.localStorage) {
    console.log("local storage supported");
    console.log("localStorage.length: " + localStorage.length);
    for (let i = 0; i < localStorage.length; ++i) {
      let key = localStorage.key(i);
      console.log(key + ": " + localStorage.getItem(key));
    }
    buttons.reverse().forEach(button => {
      const show = localStorage.getItem(button._id);
      if (!show) {
        console.log(button._id + " does not have stored value");
        return;
      }
      console.log("Stored for " + button._id + ": " + show);
      if (show === "true") {
        console.log("Show " + button.relatedClass);
        showInfo(button);
      }
    });
  }

  buttons.forEach(button => {
    button.buttonElement.style.display = "inline";
    button.buttonElement.addEventListener("click", () => {
      if (button.active)
        hideInfo(button);
      else
        showInfo(button);
    });
  });
}

function storeValue(key, value) {
  if (!window.localStorage) {
    return;
  }
  localStorage.setItem(key, value);
}

function showInfo(button) {
  const dict = button.data;
  for (let game in dict) {
    let players = dict[game];
    let div = document.getElementById(game);
    let parent = document.createElement("p");
    parent.className = button.relatedClass;
    parent.textContent = button.decorator(players);
    div.insertBefore(parent, div.childNodes[1]);
  }
  button.buttonElement.textContent = button.buttonElement.textContent.replace("Pokaż", "Ukryj");
  storeValue(button._id, true);
  button.active = true;
}

function hideInfo(button) {
  let elementsToRemove = document.getElementsByClassName(button.relatedClass);
  while (elementsToRemove[0]) {
    let playersInfo = elementsToRemove[0];
    let parent = playersInfo.parentElement;
    parent.removeChild(playersInfo);
    console.log("removed " + button.relatedClass + " for " + parent.id);
  }
  button.buttonElement.textContent = button.buttonElement.textContent.replace("Ukryj", "Pokaż");
  storeValue(button._id, false);
  button.active = false;
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
