<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['password_error'] = [];
$_SESSION['data'] = [];

if (isset($_POST['passw']) && !empty($_POST['passw']) && checkSubmittedPassword($data['id'], $_POST['passw'])) {

    if (isset($_POST['newpass']) && !empty($_POST['newpass']) && strlen(secure($_POST["newpass"])) >= 8) {

        $newdata['newpass'] = $_POST['newpass'];

        if (updatePassword($data['mail'], sha1($newdata['newpass']))) {

            setcookie('crl', $_SESSION['customer_current_url'], time() + 365 * 24 * 3600, '/');

            disconnected();

            $_SESSION['success_msg'] = 'Mise à jour de mot de passe effectuée avec succès. Reconnectez vous avec votre nouveau mot de passe.';

            setcookie('psp', 'psp', time() + 365 * 24 * 3600, '/');

            header("location:" . PROJECT . "customer/login");
        } else {

            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';
    
            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));
    
        }

    } else {

        $updata['passw'] = $_POST['passw'];

        $updata['newpass'] = $_POST['newpass'];

        $error['newpass'] = 'Veuillez remplir ce champs d\'un nouveau mot de passe de 08 caractères minimum.';

        $_SESSION['error_msg'] = 'Echec. Veuillez remplir le champs nouveau mot de passe de 08 caractères minimum';

    }

} elseif (isset($_POST['passw']) && !empty($_POST['passw']) && !checkSubmittedPassword($data['id'], $_POST['passw'])) {

    $updata['passw'] = $_POST['passw'];

    $error['passw'] = 'Mot de passe erroné. Réessayer !';

    $_SESSION['error_msg'] = 'Echec. Mot de passe erroné. Réessayer !';

} elseif (isset($_POST['passw']) && empty($_POST['passw'])) {

    $error['passw'] = 'Ce champs est requis. Entrez votre mot de passe actuel.';

    $_SESSION['error_msg'] = 'Echec. Le champs du mot de passe est vide. Ce champs est requis.';

}

if (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['password_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}