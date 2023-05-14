<?php

    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv -> load();
    
    define( 'ROOTPATH', getcwd() );
    define( 'PROJECT', $_ENV['PROJECT'] );
    define( 'DATABASE_HOST', $_ENV['DATABASE_HOST'] );
    define( 'DATABASE_NAME', $_ENV['DATABASE_NAME'] );
    define( 'DATABASE_USERNAME', $_ENV['DATABASE_USERNAME']);
    define( 'DATABASE_PASSWORD', $_ENV['DATABASE_PASSWORD'] );
    define( 'MAIL_ADDRESS', $_ENV['MAIL_ADDRESS'] );
    define( 'MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] );

    $default_profile = "customer";
    $default_profile_folder = "app/customer/index.php";
    $params = [];

    if (isset($_GET['p']) && !empty($_GET['p'])) {

        $params = explode('/', $_GET['p']);

        $profile = (isset($params[0]) && !empty($params[0])) ? $params[0] : $default_profile;

        $profile_folder = "app/" . $profile . "/index.php";

        if (file_exists($profile_folder)) {

            include $profile_folder;

        } else {

            include $default_profile_folder;

        }
    } else {

        include 'home.php';

    }
