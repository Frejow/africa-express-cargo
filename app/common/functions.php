<?php

/** Initialization instance of phpmailer classes */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/** Url redirection based on theme
 *
 * @param string $theme The actual theme running on the site.
 * @param string $link The link to redirect to.
 *
 * @return string $redirect_url The final url to redirect to, including the theme.
 */
function redirect(string $theme, string $link): string
{
    return $link . '?' . $theme;
}

/**
 * @param $params
 * @param string $default_resource
 * @param $session_type
 * @param string $redirectUrl
 * @return mixed|void
 */
function getResource($params, string $default_resource, $session_type, string $redirectUrl)
{
    if (is_array($session_type) && !empty($session_type)) {

        $resource = $params;
    } else {

        $resource = $default_resource;

        setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

        header("location:" . PROJECT . $redirectUrl);

        exit;
    }
    return $resource;
}

/** Securisation of form fields entry
 * 
 * @param mixed $data The data to secure.
 * 
 * @return string $data The final value of $data after passing the process of securisation.
 */
function secure($data): string
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    return stripslashes($data);
}

/** User registration
 * 
 * @param string $name The username.
 * @param string $first_names The user First Names.
 * @param string $phone_number The user Phone Number.
 * @param string $user_name The user Username.
 * @param string $mail The user Mail Address.
 * @param string $country The user Country.
 * @param string $password The user Password.
 * @param string $profile The user type of Profile (CUSTOMER, AGENT or ADMIN)
 * 
 * @return bool The result.
 */
function registration(string $name, string $first_names, string $phone_number, string $user_name, string $mail, string $country, string $password, string $profile): bool
{

    $is_registered = false;

    $database = databaseLogin();

    $request = 'INSERT INTO user(name, first_names, phone_number, user_name, mail, country, password, profile) VALUES (:nom, :prenom, :tel, :pseudo, :mail, :country, :pass, :profile)';

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'nom' => $name,
            'prenom' => $first_names,
            'tel' => $phone_number,
            'pseudo' => $user_name,
            'mail' => $mail,
            'country' => trim(ltrim(preg_replace('/[^\p{L}\p{N}\s]/u', "", $country))),
            'pass' => sha1($password),
            'profile' => $profile,
        ]
    );

    if ($request_execution) {

        $is_registered = true;
    }

    return $is_registered;
}

/** Mail sending
 * 
 * @param string $destination The destination mail address.
 * @param string $recipient The username of the user which own the destination mail address.
 * @param string $subject The subject.
 * @param string $body The body.
 * 
 * @return bool The result.
 */
function mailSendin(string $destination, string $recipient, string $subject, string $body): bool
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

/** Account deletion at registration in case of validation mail sending failed
 * 
 * @param int $id The user id.
 * @param string $mail The mail address submitted by user at registration.
 * 
 * @return bool The result.
 */
function backDeletedAccount(int $id, string $mail): bool
{
    date_default_timezone_set("Africa/Lagos");

    $backDeletedAccount = false;

    $database = databaseLogin();

    $request = "UPDATE user SET mail = :mail, user_name = :user_name, phone_number = :phone_number, is_active = :is_active, is_deleted = :is_deleted, updated_on = :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'mail' => $mail . '_was_deleted',
            'user_name' => 'this_user_name_was_deleted',
            'phone_number' => 'this_user_phone_number_was_deleted',
            'is_active' => 0,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $backDeletedAccount = true;
    }

    return $backDeletedAccount;
}

/** Convert a date to number
 * 
 * @param string $date The date to convert.
 * 
 * @return string $date The result after conversion.
 */
function dateToNumber(string $date): string
{
    $date = str_replace("-", '', $date);
    $date = str_replace(":", '', $date);
    return str_replace(" ", '', $date);
}

/** Check user account connected
 * 
 * @return bool The result.
 */
function connected(): bool
{
    $is_connected = false;

    if (!empty($_SESSION["connected"])) {
        $is_connected = true;
    }

    return $is_connected;
}

/** Check user account disconnected
 * 
 * @return bool The result.
 */
function disconnected(): bool
{
    $is_disconnected = false;

    unset($_SESSION['connected']);

    if (empty($_SESSION["connected"])) {
        $is_disconnected = true;
    }

    return $is_disconnected;
}

/** Connect to database
 *
 * @return object $database The result.
 */
function databaseLogin(): object
{

    $database = "";

    try {
        $database = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
    } catch (Exception $e) {
        $database = "Une erreur a été détecté lors de la connexion à la base de donnée.";
    }

    return $database;
}

