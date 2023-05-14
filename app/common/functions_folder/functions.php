<?php

// Instance d'initialisation des class PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fonction de redirection basée sur le thème
function redirect($theme, $link) {

    $redirect_url = $link.'?'.$theme;

    return $redirect_url;

}

//Fonction de sécurisation des champs d'entrées de formulaires
function secure($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

//Fonction d'enregistrement d'utilisateur dans la table 'user' 
function registered($name, $first_names, $phone_number, $user_name, $mail, $country, $password, $profile): bool
{

    $is_registered = false;

    $database = _database_login();

    $request = 'INSERT INTO user(name, first_names, phone_number, user_name, mail, country, password, profile) VALUES (:nom, :prenom, :tel, :pseudo, :mail, :country, :pass, :profile)';

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'nom' => $name,
            'prenom' => $first_names,
            'tel' => $phone_number,
            'pseudo' => $user_name,
            'mail' => $mail,
            'country' => ltrim(preg_replace('/[^\p{L}\p{N}\s]/u', "", $country)),
            'pass' => sha1($password),
            'profile' => $profile,
        ]
    );

    if ($request_execution) {

        $is_registered = true;
    }

    return $is_registered;
}

//Fonction d'envoi de mail
function mailsendin(string $destination, string $recipient, string $subject, string $body): bool
{
    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {

        // Server settings
        // for detailed debug output
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = MAIL_ADDRESS;
        $mail->Password = MAIL_PASSWORD;

        // Sender and recipient settings
        $mail->setFrom(MAIL_ADDRESS, htmlspecialchars_decode('Africa Express Cargo'));
        $mail->addAddress($destination, $recipient);
        $mail->addReplyTo(MAIL_ADDRESS, htmlspecialchars_decode('Africa Express Cargo'));

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = htmlspecialchars_decode($subject);
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {

        return false;
    }
}

//Fonction de suppression de compte à l'inscription en cas d'échec de l'envoi de mail
function back_deleted_account(int $id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $back_deleted_account = false;

    $database = _database_login();

    $request = "UPDATE user SET mail = :mail, is_active = :is_active, is_deleted = :is_deleted, updated_on = :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'mail' => 'this_mail_address_was_deleted',
            'is_active' => 0,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $back_deleted_account = true;
    }

    return $back_deleted_account;
}

//Fonction de vérification d'utilisateur connecté
function connected(): bool
{
    $is_connected = false;

    if (isset($_SESSION["connected"]) && !empty($_SESSION["connected"])) {
        $is_connected = true;
    }

    return $is_connected;
}

//Fonction de déconnexion
function disconnected(): bool
{
    $is_disconnected = false;

    unset($_SESSION['connected']);

    if (!isset($_SESSION["connected"]) || empty($_SESSION["connected"])) {
        $is_disconnected = true;
    }

    return $is_disconnected;
}

//Fonction de connexion à la base de données
function _database_login()
{

    $database = "";

    try {
        $database = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
    } catch (Exception $e) {
        $database = "Une erreur a été détecté lors de la connexion à la base de donnée.";
    }

    return $database;
}

//Fonction de vérification de valeurs d'entrée existant dans la base de données
function check_exist_fieldentry(string $fieldtype, string $fieldentry)
{

    $exist_fieldentry = false;

    $database = _database_login();

    $request = "SELECT * FROM user WHERE " .$fieldtype."=:fieldtype and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'fieldtype' => $fieldentry,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $exist_fieldentry = true;
        }
    }

    return $exist_fieldentry;
}

//Fonction de mise à jour du statut de compte (valide et actif)
function update_account_status(int $user_id)
{
    date_default_timezone_set("Africa/Lagos");

    $update_account_status = false;

    $database = _database_login();

    $request = "UPDATE user SET is_valid_mail = :valid_mail, is_valid_account = :valid_account, is_active = :active, updated_on = :updated_on WHERE id = :user_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'user_id'  => $user_id,
            'valid_mail' => '1',
            'valid_account' => '1',
            'active' => '1',
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_account_status = true;
    }

    return $update_account_status;
}

//Fonction de temporisation de contenu html
function buffer_html_file(string $filename)
{
    ob_start(); // Démarre la temporisation de sortie

    include $filename; // Inclut le fichier HTML dans le tampon

    $html = ob_get_contents(); // Récupère le contenu du tampon
    ob_end_clean(); // Arrête et vide la temporisation de sortie

    return $html; // Retourne le contenu du fichier HTML
}

