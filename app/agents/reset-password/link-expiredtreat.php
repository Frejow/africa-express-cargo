<?php

if (isset($_POST['resend_mail']) && !empty($_POST['resend_mail'])) {

    $user_mail = getUserMailAndUsername($_POST['resend_mail'])['mail'];
    $username = getUserMailAndUsername($_POST['resend_mail'])['user_name'];

    $token = uniqid();

    insertTokenInTokenTable($_POST['resend_mail'], 'RESET_PASSWORD', $token);
        
    $subject = 'Réinitialisation de mot de passe';

    ob_start(); 

    include 'app/agents/password/mailtemp.php'; 

    $mailcontent = ob_get_contents(); 

    ob_end_clean();

    if (mailSendin($user_mail, $username, $subject, $mailcontent)) {

        setcookie('success_msg', 'Mail envoyé avec succès. Vérifiez votre boite de réception ou vos spams pour valider votre compte. Ce nouveau lien expire également dans 10min à compter de maintenant.', time() + 365 * 24 * 3600, '/');

        unset($_SESSION['user_id']);

        header("location:" . PROJECT . "agents/reset-password/link-expired");
    } else {

        setcookie('error_msg', 'Erreur. Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.', time() + 365 * 24 * 3600, '/');

        header("location:" . PROJECT . "agents/reset-password/link-expired");
    }
} else {

    $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

    header("location:" . PROJECT . "agents/reset-password/link-expired");
}
