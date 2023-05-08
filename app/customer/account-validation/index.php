<?php

//session_start();

//include "app/common/functions_folder/functions.php";

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $params = explode('/', $_GET['p']);

    if (check_user_registered_token_info($params[3], $params[4], "ACCOUNT_VALIDATION", 1, 0)){

        if (update_token_table($params[3]) && update_account_status($params[3])){

            setcookie(
                "success_msg",
                'Compte créé et validé avec succès. Connectez-vous.',
                [
                    'expires' => time() + 365 * 24 * 3600,
                    'path' => '/',
                    'secure' => true,
                    'httponly' => true,
                ]
            );

            //$_SESSION['success'] = 'Compte créé et validé avec succès. Connectez-vous.';
            header("location:".PROJECT."customer/login");

        }
        
    } else {

        include 'checking_failed.php';

    }

} else {

    include 'checking_failed.php';

}


session_destroy();