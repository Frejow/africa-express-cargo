<?php
//ini_set('session.gc_maxlifetime', 60);

//session_id();
//session_save_path('C:/wamp64/www'.PROJECT.'sessions');
//session_set_cookie_params(1800);

/*
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
*/

session_start();
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

/*if ($params[1] != 'login' && $params[1] != 'logout'){

    if (!isset($_SESSION['connected'])) {

        //setcookie('connected_user_data', '', time() - 3600, '/');

        setcookie('error_msg', 'Pour des raisons de sécurité, vous êtes déconnecté après une période d\'inactivité de 30 minutes. Veuillez vous reconnecter.', time() + 365 * 24 * 3600, '/');

        header("location:".PROJECT."customer/login");

        exit;
    
    }

}*/


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