/** Check already exist submitted value in database
 * 
 * @param string $table The table name.
 * @param string $fieldtype The field type which value was submitted.
 * @param string $fieldentry The value submitted.
 * @param mixed $additionalfieldtype
 * @param mixed $additionalfieldentry
 * 
 * @return bool The result.
 */
function checkFieldEntry(string $table, string $fieldtype, string $fieldentry, $additionalfieldtype = null, $additionalfieldentry = null): bool
{

    $exist_fieldentry = false;

    $database = databaseLogin();

    if (is_null($additionalfieldtype) && is_null($additionalfieldentry)) {
        $request = "SELECT * FROM " . $table . " WHERE " . $fieldtype . "=:fieldtype and is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'fieldtype' => $fieldentry,
            'is_deleted' => 0
        ]);
    } else {
        $request = "SELECT * FROM " . $table . " WHERE " . $fieldtype . "=:fieldtype and " . $additionalfieldtype . "=:additionalfieldtype and is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'fieldtype' => $fieldentry,
            'additionalfieldtype' => $additionalfieldentry,
            'is_deleted' => 0
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $exist_fieldentry = true;
        }
    }

    return $exist_fieldentry;
}

/** Check new mail address associate to old(s) deleted account(s)
 * 
 * @param string $mail The new mail address.
 * 
 * @return array $mail_assoc_to_deleted_account All deleted account(s) with a mail address that match with the new one.
 */
function checkMailAssocToDeletedAccount(string $mail): array
{

    $mail_assoc_to_deleted_account = [];

    $database = databaseLogin();

    $request = "SELECT * FROM user WHERE mail = :mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 1
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $mail_assoc_to_deleted_account = $data;
        }
    }

    return $mail_assoc_to_deleted_account;
}

/** Update account status
 * 
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function updateAccountStatus(int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updateAccountStatus = false;

    $database = databaseLogin();

    $request = "UPDATE user SET is_valid_mail = :valid_mail, is_valid_account = :valid_account, is_active = :active, is_deleted = :deleted, updated_on = :updated_on WHERE id = :user_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'user_id'  => $user_id,
            'valid_mail' => 1,
            'valid_account' => 1,
            'active' => 1,
            'deleted' => 0,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $updateAccountStatus = true;
    }

    return $updateAccountStatus;
}

/** Get user id by mail address 
 * 
 * @param string $mail The user mail address.
 * 
 * @return array $user_id The user id.
 */
function getUserId(string $mail): array
{
    $user_id = [];

    $database = databaseLogin();

    $request = "SELECT id FROM user WHERE mail=:mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $user_id = $data;
        }
    }
    return $user_id;
}

/** Get user mail and username by id 
 * 
 * @param int $user_id The user id.
 * 
 * @return array $mail_pseudo The mail and the username.
 */
function getUserMailAndUsername(int $user_id): array
{
    $mail_pseudo = [];

    $database = databaseLogin();

    $request = "SELECT mail, user_name FROM user WHERE id=:user_id and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'is_deleted' => 1
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $mail_pseudo = $data;
        }
    }
    return $mail_pseudo;
}

/** Get user username by mail address 
 * 
 * @param string $mail The mail address.
 * 
 * @return array $user_name The username.
 */
function getUsername(string $mail): array
{
    $user_name = [];

    $database = databaseLogin();

    $request = "SELECT user_name FROM user WHERE mail=:mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $user_name = $data;
        }
    }
    return $user_name;
}

/** Get all not deleted rows of tokens table
 * 
 * @return array $getAllActiveTokens All concerned rows.
 */
function getAllActiveTokens(): array
{
    $getAllActiveTokens = [];

    $database = databaseLogin();

    $request = "SELECT * FROM token WHERE is_deleted=:is_deleted and updated_on = :updated_on";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'is_deleted' => 0,
        'updated_on' => 'null'
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchALL(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $getAllActiveTokens = $data;
        }
    }
    return $getAllActiveTokens;
}

/** Token insertion
 * 
 * @param int $user_id The user id.
 * @param string $type The type of token.
 * @param string $token The token.
 * 
 * @return bool The result.
 */
function insertTokenInTokenTable(int $user_id, string $type, string $token): bool
{

    $insertion = false;

    $database = databaseLogin();

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

/** Check if token still valid
 * 
 * @param int $user_id The user id.
 * @param string $token The token.
 * @param string $type The type of token.
 * @param int $is_active The active status of the token.
 * @param int $is_deleted The delete status of the token.
 * 
 * @return bool The result.
 */
function checkUserRegisteredTokenInf(int $user_id, string $token, string $type, int $is_active, int $is_deleted): bool
{

    $info_found = false;

    $database = databaseLogin();

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

        if (!empty($data) && is_array($data)) {

            $info_found = true;
        }
    }

    return $info_found;
}

