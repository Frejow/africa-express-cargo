<?php

$error = [];
$_SESSION['packs_added'] = [];
$_SESSION['add_pack_ingrp_errors'] = [];

if (isset($_POST['add-pack-ingrp']) && !empty($_POST['add-pack-ingrp'])) {

    if (isset($_POST['packSelect']) && !empty($_POST['packSelect'])) {

        foreach ($_POST['packSelect'] as $key => $value) {

            if (!link_specific_packages_group_to_package($_POST['add-pack-ingrp'], $_POST['packSelect'][$key])) {

                $_SESSION['error_msg'] = 'Un problème est survenu lors du processus. Réessayer. Si cela persiste, contactez nous.';

                header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/add-packages-ingroup'));

                exit;
            } else {

                $_SESSION['packs_added'][] = 'Done';
            }
        }

        if ($_SESSION['packs_added'][sizeof($_SESSION['packs_added']) - 1] == 'Done') {

            $_SESSION['success_msg'] = sizeof($_POST['packSelect']). ' nouveau(x) colis ajouté(s) avec succès';

            header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/edit-packages-group'));

            exit;
        }
    } else {

        $error['packselect'] = 'Aucun colis n\'a été sélectionné';

        $_SESSION['error_msg'] = 'Faites la sélection de colis avant soumission.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/add-packages-ingroup'));

    }
}

if (!empty($error)) {

    $_SESSION['add_pack_ingrp_errors'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/add-packages-ingroup'));

}
