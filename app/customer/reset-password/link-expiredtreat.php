<?php

if (isset($_POST['resend_mail']) && !empty($_POST['resend_mail'])) {

    $user_mail = select_user_mail_pseudo($_POST['resend_mail'])[0]['mail'];
    $user_pseudo = select_user_mail_pseudo($_POST['resend_mail'])[0]['user_name'];

    $token = uniqid();

    if (insert_intoken_table($_POST['resend_mail'], 'RESET_PASSWORD', $token)){
        $_SESSION['reset_password'] = [];
        $_SESSION['reset_password']['user_id'] = $_POST['resend_mail'];
        $_SESSION['reset_password']['token'] = $token;
        $_SESSION['reset_password']['user_name'] = $user_pseudo;
    }
    //die;
    $subject = 'Réinitialisation de mot de passe';
    $mailcontent = buffer_html_file('..'.PROJECT.'app/customer/password/mailtemp.php');

    if (mailsendin($user_mail, $user_pseudo, $subject, $mailcontent)) {

        setcookie('success_msg', 'Mail envoyé avec succès. Vérifiez votre boite de réception ou vos spams pour valider votre compte. Ce nouveau lien expire également dans 10min à compter de maintenant.', time() + 365 * 24 * 3600, '/');

        unset($_SESSION['user_id']);

        header("location:" . PROJECT . "customer/reset-password/link-expired");
    } else {

        setcookie('error_msg', 'Erreur. Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.', time() + 365 * 24 * 3600, '/');

        header("location:" . PROJECT . "customer/reset-password/link-expired");
    }
} else {

    $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

    header("location:" . PROJECT . "customer/reset-password/link-expired");
}
