<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package in group withdrawal

if (isset($_POST['withdraw_package_ingroup']) && !empty($_POST['withdraw_package_ingroup'])) {
    

    if (update_customer_package_group_id(explode('&',$_POST['withdraw_package_ingroup'])[1], explode('&',$_POST['withdraw_package_ingroup'])[0])) {

        $_SESSION['success_msg'] = 'Le colis N°'. explode('&',$_POST['withdraw_package_ingroup'])[0] .' a été retiré avec succès';

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
        }

    }

} 

//Package in group withdrawal

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Packages in group withdrawal

if (isset($_POST['withdraw_allpackages_ingroup']) && !empty($_POST['withdraw_allpackages_ingroup'])) {

    if (update_customer_package_group_id_inpackagetable($_POST['withdraw_allpackages_ingroup'])) {

        $_SESSION['success_msg'] = 'Tous les colis du groupe ont été retiré avec succès.';

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
        }

    }

} 

//All Packages in group withdrawal

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////