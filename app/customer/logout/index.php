<?php 

if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
    setcookie('thm', '?theme=light', time() + 365 * 24 * 3600, '/');
} elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
    setcookie('thm', '?theme=dark', time() + 365 * 24 * 3600, '/');
} else {
    setcookie('thm', '?theme=light', time() + 365 * 24 * 3600, '/');
}
unset($_SESSION['connected_customer'], $_SESSION['customer_curent_url']);
if (!isset($_SESSION['connected_customer'])) {

    setcookie('success_msg', 'Déconnexion réussie', time() + 365 * 24 * 3600, '/');

    //session_destroy();

    //setcookie(session_name(), '', time() - 3600, '/');

    header("location:".PROJECT."customer/login");

}
