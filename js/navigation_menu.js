function createNavMenu() {
  let nav = document.getElementById('navMenu');
  let ul = document.createElement('ul');
  let mainPage = document.createElement('a');
  mainPage.setAttribute('href', 'index.html');
  mainPage.innerHTML = 'Main page';
  let secondPage = document.createElement('a');
  secondPage.innerHTML = 'Second page';

  appendChildAsListElement(ul, mainPage);
  appendChildAsListElement(ul, secondPage)

  nav.appendChild(ul);
}

function appendChildAsListElement(parent, element) {
  let li = document.createElement('li');
  li.appendChild(element)
  parent.appendChild(li);
}
