<?php

//Pagination

if (isset($_POST['previous'])) {
    //die (var_dump($_SESSION['previous_page']));

    $_SESSION['previous_page'] = $_POST['previous'];

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    }
}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    }
    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter

if (isset($_POST['statusSelect']) && !empty($_POST['statusSelect'])) {

    //die (var_dump($_POST['statusSelect']));
    //$_SESSION['actual_page'] = $_SESSION['page'];

    if ($_SESSION['status'] == $_POST['statusSelect']) {

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        }

    } else {

        //$_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_status'] = $_POST['statusSelect'];

        if (isset($_SESSION['selected_status'])) {
            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
            } else {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
            }
        }
    }
    
} 

//Filter

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (isset($_POST['search']) && !empty($_POST['search'])) {
    //die ('dedans');
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {
        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        }
    }
//die ('dedans');
} else {
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
    }
}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['packages_nb_per_page'] == $_POST['select']) {

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        }
        

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['select_packages_nb_per_page'] = $_POST['select'];

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
        }
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package deletion

if (isset($_POST['package_group_deletion']) && !empty($_POST['package_group_deletion'])) {

    //die (var_dump($_POST['package_deletion']));
    
    if (deleted_package_or_packagegroup(explode('&',$_POST['package_group_deletion'])[0], 'customer_package_group')) {

        if (update_customer_package_group_id_inpackagetable(explode('&',$_POST['package_group_deletion'])[1])) {

            $_SESSION['success_msg'] = 'Le groupe de colis N°'. explode('&',$_POST['package_group_deletion'])[0] .' a été supprimé avec succès';

            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
            } else {
                header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
            }

        }

    }
} 

//Package deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////