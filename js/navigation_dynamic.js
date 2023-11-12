
function addMouseHoverEffect() {

  let nav = document.getElementById("navMenu");
  let pages = nav.childNodes;

  foldableElements = nav.getElementsByClassName("foldable");

  for(let i = 0; i < foldableElements.length; ++i) {
    console.log(foldableElements[i]);
    let element = foldableElements[i];
    let foldableParent = element.parentElement;
    element.style.display = "none";
    foldableParent.addEventListener("mouseover", () =>{
      element.style.display = "block";
    })
    foldableParent.addEventListener("mouseleave", () => {
      element.style.display = "none";
    })
  }
}
