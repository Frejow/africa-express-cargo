<?php

require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Instanciation de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply_aec@gmail.com';
    $mail->Password = 'mon-mot-de-passe-smtp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Variables pour l'envoi de l'e-mail
    $to = "adresse-email-destinataire@example.com";
    $subject = "Activation de compte sur Mon-Site";
    $message = "Bonjour,\n\nMerci de vous être inscrit sur Mon-Site. Veuillez activer votre compte en cliquant sur le lien suivant :\n\nhttps://www.mon-site.com/activer-compte.php?code=[Code d'activation]\n\nCordialement,\nL'équipe de Mon-Site";

    // Configuration de l'e-mail
    $mail->setFrom('noreply@mon-site.com', 'Mon-Site');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Envoi de l'e-mail
    $mail->send();
    echo "L'e-mail d'activation a été envoyé avec succès à $to";
} catch (Exception $e) {
    echo "Une erreur est survenue lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
}