/** Get token creation date and update date
 * 
 * @param int $user_id The user id.
 * @param string $token The token.
 * 
 * @return array $token_date_info The creation date and the update date
 */
function getTokenDateInf(int $user_id, string $token): array
{

    $token_date_info = [];

    $database = databaseLogin();

    $request = "SELECT created, updated_on FROM token WHERE user_id=:user_id and token=:token";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'token' => $token,
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $token_date_info = $data;
        }
    }

    return $token_date_info;
}

/** Update token table
 * 
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function updateTokenTable(int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updateTokenTable = false;

    $database = databaseLogin();

    $request = "UPDATE token SET is_active = :is_active, is_deleted = :is_deleted, updated_on= :updated_on WHERE user_id = :user_id and is_deleted = 0";

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

        $updateTokenTable = true;
    }

    return $updateTokenTable;
}

/** Update password
 * 
 * @param string $mail The mail address.
 * @param string $password The password.
 * 
 * @return bool The result.
 */
function updatePassword(string $mail, string $password): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updatePassword = false;

    $database = databaseLogin();

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

        $updatePassword = true;
    }

    return $updatePassword;
}

/** Check information submitted by user at login (email & password)
 * 
 * @param string $mail The mail address.
 * @param string $password The password.
 * @param string $profile The profile type (CUSTOMER, AGENT or ADMIN).
 * @param int $is_valid_account The valid account status of the user.
 * @param int $is_active The active status of the user.
 * @param int $is_deleted The delete status of the user.
 * 
 * @return array It contains the user personal information encode in json response.
 */
function retrieveUserbyEmailAndPassword(string $mail, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted)
{

    $values = [];

    $database = databaseLogin();

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

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $values = json_encode($data);
        }
    }

    return $values;
}

/** Check information submitted by user at login (username & password)
 * 
 * @param string $pseudo The username.
 * @param string $password The password.
 * @param string $profile The profile type (CUSTOMER, AGENT or ADMIN).
 * @param int $is_valid_account The valid account status of the user.
 * @param int $is_active The active status of the user.
 * @param int $is_deleted The delete status of the user.
 * 
 * @return string It contains the user personal information encode in json response.
 */
function retrieveUserbyPseudoAndPassword(string $pseudo, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted)
{

    $values = [];

    $database = databaseLogin();

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

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $values = json_encode($data);
        }
    }

    return $values;
}

/** Update user personal information
 * 
 * @param int $id The user id.
 * @param string $name The Name of user.
 * @param string $first_names The user First Names.
 * @param string $user_name The user Username.
 * @param string $country The user Country.
 * @param string $mail The user Mail Address.
 * @param string $phone_number The user Phone Number.
 * 
 * @return bool The result.
 */
function updatePersonalInf(int $id, string $name, string $first_names, string $user_name, string $country, string $mail, string $phone_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updating = false;

    $database = databaseLogin();

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

/** Get user information's after update
 * 
 * @param int $id The user id.
 * 
 * @return array $selected Updated user information.
 */
function getUserPersonalInf(int $id)
{

    $selected = [];

    $database = databaseLogin();

    $request = "SELECT id, name, first_names, phone_number, user_name, mail, country, avatar FROM user WHERE id=:id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $selected = json_encode($data);
        }
    }

    return $selected;
}

/** Check user password
 * 
 * @param int $id The user id.
 * @param string $password The password submitted by user.
 * 
 * @return bool The result.
 */
function checkSubmittedPassword(int $id, string $password): bool
{

    $password_found = false;

    $database = databaseLogin();

    $request = "SELECT password FROM user WHERE id=:id and password = :password";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $id,
        'password' => sha1($password)
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {
            $password_found = true;
        }
    }

    return $password_found;
}

/** Update avatar
 * 
 * @param int $id The user id.
 * @param string $avatar The path to avatar.
 * 
 * @return bool The result.
 */
function updateAvatar(int $id, string $avatar): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updateAvatar = false;

    $database = databaseLogin();

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

        $updateAvatar = true;
    }

    return $updateAvatar;
}

/** Account deactivation
 * 
 * @param int $id The user id.
 * 
 * @return bool The result.
 */
function deactivatedAccount(int $id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_active_field = false;

    $database = databaseLogin();

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

/** Account deletion 
 * 
 * @param int $id The user id.
 * 
 * @return bool The result.
 */
function deletedAccount(int $id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_deleted_field = false;

    $database = databaseLogin();

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

/** Checking
 * 
 * @param string $table The name of table.
 * @param string $where.
 * @param string $thirdParam.
 * 
 * @return bool The result.
 */
function checkingThirdParam(string $table, string $where, string $thirdParam): bool
{

    $checkingThirdParam = false;

    $database = databaseLogin();

    $request = "SELECT * FROM " . $table . " WHERE " . $where . " = :" . $where . " and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        $where => $thirdParam,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {
            $checkingThirdParam = true;
        }
    }

    return $checkingThirdParam;
}

