<?php

/** Initialization instance of phpmailer classes */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/** Url redirection based on theme
 * 
 * @param string $theme The actual theme running on the site.
 * @param string $link The link to redirect to.
 * 
 * @return $redirect_url The final url to redirect to, including the theme.
 */
function redirect(string $theme, string $link) {

    $redirect_url = $link.'?'.$theme;

    return $redirect_url;

}

/** Securisation of form fields entry
 * 
 * @param $data The data to secure.
 * 
 * @return string $data The final value of $data after passing the process of securisation.
 */
function secure($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

/** User registration
 * 
 * @param $name The user Name.
 * @param $first_names The user First Names.
 * @param $phone_number The user Phone Number.
 * @param $user_name The user Username.
 * @param $mail The user Mail Address.
 * @param $country The user Country.
 * @param $password The user Password.
 * @param $profile The user type of Profile (CUSTOMER, AGENT or ADMIN)
 * 
 * @return bool The result.
*/
function registration($name, $first_names, $phone_number, $user_name, $mail, $country, $password, $profile): bool
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

/** Mail sending
 * 
 * @param string $destination The destination mail address.
 * @param string $recipient The username of the user which own the destination mail address.
 * @param string $subject The subject.
 * @param string $body The body.
 * 
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
function back_deleted_account(int $id, string $mail): bool
{
    date_default_timezone_set("Africa/Lagos");

    $back_deleted_account = false;

    $database = _database_login();

    $request = "UPDATE user SET mail = :mail, user_name = :user_name, phone_number = :phone_number, is_active = :is_active, is_deleted = :is_deleted, updated_on = :updated_on WHERE id = :id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id'  => $id,
            'mail' => $mail.'_was_deleted',
            'user_name' => 'this_user_name_was_deleted',
            'phone_number' => 'this_user_phone_number_was_deleted',
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

/** Convert a date to number
 * 
 * @param $date The date to convert.
 * 
 * @return int $date The result after conversion.
 */
function date_to_number($date)
{
    $date = str_replace("-", '', $date);
    $date = str_replace(":", '', $date);
    $date = str_replace(" ", '', $date);
    return $date;
}

/** Check user account connected
 * 
 * @return bool The result.
 */
function connected(): bool
{
    $is_connected = false;

    if (isset($_SESSION["connected"]) && !empty($_SESSION["connected"])) {
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

    if (!isset($_SESSION["connected"]) || empty($_SESSION["connected"])) {
        $is_disconnected = true;
    }

    return $is_disconnected;
}

/** Connect to database
 * 
 * @return object $database The result.
 */
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

/** Check already exist submitted value in database
 * 
 * @param string $fieldtype The field type which value was submitted.
 * @param string $fieldentry The value submitted.
 * 
 * @return bool The result.
 */
function check_exist_fieldentry(string $fieldtype, string $fieldentry): bool
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

/** Check new mail address associate to old(s) deleted account(s)
 * 
 * @param string $mail The new mail address.
 * 
 * @return array $mail_assoc_to_deleted_account All deleted account(s) with a mail address that match with the new one.
 */
function check_mail_assoc_to_deleted_account(string $mail)
{

    $mail_assoc_to_deleted_account = [];

    $database = _database_login();

    $request = "SELECT * FROM user WHERE mail = :mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 1
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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
function update_account_status(int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_account_status = false;

    $database = _database_login();

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

        $update_account_status = true;
    }

    return $update_account_status;
}

/** Get user id by mail address 
 * 
 * @param string $mail The user mail address.
 * 
 * @return array $user_id The user id.
*/
function get_user_id(string $mail)
{
    $user_id = [];

    $database = _database_login();

    $request = "SELECT id FROM user WHERE mail=:mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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
function get_user_mail_and_username(int $user_id)
{
    $mail_pseudo = [];

    $database = _database_login();

    $request = "SELECT mail, user_name FROM user WHERE id=:user_id and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'is_deleted' => 1
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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
function get_username(string $mail)
{
    $user_name = [];

    $database = _database_login();

    $request = "SELECT user_name FROM user WHERE mail=:mail and is_deleted = :is_deleted";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'mail' => $mail,
        'is_deleted' => 0
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $user_name = $data;
        }
    }
    return $user_name;
}

/** Get all not deleted rows of tokens table
 * 
 * @return array $get_all_active_tokens All concerned rows.
 */
function get_all_active_tokens()
{
    $get_all_active_tokens = [];

    $database = _database_login();

    $request = "SELECT * FROM token WHERE is_deleted=:is_deleted and updated_on = :updated_on";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'is_deleted' => 0,
        'updated_on' => 'null'
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchALL(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $get_all_active_tokens = $data;
        }
    }
    return $get_all_active_tokens;
}

/** Token insertion
 * 
 * @param int $user_id The user id.
 * @param string $type The type of token.
 * @param string $token The token.
 * 
 * @return bool The result.
 */
function insert_token_in_token_table(int $user_id, string $type, string $token): bool
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
function check_user_registered_token_inf(int $user_id, string $token, string $type, int $is_active, int $is_deleted): bool
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

/** Get token creation date and update date
 * 
 * @param int $user_id The user id.
 * @param string $token The token.
 * 
 * @return array $token_date_info The creation date and the update date
 */
function get_token_date_inf(int $user_id, string $token)
{

    $token_date_info = [];

    $database = _database_login();

    $request = "SELECT created, updated_on FROM token WHERE user_id=:user_id and token=:token";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id,
        'token' => $token,
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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
function update_token_table(int $user_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $update_token_table = false;

    $database = _database_login();

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

        $update_token_table = true;
    }

    return $update_token_table;
}

/** Update password
 * 
 * @param string $mail The mail address.
 * @param string $password The password.
 * 
 * @return bool The result.
 */
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

/** Check informations submitted by user at login (email & password)
 * 
 * @param string $mail The mail address.
 * @param string $password The password.
 * @param string $profile The profile type (CUSTOMER, AGENT or ADMIN).
 * @param int $is_valid_account The valid account status of the user.
 * @param int $is_active The active status of the user.
 * @param int $is_deleted The delete status of the user.
 * 
 * @return array It contain the user personal informations.
 */
function retrieve_userby_email_and_password(string $mail, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted)
{

    $values = [];

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

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $values = json_encode($data);
        }
    }

    return $values;
}

