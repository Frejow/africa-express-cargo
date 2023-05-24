<?php

$_SESSION["register_errors"] = [];

$errors = [];

$data = [];

if (!isset($_POST["nom"]) || empty($_POST["nom"])) {
    $errors["nom"] = "Ce champs est vide";
}

if (!isset($_POST["prenom"]) || empty($_POST["prenom"])) {
    $errors["prenom"] = "Ce champs est vide";
}

if (!isset($_POST["pseudo"]) || empty($_POST["pseudo"])) {
    $errors["pseudo"] = "Ce champs est vide";
}

if (isset($_POST["country"]) && $_POST["country"] == "Pays") {
    $errors["country"] = "Veuillez renseigner ce champs";
}

if (!isset($_POST["tel"]) || empty($_POST["tel"])) {
    $errors["tel"] = "Veuillez renseigner ce champs";
}

if (!isset($_POST["mail"]) || empty($_POST["mail"])) {
    $errors["mail"] = "Le champs d'adresse email est vide.";
}

if (isset($_POST["mail"]) && !empty($_POST["mail"]) && !filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    $errors["mail"] = "Entrez une addresse email valide s'il vous plaît";
}

if (!isset($_POST["pass"]) || empty($_POST["pass"]) && !check_exist_fieldentry('mail', $_POST["mail"])) {
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

if (
    isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) >= 8
    && isset($_POST["repass"]) && !empty($_POST["repass"])
    && $_POST["repass"] == $_POST["pass"]
    && !isset($_POST["terms"]) && empty($_POST["terms"])
) {
    $errors["terms"] = "Veuillez cocher cette case s'il vous plaît.";
}

if (check_exist_fieldentry('mail', $_POST["mail"])) {
    $errors["mail"] = "[ " . $_POST["mail"] . " ] est déjà associé à un compte.";
}

if (check_exist_fieldentry('user_name', $_POST["pseudo"])) {
    $errors["pseudo"] = "Le nom d'utilisateur [ " . $_POST["pseudo"] . " ] a déjà été pris.";
}

if (check_exist_fieldentry('phone_number', $_POST["tel"])) {
    $errors["tel"] = "Ce numéro [ " . $_POST["tel"] . " ] appartient à un de nos utilisateur.";
}

if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
    $data["nom"] = secure($_POST["nom"]);
}

if (isset($_POST["prenom"]) && !empty($_POST["prenom"])) {
    $data["prenom"] = secure($_POST["prenom"]);
}

if (isset($_POST["tel"]) && !empty($_POST["tel"])) {
    $data["tel"] = secure($_POST["tel"]);
}

if (isset($_POST["pseudo"]) && !empty($_POST["pseudo"])) {
    $data["pseudo"] = secure($_POST["pseudo"]);
}

if (isset($_POST["mail"]) && !empty($_POST["mail"]) && (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) || filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))) {
    $data["mail"] = secure($_POST["mail"]);
}

if (isset($_POST["country"]) && !empty($_POST["country"])) {
    $data["country"] = $_POST["country"]; //die (var_dump($data["country"]));
}

$data["profile"] = "CUSTOMER";

if (empty($errors)) {

    if (registered($data["nom"], $data["prenom"], $data["tel"], $data["pseudo"], $data["mail"], $data["country"], $_POST["pass"], $data["profile"])) {

        $mail_assoc_to_deleted_account = check_mail_assoc_to_deleted_account($data["mail"]);

        if (isset($mail_assoc_to_deleted_account) && !empty($mail_assoc_to_deleted_account)) {
            foreach ($mail_assoc_to_deleted_account as $key => $value) {
                back_deleted_account($mail_assoc_to_deleted_account[$key]['id'], $data['mail']);
            }
        }

        setcookie('user_register_data', '', time() - 3600, '/');

        $user_id = select_user_id($data["mail"])[0]["id"];

        $token = uniqid();

        if (insert_intoken_table($user_id, 'ACCOUNT_VALIDATION', $token)) {
            $_SESSION['account_validation'] = [];
            $_SESSION['account_validation']['user_id'] = $user_id;
            $_SESSION['account_validation']['token'] = $token;
            //require_once __DIR__ . 'mailtemp.php';
        }
        //die;
        $subject = 'Confirmation de compte';
        $mailcontent = buffer_html_file('..' . PROJECT . 'app/customer/register/mailtemp.php');

        if (mailsendin($data['mail'], $data["pseudo"], $subject, $mailcontent)) {

            header("location:" . PROJECT . "customer/register/true");

            setcookie('user_register_data', '', time() - 3600, '/');

        } else {

            if (back_deleted_account($user_id, $data['mail']) && update_token_table($user_id)) {

                setcookie('user_register_data', json_encode($data), time() + 365 * 24 * 3600, '/');

                $_SESSION['error_msg'] = 'Erreur lors du processus. Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.';

                header("location:" . PROJECT . "customer/register");

            }

        }

    } else {

        $_SESSION['error_msg'] = 'Oupss!!! Une erreur a été détecté lors du processus. Veuillez réessayer ou nous contacter si cela persiste.';

        header("location:" . PROJECT . "customer/register");

    }

} else {

    $_SESSION["register_errors"] = $errors;

    setcookie('user_register_data', json_encode($data), time() + 365 * 24 * 3600, '/');

    header("location:" . PROJECT . "customer/register");

}
