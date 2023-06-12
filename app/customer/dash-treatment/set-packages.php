<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_pack_errors'] = [];
$_SESSION['success_msg'] = [];


if (isset($_POST['pack_trackN']) && !empty($_POST['pack_trackN'])) {

    if (!checkTrackingNumber(secure(strtoupper($_POST['pack_trackN'])))) {

        $newdata['pack_trackN'] = secure(strtoupper($_POST['pack_trackN']));

    } else {

        $error['pack_trackN'] = 'Ce numéro de suivi appartient déjà à un colis. Vérifier votre saisie.';

    }

    $updata['pack_trackN'] = secure($_POST['pack_trackN']);

} else {

    $error['pack_trackN'] = 'Ce champs est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide. Causes probables : Soit vous tentez effectivement de soumettre le formulaire avec un champs requis vide soit vous tentez une importation de fichier(s) lourds et dépassant la limite autorisée (Poids Max/Fichier : 2Mo).';

}

if (isset($_POST['pack_count']) && !empty($_POST['pack_count'])) {

    $newdata['pack_count'] = secure($_POST['pack_count']);
    $updata['pack_count'] = secure($_POST['pack_count']);

} else {

    $newdata['pack_count'] = 0;

}

if (isset($_POST['pack_cost']) && !empty($_POST['pack_cost'])) {

    $newdata['pack_cost'] = secure($_POST['pack_cost']);
    $updata['pack_cost'] = secure($_POST['pack_cost']);

} else {

    $newdata['pack_cost'] = 0;

}

if (isset($_POST['pack_descp']) && !empty($_POST['pack_descp'])) {

    $newdata['pack_descp'] = secure($_POST['pack_descp']);
    $updata['pack_descp'] = secure($_POST['pack_descp']);

} else {

    $error['pack_descp'] = 'Ce chamsp est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide. Causes probables : Soit vous tentez effectivement de soumettre le formulaire avec un champs requis vide soit vous tentez une importation de fichier(s) lourds et dépassant la limite autorisée (Poids Max/Fichier : 2Mo).';

}

if (isset($_POST['pack_type']) && !empty($_POST['pack_type'])) {

    $newdata['pack_type'] = secure($_POST['pack_type']);
    $updata['pack_type'] = secure($_POST['pack_type']);

} else {

    $newdata['pack_type'] = "-";

}

if (isset($_POST['pack_netW']) && !empty($_POST['pack_netW'])) {

    $newdata['pack_netW'] = secure($_POST['pack_netW']);
    $updata['pack_netW'] = secure($_POST['pack_netW']);

} else {

    $newdata['pack_netW'] = 0;

}

if (isset($_POST['pack_metricW']) && !empty($_POST['pack_metricW'])) {

    $newdata['pack_metricW'] = secure($_POST['pack_metricW']);
    $updata['pack_metricW'] = secure($_POST['pack_metricW']);

} else {

    $newdata['pack_metricW'] = 0;

}

