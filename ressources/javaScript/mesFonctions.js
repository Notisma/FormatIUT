function afficherPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "flex";
    document.getElementById("aGriser").style.opacity = "0.3";
}

function fermerPopupDepotCV_LM() {
    document.getElementById("popup").style.display = "none";
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
    document.getElementById("popupPremiereCo").style.display = "flex";
    document.getElementById("conteneurPrincipal").style.opacity = "0.3";

    // pour tous les enfants de popupPremiereCo, on affiche celui dont l'indice est passé en paramètre
    var enfants = document.getElementById("popupPremiereCo").children;
    for (var i = 0; i < enfants.length; i++) {
        enfants[i].style.display = "none";
    }
    enfants[indice].style.display = "flex";
}
