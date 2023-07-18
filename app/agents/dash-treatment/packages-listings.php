<?php

extract($_POST);

//Pagination

if (!empty($previous)) {

    $_SESSION['previous_page'] = $previous;

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));
}

if (!empty($next)) {
    
    $_SESSION['next_page'] = $next;

    if (!empty($_SESSION['next_page'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter Status

if (!empty($statusSelect)) {

    if ($_SESSION['status'] == $statusSelect) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    } else {

        $_SESSION['selected_status'] = $statusSelect;

        if (!empty($_SESSION['selected_status'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

        }
    }
    
} 

//Filter Status

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter Package

if (!empty($packagesType)) {

    if ($_SESSION['type'] == $packagesType) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    } else {

        $_SESSION['packages_type'] = $packagesType;

        if (!empty($_SESSION['packages_type'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

        }
    }
    
} 

//Filter Package

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (!empty($search)) {
    
    $_SESSION['research'] = secure($search);

    if (!empty($_SESSION['research'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    }

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (!empty($select)) {

    
    if ($_SESSION['rows_per_page'] == $select) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_rows_per_page'] = $select;

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package edition

if (!empty($edit_package)) {

    $_SESSION['package_id'] = $edit_package;
    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/edit-packages'));

}

//Package edition

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package updating

if (!empty($update_package)) {

    $_SESSION['package_id'] = $update_package;
    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/update-packages'));
    
}

//Package updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Insight

if (!empty($_POST['insight'])) {

    $_SESSION['invoice_id'] = $_POST['insight'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/insight'));

} elseif (empty($_POST['insight'])) {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/packages-listings'));

}

//Insight

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////