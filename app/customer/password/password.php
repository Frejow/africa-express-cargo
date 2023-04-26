<?php

$_SESSION["password_error"] = [];

$error = [];

$data = '';

if (isset($_POST['mail']) && !empty($_POST['mail'])){

    $data = secure($_POST["mail"]);

    if (check_exist_userby_email($_POST["mail"], 0)) {

        $user_id = select_user_id($_POST["mail"])[0]["id"];

        $token = uniqid();

        $username = select_username($_POST["mail"])[0]["user_name"];

        if (insert_intoken_table($user_id, 'RESET_PASSWORD', $token)){
            $_SESSION['reset_password'] = [];
            $_SESSION['reset_password']['user_id'] = $user_id;
            $_SESSION['reset_password']['token'] = $token;
            $_SESSION['reset_password']['user_name'] = $username;
        }
        //die;
        $subject = 'Réinitialisation de mot de passe';
        $mailcontent = buffer_html_file('..'.PROJECT.'app/customer/password/mailtemp.php');

        if (mailsendin($_POST['mail'], $username, $subject, $mailcontent)){

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

    } elseif (!check_exist_userby_email($_POST["mail"], 0)) {

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