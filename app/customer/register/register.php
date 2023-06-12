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

if (!isset($_POST["pass"]) || empty($_POST["pass"]) && !checkExistFieldEntry('mail', $_POST["mail"])) {
    $errors["pass"] = "Le champs du mot de passe est vide.";
}

if (isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) < 8) {
    $errors["pass"] = "Le champs doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) >= 8 && empty($_POST["repass"])) {
    $errors["repass"] = "Entrez votre mot de passe à nouveau.";
}

if ((isset($_POST["repass"]) && !empty($_POST["repass"]) && strlen(secure($_POST["pass"])) >= 8 && secure($_POST["repass"]) != secure($_POST["pass"]))) {
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

if (checkExistFieldEntry('mail', $_POST["mail"])) {
    $errors["mail"] = "[ " . $_POST["mail"] . " ] est déjà associé à un compte.";
}

if (checkExistFieldEntry('user_name', $_POST["pseudo"])) {
    $errors["pseudo"] = "Le nom d'utilisateur [ " . $_POST["pseudo"] . " ] a déjà été pris.";
}

if (checkExistFieldEntry('phone_number', $_POST["tel"])) {
    $errors["tel"] = "Ce numéro [ " . $_POST["tel"] . " ] appartient à un de nos utilisateur.";
}

if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
    $data["nom"] = strtoupper(secure($_POST["nom"]));
}

if (isset($_POST["prenom"]) && !empty($_POST["prenom"])) {
    $data["prenom"] = ucfirst(secure($_POST["prenom"]));
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

if (isset($_POST["pass"]) && !empty($_POST["pass"]) && strlen(secure($_POST["pass"])) >= 8) {
    $data["pass"] = secure($_POST["pass"]);
}

if ((isset($_POST["repass"]) && !empty($_POST["repass"]) && strlen(secure($_POST["pass"])) >= 8 && secure($_POST["repass"]) == secure($_POST["pass"]))) {
    $data["repass"] = secure($_POST["repass"]);
}

$data["profile"] = "CUSTOMER";

if (empty($errors)) {

    if (registration($data["nom"], $data["prenom"], $data["tel"], $data["pseudo"], $data["mail"], $data["country"], $data["pass"], $data["profile"])) {

        $mail_assoc_to_deleted_account = checkMailAssocToDeletedAccount($data["mail"]);

        if (isset($mail_assoc_to_deleted_account) && !empty($mail_assoc_to_deleted_account)) {
            foreach ($mail_assoc_to_deleted_account as $key => $value) {
                backDeletedAccount($mail_assoc_to_deleted_account[$key]['id'], $data['mail']);
            }
        }

        setcookie('user_register_data', '', time() - 3600, '/');

        $user_id = getUserId($data["mail"])["id"];

        $token = uniqid();

        insertTokenInTokenTable($user_id, 'ACCOUNT_VALIDATION', $token);

        $subject = 'CONFIRMATION DE COMPTE';

        ob_start(); 

        include 'app/customer/register/mailtemp.php'; 

        $mailcontent = ob_get_contents(); 

        ob_end_clean(); 

        if (mailSendin($data['mail'], $data["pseudo"], $subject, $mailcontent)) {

            header("location:" . PROJECT . "customer/register/true");

            setcookie('user_register_data', '', time() - 3600, '/');

        } else {

            if (backDeletedAccount($user_id, $data['mail']) && updateTokenTable($user_id)) {

                setcookie('user_register_data', json_encode($data), time() + 365 * 24 * 3600, '/');

                $_SESSION['error_msg'] = 'Erreur lors du processus. Cause probable : Appareil Hors Connexion. Vérifiez votre connexion internet et réessayer. Si cela persiste, contactez-nous.';

                header("location:" . PROJECT . "customer/register");

            }

        }

    } else {

        setcookie('user_register_data', json_encode($data), time() + 365 * 24 * 3600, '/');

        $_SESSION['error_msg'] = 'Oupss!!! Une erreur a été détecté lors du processus. Veuillez réessayer ou nous contacter si cela persiste.';

        header("location:" . PROJECT . "customer/register");

    }

} else {

    $_SESSION["register_errors"] = $errors;

    setcookie('user_register_data', json_encode($data), time() + 365 * 24 * 3600, '/');

    header("location:" . PROJECT . "customer/register");

}
