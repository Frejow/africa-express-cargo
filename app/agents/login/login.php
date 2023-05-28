<?php

$errors = '';
$access = $_POST["m_ps"];
$password = $_POST["pass"];

if (empty($access) || empty($password)) {
    $errors = 'Les deux champs sont requis.';
}

if (!empty($access) && !empty($password)) {

    $checkby_mail_password = retrieve_userby_email_and_password($access, $password, 'AGENT', 1, 1, 0);
    $checkby_username_password = retrieve_userby_pseudo_and_password($access, $password, 'AGENT', 1, 1, 0);

    if (!empty($checkby_mail_password) || !empty($checkby_username_password)) {

        if (!empty($checkby_mail_password)) {

            $_SESSION['connected'] = $checkby_mail_password;

        } elseif (!empty($checkby_username_password)) {

            $_SESSION['connected'] = $checkby_username_password;
            
        }

    } elseif (empty($checkby_mail_password) || empty($checkby_username_password)) {

        $errors = 'Identifiant incorrect, mot de passe incorrect, compte inactif ou inexistant.';

    }
}

if (!empty($errors)) {

  $response = array('success' => false, 'message' => $errors);

} else {
    
    $theme = '?theme=light';

    if (!empty($_COOKIE['thm'])) { $theme = $_COOKIE['thm']; }

    $redirectUrl = PROJECT.'agents/dash/noaddressee-packages-listings'.$theme;

    if (!empty($_COOKIE['crl'])) { $redirectUrl = $_COOKIE['crl']; }

  $response = array('success' => true, 'message' => 'Authentification réussie', 'redirectUrl' => $redirectUrl);

}

header('Content-Type: application/json');
echo json_encode($response);

