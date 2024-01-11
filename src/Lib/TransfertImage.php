<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurMain;

class TransfertImage
{
    public static function transfert(): int|false
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
            $tempImage = imagecreatefromstring(file_get_contents($_FILES['pdp']['tmp_name']));
            imagesavealpha($tempImage, true);
            imagepng($tempImage, $_FILES['pdp']['tmp_name']);
            imagedestroy($tempImage);

            $_FILES['pdp']['name'] = "pp_" . ConnexionUtilisateur::getTypeConnecte() . "_" . ConnexionUtilisateur::getLoginUtilisateurConnecte() . ".png";
            //echo $_FILES['pdp']['name']; die();
            $ai_id = ControleurMain::uploadFichiers(['pdp'], "afficherProfil")['pdp'];
            return $ai_id;
        }
    }

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
