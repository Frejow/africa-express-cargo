<?php

if (empty($_POST['generate'])) {
    //Pagination

    if (!empty($_POST['previous'])) {

        if ($_POST['previous'] < 0) {
            $_POST['previous'] = 1;
        }

        $_SESSION['previous_page'] = $_POST['previous'];

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    } elseif (empty($_POST['previous'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    if (!empty($_POST['next'])) {

        $_SESSION['next_page'] = $_POST['next'];

        if (isset($_SESSION['next_page'])) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
        }
    } elseif (empty($_POST['next'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    //Pagination

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Filter

    if (!empty($_POST['statusSelect'])) {

        if ($_SESSION['status'] == $_POST['statusSelect']) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
        } else {

            $_SESSION['selected_status'] = $_SESSION['status'];

            if (isset($_SESSION['selected_status'])) {

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
            }
        }
    } elseif (empty($_POST['statusSelect'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    //Filter

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Research

    if (!empty($_POST['search'])) {
        
        $_SESSION['research'] = secure($_POST['search']);

        if (isset($_SESSION['research'])) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
        }
    } elseif (empty($_POST['search'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    //Research

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Entries

    if (!empty($_POST['select'])) {


        if ($_SESSION['rows_per_page'] == $_POST['select']) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
        } else {

            $_SESSION['actual_page'] = $_SESSION['page'];

            $_SESSION['selected_rows_per_page'] = $_POST['select'];

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
        }
    } elseif (empty($_POST['select'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    //Entries

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

} elseif (!empty($_POST['generate'])) {

    //Generate invoice

    if (!isset($_SESSION['m'])) {
        $n = 0;
    } else {
        $n = $_SESSION['m'];
    }

    if (!empty($_POST['checkboxes'])) {

        $packages_to_linked_id = $_POST['checkboxes'];

        $_SESSION['m'] = $n + 1;
        $invoice_number = 'AEC/' . '000' . $_SESSION['m'] . '/' . date('y');

        $idchecked = [];
        $linked = [];

        foreach ($packages_to_linked_id as $key => $package_to_linked_id) {

            if (checkPackageId('package', 'id', $package_to_linked_id)) {

                $idchecked[] = 'Checked';

            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Une action inattendue bloque le processus. Réessayer. Contactez-nous si cela persiste.';
                header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
                exit;

            }

        }

        if ($idchecked[sizeof($packages_to_linked_id) - 1] = 'Checked') {

            if (insertInvoice($invoice_number, $data['id'])) {

                $invoice_id = getInvoiceId($invoice_number);

                foreach ($packages_to_linked_id as $key => $package_to_linked_id) {

                    if (linkedPackageToInvoice($package_to_linked_id, $invoice_id['id'])) {

                        $linked[] = 'Done';

                    } else {

                        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Contactez-nous si cela persiste.';
                        deleteInvoice($invoice_id['id']);
                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
                        exit;
                    }
                }

                if ($linked[sizeof($packages_to_linked_id) - 1] = 'Done') {

                    $_SESSION['success_msg'] = 'Facture générée avec succès.';

                    header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/invoices'));
                }
            }
        }
    } elseif (empty($_POST['checkboxes'])) {
        header("location:" . redirect($_SESSION['theme'], PROJECT . 'customer/dash/generate-invoice'));
    }

    //Generate invoice

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
