<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;

class TransfertImage
{
    public static function transfert($nom, string $controleur){
        $ret        = false;
        $img_blob   = '';
        $img_taille = 0;
        $img_type   = '';
        $img_nom    = '';
        $taille_max = 250000;
        $ret        = is_uploaded_file($_FILES['fic']['tmp_name']);

        if (!$ret) {
            echo "Problème de transfert";
            return false;
        } else {
            // Le fichier a bien été reçu
            $img_taille = $_FILES['fic']['size'];

            if ($img_taille > $taille_max) {
                echo "Trop gros !";
                return false;
            }

            $img_type = $_FILES['fic']['type'];
            $img_nom  = $_FILES['fic']['name'];

            $img_blob = file_get_contents ($_FILES['fic']['tmp_name']);
            if($controleur == "EtuMain") {
                $img_blob = file_get_contents(self::img_ronde($img_blob));
            }
            (new ImageRepository())->insert(["img_id"=>$_POST["img_id"],"img_nom"=>$nom,"img_taille"=>$img_taille,"img_type"=>$img_type,"img_blob"=>$img_blob]);
        }
    }

    public static function img_ronde(string $image)
    {

        if (!getimagesize($image)) {
            throw new Exception('L\'argument fourni n\'est pas une image.');
        }


        $image = imagecreatefromstring($image);
        $largeur = imagesx($image);
        $hauteur = imagesy($image);

        $nouvellesDimensions = 285;

        $image_ronde = imagecreatetruecolor($nouvellesDimensions, $nouvellesDimensions);
        imagealphablending($image_ronde, true);
        imagecopyresampled($image_ronde, $image, 0, 0, 0, 0, $nouvellesDimensions, $nouvellesDimensions, $largeur, $hauteur);


        $mask = imagecreatetruecolor($nouvellesDimensions, $nouvellesDimensions);

        $transparent = imagecolorallocate($mask, 0, 0, 0, 127);
        imagecolortransparent($mask, $transparent);

        imagefilledellipse($mask, $nouvellesDimensions / 2, $nouvellesDimensions / 2, $nouvellesDimensions, $nouvellesDimensions, $transparent);


        imagecopymerge($image_ronde, $mask, 0, 0, 0, 0, $nouvellesDimensions, $nouvellesDimensions, 100);


        imagecolortransparent($image_ronde, $transparent);


        imagedestroy($image);
        imagedestroy($mask);

        return $image_ronde;
    }


}