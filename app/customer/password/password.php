<?php
//session_start();
//die (var_dump($_GET['p']));

//include '..'.PROJECT."app/common/functions_folder/functions.php";

$_SESSION["password_error"] = [];

$error = [];

$data = '';

if (isset($_POST['mail']) && !empty($_POST['mail'])){

    $data = secure($_POST["mail"]);

    if (check_exist_userby_email($_POST["mail"])) {

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

        if (mailsendin($_POST['mail'], $subject, $mailcontent)){
            header("location:".PROJECT."customer/password/true");
        }

    } elseif (!check_exist_userby_email($_POST["mail"])) {

        $error["mail"] = "[ " . $_POST["mail"] . " ] n'est associé à aucun compte. Vérifier votre saisie et réessayer.";

    }
} else {

    $error["mail"] = "Ce champs est requis";

}

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

if (!empty($error)){
    $_SESSION["password_error"] = $error;

    header("location:".PROJECT."customer/password");
}