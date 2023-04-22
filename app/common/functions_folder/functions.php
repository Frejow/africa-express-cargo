<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send mail.
 *
 * @param string $destination The destination.
 * @param string $subject The subject.
 * @param string $body The body.
 * @return bool The result.
 */
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

        $mail->Username = 'express.cargo.africa@gmail.com';
        $mail->Password = EMAILING_PASSWORD;

        // Sender and recipient settings
        $mail->setFrom('express.cargo.africa@gmail.com', htmlspecialchars_decode('Africa Express Cargo'));
        $mail->addAddress($destination, $recipient);
        $mail->addReplyTo('express.cargo.africa@gmail.com', htmlspecialchars_decode('Africa Express Cargo'));

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = htmlspecialchars_decode($subject);
        $mail->Body = $body;

        return $mail->send();

    } catch (Exception $e) {

        return false;

    }

}

function secure($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

function connected(): bool
{
    $is_connected = false;

    if (isset($_SESSION["connected"]) && !empty($_SESSION["connected"])) {
        $is_connected = true;
    }

    return $is_connected;
}

function disconnected(): bool
{
    $is_disconnected = false;

    unset($_SESSION['connected']);

    if (!isset($_SESSION["connected"]) || empty($_SESSION["connected"])) {
        $is_disconnected = true;
    }

    return $is_disconnected;
}


function _database_login()
{

    $database = "";

    try {
        $database = new PDO('mysql:host=localhost;dbname='.DATABASE_NAME.';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
    } catch (Exception $e) {
        $database = "Une erreur s'est produite lors de la connexion à la base de donnée.";
    }

    return $database;
}

function check_exist_userby_email(string $mail, int $is_deleted)
{

    $exist_mail = false;

    $database = _database_login();

    $request = "SELECT * FROM user WHERE mail=:mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => $is_deleted
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $exist_mail = true;
        }
    }

    return $exist_mail;
}

function check_exist_userby_pseudo(string $pseudo, int $is_deleted)
{

    $exist_pseudo = false;

    $database = _database_login();

    $request = "SELECT * FROM user WHERE user_name=:pseudo and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'pseudo' => $pseudo,
        'is_deleted' => $is_deleted
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $exist_pseudo = true;
        }
    }

    return $exist_pseudo;
}

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

function buffer_html_file(string $filename) {
    ob_start(); // Démarre la temporisation de sortie
    
    include $filename; // Inclut le fichier HTML dans le tampon
    
    $html = ob_get_contents(); // Récupère le contenu du tampon
    ob_end_clean(); // Arrête et vide la temporisation de sortie
    
    return $html; // Retourne le contenu du fichier HTML
}

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

function check_user_registered_token_info(int $user_id, string $token, string $type, int $is_active, int $is_deleted ):bool
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

            $_SESSION ['connected'] = json_encode($data);

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

            $_SESSION ['connected'] = json_encode($data);

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

function update_personal_info(int $id, string $name, string $first_names, string $user_name, string $country, string $mail, string $phone_number,): bool
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

            $_SESSION ['connected'] = json_encode($data);

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

            $selected = true;
        }
    }

    return $selected;
}

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