/** Folder deletion
 * 
 * @param string $dir The folder path.
 */
function deleteDir(string $dir)
{
    $contain = scandir($dir);

    foreach ($contain as $value) {

        if ($value != '.' && $value != '..') {

            $path = $dir . '/' . $value;

            if (is_dir($path)) {

                deleteDir($path);
            } else {

                unlink($path);
            }
        }
    }
    rmdir($dir);
}

/** Add package
 * 
 * @param string $tracking_number The package tracking number.
 * @param int $package_units_number The number of packages.
 * @param int $worth The package worth in terms of amount.
 * @param string $description Package description.
 * @param int $net_weight Package net weight.
 * @param int $volumetric_weight Package volumetric weight.
 * @param string $product_type Product type according to package nature.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function addPackage(
    string $tracking_number,
    int    $package_units_number,
    int    $worth,
    string $description,
    int    $net_weight,
    int    $volumetric_weight,
    string $product_type,
    int    $user_id
): bool {

    $insertion = false;

    $database = databaseLogin();

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

/** Add package image in packages_images table
 * 
 * @param int $package_id The package id.
 * @param string $image The image path.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function addImagesForPackage(int $package_id, string $image, int $user_id): bool
{

    $insertion = false;

    $database = databaseLogin();

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

/** Get Package id by tracking number
 * 
 * @param string $trackN The package tracking number.
 * 
 * @return array $package_id The package id.
 */
function getPackageId(string $trackN): array
{
    $package_id = [];

    $database = databaseLogin();

    $request = "SELECT id FROM package WHERE tracking_number=:trackN";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'trackN' => $trackN
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $package_id = $data;
        }
    }
    return $package_id;
}

/** Check package id in packages_images table
 * 
 * @param string $package_id Package id.
 * 
 * @return bool The result.
 */
function checkPackageIdInPackagesImagesTab(string $package_id): bool
{

    $package_id_found = false;

    $database = databaseLogin();

    $request = "SELECT package_id FROM packages_images WHERE package_id = :package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_id' => $package_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {
            $package_id_found = true;
        }
    }

    return $package_id_found;
}

/** Get package images
 * 
 * @param int $package_id Package id.
 * 
 * @return array $packages_images All images provide for this package.
 */
function getPackageImages(int $package_id): array
{
    $package_images = [];

    $database = databaseLogin();

    $request = "SELECT images FROM packages_images WHERE package_id=:package_id and is_deleted=:is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_id' => $package_id,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $package_images = $data;
        }
    }
    return $package_images;
}

/** Listing packages or packages group
 * 
 * @param string $table The name of table.
 * @param int $page The page number.
 * @param int $rows_per_page Packages number to show per page.
 * @param string $status Package status
 * @param string $search The value of search field. 
 * @param mixed $packages_type The user id.
 * @param mixed $user_id The user id.
 * 
 * @return array $list All packages list based on the provide values of the function parameters.
 */
function listings(string $table, int $page, int $rows_per_page, string $status, string $search, $type = null, $user_id = null): array
{

    $list = [];

    $database = databaseLogin();

    if (!is_null($user_id)) {

        if ($status === 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'user_id' => $user_id,
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and status = :status and is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

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
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

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
            $request .= " AND status = :status ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'user_id' => $user_id,
                'status' => $status,
                'is_deleted' => 0,
            ]);
        }
    } elseif (is_null($user_id) && ($type == 'Tous les colis' || $type == 'Tous les groupes de colis')) {

        if ($status === 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE status = :status AND is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        } elseif ($status === 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " AND status = :status ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        }
    } elseif (is_null($user_id) && ($type == 'Colis avec destinataire' || $type == 'Groupes de colis clients')) {

        if ($status === 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id <> " . ANONYMOUS_ID . " AND is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id <> " . ANONYMOUS_ID . " AND status = :status AND is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        } elseif ($status === 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id <> " . ANONYMOUS_ID . " AND is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id <> " . ANONYMOUS_ID . " AND is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " AND status = :status ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        }
    } elseif (is_null($user_id) && ($type == 'Colis sans destinataire' || $type == 'Groupes de colis expédition')) {

        if ($status === 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = " . ANONYMOUS_ID . " AND is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = " . ANONYMOUS_ID . " AND status = :status AND is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        } elseif ($status === 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = " . ANONYMOUS_ID . " AND is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($status !== 'Tout Afficher' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE user_id = " . ANONYMOUS_ID . " AND is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " AND status = :status ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'status' => $status,
                'is_deleted' => 0,
            ]);
        }
    }


    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $list = $data;
        }
    }

    return $list;
}

