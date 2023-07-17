<?php

//Pagination

if (isset($_POST['previous'])) {

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {
        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));
    }
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Filter

if (isset($_POST['filterSelect']) && !empty($_POST['filterSelect'])) {

    if ($_SESSION['filter'] == $_POST['filterSelect']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

    } else {

        $_SESSION['selected_filter'] = $_POST['filterSelect'];

        if (isset($_SESSION['selected_filter'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

        }
    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

//Filter

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (isset($_POST['search']) && !empty($_POST['search'])) {
    
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

    }

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['rows_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));
        
    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_rows_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));
        
    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Insight

if (!empty($_POST['insight'])) {

    $_SESSION['invoice_id'] = $_POST['insight'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/insight'));

} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/invoices'));

}

//Insight

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
