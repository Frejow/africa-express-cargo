<?php

$errors = '';

$name = secure($_POST["nom"]);
$fnames = secure($_POST["prenom"]);
$pseudo = secure($_POST["pseudo"]);
$country = secure($_POST["country"]);
$tel = secure($_POST["tel"]);
$mail = secure($_POST["mail"]);
$pass = secure($_POST["pass"]);
$repass = secure($_POST["repass"]);
$profile = "AGENT";

if (empty($name) || empty($fnames) || empty($pseudo) || empty($mail) || empty($country) || empty($tel) || empty($pass)) {
    $errors = "Tous les champs sont requis.";
}

if (isset($pass) && !empty($pass) && strlen(secure($pass)) >= 8 && empty($repass)) {
    $errors = "Le champs Confirmez mot de passe est requis.";
}

if (isset($mail) && !empty($mail) && !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $errors = "Entrez une addresse email valide s'il vous plaît.";
}

if (isset($pass) && !empty($pass) && strlen(secure($pass)) < 8) {
    $errors = "Le champs Mot de passe doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if ((isset($repass) && !empty($repass) && strlen(secure($pass)) >= 8 && $repass != $pass)) {
    $errors = "Le champs Confirmez mot de passe doit recevoir le même mot de passe que celui du champs Mot de passe.";
}

if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    if (check_exist_fieldentry('mail', $mail)) {
        $errors = "L'adresse email " . $mail . " est déjà associé à un compte.";
    }
    
    if (check_exist_fieldentry('user_name', $pseudo) && !check_exist_fieldentry('mail', $mail)) {
        $errors = "Le nom d'utilisateur " . $pseudo . " a déjà été pris.";
    }
    
    if (check_exist_fieldentry('phone_number', $tel) && !check_exist_fieldentry('user_name', $pseudo) && !check_exist_fieldentry('mail', $mail)) {
        $errors = "Ce numéro " . $tel . " appartient à un de nos utilisateur.";
    }
}

if (empty($errors)) {

    if (registration($name, $fnames, $tel, $pseudo, $mail, $country, $pass, $profile)) {

        $mail_assoc_to_deleted_account = check_mail_assoc_to_deleted_account($mail);

        if (isset($mail_assoc_to_deleted_account) && !empty($mail_assoc_to_deleted_account)) {

            foreach ($mail_assoc_to_deleted_account as $key => $value) {

                back_deleted_account($mail_assoc_to_deleted_account[$key]['id'], $mail);

            }
        }
    
        $subject = 'NOUVEAU COMPTE AGENT EN ATTENTE DE VALIDATION';

        ob_start(); 

        include 'app/agents/register/mailtemp.php'; 

        $mailcontent = ob_get_contents(); 

        ob_end_clean(); 

        if (mailsendin(MAIL_ADDRESS, 'Africa Express Cargo', $subject, $mailcontent)) {

            $response = array('success' => true, 'message' => 'Super !!! Vous êtes inscrit. Vous recevrez un mail après examen et validation de votre compte. Si vous ne recevez pas de mail dans 1h, contactez nous à cette adresse : contact.support@africa-express-cargo.com');

        } else {
            
            $user_id = get_user_id($mail)['id'];

            if (back_deleted_account($user_id, $mail) && update_token_table($user_id)) {

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