/** Number of rows in a package or packages group table
 * 
 * @param string $table The name of table.
 * @param mixed $packages_type.
 * @param mixed $user_id.
 * 
 * @return array $rows The number of rows.
 */
function countRowsInTable(string $table, $packages_type = null, $user_id = null, $profile = null, $cnctdprofile_id = null): array
{

    $rows = [];

    $database = databaseLogin();

    if (!is_null($user_id)) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE is_deleted = :is_deleted and user_id = :user_id";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "is_deleted" => 0,
                "user_id" => $user_id
            ]
        );
    } elseif (is_null($user_id) && ($packages_type == 'Tous les colis' || $packages_type == 'Tous les groupes de colis')) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "is_deleted" => 0,
            ]
        );
    } elseif (is_null($user_id) && ($packages_type == 'Colis avec destinataire' || $packages_type == 'Groupes de colis clients')) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE user_id <> " . ANONYMOUS_ID . " AND is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "is_deleted" => 0,
            ]
        );
    } elseif (is_null($user_id) && ($packages_type == 'Colis sans destinataire' || $packages_type == 'Groupes de colis expédition')) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE user_id = " . ANONYMOUS_ID . " AND is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "is_deleted" => 0,
            ]
        );
    } elseif (is_null($user_id) && is_null($packages_type) && is_null($profile)) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "is_deleted" => 0,
            ]
        );
    } elseif (is_null($user_id) && is_null($packages_type) && !is_null($profile) && is_null($cnctdprofile_id)) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE profile = :profile AND is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "profile" => $profile,
                "is_deleted" => 0,
            ]
        );
    } elseif (is_null($user_id) && is_null($packages_type) && !is_null($profile) && !is_null($cnctdprofile_id)) {

        $request = "SELECT COUNT(*) FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " AND profile = :profile AND is_deleted = :is_deleted";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                "profile" => $profile,
                "is_deleted" => 0,
            ]
        );
    }

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        $rows = $data;
    }

    return $rows;
}

/** Package or packages group deletion
 * 
 * @param string $tracking_number Package or packages group tracking_number.
 * @param string $table The name of the table.
 * 
 * @return bool The result.
 */
function deletedPackageOrPackagesGroup(string $tracking_number, string $table): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_is_deleted_field = false;

    $database = databaseLogin();

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

/** Insert packages group in 'customer_package_group' table and get the packages group id
 * 
 * @param string $tracking_number Packages group tracking number.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function insertNewPackagesGroupAndGetId(string $tracking_number, int $user_id): bool
{

    $insertselect = false;

    $database = databaseLogin();

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

            $data = $selectrequest_prepare->fetch(PDO::FETCH_ASSOC);

            if (!empty($data) && is_array($data)) {

                $_SESSION['nowcreated_packagegroup_id'] = $data;

                $insertselect = true;
            }
        }
    }

    return $insertselect;
}

/** Link packages group to package
 * 
 * @param int $customer_package_group_id Packages group id.
 * @param string $package_tracking_number Package tracking number.
 * 
 * @return bool The result.
 */
function linkSpecificPackagesGroupToPackage(int $customer_package_group_id, string $package_tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $linkSpecificPackagesGroupToPackage = false;

    $database = databaseLogin();

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

        $linkSpecificPackagesGroupToPackage = true;
    }

    return $linkSpecificPackagesGroupToPackage;
}

/** Unlink packages group to package
 * 
 * @param int $customer_package_group_id Packages group id.
 * @param string $tracking_number Package tracking number.
 * 
 * @return bool The result.
 */
function unlinkSpecificPackagesGroupOfPackage(int $customer_package_group_id, string $tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $unlinkSpecificPackagesGroupOfPackage = false;

    $database = databaseLogin();

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

        $unlinkSpecificPackagesGroupOfPackage = true;
    }

    return $unlinkSpecificPackagesGroupOfPackage;
}

/** Get packages group tracking number
 * 
 * @param int $package_group_id Packages group id.
 * 
 * @return array $packagegroup_trackingnumber The tracking number. 
 */
function getPackagesGroupTrackingNumber(int $package_group_id): array
{
    $packagegroup_trackingnumber = [];

    $database = databaseLogin();

    $request = "SELECT tracking_number FROM customer_package_group WHERE id=:package_group_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_group_id' => $package_group_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $packagegroup_trackingnumber = $data;
        }
    }
    return $packagegroup_trackingnumber;
}

