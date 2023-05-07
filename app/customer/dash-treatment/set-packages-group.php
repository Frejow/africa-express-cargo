<?php

$error = [];
$_SESSION['group_created'] = [];
$_SESSION['set_pack_group_errors'] = [];

if (isset($_POST['set-pack-grp']) && !empty($_POST['set-pack-grp'])) {
    
    if (isset($_POST['packSelect']) && !empty($_POST['packSelect'])) {

        if (sizeof($_POST['packSelect']) >= 2) {

            if (insert_select_incustomerpackagegroup_table($_POST['set-pack-grp'], $data[0]['id'])) {

                foreach ($_POST['packSelect'] as $key => $value) {
    
                    if(!update_customerpackagegroupid_field_inpackage_table($_SESSION['nowcreated_packagegroup_id'][0]['id'], $_POST['packSelect'][$key])) {

                        $_SESSION['error_msg'] = 'Un problème est survenu lors de la création du groupe. Réessayer. Si cela persiste, contactez nous.';

                        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                            header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
                        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                            header("location:" . PROJECT . "customer/dash/set-packages-group?theme=dark");
                        } else {
                            header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
                        }

                        exit;

                    } else {

                        $_SESSION['group_created'][] = 'Done';

                    }

                }

                if ($_SESSION['group_created'][sizeof($_SESSION['group_created'])-1] == 'Done') {

                    $_SESSION['success_msg'] = 'Groupe de colis créé avec succès';
    
                    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
                    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=dark");
                    } else {
                        header("location:" . PROJECT . "customer/dash/packages-group-listings?theme=light");
                    }
                    exit;
                }
    
            } else {

                $_SESSION['error_msg'] = 'Un problème est survenu lors de la création du groupe. Réessayer. Si cela persiste, contactez nous.';

            }

        } else {

            $error['packselect'] = 'Deux colis au moins doivent être sélectionnés pour créer un groupe';

        }

    } else {

        $error['packselect'] = 'Aucun colis n\'a été sélectionné';

        $_SESSION['error_msg'] = 'Faites la sélection de colis avant soumission.';

    }

}

if (!empty($error)) {

    $_SESSION['set_pack_group_errors'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/set-packages-group?theme=light");
    }

}