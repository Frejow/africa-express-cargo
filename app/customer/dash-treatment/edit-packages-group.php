<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Package in group withdrawal

if (isset($_POST['withdraw_package_ingroup']) && !empty($_POST['withdraw_package_ingroup'])) {
    

    if (unlink_specific_packages_group_of_package(explode('&',$_POST['withdraw_package_ingroup'])[1], explode('&',$_POST['withdraw_package_ingroup'])[0])) {

        $_SESSION['success_msg'] = 'Le colis N°'. explode('&',$_POST['withdraw_package_ingroup'])[0] .' a été retiré avec succès';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/edit-packages-group'));

    }

} 

//Package in group withdrawal

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Packages in group withdrawal

if (isset($_POST['withdraw_allpackages_ingroup']) && !empty($_POST['withdraw_allpackages_ingroup'])) {

    if (unlink_specific_packages_group_ofAll_packages($_POST['withdraw_allpackages_ingroup'])) {

        $_SESSION['success_msg'] = 'Tous les colis du groupe ont été retiré avec succès.';

        header("location:". redirect($_SESSION['theme'], PROJECT.'customer/dash/edit-packages-group'));

    }

} 

//All Packages in group withdrawal

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////