<?php

$error = [];
$_SESSION['group_created'] = [];
$_SESSION['set_pack_group_errors'] = [];

if (isset($_POST['set-pack-grp']) && !empty($_POST['set-pack-grp'])) {
    
    if (isset($_POST['packSelect']) && !empty($_POST['packSelect'])) {

        //if (sizeof($_POST['packSelect']) >= 2) {

            if (insert_new_packages_group_and_get_id($_POST['set-pack-grp'], $data['id'])) {

                foreach ($_POST['packSelect'] as $key => $value) {
    
                    if(!link_specific_packages_group_to_package($_SESSION['nowcreated_packagegroup_id']['id'], $_POST['packSelect'][$key])) {

                        $_SESSION['error_msg'] = 'Un problème est survenu lors de la création du groupe. Réessayer. Si cela persiste, contactez nous.';

                        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages-group'));

                        exit;

                    } else {

                        $_SESSION['group_created'][] = 'Done';

                    }

                }

                if ($_SESSION['group_created'][sizeof($_SESSION['group_created'])-1] == 'Done') {

                    $_SESSION['success_msg'] = 'Groupe de colis créé avec succès';
    
                    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings'));

                    exit;
                }
    
            } else {

                $_SESSION['error_msg'] = 'Un problème est survenu lors de la création du groupe. Réessayer. Si cela persiste, contactez nous.';

                header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages-group'));

            }

        //} else {

            //$error['packselect'] = 'Deux colis au moins doivent être sélectionnés pour créer un groupe';

        //}

    } else {

        $error['packselect'] = 'Aucun colis n\'a été sélectionné';

        $_SESSION['error_msg'] = 'Faites la sélection de colis avant soumission.';

    }

}

if (!empty($error)) {

    $_SESSION['set_pack_group_errors'] = $error;

    header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/set-packages-group'));

}