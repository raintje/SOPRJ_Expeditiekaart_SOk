function AddItemPath(elem, source){
    if(elem.selectedIndex != 0){
        let sourceElem = document.getElementById(source);
        let tagElem = createTagElement(elem);

        sourceElem.appendChild(tagElem);

        // RemoveItemFromSelect(elem);
    }
}

function RemoveItemFromSelect(selectElement){
    selectElement.remove(selectElement.selectedIndex);
}

function createTagElement(elem){
    let text = elem.options[elem.selectedIndex].text;

    //tag (Main body)
    let tagElem = document.createElement("DIV");
    tagElem.classList.add("tag");

    //close button
    let closeElem = document.createElement("DIV");
    closeElem.classList.add("tag-close");
    closeElem.innerHTML = "x";
    closeElem.onclick = function() { RemoveItemPath(tagElem, elem) };

    //text
    let textElem = document.createElement("DIV");
    textElem.classList.add("tag-text");
    textElem.innerHTML = text;

    //hidden input
    let inputElem = document.createElement("INPUT");
    inputElem.setAttribute("type", "hidden");
    inputElem.setAttribute("name", "itemLinks[]");
    inputElem.setAttribute("value", elem.value);

    //append
    tagElem.appendChild(textElem);
    tagElem.appendChild(closeElem);
    tagElem.appendChild(inputElem);

    return tagElem;
}

function RemoveItemPath(tagElem, selectElem){
    let optionElem = document.createElement("OPTION");
    console.log(tagElem)
    optionElem.text = tagElem.querySelector(".tag-text").innerText;
    optionElem.setAttribute("value", tagElem.querySelector("Input").value);
    selectElem.add(optionElem);

    tagElem.parentNode.removeChild(tagElem);
}

function addRemoveToTags(){
    let tagElements = document.querySelectorAll("#item-links-container .tag");
    let selectContainer = document.getElementById("itemPathSelect");

    for(let i = 0; i < tagElements.length; i++){
        tagElements[i].querySelector(".tag-close").addEventListener("click", () => {
            RemoveItemPath(tagElements[i], selectContainer);
        });
    }
}

window.onload = () => {
    addRemoveToTags();
}

document.getElementById("itemPathSelect").onchange = function() {
    AddItemPath(this, 'item-links-container');
};