//Fonction de récupération de token à l'inscription
function select_register_user_token(string $mail)
{
    $register_user_token = [];

    $database = _database_login();

    $request = "SELECT token FROM user WHERE mail=:mail";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $register_user_token = $data;
        }
    }
    return $register_user_token;
}

//Fonction de récupération de l'id utilisateur
function select_user_id(string $mail)
{
    $user_id = [];

    $database = _database_login();

    $request = "SELECT id FROM user WHERE mail=:mail";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $user_id = $data;
        }
    }
    return $user_id;
}

//Fonction de récupération de nom utilisateur 
function select_username(string $mail)
{
    $user_id = [];

    $database = _database_login();

    $request = "SELECT user_name FROM user WHERE mail=:mail";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $user_id = $data;
        }
    }
    return $user_id;
}

//Fonction d'insertion de token dans la table token
function insert_intoken_table(int $user_id, string $type, string $token): bool
{

    $insertion = false;

    $database = _database_login();

    $request = "INSERT INTO token (user_id, type, token, is_active, is_deleted) VALUES (:user_id, :type, :token, :is_active, :is_deleted)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'user_id' => $user_id,
            'type' => $type,
            'token' => $token,
            'is_active' => 1,
            'is_deleted' => 0
        ]
    );

    if ($request_execution) {

        $insertion = true;
    }

    return $insertion;
}

//Fonction de vérification de token à la validation de compte
function check_user_registered_token_info(int $user_id, string $token, string $type, int $is_active, int $is_deleted): bool
{

    $info_found = false;

    $database = _database_login();

    $request = "SELECT * FROM token WHERE user_id=:user_id and token=:token and type=:type and is_active=:is_active and is_deleted=:is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'token' => $token,
        'type' => $type,
        'is_active' => $is_active,
        'is_deleted' => $is_deleted
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $info_found = true;
        }
    }

    return $info_found;
}

//Fonction de mise à jour de la table token
function update_token_table(int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_token_table = false;

    $database = _database_login();

    $request = "UPDATE token SET is_active = :is_active, is_deleted = :is_deleted, updated_on= :updated_on WHERE user_id = :user_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'user_id'  => $user_id,
            'is_active' => 0,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_token_table = true;
    }

    return $update_token_table;
}

//Fonction de mise à jour de mot de passe
function update_password(string $mail, string $password): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_password = false;

    $database = _database_login();

    $request = "UPDATE user SET password = :password, is_active = :is_active, updated_on= :updated_on WHERE mail = :mail";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'mail'  => $mail,
            'password' => $password,
            'is_active' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_password = true;
    }

    return $update_password;
}

//Fonction de vérification des informations de l'utilisateur (email & password) à la connexion
function check_exist_userby_email_and_password(string $mail, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted): bool
{

    $exist_user = false;

    $database = _database_login();

    $request = "SELECT id, name, first_names, phone_number, user_name, mail, country, avatar FROM user WHERE mail=:mail and password=:password and profile=:profile and is_valid_account=:is_valid_account and is_active=:is_active and is_deleted=:is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'password' => sha1($password),
        'profile' => $profile,
        'is_valid_account' => $is_valid_account,
        'is_active' => $is_active,
        'is_deleted' => $is_deleted
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $_SESSION['connected'] = json_encode($data);

            /*setcookie(
                "connected_user",
                json_encode($data),
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );*/

            $exist_user = true;
        }
    }

    return $exist_user;
}

//Fonction de vérification des informations de l'utilisateur (pseudo & password) à la connexion
function check_exist_userby_pseudo_and_password(string $pseudo, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted): bool
{

    $exist_user = false;

    $database = _database_login();

    $request = "SELECT id, name, first_names, phone_number, user_name, mail, country, avatar FROM user WHERE user_name=:pseudo and password=:password and profile=:profile and is_valid_account=:is_valid_account and is_active=:is_active and is_deleted=:is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'pseudo' => $pseudo,
        'password' => sha1($password),
        'profile' => $profile,
        'is_valid_account' => $is_valid_account,
        'is_active' => $is_active,
        'is_deleted' => $is_deleted
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $_SESSION['connected'] = json_encode($data);

            /*setcookie(
                "connected_user",
                json_encode($data),
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );*/

            $exist_user = true;
        }
    }

    return $exist_user;
}

