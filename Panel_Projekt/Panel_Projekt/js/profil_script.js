function toggleEdit(field) {
    var textElement = document.getElementById(field + '_text');
    var inputElement = document.getElementById(field + '_input');
    
    if (inputElement.style.display === "none") {
        textElement.style.display = "none";
        inputElement.style.display = "inline";
    } else {
        textElement.style.display = "inline";
        inputElement.style.display = "none";
    }
}
