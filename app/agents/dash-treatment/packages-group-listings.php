<?php

//Pagination

if (isset($_POST['previous'])) {
    //die (var_dump($_SESSION['previous_page']));

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));
}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter Status

if (isset($_POST['statusSelect']) && !empty($_POST['statusSelect'])) {

    //die (var_dump($_POST['statusSelect']));
    //$_SESSION['actual_page'] = $_SESSION['page'];

    if ($_SESSION['status'] == $_POST['statusSelect']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

    } else {

        //$_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_status'] = $_POST['statusSelect'];

        if (isset($_SESSION['selected_status'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

        }
    }
    
} 

//Filter Status

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter Packages-group

if (!empty($_POST['packagesType'])) {

    if ($_SESSION['type'] == $_POST['packagesType']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

    } else {

        $_SESSION['packages_type'] = $_POST['packagesType'];

        if (isset($_SESSION['packages_type'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

        }
    }
    
} 

//Filter Packages-group

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (isset($_POST['search']) && !empty($_POST['search'])) {
    //die ('dedans');
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

    }
//die ('dedans');
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['rows_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_rows_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-group-listings'));
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Packages-group edition



//Packages-group edition

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Packages-group updating



//Packages-group updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////