//Fonction de mise à jour des informations personnelles de l'utilisateur
function update_personal_info(int $id, string $name, string $first_names, string $user_name, string $country, string $mail, string $phone_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updating = false;

    $database = _database_login();

    $request = "UPDATE user SET name = :name, first_names = :first_names, user_name = :user_name, country = :country, mail = :mail, phone_number = :phone_number, updated_on= :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'name'  => $name,
            'first_names'  => $first_names,
            'user_name'  => $user_name,
            'country'  => $country,
            'mail'  => $mail,
            'phone_number'  => $phone_number,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $updating = true;
    }

    return $updating;
}

//Fonction de récupération des informations utilisateurs mises à jour 
function select_user_updated_info(int $id): bool
{

    $selected = false;

    $database = _database_login();

    $request = "SELECT id, name, first_names, phone_number, user_name, mail, country, avatar FROM user WHERE id=:id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $_SESSION['connected'] = json_encode($data);

            $selected = true;
        }
    }

    return $selected;
}

//Fonction de vérification de mot de passe
function check_password(int $id, string $password): bool
{

    $password_found = false;

    $database = _database_login();

    $request = "SELECT password FROM user WHERE id=:id and password = :password";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $id,
        'password' => sha1($password)
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {
            $password_found = true;
        }
    }

    return $password_found;
}

//Fonction de mise à jour d'avatar
function update_avatar(int $id, string $avatar): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_avatar = false;

    $database = _database_login();

    $request = "UPDATE user SET avatar = :avatar, updated_on= :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'avatar' => $avatar,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_avatar = true;
    }

    return $update_avatar;
}

//Fonction de désactivation de compte
function deactivated_account(int $id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_active_field = false;

    $database = _database_login();

    $request = "UPDATE user SET is_active = :is_active, updated_on= :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'is_active' => 0,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_is_active_field = true;
    }

    return $update_is_active_field;
}

//Fonction de suppression de compte
function deleted_account(int $id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_deleted_field = false;

    $database = _database_login();

    $request = "UPDATE user SET is_active = :is_active, is_deleted = :is_deleted, updated_on = :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'is_active' => 0,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_is_deleted_field = true;
    }

    return $update_is_deleted_field;
}

//Fonction de vérification de numéro de suivi
function check_tracking_number(string $trackN): bool
{

    $trackN_found = false;

    $database = _database_login();

    $request = "SELECT * FROM package WHERE tracking_number = :tracking_number and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'tracking_number' => $trackN,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {
            $trackN_found = true;
        }
    }

    return $trackN_found;
}

//Fonction de suppression de dossier d'images
function delete_dir($dir) {

    if (!is_dir($dir)) {

        return;

    }

    $contain = scandir($dir);

    foreach ($contain as $key => $value) {

        if ($contain[$key] != '.' && $contain[$key] != '..') {

            $path = $dir . '/' . $contain[$key];

            if (is_dir($path)) {

                delete_dir($path);

            } else {

                unlink($path);

            }
        }
    }

    rmdir($dir);
}

//Fonction d'ajout de colis dans la table package
function add_package(
    string $tracking_number,
    $package_units_number,
    $worth,
    string $description,
    $net_weight,
    $volumetric_weight,
    $product_type,
    int $user_id
): bool {

    $insertion = false;

    $database = _database_login();

    $request = "INSERT INTO package (tracking_number, package_units_number, worth, description, net_weight, volumetric_weight, product_type, user_id) 
    VALUES (:tracking_number, :package_units_number, :worth, :description, :net_weight, :volumetric_weight, :product_type, :user_id)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'tracking_number' => $tracking_number,
            'package_units_number' => $package_units_number,
            'worth' => $worth,
            'description' => $description,
            'net_weight' => $net_weight,
            'volumetric_weight' => $volumetric_weight,
            'product_type' => $product_type,
            'user_id' => $user_id
        ]
    );

    if ($request_execution) {

        $insertion = true;
    }

    return $insertion;
}

