
function hideElementOfClass(parentId, classToHide) {
  let parent = document.getElementById(parentId);
  let elementsToHide = parent.getElementsByClassName(classToHide);
  for (let i =0; i< elementsToHide.length; ++i) {
    let element = elementsToHide[i];
    element.style.display = "none";
  }
}

function addMouseHoverEffect() {
  const navMenuId = "navMenu";
  const classToHide = "foldable";

  let nav = document.getElementById(navMenuId);

  foldableElements = nav.getElementsByClassName(classToHide);

  hideElementOfClass(navMenuId, classToHide);
  for(let i = 0; i < foldableElements.length; ++i) {
    console.log(foldableElements[i]);
    let element = foldableElements[i];
    let foldableParent = element.parentElement;
    foldableParent.addEventListener("mouseover", () =>{
      element.style.display = "block";
    })
    foldableParent.addEventListener("mouseleave", () => {
      element.style.display = "none";
    })
  }
}
