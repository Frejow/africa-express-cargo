<?php

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

            header("location:".PROJECT."customer/login");

        }
        
    } else {

        $token_created_at = select_token_date_info($params[3], $params[4])['created'];
        $token_updated_on = select_token_date_info($params[3], $params[4])['updated_on'];

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
