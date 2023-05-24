<?php

if (isset($_POST['resend_mail']) && !empty($_POST['resend_mail'])) {

    $user_mail = select_user_mail_pseudo($_POST['resend_mail'])['mail'];
    $username = select_user_mail_pseudo($_POST['resend_mail'])['user_name'];

    $token = uniqid();

    insert_intoken_table($_POST['resend_mail'], 'ACCOUNT_VALIDATION', $token);

    $subject = 'Confirmation de compte';

    ob_start(); 

    include 'app/customer/register/mailtemp.php'; 

    $mailcontent = ob_get_contents(); 

    ob_end_clean();

    if (mailsendin($user_mail, $username, $subject, $mailcontent)) {

        setcookie('success_msg', 'Mail envoyé avec succès. Vérifiez votre boite de réception ou vos spams pour valider votre compte. Ce nouveau lien expire également dans 10min à compter de maintenant.', time() + 365 * 24 * 3600, '/');

        unset($_SESSION['user_id']);

        header("location:" . PROJECT . "customer/account-validation/link-expired");
    } else {

        setcookie('error_msg', 'Erreur. Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.', time() + 365 * 24 * 3600, '/');

        header("location:" . PROJECT . "customer/account-validation/link-expired");
    }
} else {

    $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

    header("location:" . PROJECT . "customer/account-validation/link-expired");
}
