<?php

//Pagination

if (isset($_POST['previous'])) {
    //die (var_dump($_SESSION['previous_page']));

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {
        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));
    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter

if (isset($_POST['statusSelect']) && !empty($_POST['statusSelect'])) {

    //die (var_dump($_POST['statusSelect']));
    //$_SESSION['actual_page'] = $_SESSION['page'];

    if ($_SESSION['status'] == $_POST['statusSelect']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

    } else {

        //$_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_status'] = $_POST['statusSelect'];

        if (isset($_SESSION['selected_status'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

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

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

    }
//die ('dedans');
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['packages_nb_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));
        
    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['select_packages_nb_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package group deletion

if (isset($_POST['package_group_deletion']) && !empty($_POST['package_group_deletion'])) {

    //die (var_dump($_POST['package_deletion']));
    
    if (deleted_package_or_packagegroup(explode('&',$_POST['package_group_deletion'])[0], 'customer_package_group')) {

        if (update_customer_package_group_id_inpackagetable(explode('&',$_POST['package_group_deletion'])[1])) {

            $_SESSION['success_msg'] = 'Le groupe de colis N°'. explode('&',$_POST['package_group_deletion'])[0] .' a été supprimé avec succès';

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

        }

    }
} 

//Package group deletion

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package group edition

if (isset($_POST['packages_group_edition']) && !empty($_POST['packages_group_edition'])) {

    $_SESSION['packages_group_tracking_number'] = explode('&',$_POST['packages_group_edition'])[0];

    $_SESSION['packages_group_id'] = explode('&',$_POST['packages_group_edition'])[1];

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/edit-packages-group'));

}

//Package group edition

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////