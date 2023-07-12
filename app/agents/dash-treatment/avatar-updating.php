<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['avatar_error'] = [];
$_SESSION['data'] = [];

if (isset($_POST["avatar_deletion"])) {

    if (updateAvatar($data['id'], 'null')) {

        if (!empty(getUserPersonalInf($data['id']))) {

            $_SESSION['connected_agent'] = getUserPersonalInf($data['id']);

            $_SESSION['success_msg'] = 'Mise à jour effectuée avec succès';

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

        } else {
    
            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

        }

    } else {
    
        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

    }

}

if (!empty($_POST['pass_w']) && checkSubmittedPassword($data['id'], $_POST['pass_w'])) {

    if (!empty($_FILES['fileToUpload'])) {

        if ($_FILES["fileToUpload"]["error"] == 0) {

            if ($_FILES["fileToUpload"]["size"] <= 2000000) {

                $file_name = $_FILES["fileToUpload"]["name"];
    
                $file_info = pathinfo($file_name);
    
                $file_ext = $file_info["extension"];
    
                $allowed_ext = ["png", "jpg", "jpeg", "gif"];
    
                if (in_array(strtolower($file_ext), $allowed_ext)) {
    
                    $rootpath = $_SERVER["DOCUMENT_ROOT"] . PROJECT . 'public/images';
    
                    $newfolder = $rootpath . '/uploads/' . $data['user_name'] . '/profile/';
    
                    if (!file_exists($newfolder)) {
    
                        mkdir($newfolder, 0700, true);
                    }
    
                    $move_uploaded_file = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newfolder . '/' . basename($_FILES['fileToUpload']['name']));
    
                    if ($move_uploaded_file) {
    
                        $newdata["avatar"] = PROJECT . 'public/images/uploads/' . $data['user_name'] . '/profile/' . basename($_FILES['fileToUpload']['name']);
    
                    }
    
                } else {
    
                    $error["avatar"] = "L'extension de votre fichier n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
    
                    $updata['avatar'] = $file_name;
    
                    $_SESSION['error_msg'] = 'Echec. Extension non prise en charge. Extensions autorisées [ PNG/JPG/JPEG/GIF ]';
    
                }
    
            } else {
    
                $file_name = $_FILES["fileToUpload"]["name"];
    
                $error["avatar"] = "Fichier trop lourd. Poids maximum autorisé : 2Mo";
    
                $updata['avatar'] = $file_name;
    
                $_SESSION['error_msg'] = 'Echec. Fichier lourd. Poids maximal : 2Mo';
    
            }
        } else {

            $_SESSION['error_msg'] = 'Une erreur est survenue avec ce fichier. Il se peut que votre fichier pèse plus que le poids maximal autorisé. Réessayer avec un autre fichier image. Si cela persiste, contactez nous !';
        
            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

        }
        
    } else {

        $newdata["avatar"] = $data["avatar"];

        $error["avatar"] = "Veuillez importer une image.";

        $_SESSION['error_msg'] = 'Echec. Aucune importation effectuée';

    }

    if (isset($newdata["avatar"])) {

        if (isset($_POST) && !empty($_POST)) {

            if (updateAvatar($data['id'], $newdata['avatar'])) {

                if (!empty(getUserPersonalInf($data['id']))) {

                    $_SESSION['connected_agent'] = getUserPersonalInf($data['id']);
    
                    $_SESSION['success_msg'] = 'Mise à jour effectuée avec succès';
    
                    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));
    
                } else {
        
                    $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, contactez nous !';
        
                    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));
        
                }
     
            } else {
        
                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';
    
                header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));
    
            }

        } elseif (isset($_POST) && empty($_POST) && !isset($_POST['avatar_deletion'])) { 

            $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier lourd et dépassant la limite autorisée (Poids Max : 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

            exit;

        }

    }

} elseif (isset($_POST['pass_w']) && !empty($_POST['pass_w']) && !checkSubmittedPassword($data['id'], $_POST['pass_w'])) {

    $error["pass_w"] = 'La tentative de mise à jour de l\'avatar a échoué. Mot de passe erroné. Réessayer !';

    $_SESSION['error_msg'] = 'Echec. Mot de passe erroné';

} elseif (isset($_POST['pass_w']) && empty($_POST['pass_w']) && !isset($_POST['avatar_deletion'])) {

    $error["pass_w"] = 'La tentative de mise à jour de l\'avatar a échoué. Aucun mot de passe n\'a été soumis. Réessayer !';

    $_SESSION['error_msg'] = 'Echec. Le champs mot de passe a été soumis vide. Ce champs est requis.';

} elseif (!isset($_POST['pass_w']) && empty($_POST['pass_w']) && !isset($_POST['avatar_deletion'])) { 

    $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier lourd et dépassant la limite autorisée (Poids Max : 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

    exit;

}

if (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['avatar_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/profile-settings'));

}