/** Get all tracking numbers of all packages in a packages group
 * 
 * @param int $package_group_id Packages group id.
 * 
 * @return array $allpackages_inpackagegroup All packages concerned.
 */
function getAllPackagesLinkedToSpecificPackagesGroup(int $package_group_id): array
{
    $allpackages_inpackagegroup = [];

    $database = databaseLogin();

    $request = "SELECT * FROM package WHERE customer_package_group_id = :package_group_id and is_deleted = :is_deleted ORDER BY id DESC";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_group_id' => $package_group_id,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $allpackages_inpackagegroup = $data;
        }
    }
    return $allpackages_inpackagegroup;
}

/** Unlink packages group to all packages concerned according to packages group id
 *
 * @param int $customer_package_group_id Packages group id.
 * @return bool The result.
 */
function unlinkSpecificPackagesGroupOfAllPackages(int $customer_package_group_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $unlinkSpecificPackagesGroupOfAllPackages = false;

    $database = databaseLogin();

    $request = "UPDATE package SET customer_package_group_id = NULL, updated_on= :updated_on WHERE customer_package_group_id = :customer_package_group_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'customer_package_group_id' => $customer_package_group_id,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $unlinkSpecificPackagesGroupOfAllPackages = true;
    }

    return $unlinkSpecificPackagesGroupOfAllPackages;
}

/** Update package status
 * 
 * @param string $tracking_number The user id.
 * @param string $status The path to avatar.
 * 
 * @return bool The result.
 */
function updatePackageStatus(string $tracking_number, string $status): bool
{
    date_default_timezone_set("Africa/Lagos");

    $updatePackageStatus = false;

    $database = databaseLogin();

    $request = "UPDATE package SET status = :status, updated_on= :updated_on WHERE tracking_number = :tracking_number";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'tracking_number'  => $tracking_number,
            'status' => $status,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $updatePackageStatus = true;
    }

    return $updatePackageStatus;
}

/** Check if there is atleast one active package with delivered status
 * 
 * @return array The result.
 */
function checkDeliveredStatus(): array
{

    $packageDelivered = [];

    $database = databaseLogin();

    $request = "SELECT * FROM package WHERE status = :status and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'status' => 'Livrer',
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {
            $packageDelivered = $data;
        }
    }

    return $packageDelivered;
}

/** Add product type
 * 
 * @param string $name.
 * @param int $billing_per_kg.
 * @param int $billing_per_cbm.
 * @param int $billing_per_pcs.
 * @param int $billing_per_kg_with_insurance.
 * @param int $billing_per_cbm_with_insurance.
 * @param int $billing_per_pcs_with_insurance.
 * 
 * @return bool The result.
 */
function addProduct(string $name, int $billing_per_kg, int $billing_per_cbm, int $billing_per_pcs, int $billing_per_kg_with_insurance, int $billing_per_cbm_with_insurance, int $billing_per_pcs_with_insurance, int $have_insurance): bool
{

    $addProduct = false;

    $database = databaseLogin();

    $request = "INSERT INTO product_type (name, billing_per_kg, billing_per_cbm, billing_per_pcs, billing_per_kg_with_insurance, billing_per_cbm_with_insurance, billing_per_pcs_with_insurance, have_insurance) 
    VALUES (:name, :billing_per_kg, :billing_per_cbm, :billing_per_pcs, :billing_per_kg_with_insurance, :billing_per_cbm_with_insurance, :billing_per_pcs_with_insurance, :have_insurance)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'name' => $name,
            'billing_per_kg' => $billing_per_kg,
            'billing_per_cbm' => $billing_per_cbm,
            'billing_per_pcs' => $billing_per_pcs,
            'billing_per_kg_with_insurance' => $billing_per_kg_with_insurance,
            'billing_per_cbm_with_insurance' => $billing_per_cbm_with_insurance,
            'billing_per_pcs_with_insurance' => $billing_per_pcs_with_insurance,
            'have_insurance' => $have_insurance,
        ]
    );

    if ($request_execution) {
        $addProduct = true;
    }

    return $addProduct;
}

/** Listing
 * 
 * @param string $table The name of table.
 * @param int $page The page number.
 * @param int $rows_per_page Number to show per page.
 * @param string $search The value of search field. 
 * @param string $researchBy.
 * @param string $orderBy.
 * @param string $profile.
 * @param int $cnctdprofile_id.
 * 
 * @return array $list The list.
 */
