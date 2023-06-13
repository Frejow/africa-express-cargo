<?php

$errors = '';

extract($_POST);

if (empty($pass) || empty($repass)) {
    $errors = "Les deux champs sont requis.";
}

if (!empty($pass) && strlen(secure($pass)) < 8) {
    $errors = "Le champs Nouveau mot de passe doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (!empty($pass) && strlen(secure($pass)) >= 8 && empty($repass)) {
    $errors = "Entrez votre mot de passe à nouveau dans le champs Confirmer mot de passe.";
}

if ((!empty($repass) && strlen(secure($pass)) >= 8 && $repass != $pass)) {
    $errors = "Mot de passe du champs Confirmer mot de passe erroné. Entrez le mot de passe du précédent champs.";
}

if (empty($errors)) {

    if (!empty($_COOKIE["passdata"])) {

        if (updatePassword($_COOKIE["passdata"], sha1($pass))){
    
            setcookie('passdata', '', time() - 3600, '/');

            $response = array('success' => true, 'message' => 'Mot de passe changer avec succès.', 'redirectUrl' => PROJECT."customer/login");

        }

    }

} else {

    $response = array('success' => false, 'message' => $errors);

}

header('Content-Type: application/json');
echo json_encode($response);