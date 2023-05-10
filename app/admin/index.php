<?php

session_start();

if (isset(explode('?', $_SERVER['REQUEST_URI'])[1])) {
    $_SESSION ['theme'] = explode('?', $_SERVER['REQUEST_URI'])[1];
} else {
    $_SESSION ['theme'] = 'theme=light';
}

include "app/common/functions_folder/functions.php";

    $params = explode('/', $_GET['p']);
    $profile = "admin";
    $default_resource = "login";
    $default_action = "index";

    $default_action_folder = "app/" . $profile . "/" . $default_resource . "/" . $default_action . ".php";

    if (isset($_GET['p']) && !empty($_GET['p'])) {

        $resource = (isset($params[1]) && !empty($params[1])) ? $params[1] : $default_resource;

        $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;

        $action_folder = "app/" . $profile . "/" . $resource . "/" . $action . ".php";

        if (file_exists($action_folder)) {

            require_once $action_folder;

        } else {

            require_once $default_action_folder;

        }

    } else {
        
        require_once $default_action_folder;
    }