<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['avatar_error'] = [];
$_SESSION['personal_error'] = [];
$_SESSION['password_error'] = [];
$_SESSION['deactivation_error'] = [];
$_SESSION['deletion_error'] = [];
$_SESSION['data'] = [];

//Avatar Updating

if (isset($_POST["avatar_deletion"])) {

    if (updateAvatar($data['id'], 'null')) {

        if (!empty(getUserPersonalInf($data['id']))) {

            $_SESSION['connected_customer'] = getUserPersonalInf($data['id']);

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

        }
    }
}

if (isset($_POST['pass_w']) && !empty($_POST['pass_w']) && checkSubmittedPassword($data['id'], $_POST['pass_w'])) {

    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {

        if ($_FILES["fileToUpload"]["size"] <= 2000000) {

            $file_name = $_FILES["fileToUpload"]["name"];

            $file_info = pathinfo($file_name);

            $file_ext = $file_info["extension"];

            $allowed_ext = ["png", "jpg", "jpeg", "gif"];

            if (in_array(strtolower($file_ext), $allowed_ext)) {

                $rootpath = $_SERVER["DOCUMENT_ROOT"] . PROJECT . 'public/images/uploads';

                $newfolder = $rootpath . '/' . $data['id'] . '/profile/';

                if (!file_exists($newfolder)) {

                    mkdir($newfolder, 0700, true);
                }

                $move_uploaded_file = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newfolder . '/' . basename($_FILES['fileToUpload']['name']));

                if ($move_uploaded_file) {

                    $newdata["avatar"] = PROJECT . 'public/images/uploads/' . $data['id'] . '/profile/' . basename($_FILES['fileToUpload']['name']);

                }

            } else {

                $error["avatar"] = "L'extension de votre fichier n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                $updata['avatar'] = $file_name;

            }

        } else {

            $file_name = $_FILES["fileToUpload"]["name"];

            $error["avatar"] = "Fichier trop lourd. Poids maximum autorisé : 2mo";

            $updata['avatar'] = $file_name;
        }
        
    } else {

        $newdata["avatar"] = $data["avatar"];

        $error["avatar"] = "Veuillez importer une image.";

    }

    if (isset($newdata["avatar"])) {

        if (updateAvatar($data['id'], $newdata['avatar'])) {

            if (!empty(getUserPersonalInf($data['id']))) {

                $_SESSION['connected_customer'] = getUserPersonalInf($data['id']);

                header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

            }

        }

    }

} elseif (isset($_POST['pass_w']) && !empty($_POST['pass_w']) && !checkSubmittedPassword($data['id'], $_POST['pass_w'])) {

    $error["pass_w"] = 'La tentative de mise à jour de l\'avatar a échoué. Mot de passe erroné. Réessayer !';


} elseif (isset($_POST['pass_w']) && empty($_POST['pass_w']) && !isset($_POST['avatar_deletion'])) {

    $error["pass_w"] = 'La tentative de mise à jour de l\'avatar a échoué. Aucun mot de passe n\'a été soumis. Réessayer !';

}

