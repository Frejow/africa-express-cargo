<?php

session_start();

if (isset(explode('?', $_SERVER['REQUEST_URI'])[1])) {
    $_SESSION ['theme'] = explode('?', $_SERVER['REQUEST_URI'])[1];
} else {
    $_SESSION ['theme'] = 'theme=light';
}

if (isset($_COOKIE['error_msg']) && !empty($_COOKIE['error_msg'])){
    $msg = $_COOKIE['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    setcookie('error_msg', '', time() - 3600, '/');
}

session_regenerate_id(true);

$params = explode('/', $_GET['p']);

include "app/common/functions_folder/functions.php";

if (!connected()) {
    unset($_SESSION['current_url']);
}

$data = [];

if (isset($_SESSION["connected"]) && !empty($_SESSION["connected"])) {
    $data = json_decode($_SESSION["connected"], true);
}          

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

            } elseif (($params[1] != 'dash' && $params[1] != 'logout' && $params[1] != 'dash-treatment')) {

                if (connected()) {

                    header("location:".$_SESSION['current_url']);

                } else {

                    $resource = $params[1];

                }

            } elseif (($params[1] == 'logout')) {

                $resource = $params[1];

            }

            elseif (($params[1] == 'dash-treatment')) {

                $resource = $params[1];

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

        //$resource = (isset($params[1]) && !empty($params[1])) ? $params[1] : $default_resource;

        $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;

        $action_folder = "app/" . $profile . "/" . $resource . "/" . $action . ".php";

        //die(var_dump(($action_folder)));

        if (file_exists($action_folder)) {

            require_once $action_folder;

        } else {

            require_once $default_action_folder;

        }

    } else {
        
        require_once $default_action_folder;
    }