//Fonction d'ajout d'image(s) de colis dans la table images
function add_images_for_package(int $package_id, string $image, int $user_id): bool
{

    $insertion = false;

    $database = _database_login();

    $request = "INSERT INTO packages_images (package_id, images, user_id) VALUES (:package_id, :image, :user_id)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'package_id' => $package_id,
            'image' => $image,
            'user_id' => $user_id
        ]
    );

    if ($request_execution) {

        $insertion = true;
    }

    return $insertion;
}

//Fonction de récupération de l'id d'un colis
function select_package_id(string $trackN)
{
    $package_id = [];

    $database = _database_login();

    $request = "SELECT id FROM package WHERE tracking_number=:trackN";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'trackN' => $trackN
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $package_id = $data;
        }
    }
    return $package_id;
}

//Fonction de vérification de l'id d'un colis dans la table images
function check_package_id_in_packages_images_tab(string $package_id): bool
{

    $package_id_found = false;

    $database = _database_login();

    $request = "SELECT package_id FROM packages_images WHERE package_id = :package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_id' => $package_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {
            $package_id_found = true;
        }
    }

    return $package_id_found;
}

//Fonction de récupération d'image(s) de colis
function select_package_images(int $package_id)
{
    $package_images = [];

    $database = _database_login();

    $request = "SELECT images FROM packages_images WHERE package_id=:package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_id' => $package_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $package_images = $data;
        }
    }
    return $package_images;
}

//Fonction de listings des colis
function listings($table, $page, $packages_nb_per_page, $status, $search, $user_id)
{

    $packages_list = [];

    $database = _database_login();

    if ($status === 'Tout Afficher' && $search === 'UNDEFINED') {

        $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $packages_nb_per_page . " OFFSET " . ($page - 1) * $packages_nb_per_page;

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'user_id' => $user_id,
            'is_deleted' => 0,
        ]);
    } elseif ($status !== 'Tout Afficher' && $search === 'UNDEFINED') {

        $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and status = :status and is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $packages_nb_per_page . " OFFSET " . ($page - 1) * $packages_nb_per_page;

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'user_id' => $user_id,
            'status' => $status,
            'is_deleted' => 0,
        ]);
    } elseif ($status === 'Tout Afficher' && $search !== 'UNDEFINED') {

        $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and is_deleted = :is_deleted AND ";

        $search_terms_array = str_split($search);

        $search_terms_count = count($search_terms_array);

        for ($i = 0; $i < $search_terms_count; $i++) {
            $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
            if ($i != $search_terms_count - 1) {
                $request .= " AND ";
            }
        }
        $request .= " ORDER BY id DESC LIMIT " . $packages_nb_per_page . " OFFSET " . ($page - 1) * $packages_nb_per_page;

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'user_id' => $user_id,
            'is_deleted' => 0,
        ]);
    } elseif ($status !== 'Tout Afficher' && $search !== 'UNDEFINED') {

        $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and is_deleted = :is_deleted AND ";

        $search_terms_array = str_split($search);

        $search_terms_count = count($search_terms_array);

        for ($i = 0; $i < $search_terms_count; $i++) {
            $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
            if ($i != $search_terms_count - 1) {
                $request .= " AND ";
            }
        }
        $request .= " AND status = :status ORDER BY id DESC LIMIT " . $packages_nb_per_page . " OFFSET " . ($page - 1) * $packages_nb_per_page;

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'user_id' => $user_id,
            'status' => $status,
            'is_deleted' => 0,
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $packages_list = $data;
        }
    }

    return $packages_list;
}

//Fonction de récupération du nombre de lignes d'une table
function count_rows_in_table($table, $user_id)
{

    $rows = [];

    $database = _database_login();

    $request = "SELECT COUNT(*) FROM " . $table . " WHERE is_deleted = :is_deleted and user_id = :user_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            "is_deleted" => 0,
            "user_id" => $user_id
        ]
    );

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        $rows = $data;
    }

    return $rows;
}

//Fonction de suppression de colis ou de groupe de colis
function deleted_package_or_packagegroup(string $tracking_number, string $table): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_deleted_field = false;

    $database = _database_login();

    $request = "UPDATE " . $table . " SET is_active = :is_active, is_deleted = :is_deleted, updated_on = :updated_on WHERE tracking_number = :tracking_number";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'tracking_number'  => $tracking_number,
            'is_active' => 0,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_is_deleted_field = true;
    }

    return $update_is_deleted_field;
}

