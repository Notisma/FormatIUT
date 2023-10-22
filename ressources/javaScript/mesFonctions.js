const myButton = document.getElementById("my-button");

myButton.addEventListener("click", afficherPopupDepotCV_LM);

function afficherPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.5";
}

function fermerPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("aGriser").style.opacity = "1";
}