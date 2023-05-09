<?php

$error = [];
$_SESSION['packs_added'] = [];
$_SESSION['add_pack_ingrp_errors'] = [];

if (isset($_POST['add-pack-ingrp']) && !empty($_POST['add-pack-ingrp'])) {

    if (isset($_POST['packSelect']) && !empty($_POST['packSelect'])) {

        foreach ($_POST['packSelect'] as $key => $value) {

            if (!update_customerpackagegroupid_field_inpackage_table($_POST['add-pack-ingrp'], $_POST['packSelect'][$key])) {

                $_SESSION['error_msg'] = 'Un problème est survenu lors du processus. Réessayer. Si cela persiste, contactez nous.';

                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                    header("location:" . PROJECT . "customer/dash/add-packages-ingroup?theme=light");
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                    header("location:" . PROJECT . "customer/dash/add-packages-ingroup?theme=dark");
                } else {
                    header("location:" . PROJECT . "customer/dash/add-packages-ingroup?theme=light");
                }

                exit;
            } else {

                $_SESSION['packs_added'][] = 'Done';
            }
        }

        if ($_SESSION['packs_added'][sizeof($_SESSION['packs_added']) - 1] == 'Done') {

            $_SESSION['success_msg'] = sizeof($_POST['packSelect']). ' nouveau(x) colis ajouté(s) avec succès';

            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=dark");
            } else {
                header("location:" . PROJECT . "customer/dash/edit-packages-group?theme=light");
            }
            exit;
        }
    } else {

        $error['packselect'] = 'Aucun colis n\'a été sélectionné';

        $_SESSION['error_msg'] = 'Faites la sélection de colis avant soumission.';
    }
}

if (!empty($error)) {

    $_SESSION['add_pack_ingrp_errors'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
    }
}
