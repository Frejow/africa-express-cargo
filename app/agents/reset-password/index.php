<?php

if (isset($_GET['p']) && !empty($_GET['p'])) {

    $params = explode('/', $_GET['p']);

    if (checkUserRegisteredTokenInf($params[3], $params[4], "RESET_PASSWORD", 1, 0)){

        if (updateTokenTable($params[3])){

            header("location:".PROJECT."agents/password/reset-password");

        }
        
    } else {

        $token_created_at = getTokenDateInf($params[3], $params[4])['created'];
        $token_updated_on = getTokenDateInf($params[3], $params[4])['updated_on'];

        if (dateToNumber($token_updated_on) - dateToNumber($token_created_at) < 1002) {

            include 'checking-failed.php';

        } else {

            $_SESSION['user_id'] = $params[3];

            include 'link-expired.php';

        }

    }

} else {

    include 'checking-failed.php';

}