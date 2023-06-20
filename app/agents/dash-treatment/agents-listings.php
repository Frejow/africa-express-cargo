<?php

//Pagination

if (isset($_POST['previous'])) {

    $_SESSION['previous_page'] = $_POST['previous'];

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));
}

if (isset($_POST['next'])) {
    
    $_SESSION['next_page'] = $_POST['next'];

    if (isset($_SESSION['next_page'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

    }
} 

//Pagination

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Order

if (isset($_POST['orderBy']) && !empty($_POST['orderBy'])) {

    if ($_SESSION['order'] == $_POST['orderBy']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

    } else {

        $_SESSION['selected_order'] = $_POST['orderBy'];

        if (isset($_SESSION['selected_order'])) {

            header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

        }
    }
    
} 

//Order

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Research

if (isset($_POST['search']) && !empty($_POST['search'])) {
    //die ('dedans');
    $_SESSION['research'] = secure($_POST['search']);

    if (isset($_SESSION['research'])) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

    }
    
} else {

    header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

}

//Research

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Entries

if (isset($_POST['select'])) {

    
    if ($_SESSION['rows_per_page'] == $_POST['select']) {

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));

    } else {

        $_SESSION['actual_page'] = $_SESSION['page'];

        $_SESSION['selected_rows_per_page'] = $_POST['select'];

        header("location:". redirect($_SESSION['theme'], PROJECT.'agents/dash/agents-listings'));
        
    }
    
} 

//Entries

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Product type edition



//Product type edition

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Product type status updating



//Product type status updating

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////