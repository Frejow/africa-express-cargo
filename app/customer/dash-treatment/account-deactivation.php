<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['deactivation_error'] = [];
$_SESSION['data'] = [];


if (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && check_submitted_password($data['id'], $_POST['pass-w'])) {

    if (deactivated_account($data['id'])) {

        disconnected();

        $_SESSION['success_msg'] = 'Compte désactivé avec succès';

        header("location:" . PROJECT . "customer/login");

    } else {

        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

    }

} elseif (isset($_POST['pass-w']) && !empty($_POST['pass-w']) && !check_submitted_password($data['id'], $_POST['pass-w'])) {

    $error['pass-w'] = 'Mot de passe erroné. Veuillez réessayer !';

    $_SESSION['error_msg'] = 'Echec. Mot de passe erroné';

} elseif (isset($_POST['pass-w']) && empty($_POST['pass-w'])) {

    $error['pass-w'] = 'Le mot de passe est requis.';

    $_SESSION['error_msg'] = 'Echec. Le mot de passe est requis.';

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}

if (!empty($error)) {

    $_SESSION['deactivation_error'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}