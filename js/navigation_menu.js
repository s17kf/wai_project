function createNavMenu() {
  let nav = document.getElementById('navMenu');
  let ul = document.createElement('ul');

  let menuEntries = JSON.parse(MENU_ENTRIES);
  console.log("Parse menu entries ...");
  for (let i = 0; i < menuEntries.length; ++i) {
    const entry = menuEntries[i];
    let page = document.createElement('a');
    page.setAttribute('href', entry.href);
    page.innerHTML = entry.name;
    console.log(menuEntries[i]);
    appendChildAsListElement(ul, page);
  }
  console.log("All menu entries parsed!")

  nav.appendChild(ul);
}

function appendChildAsListElement(parent, element) {
  let li = document.createElement('li');
  li.appendChild(element)
  parent.appendChild(li);
}

const MENU_ENTRIES = `
  [
    {
      "name": "Main page kurwa",
      "href": "index.html"
    },
    {
      "name": "Second kurwa page!",
      "href": "dupa.html"
    }
  ]
`
