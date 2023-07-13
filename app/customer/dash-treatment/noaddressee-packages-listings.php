<?php

extract($_POST);

if (!empty($package_claiming_id) && !empty($tracking_number)) {

    if (checkFieldEntry('package', 'id', $package_claiming_id, 'tracking_number', secure(strtoupper($tracking_number)))) {
        
        if (deleteImgInPackageImagesTable($package_claiming_id) && assocPackageToOwner($package_claiming_id, $data['id'])) {

            $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

            $defaultfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . secure(strtoupper($tracking_number));

            $newfolder = $rootpath . '/' . $data['user_name'] . '/packages/';

            if (rename($defaultfolder, $newfolder . basename($defaultfolder))) {

                $_SESSION['success_msg'] = 'Vérification réussie. Consultez les informations du colis à la section Mes Colis.';

            }
            
        } else {
            
            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer.';

        }

    } else {
        
        $_SESSION['error_msg'] = 'La vérification a échoué. Réessayer en vous assurant de bien entrer le bon numéro de suivi.';

    }

} else {

    $_SESSION['error_msg'] = 'Erreur. Causes probables : une action inattendue bloque le processus ou le champs du numéro de suivi a été soumis vide. Réessayer.';

}

header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/noaddressee-packages-listings'));