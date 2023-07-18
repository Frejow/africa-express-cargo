<?php

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $params = explode('/', $_GET['p']);

    if (checkUserRegisteredTokenInf($params[3], $params[4], "ACCOUNT_VALIDATION", 1, 0)){

        if (updateTokenTable($params[3]) && updateAccountStatus($params[3])){

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
        date_default_timezone_set("Africa/Lagos");
        
        $token_created_at = getTokenDateInf($params[3], $params[4])['created'];
        $expiration_date_time = date('Y-m-d H:i:s', strtotime($token_created_at . " +10 min"));;

        if ($token_created_at < $expiration_date_time) {

            include 'checking-failed.php';

        } else {

            $_SESSION['user_id'] = $params[3];

            include 'link-expired.php';

        }

    }

} else {

    include 'checking-failed.php';

}
