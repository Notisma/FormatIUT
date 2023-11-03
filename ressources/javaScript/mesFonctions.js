const myButton = document.getElementById("my-button");

myButton.addEventListener("click", afficherPopupDepotCV_LM);

function afficherPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.3";
}

function fermerPopupDepotCV_LM() {
        document.getElementById("popup").style.display = "none";
        document.getElementById("aGriser").style.opacity = "1";
}

function afficherPopupInfosEtu()  {
    document.getElementById("infosEtuCandidat").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.3";
}

function fermerPopupInfosEtu() {
    document.getElementById("infosEtuCandidat").style.display = "none";
    document.getElementById("aGriser").style.opacity = "1";
}
function updateImage(inputNumber) {
    const fileInput = document.getElementById("fd" + inputNumber);
    const noFileImage = document.getElementById("imageNonDepose" + inputNumber);
    const fileSelectedImage = document.getElementById("imageDepose" + inputNumber);

    if (fileInput.files.length > 0) {
        noFileImage.style.display = "none";
        fileSelectedImage.style.display = "inline-block";
    } else {
        noFileImage.style.display = "inline-block";
        fileSelectedImage.style.display = "none";
    }
}