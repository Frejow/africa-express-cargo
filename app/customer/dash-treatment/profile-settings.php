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

    //die (var_dump($_POST['avatar_deletion']));

    //die ('dedans');

    
        if (update_avatar($data[0]['id'], 'null')) {

            if (select_user_updated_info($data[0]['id'])) {
    
                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                    header("location:".PROJECT."customer/dash/profile-settings?theme=light");
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                    header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
                } else {
                    header("location:".PROJECT."customer/dash/profile-settings?theme=light");
                }
    
                //header("location:".PROJECT."customer/dash/profile-settings");
                
            }
    
        }
    

}

if (isset($_POST['pass_w']) && !empty($_POST['pass_w']) && check_password($data[0]['id'], $_POST['pass_w'])) {

    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {

        if ($_FILES["fileToUpload"]["size"] <= 3000000) {

            $file_name = $_FILES["fileToUpload"]["name"];

            $file_info = pathinfo($file_name);

            $file_ext = $file_info["extension"];

            $allowed_ext = ["png", "jpg", "jpeg", "gif"];

            if (in_array($file_ext, $allowed_ext)) {

                $rootpath = $_SERVER['DOCUMENT_ROOT'].'/africa-express-cargo/public/images/uploads';

                $newfolder = $rootpath.'/'.$data[0]['id'].'/profile/';

                if (!file_exists($newfolder)) {

                    mkdir($newfolder, 0700, true);

                }

                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newfolder.'/' . basename($_FILES['fileToUpload']['name']));

                $newdata["avatar"] = PROJECT . 'public/images/uploads/'. $data[0]['id'] . '/profile/' . basename($_FILES['fileToUpload']['name']);

            } else {

                $error["avatar"] = "L'extension de votre fichier n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                $updata ['avatar'] = $file_name;

            }

        } else {

            $file_name = $_FILES["fileToUpload"]["name"];

            $error["avatar"] = "Fichier trop lourd. Poids maximum autorisé : 3mo";

            $updata ['avatar'] = $file_name;

        }
    } else {

        $newdata["avatar"] = $data[0]["avatar"];

    }

    if (isset($newdata["avatar"])) {

        if (update_avatar($data[0]['id'], $newdata['avatar'])) {

            if (select_user_updated_info($data[0]['id'])) {

                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                    header("location:".PROJECT."customer/dash/profile-settings?theme=light");
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                    header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
                } else {
                    header("location:".PROJECT."customer/dash/profile-settings?theme=light");
                }

                //header("location:".PROJECT."customer/dash/profile-settings");

            }

        }

    }

} elseif (isset($_POST['pass_w']) && !empty($_POST['pass_w']) && !check_password($data[0]['id'], $_POST['pass_w'])) {

    $error["pass_w"] = 'La tentative de mise à jour a échoué de l\'avatar. Mot de passe erroné. Réessayer !';

    $updata ['avatar'] = 'REESSAYER';


} elseif (isset($_POST['pass_w']) && empty($_POST['pass_w']) && !isset($_POST['avatar_deletion'])) {

    $error["pass_w"] = 'La tentative de mise à jour a échoué de l\'avatar. Aucun mot de passe n\'a été soumis. Réessayer !';

    $updata ['avatar'] = 'REESSAYER';

}  

if (!empty($error)){

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['avatar_error'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
    } else {
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    }

    //header("location:".PROJECT."customer/dash/profile-settings");

}

//Avatar Updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Personal Informations

