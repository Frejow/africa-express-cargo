<?php

$errors = '';

extract($_POST);

if (empty($m_ps) || empty($pass)) {
    $errors = 'Les deux champs sont requis.';
}

if (!empty($m_ps) && !empty($pass)) {

    $checkby_mail_password = retrieveUserbyEmailAndPassword($m_ps, $pass, 'ADMIN', 1, 1, 0);
    $checkby_username_password = retrieveUserbyPseudoAndPassword($m_ps, $pass, 'ADMIN', 1, 1, 0);

    if (!empty($checkby_mail_password) || !empty($checkby_username_password)) {

        if (!empty($checkby_mail_password)) {

            $_SESSION['connected_admin'] = $checkby_mail_password;

        } elseif (!empty($checkby_username_password)) {

            $_SESSION['connected_admin'] = $checkby_username_password;
            
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

    $redirectUrl = PROJECT.'admin/dash/noaddressee-packages-listings'.$theme;

    if (!empty($_COOKIE['crl'])) { $redirectUrl = $_COOKIE['crl']; }

  $response = array('success' => true, 'message' => 'Authentification réussie', 'redirectUrl' => $redirectUrl);

}

header('Content-Type: application/json');
echo json_encode($response);

