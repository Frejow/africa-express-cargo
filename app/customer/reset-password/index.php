<?php

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $params = explode('/', $_GET['p']);

    if (check_user_registered_token_inf($params[3], $params[4], "RESET_PASSWORD", 1, 0)){

        if (update_token_table($params[3])){

            header("location:".PROJECT."customer/password/reset-password");

        }
        
    } else {

        $token_created_at = get_token_date_inf($params[3], $params[4])['created'];
        $token_updated_on = get_token_date_inf($params[3], $params[4])['updated_on'];

        if (date_to_number($token_updated_on) - date_to_number($token_created_at) < 1002) {

            include 'checking-failed.php';

        } else {

            $_SESSION['user_id'] = $params[3];

            include 'link-expired.php';

        }

    }

} else {

    include 'checking-failed.php';

}