<?php

$errors = '';

secure(extract($_POST));

if (empty($mail)) {

    $errors = "Le champs email est requis";
    
} else {

    if (!checkFieldEntry('user', 'mail', $mail)) {

        $errors = $mail . " n'est associé à aucun compte. Vérifier votre saisie et réessayer.";

    }

}

if (empty($errors)){

    if (checkFieldEntry('user', 'mail', $mail)) {

        $user_id = getUserId($mail)["id"];

        $token = uniqid();

        $username = getUsername($mail)["user_name"];

        insertTokenInTokenTable($user_id, 'RESET_PASSWORD', $token);
        
        $subject = 'Réinitialisation de mot de passe';

        ob_start(); 

        include 'app/admin/password/mailtemp.php'; 

        $mailcontent = ob_get_contents(); 

        ob_end_clean();

        if (mailSendin($mail, $username, $subject, $mailcontent)){

            setcookie('passdata', $mail, time() + 365 * 24 * 3600, '/');

            $response = array('success' => true, 'message' => 'Un email a été envoyé à votre adresse email. Vérifier votre boite de réception ou vos spams et suivre les instructions pour réinitialiser votre mot de passe. Le lien de réinitialisation expire dans 10min.');

        }

    }

} else {

    $response = array('success' => false, 'message' => $errors);

}

header('Content-Type: application/json');
echo json_encode($response);