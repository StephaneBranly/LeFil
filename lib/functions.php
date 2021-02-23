<?php
function clean_string($string)
{ 
    $url = $string;
    $url = preg_replace('#Ç#', 'C', $url);
    $url = preg_replace('#ç#', 'c', $url);
    $url = preg_replace('#è|é|ê|ë#', 'e', $url);
    $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
    $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
    $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
    $url = preg_replace('#ì|í|î|ï#', 'i', $url);
    $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
    $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
    $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
    $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
    $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
    $url = preg_replace('#ý|ÿ#', 'y', $url);
    $url = preg_replace('#Ý#', 'Y', $url);
    $url = preg_replace('# |\'#', '-', $url);
    $url = preg_replace('#\\\|\"#', '', $url);         
    return ($url);
}

function remove_balise($string)
{
    $url = $string;
    $url = preg_replace('#<[^>]+>#', ' ', $url);
     
    return ($url);
}

function show_clean_string($string)
{ 
    $url = $string;
    $url = preg_replace('^\\\^', '', $url);     
    return ($url);
}

function is_admin()
{
    return(secure_session('user')=='branlyst' && secure_session('connected'));
}

function resize_img($image_path,$image_dest,$max_size = 300,$qualite = 100,$type = 'auto',$upload = false)
{
    // Vérification que le fichier existe
    if(!file_exists($image_path)):
        return 'wrong_path';
    endif;

    if($image_dest == ""):
        $image_dest = $image_path;
    endif;

    // Extensions et mimes autorisés
    $extensions = array('jpg','jpeg','png','gif');
    $mimes = array('image/jpeg','image/gif','image/png');

    // Récupération de l'extension de l'image
    $tab_ext = explode('.', $image_path);
    $extension  = strtolower($tab_ext[count($tab_ext)-1]);

    // Récupération des informations de l'image
    $image_data = getimagesize($image_path);

    // Si c'est une image envoyé alors son extension est .tmp et on doit d'abord la copier avant de la redimentionner
    if($upload && in_array($image_data['mime'],$mimes)):
        copy($image_path,$image_dest);
        $image_path = $image_dest;

        $tab_ext = explode('.', $image_path);
        $extension  = strtolower($tab_ext[count($tab_ext)-1]);
    endif;

    // Test si l'extension est autorisée
    if (in_array($extension,$extensions) && in_array($image_data['mime'],$mimes)):

        // On stocke les dimensions dans des variables
        $img_width = $image_data[0];
        $img_height = $image_data[1];

        // On vérifie quel coté est le plus grand
        if($img_width >= $img_height && $type != "height"):

        // Calcul des nouvelles dimensions à partir de la largeur
            if($max_size >= $img_width):
                return 'no_need_to_resize';
            endif;

            $new_width = $max_size;
            $reduction = ( ($new_width * 100) / $img_width );
            $new_height = round(( ($img_height * $reduction )/100 ),0);

        else:

            // Calcul des nouvelles dimensions à partir de la hauteur
            if($max_size >= $img_height):
                return 'no_need_to_resize';
            endif;

            $new_height = $max_size;
            $reduction = ( ($new_height * 100) / $img_height );
            $new_width = round(( ($img_width * $reduction )/100 ),0);

        endif;

        // Création de la ressource pour la nouvelle image
        $dest = imagecreatetruecolor($new_width, $new_height);

        // En fonction de l'extension on prépare l'iamge
        switch($extension){
            case 'jpg':
            case 'jpeg':
                $src = imagecreatefromjpeg($image_path); // Pour les jpg et jpeg
                break;

        case 'png':
            $src = imagecreatefrompng($image_path); // Pour les png
            break;

        case 'gif':
            $src = imagecreatefromgif($image_path); // Pour les gif
            break;
        }

        // Création de l'image redimentionnée
        if(imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height)):

            // On remplace l'image en fonction de l'extension
            switch($extension){
                case 'jpg':
                case 'jpeg':
                    imagejpeg($dest , $image_dest, $qualite); // Pour les jpg et jpeg
                    break;

                case 'png':
                    $black = imagecolorallocate($dest, 0, 0, 0);
                    imagecolortransparent($dest, $black);

                    $compression = round((100 - $qualite) / 10,0);
                    imagepng($dest , $image_dest, $compression); // Pour les png
                    break;

                case 'gif':
                    imagegif($dest , $image_dest); // Pour les gif
                    break;
            }

            return 'success';

        else:
            return 'resize_error';
        endif;

    else:
        return 'no_img';
    endif;
  }
?>