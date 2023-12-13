<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use GdImage;

class TransfertImage
{
    public static function transfert(): int|false
    {
        $taille_max = 1000000;
        $ret = is_uploaded_file($_FILES['pdp']['tmp_name']);

        if (!$ret) {
            echo "Problème de transfert";
            return false;
        } else { // Le fichier a bien été reçu
            $img_taille = $_FILES['pdp']['size'];

            if ($img_taille > $taille_max) {
                echo "Trop gros !";
                return false;
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
