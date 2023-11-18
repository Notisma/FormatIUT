<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use GdImage;

class TransfertImage
{
    public static function transfert($nom)
    {
        $ret = false;
        $img_blob = '';
        $img_taille = 0;
        $img_type = '';
        $img_nom = '';
        $taille_max = 1000000;
        $ret = is_uploaded_file($_FILES['pdp']['tmp_name']);

        if (!$ret) {
            echo "Problème de transfert";
            return false;
        } else {
            // Le fichier a bien été reçu
            $img_taille = $_FILES['pdp']['size'];

            if ($img_taille > $taille_max) {
                echo "Trop gros !";
                return false;
            }

            $img_type = $_FILES['pdp']['type'];
            $img_nom = $_FILES['pdp']['name'];

            $img_blob = file_get_contents($_FILES['pdp']['tmp_name']);
            if ($_REQUEST["controleur"] == "EtuMain") {
                $image = self::img_ronde($img_blob);
                $img_blob = self::image_data($image);
            }
            (new ImageRepository())->insert(["img_id" => $_REQUEST["img_id"], "img_nom" => $nom, "img_taille" => $img_taille, "img_type" => $img_type, "img_blob" => $img_blob]);
        }
        return true;
    }

    public static function img_ronde(string $image) {
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

        imagefilledellipse($mask, $nouvellesdimensions/2, $nouvellesdimensions/2, $nouvellesdimensions, $nouvellesdimensions, $transparent);

        $red = imagecolorallocate($mask, 0, 0, 0);
        imagecopymerge($image_ronde, $mask, 0, 0, 0, 0, $nouvellesdimensions, $nouvellesdimensions, 100);
        imagecolortransparent($image_ronde, $red);
        imagefill($image_ronde, 0, 0, $red);

        return $image_ronde;
    }

    private static function image_data($gdimage){
        ob_start();
        imagepng($gdimage);
        return(ob_get_clean());
    }

}