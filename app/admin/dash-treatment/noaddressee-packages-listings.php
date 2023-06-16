<?php

//Pagination

if (isset($_POST['previous'])) {
    //die (var_dump($_SESSION['previous_page']));

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));
}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter

if (isset($_POST['statusSelect']) && !empty($_POST['statusSelect'])) {

    //die (var_dump($_POST['statusSelect']));
    //$_SESSION['actual_page'] = $_SESSION['page'];

    if ($_SESSION['status'] == $_POST['statusSelect']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    } else {

        //$_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_status'] = $_POST['statusSelect'];

        if (isset($_SESSION['selected_status'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

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

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    }
//die ('dedans');
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['packages_nb_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['select_packages_nb_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package deletion

if (isset($_POST['package_deletion']) && !empty($_POST['package_deletion'])) {

    //die (var_dump($_POST['package_deletion']));
    
    if (isset(explode('&', $_POST['package_deletion'])[1])) {

        if (deletedPackageOrPackagesGroup(explode('&', $_POST['package_deletion'])[0], 'package')) {

            if (unlinkSpecificPackagesGroupOfPackage(explode('&', $_POST['package_deletion'])[1], explode('&', $_POST['package_deletion'])[0])) {

                $_SESSION['success_msg'] = 'Votre colis N°'. explode('&', $_POST['package_deletion'])[0] .' a été supprimé avec succès';
    
                header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

            }
    
        }

    } else {

        if (deletedPackageOrPackagesGroup($_POST['package_deletion'], 'package')) {

            $_SESSION['success_msg'] = 'Votre colis N°'. $_POST['package_deletion'] .' a été supprimé avec succès';
    
            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));
    
        }

    }
    
} 

//Package deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////