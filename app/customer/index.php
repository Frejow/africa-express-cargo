<?php

session_start();

session_regenerate_id(true);

include "app/common/functions.php";

//Suppression des tokens après délai d'expiration de 10min
date_default_timezone_set("Africa/Lagos");
$current_date_time = date('Y-m-d H:i:s');
$tokens =  get_all_active_tokens(); 

if (isset($tokens) && !empty($tokens)) {

    foreach ($tokens as $key => $value) {

        $timegap = date_to_number($current_date_time) - date_to_number($tokens[$key]['created']); 

        if ($timegap >= 1000) {

            if ($tokens[$key]['type'] == 'ACCOUNT_VALIDATION') { 

                if (update_token_table($tokens[$key]['user_id'])) {
                    
                    deleted_account($tokens[$key]['user_id']);
                } 

            } elseif ($tokens[$key]['type'] == 'RESET_PASSWORD') {

                update_token_table($tokens[$key]['user_id']);

            }

        }

    }

}

//Récupération du thème actif
if (isset(explode('?', $_SERVER['REQUEST_URI'])[1])) {
    $_SESSION ['theme'] = explode('?', $_SERVER['REQUEST_URI'])[1];
} else {
    $_SESSION ['theme'] = 'theme=light';
}

//Section toast
if (isset($_SESSION['success_msg']) && !empty($_SESSION['success_msg'])) {
    $msg = $_SESSION['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    unset($_SESSION['success_msg']);
}

if (isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])) {
    $msg = $_SESSION['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    unset($_SESSION['error_msg']);
}

if (isset($_COOKIE['success_msg']) && !empty($_COOKIE['success_msg'])){
    $msg = $_COOKIE['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    setcookie('success_msg', '', time() - 3600, '/');
}

if (isset($_COOKIE['error_msg']) && !empty($_COOKIE['error_msg'])){
    $msg = $_COOKIE['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    setcookie('error_msg', '', time() - 3600, '/');
}


$data = [];

//Affecter la valeur de cookie de session de l'utilisateur connecté à la variable $data
if (isset($_SESSION["connected"]) && !empty($_SESSION["connected"])) {
    $data = json_decode($_SESSION["connected"], true);
} 

//S'assurer de l'existence effective du compte

    $params = explode('/', $_GET['p']);
    $profile = "customer";
    $default_resource = "login";
    $default_action = "index";

    $default_action_folder = "app/" . $profile . "/" . $default_resource . "/" . $default_action . ".php";

    if (isset($_GET['p']) && !empty($_GET['p'])) {

        if (isset($params[1]) && !empty($params[1])) {

            if (($params[1] == 'dash')) {

                if (connected()){

                    $resource = $params[1];

                } else {

                    $resource = $default_resource;

                    setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                    header("location:".PROJECT."customer/login");

                    exit;

                }

            } elseif (($params[1] == 'logout')) {

                if (connected()) {

                    $resource = $params[1];

                } else {

                    $resource = $default_resource;

                    setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                    header("location:".PROJECT."customer/login");

                    exit;

                }

            }

            elseif (($params[1] == 'dash-treatment')) {

                if (connected()){

                    $resource = $params[1];

                } else {

                    $resource = $default_resource;

                    setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                    header("location:".PROJECT."customer/login");

                    exit;

                }

            } 
            
            elseif (($params[1] != 'dash' && $params[1] != 'logout' && $params[1] != 'dash-treatment')) {

                if (connected()) {

                    header("location:".$_SESSION['current_url']);

                } else {

                    $resource = $params[1];

                }

            }
            
        } else {

            if (connected()) {

                header("location:".$_SESSION['current_url']);

            } else {

                $resource = $default_resource;

                header("location:".PROJECT."customer/login");
    
                exit;

            }
            
        }

        $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;

        $action_folder = "app/" . $profile . "/" . $resource . "/" . $action . ".php";

        if (file_exists($action_folder)) {

            require_once $action_folder;

        } else {

            require_once 'error/404.php';

        }

    } else {
        
        require_once 'error/404.php';;
    }
