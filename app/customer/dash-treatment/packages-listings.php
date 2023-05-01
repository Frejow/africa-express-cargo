<?php
//die (var_dump($_SESSION['page']));

if (isset($_POST['previous'])) {

    if ($_SESSION['page'] - 1 <= 0) {
        $_SESSION['previous_page'] = 1;
    } else {
        $_SESSION['previous_page'] = $_SESSION['page'] - 1;
    }

    if (isset($_SESSION['previous_page'])) {
        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
    }
}

if (isset($_POST['statusSelect']) && $_POST['statusSelect'] != 'Tout Afficher') {

    $_SESSION['selected_status'] = $_POST['statusSelect'];

    if (isset($_SESSION['selected_status'])) {
        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
    }
} else {
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    }
}

if (isset($_POST['search']) && !empty($_POST['search'])) {
    //die ('dedans');
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {
        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
    }
//die ('dedans');
} else {
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    }
}




if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_SESSION['page'] + 1;

    if (isset($_SESSION['next_page'])) {
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
    }
    }
} 

if (isset($_POST['select'])) {
    
    if ($_SESSION['packages_nb_per_page'] == $_POST['select']) {

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
        

    } else {

        $_SESSION['select_packages_nb_per_page'] = $_POST['select'];

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
        
    }
    
} 