function othListings(string $table, int $page, int $rows_per_page, string $search, string $researchBy, string $orderBy, string $profile = null, int $cnctdprofile_id = null): array
{

    $list = [];

    $database = databaseLogin();

    if (is_null($profile)) {

        if ($orderBy === 'Par défaut' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Par défaut' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'is_deleted' => 0,
            ]);
        }
    } elseif (!is_null($profile) && is_null($cnctdprofile_id)) {

        if ($orderBy === 'Par défaut' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Par défaut' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        }
    } elseif (!is_null($profile) && !is_null($cnctdprofile_id)) {

        if ($orderBy === 'Par défaut' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search === 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Par défaut' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY id DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'A - Z' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name ASC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        } elseif ($orderBy === 'Z - A' && $search !== 'UNDEFINED') {

            $request = "SELECT * FROM " . $table . " WHERE id <> " . $cnctdprofile_id . " and is_deleted = :is_deleted and profile = :profile AND ";

            $search_terms_array = str_split($search);

            $search_terms_count = count($search_terms_array);

            for ($i = 0; $i < $search_terms_count; $i++) {
                $request .= $researchBy . " LIKE '%" . $search_terms_array[$i] . "%'";
                if ($i != $search_terms_count - 1) {
                    $request .= " AND ";
                }
            }
            $request .= " ORDER BY name DESC LIMIT " . $rows_per_page . " OFFSET " . ($page - 1) * $rows_per_page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'profile' => $profile,
                'is_deleted' => 0,
            ]);
        }
    }


    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $list = $data;
        }
    }

    return $list;
}

/** Listing in select field 
 * 
 * @param string $table Name of table
 * @param int $user_id The user id.
 * 
 * @return array $selectFieldListing.
 */
function selectFieldListing(string $table, string $profile = null, int $user_id = null): array
{
    $selectFieldListing = [];

    $database = databaseLogin();

    if (is_null($profile) && !is_null($user_id)) {

        $request = "SELECT * FROM " . $table . " WHERE user_id = :user_id and is_deleted = :is_deleted and customer_package_group_id IS NULL ORDER BY id DESC";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'user_id' => $user_id,
            'is_deleted' => 0,
        ]);
    } elseif (!is_null($profile) && is_null($user_id)) {

        $request = "SELECT * FROM " . $table . " WHERE profile = :profile and is_deleted = :is_deleted and is_active = :is_active ORDER BY name ASC";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'profile' => $profile,
            'is_deleted' => 0,
            'is_active' => 1
        ]);
    } elseif (is_null($profile) && is_null($user_id)) {

        $request = "SELECT * FROM " . $table . " WHERE is_deleted = :is_deleted and is_active = :is_active ORDER BY name ASC";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'is_deleted' => 0,
            'is_active' => 1
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $selectFieldListing = $data;
        }
    }

    return $selectFieldListing;
}

/** Get product
 * 
 * @param int $product_id.
 * 
 * @return array $getProduct.
 */
function getProduct(int $product_id): array
{
    $getProduct = [];

    $database = databaseLogin();

    $request = "SELECT * FROM product_type WHERE id = :id and is_active = :is_active and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $product_id,
        'is_active' => 1,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $getProduct = $data;
        }
    }
    return $getProduct;
}

/** Add shipping type
 * 
 * @param string $name.
 * @param string $delivery_time.
 * 
 * @return bool The result.
 */
function addShipping(string $name, string $delivery_time): bool
{

    $addShipping = false;

    $database = databaseLogin();

    $request = "INSERT INTO shipping_type (name, delivery_time) VALUES (:name, :delivery_time)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'name' => $name,
            'delivery_time' => $delivery_time,
        ]
    );

    if ($request_execution) {
        $addShipping = true;
    }

    return $addShipping;
}

/** Add package
 * 
 * @param string $tracking_number The package tracking number.
 * @param int $package_units_number The number of packages.
 * @param int $worth The package worth in terms of amount.
 * @param string $description Package description.
 * @param int $net_weight Package net weight.
 * @param int $volumetric_weight Package volumetric weight.
 * @param string $product_type Product type according to package nature.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function addPackge(
    string $tracking_number,
    int    $package_units_number,
    string $worth,
    string $description,
    string $net_weight,
    string $volumetric_weight,
    int    $shipping_unit_cost,
    string $shipping_cost,
    string $product_type,
    string $shipping_type,
    string $status,
    int    $user_id,
    int    $product_type_id,
    int    $shipping_type_id
): bool {

    $insertion = false;

    $database = databaseLogin();

    $request = "INSERT INTO package (tracking_number, package_units_number, worth, description, net_weight, volumetric_weight, shipping_unit_cost, shipping_cost, product_type, shipping_type, status, user_id, product_type_id, shipping_type_id) 
    VALUES (:tracking_number, :package_units_number, :worth, :description, :net_weight, :volumetric_weight, :shipping_unit_cost, :shipping_cost, :product_type, :shipping_type, :status, :user_id, :product_type_id, :shipping_type_id)";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'tracking_number' => $tracking_number,
            'package_units_number' => $package_units_number,
            'worth' => $worth,
            'description' => $description,
            'net_weight' => $net_weight,
            'volumetric_weight' => $volumetric_weight,
            'shipping_unit_cost' => $shipping_unit_cost,
            'shipping_cost' => $shipping_cost,
            'product_type' => $product_type,
            'shipping_type' => $shipping_type,
            'status' => $status,
            'user_id' => $user_id,
            'product_type_id' => $product_type_id,
            'shipping_type_id' => $shipping_type_id
        ]
    );

    if ($request_execution) {

        $insertion = true;
    }

    return $insertion;
}

/** Get no addressee packages images
 * 
 * @param int $user_id
 * 
 * @return array $getNoAddresseePackagesImages.
 */
