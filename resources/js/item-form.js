function AddItemPath(elem, source){
    if(elem.selectedIndex != 0){
        let sourceElem = document.getElementById(source);
        let tagElem = createTagElement(elem);

        sourceElem.appendChild(tagElem);

        RemoveItemFromSelect(elem);
    }
}

function RemoveItemPath(tagElem, selectElem, text, value){
    let optionElem = document.createElement("OPTION");
    optionElem.text = text;
    optionElem.setAttribute("value", value);
    selectElem.add(optionElem);

    tagElem.parentNode.removeChild(tagElem);
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
    closeElem.onclick = function() { RemoveItemPath(tagElem, elem, text, elem.value) };

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

window.onload = function(){
    document.getElementById("itemPathSelect").onchange = function() {
        AddItemPath(this, 'item-links-container');
    };
}