if (isset($_POST['pass']) && !empty($_POST['pass']) && check_password($data[0]['id'], $_POST['pass'])) {

    if (isset($_POST['nom']) && !empty($_POST['nom']) && $_POST['nom'] != $data[0]['name']){
        $newdata ['nom'] = secure($_POST['nom']);
    }
    else {
        $newdata ['nom'] = $data[0]['name'];
    }

    if (isset($_POST['prenoms']) && !empty($_POST['prenoms']) && $_POST['prenoms'] != $data[0]['first_names']){
        $newdata ['prenoms'] = secure($_POST['prenoms']);
    } else {
        $newdata ['prenoms'] = $data[0]['first_names'];
    }

    if (isset($_POST['pseudo']) && !empty($_POST['pseudo']) && $_POST['pseudo'] != $data[0]['user_name']){
        $newdata ['pseudo'] = secure($_POST['pseudo']);
    } else {
        $newdata ['pseudo'] = $data[0]['user_name'];
    }

    if (isset($_POST['pays']) && !empty($_POST['pays']) && $_POST['pays'] != $data[0]['country']){
        $newdata ['pays'] = secure($_POST['pays']);
    } else {
        $newdata ['pays'] = $data[0]['country'];
    }

    $newdata ['mail'] = $data[0]['mail'];

    /*if ($_POST['mail'] != $data[0]['mail'] && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
        $newdata ['mail'] = $_POST['mail'];
    } else {
        $newdata ['mail'] = $data[0]['mail'];
    }*/

    if (isset($_POST['tel']) && !empty($_POST['tel']) && $_POST['tel'] != $data[0]['phone_number']){
        $newdata ['tel'] = secure($_POST['tel']);
    } else {
        $newdata ['tel'] = $data[0]['phone_number'];
    }

    if (update_personal_info($data[0]['id'], $newdata ['nom'], $newdata ['prenoms'], $newdata ['pseudo'], $newdata ['pays'], $newdata ['mail'], $newdata ['tel'])) {
        if (select_user_updated_info($data[0]['id'])){

            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                header("location:".PROJECT."customer/dash/profile-settings?theme=light");
            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
            } else {
                header("location:".PROJECT."customer/dash/profile-settings?theme=light");
            }

            //header("location:".PROJECT."customer/dash/profile-settings");

        }
    }

} elseif (isset($_POST['pass']) && !empty($_POST['pass']) && !check_password($data[0]['id'], $_POST['pass'])) {

    $_SESSION['personal_error'] = 'La tentative de mise à jour a échoué. Mot de passe erroné. Réessayer !';

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
    } else {
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    }
    
    //header("location:".PROJECT."customer/dash/profile-settings");

}

//Personal Informations

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Password Updating

if (isset($_POST['passw']) && !empty($_POST['passw']) && check_password($data[0]['id'], $_POST['passw'])) {

    if (isset($_POST['newpass']) && !empty($_POST['newpass']) && strlen(secure($_POST["newpass"])) >= 8){

        $newdata ['newpass'] = $_POST['newpass'];

        if (update_password($data[0]['mail'], sha1($newdata['newpass']))) {

            setcookie('crl', $_SESSION['current_url'], time() + 365 * 24 * 3600, '/');

            disconnected();

            setcookie(
                "psp",
                'psp',
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );

            setcookie('pass_data', '', time() - 3600, '/');

            header("location:".PROJECT."customer/login");

        }

    } else {

        $updata ['passw'] = $_POST['passw'];

        $updata ['newpass'] = $_POST['newpass'];

        $error['newpass'] = 'Veuillez remplir ce champs d\'un nouveau mot de passe de 08 caractères minimum.';

    }

} elseif (isset($_POST['passw']) && !empty($_POST['passw']) && !check_password($data[0]['id'], $_POST['passw'])) {

    $updata ['passw'] = $_POST['passw'];

    $error['passw'] = 'Mot de passe erroné. Réessayer !';

}

if (!empty($error)){

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['password_error'] = $error;

    if (isset($error['newpass'])) {
        $_SESSION['error_msg'] = isset($error['newpass']);
    } elseif (isset($error['passw'])) {
        $_SESSION['error_msg'] = isset($error['passw']);
    }

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
    } else {
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    }

    //header("location:".PROJECT."customer/dash/profile-settings");

}

//Password Updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Deactivation

if (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && check_password($data[0]['id'], $_POST['pass-w'])) {

    if (deactivated_account($data[0]['id'])) {

        disconnected(); 

        header("location:".PROJECT."customer/login");

    }

} elseif (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && !check_password($data[0]['id'], $_POST['pass-w'])) {

    $error['pass-w'] = 'Mot de passe erroné. Veuillez réessayer !';

}

if (!empty($error)){

    $_SESSION['error_msg'] = $error['pass-w'];
    //setcookie('error_msg', $error['pass-w'], time() + 365 * 24 * 3600, '/');

    //$_SESSION['deactivation_error'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
    } else {
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    }

    //header("location:".PROJECT."customer/dash/profile-settings");

}

//Deactivation

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Deletion

if (isset($_POST['pass--w']) && !empty($_POST['pass--w']) && check_password($data[0]['id'], $_POST['pass--w'])) {

    if (deleted_account($data[0]['id'])) {

        disconnected(); 

        header("location:".PROJECT."customer/login");

    }

} elseif (isset($_POST['pass--w']) && !empty($_POST['pass--w']) && !check_password($data[0]['id'], $_POST['pass--w'])) {

    $error['pass--w'] = 'Mot de passe erroné. Veuillez réessayer !';

}

if (!empty($error)){

    $_SESSION['error_msg'] = $error['pass--w'];

    //setcookie('error_msg', $error['pass--w'], time() + 365 * 24 * 3600, '/');

    //$_SESSION['deletion_error'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
        header("location:".PROJECT."customer/dash/profile-settings?theme=dark");
    } else {
        header("location:".PROJECT."customer/dash/profile-settings?theme=light");
    }

    //header("location:".PROJECT."customer/dash/profile-settings");

}

//Deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