function getNoAddresseePackagesImages(int $user_id): array
{
    $getNoAddresseePackagesImages = [];

    $database = databaseLogin();

    $request = "SELECT * FROM packages_images WHERE user_id = :user_id and is_active = :is_active and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'is_active' => 1,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $getNoAddresseePackagesImages = $data;
        }
    }
    return $getNoAddresseePackagesImages;
}

/** Delete image in package images table
 * 
 * @param int $package_id.
 * 
 * @return bool The result.
 */
function deleteImgInPackageImagesTable(int $package_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $deleteImgInPackageImagesTable = false;

    $database = databaseLogin();

    $request = "UPDATE packages_images SET is_deleted = :is_deleted, updated_on= :updated_on WHERE package_id = :package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'package_id'  => $package_id,
            'is_deleted' => 1,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $deleteImgInPackageImagesTable = true;
    }

    return $deleteImgInPackageImagesTable;
}

/** Update user_id in package table
 * 
 * @param int $package_id.
 * @param int $user_id.
 * 
 * @return bool The result.
 */
function assocPackageToOwner(int $package_id, int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $assocPackageToOwner = false;

    $database = databaseLogin();

    $request = "UPDATE package SET user_id = :user_id, updated_on= :updated_on WHERE id = :package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'package_id'  => $package_id,
            'user_id' => $user_id,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $assocPackageToOwner = true;
    }

    return $assocPackageToOwner;
}

/** Get information about the package to edit.
 * 
 * @param int $package_id
 * 
 * @return array $getPackageToEdit.
 */
function getPackageToEdit(int $package_id): array
{
    $getPackageToEdit = [];

    $database = databaseLogin();

    $request = "SELECT * FROM package WHERE id = :id and is_active = :is_active and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $package_id,
        'is_active' => 1,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $getPackageToEdit = $data;
        }
    }
    return $getPackageToEdit;
}

/** Update package table
 * 
 * @param int $package_id.
 * 
 * @return bool The result.
 */
function updatePackageTable(
    int    $package_id,
    string $tracking_number,
    int    $package_units_number,
    string $worth,
    string $description,
    string $net_weight,
    string $volumetric_weight,
    int    $shipping_unit_cost,
    string $shipping_cost,
    string $product_type,
    string $shipping_type,
    string $status,
    int    $user_id,
    int    $product_type_id,
    int    $shipping_type_id
): bool {
    date_default_timezone_set("Africa/Lagos");

    $updatePackageTable = false;

    $database = databaseLogin();

    $request = "UPDATE package SET tracking_number = :tracking_number, package_units_number = :package_units_number, worth = :worth, description = :description, net_weight = :net_weight, volumetric_weight = :volumetric_weight, shipping_unit_cost = :shipping_unit_cost, shipping_cost = :shipping_cost, product_type = :product_type, shipping_type = :shipping_type, status = :status, user_id = :user_id, product_type_id = :product_type_id, shipping_type_id = :shipping_type_id, updated_on= :updated_on WHERE id = :package_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'package_id'  => $package_id,
            'tracking_number' => $tracking_number,
            'package_units_number' => $package_units_number,
            'worth' => $worth,
            'description' => $description,
            'net_weight' => $net_weight,
            'volumetric_weight' => $volumetric_weight,
            'shipping_unit_cost' => $shipping_unit_cost,
            'shipping_cost' => $shipping_cost,
            'product_type' => $product_type,
            'shipping_type' => $shipping_type,
            'status' => $status,
            'user_id' => $user_id,
            'product_type_id' => $product_type_id,
            'shipping_type_id' => $shipping_type_id,
            'updated_on' => date('Y-m-d H:i:s')
        ]
    );

    if ($request_execution) {

        $updatePackageTable = true;
    }

    return $updatePackageTable;
}
