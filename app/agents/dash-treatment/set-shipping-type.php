<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_shiptype_errors'] = [];

secure(extract($_POST));

if (!empty($shipping)) {

    $updata['shipping'] = $shipping;

    if (!checkingThirdParam('shipping_type', 'name', ucfirst(trim($shipping)))) {

        $newdata['shipping'] = ucfirst(trim($shipping));
        
    } else {

        $error['shipping'] = $shipping . ' existe déjà.';

        $_SESSION['error_msg'] = 'Erreur. Ce type existe déjà.';
    }

} else {

    $error['shipping'] = 'Ce champs est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
}

if (!empty($deliv_time)) {

    $updata['deliv_time'] = $deliv_time;

    $newdata['deliv_time'] = ucfirst(trim($deliv_time));

} else {

    $error['deliv_time'] = 'Ce champs est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
}


if (empty($error)) {

    if (addShipping($newdata['shipping'], $newdata['deliv_time'])) {

        $_SESSION['success_msg'] = 'Nouveau type ajouté avec succès';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/shipping-type'));
    } else {

        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-shipping-type'));
    }

} elseif (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_shiptype_errors'] = $error;

    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-shipping-type'));
}
