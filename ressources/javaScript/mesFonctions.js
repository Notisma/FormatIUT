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
function afficherPopupModifCV_LM(){
    document.getElementById("popupModif").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.3";
}
function fermerPopupModifCV_LM() {
    document.getElementById("popupModif").style.display = "none";
    document.getElementById("aGriser").style.opacity = "1";
}

function afficherPopupMdp() {
    document.getElementById("popupMdp").style.display = "flex";
    document.getElementById("center").style.opacity = "0.3";
}

function fermerPopupMdp() {
    document.getElementById("popupMdp").style.display = "none";
    document.getElementById("center").style.opacity = "1";
}


function afficherPopupPremiereCo(indice) {
    let enfants = document.getElementById("popupPremiereCo").children;
    if (indice < 0 || indice >= enfants.length) {
        return;
    }

    document.getElementById("popupPremiereCo").style.display = "flex";
    document.getElementById("conteneurPrincipal").style.opacity = "0.3";

    for (var i = 0; i < enfants.length; i++) {
        enfants[i].style.display = "none";
    }

    enfants[indice].style.display = "flex";
}

function fermerPopupPremiereCo() {
    document.getElementById("popupPremiereCo").style.display = "none";
    document.getElementById("conteneurPrincipal").style.opacity = "1";
}

function supprimerElement(id) {
    let element = document.getElementById(id);
    //si l'élément existe
    if (element) {
        element.style.display = "none";
    } else {
        alert("L'élément n'existe pas")
    }
}