//Fonction de mise à jour du champs 'customer_package_group_id' dans la table package
function update_customer_package_group_id(string $customer_package_group_id, string $tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_customer_package_group_id = false;

    $database = _database_login();

    $request = "UPDATE package SET customer_package_group_id = NULL, updated_on= :updated_on WHERE customer_package_group_id = :customer_package_group_id and tracking_number = :tracking_number";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'customer_package_group_id' => $customer_package_group_id,
            'tracking_number' => $tracking_number,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_customer_package_group_id = true;
    }

    return $update_customer_package_group_id;
}

//Fonction de listings des colis éligibles à la sélection pour groupe de colis
function packages_listing_in_selectfield($user_id)
{

    $packages_listing = [];

    $database = _database_login();

    $request = "SELECT * FROM package WHERE user_id = :user_id and is_deleted = :is_deleted and customer_package_group_id IS NULL ORDER BY id DESC";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'is_deleted' => 0,
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $packages_listing = $data;
        }
    }

    return $packages_listing;
}

/**
 * Fonction d'insertion de numéro de suivi de groupe de colis dans la table 'customer_package_group' et de récupération
 *  de l'id du groupe de colis
 */
function insert_select_incustomerpackagegroup_table(string $tracking_number, int $user_id): bool
{

    $insertselect = false;

    $database = _database_login();

    $insertrequest = "INSERT INTO customer_package_group (tracking_number, user_id) VALUES (:tracking_number, :user_id)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'tracking_number' => strtoupper($tracking_number),
            'user_id' => $user_id,
        ]
    );

    if ($insertrequest_execution) {

        $selectrequest = "SELECT id FROM customer_package_group WHERE tracking_number = :tracking_number";

        $selectrequest_prepare = $database->prepare($selectrequest);

        $selectrequest_execution = $selectrequest_prepare->execute(
            [
                'tracking_number' => $tracking_number,
            ]
        );

        if ($selectrequest_execution) {

            $data = $selectrequest_prepare->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data) && !empty($data) && is_array($data)) {

                $_SESSION['nowcreated_packagegroup_id'] = $data;

                $insertselect = true;
            }
        }
    }

    return $insertselect;
}

//Fonction de mise à jour du champs 'customer_package_group_id' pour un colis dans la table 'package'
function update_customerpackagegroupid_field_inpackage_table(int $customer_package_group_id, string $package_tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update = false;

    $database = _database_login();

    $request = "UPDATE package SET customer_package_group_id = :customer_package_group_id, updated_on= :updated_on WHERE tracking_number = :package_tracking_number";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'package_tracking_number' => $package_tracking_number,
            'customer_package_group_id'  => $customer_package_group_id,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update = true;
    }

    return $update;
}

//Fonction de récupération du numéro de suivi d'un groupe de colis
function select_packagegroup_trackingnumber(int $package_group_id)
{
    $packagegroup_trackingnumber = [];

    $database = _database_login();

    $request = "SELECT tracking_number FROM customer_package_group WHERE id=:package_group_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_group_id' => $package_group_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $packagegroup_trackingnumber = $data;
        }
    }
    return $packagegroup_trackingnumber;
}

//Fonction de récupération des numéros de suivi des colis d'un groupe de colis
function select_allpackages_forpackagegroup(int $package_group_id)
{
    $allpackages_forpackagegroup = [];

    $database = _database_login();

    $request = "SELECT * FROM package WHERE customer_package_group_id = :package_group_id and is_deleted = :is_deleted ORDER BY id DESC";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_group_id' => $package_group_id,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $allpackages_forpackagegroup = $data;
        }
    }
    return $allpackages_forpackagegroup;
}

//Fonction de mise à jour du champs 'customer_package_group_id' dans la table 'package'
function update_customer_package_group_id_inpackagetable(string $customer_package_group_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_customer_package_group_id = false;

    $database = _database_login();

    $request = "UPDATE package SET customer_package_group_id = NULL, updated_on= :updated_on WHERE customer_package_group_id = :customer_package_group_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'customer_package_group_id' => $customer_package_group_id,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $update_customer_package_group_id = true;
    }

    return $update_customer_package_group_id;
}
