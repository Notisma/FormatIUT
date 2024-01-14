function afficherPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.3";
}



function toggleExpand() {
    let element = document.getElementsByClassName("annotations")[0];
    let fleche = document.getElementsByClassName("interaction")[0];
    if (element.style.width !== "350px") {
        element.style.width = "350px";
        fleche.style.position="relative";
        fleche.style.right="40px";
        fleche.style.transform="rotate(180deg)";
        fleche.style.top="0";
        fleche.style.borderRadius="0 50px 50px 0";
        let divs = element.getElementsByTagName("div");
        for (var i = 0; i < divs.length; i++) {
            divs[i].style.display = "flex";
        }
    }
    else {
        fleche.style.transform="rotate(180deg)";
        element.style.width = "0px";

    }
}

function fermerPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "none";
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

function afficherPopupModifCV_LM() {
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

function afficherPopupCGU() {
    document.getElementById("cgu").style.display="flex";
    document.getElementById("center").style.opacity="0.3";
}
function fermerPopupCGU(){
    document.getElementById("cgu").style.display="none";
    document.getElementById("center").style.opacity="1";
}

function afficherPopupPremiereCo(indice) {
    let enfants = document.getElementById("popupPremiereCo").children;
    if (indice < 0 || indice >= enfants.length) {
        return;
    }

    document.getElementById("popupPremiereCo").style.display = "flex";
    document.getElementsByClassName("mainAcc")[0].style.opacity = "0.3";

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

function afficherSousMenu() {
    let sousMenu = document.getElementById("sousMenu");
    sousMenu.style.display = "flex";
}

function fermerSousMenu() {
    let sousMenu = document.getElementById("sousMenu");
    sousMenu.style.display = "none";
}

function afficherPageCompteAdmin(page) {
    if (page) {
        let elements = document.getElementsByClassName("mainAdmins");
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].id !== page) {
                elements[i].style.display = "none";
            } else {
                elements[i].style.display = "flex";
            }
        }

        let elements2 = document.getElementsByClassName("sousMenuAdmin");
        for (var j = 0; j < elements.length; j++) {
            if (elements2[j].className === "sousMenuAdmin " + page + "M") {
                elements2[j].id = "selection";
            } else {
                elements2[j].id = "";
            }
        }
    }
}

function afficherPageCompteEtu(page) {
    if (page) {
        let elements = document.getElementsByClassName("mainEtu");
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].id !== page) {
                elements[i].style.display = "none";
            } else {
                elements[i].style.display = "flex";
            }
        }

        let elements2 = document.getElementsByClassName("sousMenuEtu");
        for (var j = 0; j < elements.length; j++) {
            if (elements2[j].className === "sousMenuEtu " + page + "M") {
                elements2[j].id = "selection";
            } else {
                elements2[j].id = "";
            }
        }
    }
}

function afficherPageCompteEntr(page) {
    if (page) {
        let elements = document.getElementsByClassName("mainEntr");
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].id !== page) {
                elements[i].style.display = "none";
            } else {
                elements[i].style.display = "flex";
            }
        }

        let elements2 = document.getElementsByClassName("sousMenuEntr");
        for (var j = 0; j < elements.length; j++) {
            if (elements2[j].className === "sousMenuEntr " + page + "M") {
                elements2[j].id = "selection";
            } else {
                elements2[j].id = "";
            }
        }
    }
}

function decoAuto() {
    let element = document.getElementById("decoAuto");
    if (element.style.display !== "flex") {
        element.style.display = "flex";
    }
}
