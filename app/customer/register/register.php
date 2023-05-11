<?php
//die (var_dump($_GET['p']));
//die (var_dump ('customer'));
//die(var_dump($_POST['country']));

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

if (!isset($_POST["pass"]) || empty($_POST["pass"]) && !check_exist_userby_email($_POST["mail"], 0)) {
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

if (check_exist_userby_email($_POST["mail"], 0)) {
    $errors["mail"] = "[ " . $_POST["mail"] . " ] est déjà associé à un compte. Veuillez le changer.";
}

if (check_exist_userby_pseudo($_POST["pseudo"], 0)) {
    $errors["pseudo"] = "Le nom d'utilisateur [ " . $_POST["pseudo"] . " ] a déjà été pris. Veuillez le changer.";
}

if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
    $data["nom"] = secure($_POST["nom"]);
}

if (isset($_POST["prenom"]) && !empty($_POST["prenom"])) {
    $data["prenom"] = secure($_POST["prenom"]);
}

if (isset($_POST["tel"]) && !empty($_POST["tel"])) {
    $data["tel"] = $_POST["tel"];
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

    $database =  _database_login();

    if (is_object($database)) {

        // Ecriture de la requête
        $request_insertion = 'INSERT INTO user(name, first_names, phone_number, user_name, mail, country, password, profile) VALUES (:nom, :prenom, :tel, :pseudo, :mail, :country, :pass, :profile)';

        // Préparation
        $request_insertion_prepare = $database->prepare($request_insertion);

        // Exécution ! 
        $result = $request_insertion_prepare->execute([
            'nom' => $data["nom"],
            'prenom' => $data["prenom"],
            'tel' => $data["tel"],
            'pseudo' => $data["pseudo"],
            'mail' => $data["mail"],
            'country' => ltrim(preg_replace('/[^\p{L}\p{N}\s]/u', "", $_POST["country"])),
            'pass' => sha1($_POST["pass"]),
            'profile' => $data["profile"],
        ]);

        if ($result) {

            setcookie('user_register_data', '', time() - 3600, '/');

            $user_id = select_user_id($data["mail"])[0]["id"];

            $token = uniqid();

            if (insert_intoken_table($user_id, 'ACCOUNT_VALIDATION', $token)){
                $_SESSION['account_validation'] = [];
                $_SESSION['account_validation']['user_id'] = $user_id;
                $_SESSION['account_validation']['token'] = $token;
            }
            //die;
            $subject = 'Confirmation de compte';
            $mailcontent = buffer_html_file('..'.PROJECT.'app/customer/register/mailtemp.php');

            if (mailsendin($data['mail'], $data["pseudo"], $subject, $mailcontent)){

                header("location:".PROJECT."customer/register/true");

                setcookie('user_register_data', '', time() - 3600, '/');

            } else {

                deleted_account($user_id);

                $_SESSION['error_msg'] = 'Erreur lors du processus. Cause probable : Hors Connexion. Réessayer, si cela persiste, contactez-nous.';

                header("location:".PROJECT."customer/register");

            }

        } else {

            $_SESSION['error_msg'] = 'Oupss!!! Une erreur a été détecté lors du processus. Veuillez réessayer ou nous contacter si cela persiste.';

            header("location:".PROJECT."customer/register");

        }
    } else {

        $_SESSION['error_msg'] = $database;

        header("location:".PROJECT."customer/register");
    }
} else {

    $_SESSION["register_errors"] = $errors;

    setcookie(
        "user_register_data",
        json_encode($data),
        [
            'expires' => time() + 365 * 24 * 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]
    );

    header("location:".PROJECT."customer/register");
}