if (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['avatar_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

//Avatar Updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Personal Informations

if (isset($_POST['pass']) && !empty($_POST['pass']) && checkSubmittedPassword($data['id'], $_POST['pass'])) {

    if (isset($_POST['nom']) && !empty($_POST['nom']) && $_POST['nom'] != $data['name']) {
        $newdata['nom'] = secure($_POST['nom']);
    } else {
        $newdata['nom'] = $data['name'];
    }

    if (isset($_POST['prenoms']) && !empty($_POST['prenoms']) && $_POST['prenoms'] != $data['first_names']) {
        $newdata['prenoms'] = secure($_POST['prenoms']);
    } else {
        $newdata['prenoms'] = $data['first_names'];
    }

    if (isset($_POST['pseudo']) && !empty($_POST['pseudo']) && $_POST['pseudo'] != $data['user_name']) {
        $newdata['pseudo'] = secure($_POST['pseudo']);
    } else {
        $newdata['pseudo'] = $data['user_name'];
    }

    if (isset($_POST['pays']) && !empty($_POST['pays']) && $_POST['pays'] != $data['country']) {
        $newdata['pays'] = secure($_POST['pays']);
    } else {
        $newdata['pays'] = $data['country'];
    }

    $newdata['mail'] = $data['mail'];

    if (isset($_POST['tel']) && !empty($_POST['tel']) && $_POST['tel'] != $data['phone_number']) {
        $newdata['tel'] = secure($_POST['tel']);
    } else {
        $newdata['tel'] = $data['phone_number'];
    }

    if (updatePersonalInf($data['id'], $newdata['nom'], $newdata['prenoms'], $newdata['pseudo'], $newdata['pays'], $newdata['mail'], $newdata['tel'])) {

        if (!empty(getUserPersonalInf($data['id']))) {

            $_SESSION['connected_customer'] = getUserPersonalInf($data['id']);

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

        } else {

            $_SESSION['personal_error'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

        }

    } else {

        $_SESSION['personal_error'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

    }

} elseif (isset($_POST['pass']) && !empty($_POST['pass']) && !checkSubmittedPassword($data['id'], $_POST['pass'])) {

    $_SESSION['personal_error'] = 'La tentative de mise à jour des informations personnelles a échoué. Mot de passe erroné. Réessayer !';

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

} elseif (isset($_POST['pass']) && empty($_POST['pass'])) {

    $_SESSION['personal_error'] = 'La tentative de mise à jour des informations personnelles a échoué. Aucun mot de passe n\'a été soumis. Réessayer !';

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

//Personal Informations

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Password Updating

if (isset($_POST['passw']) && !empty($_POST['passw']) && checkSubmittedPassword($data['id'], $_POST['passw'])) {

    if (isset($_POST['newpass']) && !empty($_POST['newpass']) && strlen(secure($_POST["newpass"])) >= 8) {

        $newdata['newpass'] = $_POST['newpass'];

        if (updatePassword($data['mail'], sha1($newdata['newpass']))) {

            setcookie('crl', $_SESSION['current_url'], time() + 365 * 24 * 3600, '/');

            disconnected();

            setcookie('psp', 'psp', time() + 365 * 24 * 3600, '/');

            //setcookie('pass_data', '', time() - 3600, '/');

            header("location:" . PROJECT . "customer/login");
        }

    } else {

        $updata['passw'] = $_POST['passw'];

        $updata['newpass'] = $_POST['newpass'];

        $error['newpass'] = 'Veuillez remplir ce champs d\'un nouveau mot de passe de 08 caractères minimum.';
    }

} elseif (isset($_POST['passw']) && !empty($_POST['passw']) && !checkSubmittedPassword($data['id'], $_POST['passw'])) {

    $updata['passw'] = $_POST['passw'];

    $error['passw'] = 'Mot de passe erroné. Réessayer !';

} elseif (isset($_POST['passw']) && empty($_POST['passw'])) {

    $error['passw'] = 'Ce champs est requis. Entrez votre mot de passe actuel.';

}

if (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['password_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

//Password Updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Deactivation

if (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && checkSubmittedPassword($data['id'], $_POST['pass-w'])) {

    if (deactivatedAccount($data['id'])) {

        disconnected();

        header("location:" . PROJECT . "customer/login");

    } else {

        $error['pass-w'] = '';

        header("location:" . PROJECT . "customer/login");

    }

} elseif (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && !checkSubmittedPassword($data['id'], $_POST['pass-w'])) {

    $error['pass-w'] = 'Mot de passe erroné. Veuillez réessayer !';

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

if (!empty($error)) {

    $_SESSION['deactivation_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

//Deactivation

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Deletion

if (isset($_POST['pass--w']) && !empty($_POST['pass--w']) && checkSubmittedPassword($data['id'], $_POST['pass--w'])) {

    if (deletedAccount($data['id'])) {

        disconnected();

        header("location:" . PROJECT . "customer/login");
    } else {

        $error['pass--w'] = '';

        header("location:" . PROJECT . "customer/login");

    }

} elseif (isset($_POST['pass--w']) && !empty($_POST['pass--w']) && !checkSubmittedPassword($data['id'], $_POST['pass--w'])) {

    $error['pass--w'] = 'Mot de passe erroné. Veuillez réessayer !';

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

if (!empty($error)) {

    $_SESSION['deletion_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

//Deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ((isset($error['pass_w']) && !empty($error['pass_w']))
    || (isset($_SESSION['personal_error']) && !empty($_SESSION['personal_error']))
    || (isset($error['passw']) && !empty($error['passw']))
    || (isset($error['pass-w']) && !empty($error['pass-w']))
    || (isset($error['pass--w']) && !empty($error['pass--w']))
    || (isset($error['avatar']) && !empty($error['avatar']))
    || (isset($error['newpass']) && !empty($error['newpass']))
) {
    //die ('yes');
    $_SESSION['error_msg'] = 'Echec. Causes probables : Mot de passe erroné ou violation de règles au niveau des champs de la section concernée par la mise à jour. Vérifiez puis réessayer.';

} else {
    //die ('yes');
    unset($_SESSION['error_msg']);

    $_SESSION['success_msg'] = 'Mise à jour effectuée avec succès';

}
