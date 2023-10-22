const myButton = document.getElementById("my-button");

myButton.addEventListener("click", afficherDiv);

function afficherDiv() {
    document.getElementById("popup").style.display = "flex";
}

function fermerDiv() {
    document.getElementById("popup").style.display = "none";
}