<?php

$_SESSION["reset_errors"] = [];

$errors = [];

if (!isset($_POST["pass"]) || empty($_POST["pass"])) {
    $errors["pass"] = "Le champs du mot de passe est vide.";
}

if (isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) < 8) {
    $errors["pass"] = "Le champs doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) >= 8 && empty($_POST["repass"])) {
    $errors["repass"] = "Entrez votre mot de passe à nouveau.";
}

if ((isset($_POST["repass"]) && !empty($_POST["repass"]) && strlen(secure($_POST["pass"])) >= 8 && $_POST["repass"] != $_POST["pass"])) {
    $errors["repass"] = "Mot de passe erroné. Entrez le mot de passe du précédent champs";
}

if (empty($errors)) {

    if (isset($_COOKIE["passdata"]) && !empty($_COOKIE["passdata"])) {
        if (update_password($_COOKIE["passdata"], sha1($_POST['pass']))){
            setcookie(
                "success_msg",
                'Mot de passe changer avec succès. Vous pouvez vous connecter.',
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );
            setcookie('user_passdata', '', time() - 3600, '/');

            setcookie('passdata', '', time() - 3600, '/');

            header("location:".PROJECT."customer/login");
        }
    }

} else {

    $_SESSION["reset_errors"] = $errors;

    header("location:".PROJECT."customer/password/reset-password");
}