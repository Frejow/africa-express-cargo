<?php
    require 'vendor/autoload.php';
    define( 'ROOTPATH', getcwd() );
    define( 'PROJECT', '/africa-express-cargo/' );
    define( 'DATABASE_HOST', 'localhost' );
    define( 'DATABASE_NAME', 'a_c_e' );
    define( 'DATABASE_USERNAME', 'root');
    define( 'DATABASE_PASSWORD', 'jevaisreussir08' );
    define( 'MAIL_ADDRESS', '' );
    define( 'MAIL_PASSWORD', '' );

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
