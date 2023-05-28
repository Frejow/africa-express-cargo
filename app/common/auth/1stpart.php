<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php
    if (isset($params[1]) && !empty($params[1])) {
        switch ($params[1]) {
            case "login":
                echo "<title>Africa Express Cargo | Connexion</title>";
                break;
            case "password":
                echo "<title>Africa Express Cargo | Mot de passe oublié</title>";
                break;
            case "register":
                echo "<title>Africa Express Cargo | Inscription</title>";
                break;
            case "account-validation":
                echo "<title>Africa Express Cargo | Vérification</title>";
                break;
            case "reset-password":
                echo "<title>Africa Express Cargo | Vérification</title>";
                break;
        }
    } else {
        echo "<title>Erreur 404</title>";
    }
    if (isset($params[2]) && !empty($params[2])) {
        switch ($params[2]) {
            case "checking-failed":
                echo "<title>Echec de la vérification</title>";
                break;
            case "link-expired":
                echo "<title>Lien expiré</title>";
                break;
            default:
                echo "<title>Erreur 404</title>";
                break;
        }
    } else {
        echo "<title>Erreur 404</title>";
    }
    ?>
    <!-- CSS files -->
    <?php
    if ((isset($params[2]) && !empty($params[2]) && $params[2] != 'reset-password') || (isset($params[1]) && !empty($params[1]) && ($params[1] != 'login' && $params[1] != 'password' && $params[1] != 'register'))) {
    ?>
        <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
        <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
        <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
        <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
        <link href='<?= PROJECT ?>public/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css' rel="stylesheet" type="text/css">
        <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>
    <?php
    } else {
    ?>
    <link href='<?= PROJECT ?>public/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/vendor/bootstrap/css/bootstrap.min.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/vendor/select2/select2.min.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/css/fontawesome-free/css/all.min.css' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/fonts/font-awesome-4.7.0/css/font-awesome.min.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
    <link href='<?= PROJECT ?>public/vendor/animate/animate.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/vendor/css-hamburgers/hamburgers.min.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/css/util.css' rel="stylesheet" type="text/css">
    <link href='<?= PROJECT ?>public/css/main.css' rel="stylesheet" type="text/css">
    <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>
    <script src='<?= PROJECT ?>public/js/ajax-l.js'></script>
    <script src='<?= PROJECT ?>public/js/ajax-r.js'></script>
    <?php
    }
    ?>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        .loader {
            display: none;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader.show {
            display: inline-block;
        }
    </style>
</head>