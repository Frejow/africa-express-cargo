<?php

$_SESSION["password_error"] = [];

$error = [];

$data = '';

if (isset($_POST['mail']) && !empty($_POST['mail'])){

    $data = secure($_POST["mail"]);

    if (checkExistFieldEntry('mail', $_POST["mail"])) {

        $user_id = getUserId($_POST["mail"])["id"];

        $token = uniqid();

        $username = getUsername($_POST["mail"])["user_name"];

        insertTokenInTokenTable($user_id, 'RESET_PASSWORD', $token);
        
        $subject = 'REINITIALISATION DE MOT DE PASSE';

        ob_start(); 

        include 'app/customer/password/mailtemp.php'; 

        $mailcontent = ob_get_contents(); 

        ob_end_clean();

        if (mailSendin($_POST['mail'], $username, $subject, $mailcontent)){

            $data = secure($_POST["mail"]);

            setcookie(
                "passdata",
                $data,
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );

            header("location:".PROJECT."customer/password/true");
        }

    } elseif (!checkExistFieldEntry('mail', $_POST["mail"])) {

        $error["mail"] = "[ " . $_POST["mail"] . " ] n'est associé à aucun compte. Vérifier votre saisie et réessayer.";

    }
} else {

    $error["mail"] = "Ce champs est requis";

}

if (!empty($error)){

    setcookie(
    "user_passdata",
    $data,
    [
        'expires' => time() + 365 * 24 * 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
    ]
    );

    $_SESSION["password_error"] = $error;

    header("location:".PROJECT."customer/password");
}