/** Check informations submitted by user at login (username & password)
 * 
 * @param string $pseudo The username.
 * @param string $password The password.
 * @param string $profile The profile type (CUSTOMER, AGENT or ADMIN).
 * @param int $is_valid_account The valid account status of the user.
 * @param int $is_active The active status of the user.
 * @param int $is_deleted The delete status of the user.
 * 
 * @return array It contain the user personal informations.
 */
function retrieve_userby_pseudo_and_password(string $pseudo, string $password, string $profile, int $is_valid_account, int $is_active, int $is_deleted)
{

    $values = [];

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

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $values = json_encode($data); 

        }
    }

    return $values;
}

/** Update user personal informations 
 * 
 * @param int $id The user id.
 * @param string $name The user Name.
 * @param string $first_names The user First Names.
 * @param string $user_name The user Username.
 * @param string $country The user Country.
 * @param string $mail The user Mail Address.
 * @param string $phone_number The user Phone Number.
 * 
 * @return bool The result.
*/
function update_personal_inf(int $id, string $name, string $first_names, string $user_name, string $country, string $mail, string $phone_number): bool
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

/** Get user informations after update
 * 
 * @param int $id The user id.
 * 
 * @return bool The result.
 */
function get_user_personal_inf(int $id): bool
{

    $selected = false;

    $database = _database_login();

    $request = "SELECT id, name, first_names, phone_number, user_name, mail, country, avatar FROM user WHERE id=:id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'id' => $id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $_SESSION['connected'] = json_encode($data);

            $selected = true;
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
function check_submitted_password(int $id, string $password): bool
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

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {
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

/** Account deactivation
 * 
 * @param int $id The user id.
 * 
 * @return bool The result.
 */
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

/** Account deletion 
 * 
 * @param int $id The user id.
 * 
 * @return bool The result.
*/
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

/** Check tracking number
 * 
 * @param string $trackN The tracking number.
 * 
 * @return bool The result.
 */
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

/** Folder deletion
 * 
 * @param $dir The folder path.
 */
function delete_dir($dir) 
{

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

/** Add package
 * 
 * @param string $tracking_number The package tracking number.
 * @param $package_units_number The number of packages.
 * @param $worth The package worth in term of amount.
 * @param string $description Package description.
 * @param $net_weight Package net weight.
 * @param $volumetric_weight Package volumetric weight.
 * @param $product_type Product type according to package nature.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
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

/** Add package image in packages_images table
 * 
 * @param int $package_id The package id.
 * @param string $image The image path.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
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

/** Get Package id by tracking number
 * 
 * @param string $trackN The package tracking number.
 * 
 * @return array $package_id The package id.
 */
function get_package_id(string $trackN)
{
    $package_id = [];

    $database = _database_login();

    $request = "SELECT id FROM package WHERE tracking_number=:trackN";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'trackN' => $trackN
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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

/** Get package images
 * 
 * @param int $package_id Package id.
 * 
 * @return array $packages_images All images provide for this package.
 */
function get_package_images(int $package_id)
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

/** Listing packages or packages group
 * 
 * @param string $table The name of table.
 * @param int $page The page number.
 * @param int $packages_nb_per_page Packages number to show per page.
 * @param string $status Package status
 * @param string $search The value of search field. 
 * @param int $user_id The user id.
 * 
 * @return array $list All packages list based on the provide values of the function parameters.
 */
function listings(string $table, int $page, int $packages_nb_per_page, string $status, string $search, int $user_id)
{

    $list = [];

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

            $list = $data;
        }
    }

    return $list;
}

/** Number of rows in a package or packages group table
 * 
 * @param string $table The name of table.
 * @param int $user_id.
 * 
 * @return array $rows The number of rows.
 */
function count_rows_in_table(string $table, int $user_id)
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
function deleted_package_or_packages_group(string $tracking_number, string $table): bool
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

/** Listing of all unlinked packages to a packages group 
 * 
 * @param int $user_id The user id.
 * 
 * @return array $packages_listing All packages concerned.
*/
function packages_listing_in_select_field(int $user_id)
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

/** Insert packages group in 'customer_package_group' table and get the packages group id
 * 
 * @param string $tracking_number Packages group tracking number.
 * @param int $user_id The user id.
 * 
 * @return bool The result.
 */
function insert_new_packages_group_and_get_id(string $tracking_number, int $user_id): bool
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

            $data = $selectrequest_prepare->fetch(PDO::FETCH_ASSOC);

            if (isset($data) && !empty($data) && is_array($data)) {

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
function link_specific_packages_group_to_package(int $customer_package_group_id, string $package_tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $link_specific_packages_group_to_package = false;

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

        $link_specific_packages_group_to_package = true;
    }

    return $link_specific_packages_group_to_package;
}

/** Unlink packages group to package
 * 
 * @param int $customer_package_group_id Packages group id.
 * @param string $tracking_number Package tracking number.
 * 
 * @return bool The result.
 */
function unlink_specific_packages_group_of_package(string $customer_package_group_id, string $tracking_number): bool
{
    date_default_timezone_set("Africa/Lagos");

    $unlink_specific_packages_group_of_package = false;

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

        $unlink_specific_packages_group_of_package = true;
    }

    return $unlink_specific_packages_group_of_package;
}

/** Get packages group tracking number
 * 
 * @param int $package_group_id Packages group id.
 * 
 * @return array $packagegroup_trackingnumber The tracking number. 
 */
function get_packages_group_tracking_number(int $package_group_id)
{
    $packagegroup_trackingnumber = [];

    $database = _database_login();

    $request = "SELECT tracking_number FROM customer_package_group WHERE id=:package_group_id";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'package_group_id' => $package_group_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

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
function get_all_packages_linked_to_specific_packages_group(int $package_group_id)
{
    $allpackages_inpackagegroup = [];

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

            $allpackages_inpackagegroup = $data;
        }
    }
    return $allpackages_inpackagegroup;
}

/** Unlink packages group to all packages concerned according to packages group id
 * 
 * @param int $customer_package_group_id Packages group id.
 * @param string $tracking_number Package tracking number.
 * 
 * @return bool The result.
 */
function unlink_specific_packages_group_ofAll_packages(int $customer_package_group_id): bool
{
    date_default_timezone_set("Africa/Lagos");

    $unlink_specific_packages_group_ofAll_packages = false;

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

        $unlink_specific_packages_group_ofAll_packages = true;
    }

    return $unlink_specific_packages_group_ofAll_packages;
}
