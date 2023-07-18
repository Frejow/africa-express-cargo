<?php

$error = [];
$updata = [];
$_SESSION['generate_invoice_errors'] = [];

if (empty($_POST['generate'])) {
    //Customer

    if (!empty($_POST['customerSelect'])) {

        $updata['customerSelect'] = secure($_POST['customerSelect']);

        $_SESSION['selected_customer'] = secure($_POST['customerSelect']);

        if (!empty($_SESSION['selected_customer'])) {
            $_SESSION['data'] = json_encode($updata);

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        }
    } elseif (empty($_POST['customerSelect'])) {

        $error['customerSelect'] = 'Veuillez sélectionner un client.';

        $_SESSION['generate_invoice_errors'] = $error;

        $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Customer

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Pagination

    if (!empty($_POST['previous'])) {

        if ($_POST['previous'] < 0) {
            $_POST['previous'] = 1;
        }

        $_SESSION['previous_page'] = $_POST['previous'];

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    } elseif (empty($_POST['previous'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    if (!empty($_POST['next'])) {

        $_SESSION['next_page'] = $_POST['next'];

        if (isset($_SESSION['next_page'])) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        }
    } elseif (empty($_POST['next'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Pagination

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Filter

    if (!empty($_POST['statusSelect'])) {

        if ($_SESSION['status'] == $_POST['statusSelect']) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        } else {

            $_SESSION['selected_status'] = $_SESSION['status'];

            if (isset($_SESSION['selected_status'])) {

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
            }
        }
    } elseif (empty($_POST['statusSelect'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Filter

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Research

    if (!empty($_POST['search'])) {

        $_SESSION['research'] = secure($_POST['search']);

        if (isset($_SESSION['research'])) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        }
    } elseif (empty($_POST['search'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Research

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Entries

    if (!empty($_POST['select'])) {


        if ($_SESSION['rows_per_page'] == $_POST['select']) {

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        } else {

            $_SESSION['actual_page'] = $_SESSION['page'];

            $_SESSION['selected_rows_per_page'] = $_POST['select'];

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        }
    } elseif (empty($_POST['select'])) {

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Entries

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

} elseif (!empty($_POST['generate']) && $_POST['generate'] == 'generate') { 
    if (!empty($_POST['payment'])) {

        $updata['payment'] = $_POST['payment'];

        if ($_POST['payment'] == 'mobile money') {
            //die;

            $tax = '1.03 %';
            $payment_method = 'MOBILE MONEY';

        } elseif ($_POST['payment'] == 'cash') {
            //die ('ici');

            $tax = '1';
            $payment_method = 'CASH';

        } else {

            $error['payment'] = 'Veuillez cocher une option parmi celles disponibles.';

            $_SESSION['generate_invoice_errors'] = $error;

            $_SESSION['data'] = json_encode($updata);

            if (empty($_SESSION['error_msg'])) {
                $_SESSION['error_msg'] = 'Veuillez bien préciser le type de paiement. CASH ou MOBILE MONEY ?';
            }

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
            exit;
        }

    } elseif (empty($_POST['payment'])) {

        $error['payment'] = 'Veuillez cocher une option.';

        $_SESSION['generate_invoice_errors'] = $error;

        if (empty($_SESSION['error_msg'])) {
            $_SESSION['error_msg'] = 'Veuillez préciser le type de paiement.';
        }

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
        exit;
    }

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
        $linked_and_updated = [];

        foreach ($packages_to_linked_id as $key => $package_to_linked_id) {

            if (checkPackageId('package', 'id', $package_to_linked_id)) {

                $idchecked[] = 'Checked';

                $user_id = getPackage($package_to_linked_id)['user_id'];

            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Une action inattendue bloque le processus. Réessayer. Contactez-nous si cela persiste.';
                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
                exit;
            }
        }

        if (!empty($packages_to_linked_id)) {

            $_SESSION['tax'] = $tax;
            $_SESSION['packages_to_linked_id'] = $packages_to_linked_id;
            $_SESSION['customer'] = $_POST['customerSelect'];
            $_SESSION['payment_method'] = $payment_method;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['invoice_number'] = $invoice_number;
            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
            exit;
        }
    } elseif (empty($_POST['checkboxes'])) {
        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
    }

    //Generate invoice

} elseif (!empty($_POST['generate']) && $_POST['generate'] == 'confirm') {

    if (insertInvoice($_SESSION['invoice_number'], $_SESSION['user_id'], $_SESSION['payment_method'])) {

        $invoice_id = getInvoiceId($_SESSION['invoice_number']);

        foreach ($_SESSION['packages_to_linked_id'] as $key => $package_to_linked_id) {

            if (linkedPackageToInvoice($package_to_linked_id, $invoice_id['id']) && updatePackageAfterInvoice($package_to_linked_id, 'Livrer')) {

                $linked_and_updated[] = 'Done';
            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Contactez-nous si cela persiste.';
                deleteInvoice($invoice_id['id']);
                unset($_SESSION['tax'], $_SESSION['packages_to_linked_id'], $_SESSION['customer'], $_SESSION['payment_method'], $_SESSION['user_id'], $_SESSION['invoice_number']);
                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));
                exit;
            }
        }

        if ($linked[sizeof($_SESSION['packages_to_linked_id']) - 1] = 'Done') {

            $message = 'Colis reçus :' . '<br>';

            foreach ($_SESSION['packages_to_linked_id'] as $key => $package_to_linked_id) {

                $package_tracking_number = getPackage($package_to_linked_id)['tracking_number'];

                $message .= '<strong>' . $package_tracking_number. '</strong>' . '<br>';

            }

            $message .= 'Facture N°'.$_SESSION['invoice_number'];

            insertNotifications('Nouvelle Facture', $message, $_SESSION['user_id'], null);

            $_SESSION['success_msg'] = 'Facture générée avec succès.';

            unset($_SESSION['data'], $_SESSION['tax'], $_SESSION['packages_to_linked_id'], $_SESSION['customer'], $_SESSION['payment_method'], $_SESSION['user_id'], $_SESSION['invoice_number']);

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/invoices'));
        }
    }

} elseif (!empty($_POST['generate']) && $_POST['generate'] == 'cancel') {

    unset($_SESSION['tax'], $_SESSION['packages_to_linked_id'], $_SESSION['customer'], $_SESSION['payment_method'], $_SESSION['user_id'], $_SESSION['invoice_number']);
    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/generate-invoice'));

}