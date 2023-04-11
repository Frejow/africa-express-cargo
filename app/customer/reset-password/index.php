<?php

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $params = explode('/', $_GET['p']);

    if (check_user_registered_token_info($params[3], $params[4], "RESET_PASSWORD", 1, 0)){

        if (update_token_table($params[3])){

            header("location:".PROJECT."customer/password/reset-password");

        }
        
    } else {

        include 'checking_failed.php';

    }

} else {

    include 'checking_failed.php';

}


session_destroy();