if (isset($_FILES["filesToUpload"]) && !empty($_FILES["filesToUpload"])) { 

    $newdata['images'] = []; 

    if (sizeof($_FILES["filesToUpload"]['error']) <= 3) {

        foreach ($_FILES["filesToUpload"]['error'] as $key => $value) {

            if ($_FILES["filesToUpload"]['error'][$key] == 0) {
    
                if ($_FILES["filesToUpload"]["size"][$key] <= 2000000) { 
    
                    $file_name = $_FILES["filesToUpload"]["name"][$key];
    
                    $file_info = pathinfo($file_name);
    
                    $file_ext = $file_info["extension"];
    
                    $allowed_ext = ["png", "jpg", "jpeg", "gif"];
    
                    if (in_array(strtolower($file_ext), $allowed_ext)) {
    
                        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images';
    
                        $newfolder = $rootpath . '/uploads/' . $data['user_name'] . '/packages/' . $newdata['pack_trackN'] ;
    
                        if (!file_exists($newfolder)) {
    
                            mkdir($newfolder, 0700, true);
                        }
    
                        move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$key], $newfolder . '/' . basename($_FILES['filesToUpload']['name'][$key]));
    
                        $newdata["images"][$key] = PROJECT . 'public/images/uploads/' . $data['user_name'] . '/packages/' . $newdata['pack_trackN'] . '/' . basename($_FILES['filesToUpload']['name'][$key]);
                    
                    } else {

                        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images';
    
                        $newfolder = $rootpath . '/uploads/' . $data['user_name'] . '/packages/' . $newdata['pack_trackN'] ;
                        
                        if (is_dir($newfolder)) { 

                            deleteDir($newfolder);

                            $error["images"][$key] = "L'extension du fichier ".$file_name." n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
    
                            $updata['images'][$key] = $file_name;

                            $_SESSION['set_pack_errors'] = $error;

                            $_SESSION['data'] = json_encode($updata);

                            $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';

                            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                            exit;

                        } else {

                            $error["images"][$key] = "L'extension du fichier ".$file_name." n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
    
                            $updata['images'][$key] = $file_name;

                            $_SESSION['set_pack_errors'] = $error;

                            $_SESSION['data'] = json_encode($updata);

                            $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';

                            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                            exit;

                        }
    
                    }
                    
                } else {  

                    $file_name = $_FILES["filesToUpload"]["name"][$key]; 

                    $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images';
    
                    $newfolder = $rootpath . '/uploads/' . $data['user_name'] . '/packages/' . $newdata['pack_trackN'] ;

                    if (is_dir($newfolder)) { 

                        deleteDir($newfolder);

                        $error["images"][$key] = "Le fichier ".$file_name." est trop lourd. Poids maximum autorisé : 2mo";
    
                        $updata['images'][$key] = $file_name;

                        $_SESSION['set_pack_errors'] = $error;

                        $_SESSION['data'] = json_encode($updata);

                        $_SESSION['error_msg'] = 'Erreur niveau poids de fichier(s). Poids maximum autorisé : 2mo';

                        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                        exit;

                    } else {

                        $error["images"][$key] = "Le fichier ".$file_name." est trop lourd. Poids maximum autorisé : 2mo";
    
                        $updata['images'][$key] = $file_name;

                        $_SESSION['set_pack_errors'] = $error;

                        $_SESSION['data'] = json_encode($updata);

                        $_SESSION['error_msg'] = 'Erreur niveau poids de fichier(s). Poids maximum autorisé : 2mo';

                        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                        exit;

                    }
    
                }
            }
        } 

    } else {

        $updata['images'][0] = 'AJOUTER DES IMAGES [ TROIS (03) MAXIMUM ]';

        $_SESSION['data'] = json_encode($updata);

        $_SESSION['error_msg'] = 'Vous essayez une importation de plus de 03 fichiers.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

        exit;

    }
    
} else {

    $newdata['images'] = [];

}


if (empty($error)) {

    if (isset($_POST) && !empty($_POST)) {
    
        if (addPackage($newdata['pack_trackN'], $newdata['pack_count'], $newdata['pack_cost'], $newdata['pack_descp'], 
        $newdata['pack_netW'], $newdata['pack_metricW'], $newdata['pack_type'], $data['id'])) {

            if (!empty($newdata['images'])) {

                for ($i = 0; $i < sizeof($newdata['images']); $i++) {

                    if (!addImagesForPackage(getPackageId($newdata['pack_trackN'])['id'], $newdata['images'][$i], $data['id'])) {

                        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                        $_SESSION['data'] = json_encode($updata);

                        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                        exit;

                    } else {

                        $_SESSION['imgs_insertion'] = 'Done';

                    }
                }

                if (isset($_SESSION['imgs_insertion'])) {

                    $_SESSION['success_msg'] = 'Votre colis a été ajouté avec succès';

                    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

                } else {

                    $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                    $_SESSION['data'] = json_encode($updata);

                    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

                    exit;

                }

            } else {

                $_SESSION['success_msg'] = 'Votre colis a été ajouté avec succès';

                header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

            }

        } else {

            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

            $_SESSION['data'] = json_encode($updata);

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

            exit;

        }

    } else {

        $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier(s) lourds et dépassant la limite autorisée (Poids Max/Fichier : 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

        exit;
    }
    
} elseif (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_pack_errors'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages'));

}




