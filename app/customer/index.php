<?php

session_start();

session_regenerate_id(true);

include "app/common/functions.php";

if (!empty($_SESSION['customer_current_url'])) {
    $_SESSION['current_url'] = $_SESSION['customer_current_url'];
}

//Suppression des tokens après délai d'expiration de 10min
$tokens =  getAllActiveTokens();

if (!empty($tokens)) {

    foreach ($tokens as $key => $value) {

        date_default_timezone_set("Africa/Lagos");
        
        $created_date_time = new DateTime($value['created']);
        $expiration_date_time = new DateTime(date('Y-m-d H:i:s', strtotime($value['created'] . " +10 min")));

        if ($created_date_time >= $expiration_date_time) {

            if ($value['type'] == 'ACCOUNT_VALIDATION') {

                if (updateTokenTable($value['user_id'])) {

                    deletedAccount($value['user_id']);
                }
            } elseif ($value['type'] == 'RESET_PASSWORD') {

                updateTokenTable($value['user_id']);
            }
        }
    }
}

//Récupération du thème actif
if (isset(explode('?', $_SERVER['REQUEST_URI'])[1])) {
    $_SESSION['theme'] = explode('?', $_SERVER['REQUEST_URI'])[1];
} else {
    $_SESSION['theme'] = 'theme=light';
}

//Section toast
if (!empty($_SESSION['success_msg'])) {
    $msg = $_SESSION['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    unset($_SESSION['success_msg']);
}

if (!empty($_SESSION['error_msg'])) {
    $msg = $_SESSION['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    unset($_SESSION['error_msg']);
}

if (!empty($_COOKIE['success_msg'])) {
    $msg = $_COOKIE['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    setcookie('success_msg', '', time() - 3600, '/');
}

if (!empty($_COOKIE['error_msg'])) {
    $msg = $_COOKIE['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    setcookie('error_msg', '', time() - 3600, '/');
}


$data = [];

//Affecter la valeur de cookie de session de l'utilisateur connecté à la variable $data
if (!empty($_SESSION["connected_customer"])) {
    $data = json_decode($_SESSION["connected_customer"], true);
}

//S'assurer de l'existence effective du compte

$params = explode('/', $_GET['p']);
$profile = "customer";
$default_resource = "login";
$default_action = "index";

$default_action_folder = "app/" . $profile . "/" . $default_resource . "/" . $default_action . ".php";

if (!empty($_GET['p'])) {

    if (!empty($params[1])) {

        if (($params[1] == 'dash')) {

            if (!empty($_SESSION['connected_customer'])) {

                $resource = $params[1];
            } else {

                $resource = $default_resource;

                setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                header("location:" . PROJECT . "customer/login");

                exit;
            }
        } elseif (($params[1] == 'logout')) {

            if (!empty($_SESSION['connected_customer'])) {

                $resource = $params[1];
            } else {

                $resource = $default_resource;

                setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                header("location:" . PROJECT . "customer/login");

                exit;
            }
        } elseif (($params[1] == 'dash-treatment')) {

            if (!empty($_SESSION['connected_customer'])) {

                $resource = $params[1];
            } else {

                $resource = $default_resource;

                setcookie('error_msg', 'Authentification requise ! Veuillez-vous connecter.', time() + 365 * 24 * 3600, '/');

                header("location:" . PROJECT . "customer/login");

                exit;
            }
        } elseif (($params[1] != 'dash' && $params[1] != 'logout' && $params[1] != 'dash-treatment')) {

            if (!empty($_SESSION['connected_customer'])) {

                header("location:" . $_SESSION['customer_current_url']);
            } else {

                $resource = $params[1];
            }
        }
    } else {

        if (!empty($_SESSION['connected_customer'])) {

            header("location:" . $_SESSION['customer_current_url']);
        } else {

            $resource = $default_resource;

            header("location:" . PROJECT . "customer/login");

            exit;
        }
    }

    $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;

    $action_folder = "app/" . $profile . "/" . $resource . "/" . $action . ".php";

    if (file_exists($action_folder)) {

        require_once $action_folder;
    } else {

        require_once '404/index.php';
    }
} else {

    require_once '404/index.php';;
}
