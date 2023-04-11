<?php
session_start();

//include '..'.PROJECT."app/common/functions_folder/functions.php";

$_SESSION["login_errors"] = [];

$errors = [];

$data = [];

if (!isset($_POST["m_ps"]) || empty($_POST["m_ps"])) {
    $errors["m_ps"] = "Ce champs est requis.";
}

if (isset($_POST["m_ps"]) && !empty($_POST["m_ps"])) {
    $data["m_ps"] = (secure($_POST["m_ps"]));
}

if (!isset($_POST["pass"]) || empty($_POST["pass"])) {
    $errors["pass"] = "Le champs du mot de passe est requis.";
}

if (isset($_POST["remember_me"]) && !empty($_POST["remember_me"])){
        
    setcookie(
        "user_data",
        json_encode($data),
        [
            'expires' => time() + 365 * 24 * 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]
    );

}

if (empty($errors)) {

    if (check_exist_userby_email_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1) 
    || check_exist_userby_pseudo_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1)) {
        
        header("location:".PROJECT."customer/dash/packages-listings?theme=light");

    }
    elseif (!check_exist_userby_email_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1) 
    || !check_exist_userby_pseudo_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1)) {

        //

        header("location:".PROJECT."customer/login");
        
    }

}

else {

    $_SESSION["login_errors"] = $errors;

    setcookie(
        "user_data",
        json_encode($data),
        [
            'expires' => time() + 365 * 24 * 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]
    );
    
    header("location:".PROJECT."customer/login");

}
