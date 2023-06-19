<?php

//Pagination

if (!empty($_POST['previous'])) {

    if ($_POST['previous'] < 0) {
        $_POST['previous'] = 1;
    } 

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

if (!empty($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

    }
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter

if (!empty($_POST['statusSelect'])) {

    if ($_SESSION['status'] == $_POST['statusSelect']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

    } else {

        $_SESSION['selected_status'] = $_POST['statusSelect'];

        if (isset($_SESSION['selected_status'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

        }
    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Filter

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (!empty($_POST['search'])) {
    
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

    }

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (!empty($_POST['select'])) {

    
    if ($_SESSION['rows_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_rows_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));
        
    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package deletion

if (!empty($_POST['package_deletion'])) {

    if (explode('&', $_POST['package_deletion'])[0] == 'En attente...' || explode('&', $_POST['package_deletion'])[0] == 'Livrer et Confirmer') {

        if (!empty(explode('&', $_POST['package_deletion'])[2])) {

            if (deletedPackageOrPackagesGroup(explode('&', $_POST['package_deletion'])[1], 'package')) {
    
                if (unlinkSpecificPackagesGroupOfPackage(explode('&', $_POST['package_deletion'])[2], explode('&', $_POST['package_deletion'])[1])) {
    
                    $_SESSION['success_msg'] = 'Votre colis N°'. explode('&', $_POST['package_deletion'])[1] .' a été supprimé avec succès';
        
                    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));
    
                }
        
            }
    
        } else {
    
            if (deletedPackageOrPackagesGroup(explode('&', $_POST['package_deletion'])[1], 'package')) {
    
                $_SESSION['success_msg'] = 'Votre colis N°'. explode('&', $_POST['package_deletion'])[1] .' a été supprimé avec succès';
        
                header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));
        
            }
    
        }

    } else {

        $_SESSION['error_msg'] = 'Le colis N°'. explode('&', $_POST['package_deletion'])[1] .' ne peut être supprimé.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));
    
    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Package deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Confirmation

if (!empty($_POST['confirm'])) {
    
    if (updatePackageStatus($_POST['confirm'], 'Livrer et Confirmer')) {

        $_SESSION['success_msg'] = 'Le statut du colis N°'. $_POST['confirm'] .' a été mis à jour.';
    
        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-listings'));

}

//Confirmation

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////