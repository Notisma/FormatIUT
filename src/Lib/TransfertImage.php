<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Controleur\ControleurMain;

class TransfertImage
{

    /**
     * @return int L'ID auto-incrémenté de l'image.
     * <br><br>
     * Méthode appelée quand il faut upload une image.
     * <br>
     * Gère les types, l'arrondissement si pp étudiant, la taille, la conversion et le nommage.
     * <br>
     * Après ça, la méthode appelle simplement uploadFichiers.
     */
    public static function transfert(): ?int
    {
        $taille_max = 1000000;
        $ret = is_uploaded_file($_FILES['pdp']['tmp_name']);

        if (!$ret) {
            ControleurMain::afficherErreur("Problème de transfert (mauvais type de fichier ?)");
            die();
        } else { // Le fichier a bien été reçu
            $img_taille = $_FILES['pdp']['size'];

            if ($img_taille > $taille_max) {
                ControleurMain::afficherErreur("Trop gros !");
                die();
            }
            // si l'upload est une nouvelle PP étudiant, on la rend ronde avant de l'importer
            if (ConnexionUtilisateur::getTypeConnecte() == "Etudiants") {
                $tmp_filename = $_FILES['pdp']['tmp_name'];
                if (exif_imagetype($tmp_filename)) {
                    $img = file_get_contents($tmp_filename);
                    $img_arrondie = self::getImageArrondieData($img);
                    file_put_contents($tmp_filename, $img_arrondie);
                }
            }

            //convert image to png
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower(pathinfo($_FILES['pdp']['name'], PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedExtensions)) {
                $tempImage = imagecreatefromstring(file_get_contents($_FILES['pdp']['tmp_name']));
                imagesavealpha($tempImage, true);
                imagepng($tempImage, $_FILES['pdp']['tmp_name']);
                imagedestroy($tempImage);

                $_FILES['pdp']['name'] = "pp_" . ConnexionUtilisateur::getTypeConnecte() . "_" . ConnexionUtilisateur::getLoginUtilisateurConnecte() . ".png";
                //echo $_FILES['pdp']['name']; die();
                $ai_id = ControleurMain::uploadFichiers(['pdp'], "afficherProfil")['pdp'];
                return $ai_id;
            }
            else{
                if(ConnexionUtilisateur::getTypeConnecte() == "Etudiants"){
                    ControleurEtuMain::redirectionFlash('afficherProfil', "danger", "Seuls les fichiers png, jpeg ou jpg sont acceptés" );
                }
                else if(ConnexionUtilisateur::getTypeConnecte() == "Entreprise"){
                    ControleurEntrMain::redirectionFlash('afficherProfil', "danger", "Seuls les fichiers png, jpeg ou jpg sont acceptés" );
                }
                else if(ConnexionUtilisateur::getTypeConnecte()== "Administateurs" || ConnexionUtilisateur::getTypeConnecte()== "Personnels" || ConnexionUtilisateur::getTypeConnecte()== "Secretariat"){
                    ControleurAdminMain::redirectionFlash('afficherProfil', "danger", "Seuls les fichiers png, jpeg ou jpg sont acceptés" );
                }
                return null;
            }
        }
    }

    /**
     * @param string $image
     * @return false|string, l'image en format texte
     * <br><br>Arrondit l'image. Méthode privée car utilisée dans transfert().
     */
    public static function getImageArrondieData(string $image): false|string
    {
        $image = imagecreatefromstring($image);
        $largeur = imagesx($image);
        $hauteur = imagesy($image);

        $nouvellesdimensions = 284;

        $image_ronde = imagecreatetruecolor($nouvellesdimensions, $nouvellesdimensions);
        imagealphablending($image_ronde, true);
        imagecopyresampled($image_ronde, $image, 0, 0, 0, 0, $nouvellesdimensions, $nouvellesdimensions, $largeur, $hauteur);

        $mask = imagecreatetruecolor($nouvellesdimensions, $nouvellesdimensions);

        $transparent = imagecolorallocate($mask, 255, 0, 0);
        imagecolortransparent($mask, $transparent);

        imagefilledellipse($mask, $nouvellesdimensions / 2, $nouvellesdimensions / 2, $nouvellesdimensions, $nouvellesdimensions, $transparent);

        $red = imagecolorallocate($mask, 0, 0, 0);
        imagecopymerge($image_ronde, $mask, 0, 0, 0, 0, $nouvellesdimensions, $nouvellesdimensions, 100);
        imagecolortransparent($image_ronde, $red);
        imagefill($image_ronde, 0, 0, $red);

        if (!$image_ronde) return false;

        ob_start();
        imagepng($image_ronde);
        return (ob_get_clean());
    }
}
