<?php

$errors = '';

secure(extract($_POST));

if (empty($nom) || empty($prenom) || empty($pseudo) || empty($mail) || empty($country) || empty($tel) || empty($pass)) {
    $errors = "Tous les champs sont requis.";
}

if (!empty($pass) && strlen($pass) >= 8 && empty($repass)) {
    $errors = "Le champs Confirmez mot de passe est requis.";
}

if (!empty($mail) && !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $errors = "Entrez une addresse email valide s'il vous plaît.";
}

if (!empty($pass) && strlen($pass) < 8) {
    $errors = "Le champs Mot de passe doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if ((!empty($repass) && strlen($pass) >= 8 && $repass != $pass)) {
    $errors = "Le champs Confirmez mot de passe doit recevoir le même mot de passe que celui du champs Mot de passe.";
}

if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    if (checkFieldEntry('user', 'mail', $mail)) {
        $errors = "L'adresse email " . $mail . " est déjà associé à un compte.";
    }
    
    if (checkFieldEntry('user', 'user_name', $pseudo) && !checkFieldEntry('user', 'mail', $mail)) {
        $errors = "Le nom d'utilisateur " . $pseudo . " a déjà été pris.";
    }
    
    if (checkFieldEntry('user', 'phone_number', $tel) && !checkFieldEntry('user', 'user_name', $pseudo) && !checkFieldEntry('user', 'mail', $mail)) {
        $errors = "Le numéro " . $tel . " appartient à un de nos utilisateur.";
    }
}

if (empty($errors)) {

    $profile = "ADMIN";

    if (registration($nom, $prenom, $tel, $pseudo, $mail, $country, $pass, $profile)) {

        $mail_assoc_to_deleted_account = checkMailAssocToDeletedAccount($mail);

        if (!empty($mail_assoc_to_deleted_account)) {

            foreach ($mail_assoc_to_deleted_account as $key => $value) {

                backDeletedAccount($mail_assoc_to_deleted_account[$key]['id'], $mail);

            }
        }
    
        $subject = 'NOUVEAU COMPTE ADMINISTRATEUR EN ATTENTE DE VALIDATION';

        ob_start(); 

        include 'app/admin/register/mailtemp.php'; 

        $mailcontent = ob_get_contents(); 

        ob_end_clean(); 

        if (mailSendin(MAIL_ADDRESS, 'Africa Express Cargo', $subject, $mailcontent)) {

            $response = array('success' => true, 'message' => 'Super !!! Vous êtes inscrit. Vous recevrez un mail après examen et validation de votre compte. Si vous ne recevez pas de mail dans 1h, contactez nous à cette adresse : contact.support@africa-express-cargo.com');

        } else {
            
            $user_id = getUserId($mail)['id'];

            if (backDeletedAccount($user_id, $mail) && updateTokenTable($user_id)) {

                $response = array('success' => false, 'message' => 'Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.');

            }

        }

    } else {

        $response = array('success' => false, 'message' => 'Oupss!!! Une erreur a été détecté lors du processus. Veuillez réessayer ou nous contacter si cela persiste.');

    }

} else {

    $response = array('success' => false, 'message' => $errors);

}

header('Content-Type: application/json');
echo json_encode($response);
