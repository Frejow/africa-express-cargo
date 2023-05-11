<?php

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

if (empty($errors)) {

    if (check_exist_userby_email_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1, 1, 0) 
    || check_exist_userby_pseudo_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1, 1, 0)) {

        if (isset($_POST["remember_me"]) && !empty($_POST["remember_me"])){
        
            setcookie(
                "cud",
                json_encode($data),
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );
        
        } else {
            setcookie('cud', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['thm'])) {

            $_SESSION['success_msg'] = 'Authentification réussie';

            header("location:".PROJECT."customer/dash/packages-listings".$_COOKIE['thm']);

            setcookie('thm', '', time() - 3600, '/');

        } elseif (isset($_COOKIE['crl'])) {

            $_SESSION['success_msg'] = 'Authentification réussie';

            header("location:".$_COOKIE['crl']);

            setcookie('crl', '', time() - 3600, '/');

        } else {
            
            $_SESSION['success_msg'] = 'Authentification réussie';

            header("location:".PROJECT."customer/dash/packages-listings?theme=light");

        }
        
        setcookie('ud', '', time() - 3600, '/');

    }
    elseif (!check_exist_userby_email_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1, 1, 0) 
    || !check_exist_userby_pseudo_and_password($_POST["m_ps"], $_POST["pass"], 'CUSTOMER', 1, 1, 0)) {

        setcookie(
            "error_msg",
            "Adresse email ou mot de passe incorrect. Réessayer",
            [
                'expires' => time() + 365 * 24 * 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
            ]
        );

        setcookie(
            "ud",
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

}

else {

    $_SESSION["login_errors"] = $errors;

    setcookie(
        "ud",
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
