<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['personal_error'] = [];
$_SESSION['data'] = [];

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

            $_SESSION['success_msg'] = 'Mise à jour effectuée avec succès';

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

        } else {

            $_SESSION['personal_error'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

        }

    } else {

        $_SESSION['personal_error'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer, si cela persiste, veuillez nous contacter !';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

    }

} elseif (isset($_POST['pass']) && !empty($_POST['pass']) && !checkSubmittedPassword($data['id'], $_POST['pass'])) {

    $_SESSION['personal_error'] = 'La tentative de mise à jour des informations personnelles a échoué. Mot de passe erroné. Réessayer !';

    $_SESSION['error_msg'] = 'Echec. Mot de passe erroné';

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

} elseif (isset($_POST['pass']) && empty($_POST['pass'])) {

    $_SESSION['personal_error'] = 'La tentative de mise à jour des informations personnelles a échoué. Aucun mot de passe n\'a été soumis. Réessayer !';

    $_SESSION['error_msg'] = 'Echec. Le champs mot de passe a été soumis vide. Ce champs est requis.';

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/profile-settings'));

}