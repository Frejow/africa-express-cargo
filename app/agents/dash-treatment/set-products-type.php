<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_prodtype_errors'] = [];

secure(extract($_POST));

if (!empty($products)) {

    $updata['products'] = $products;

    if (!empty(explode('-', $products)[1])) {

        $data['products'] = [];
        $err['products'] = [];

        $products_array = explode('-', $products);

        foreach ($products_array as $key => $product) {

            if (!checkingThirdParam('product_type', 'name', ucfirst(trim($product)))) {

                $data['products'][] = ucfirst(trim($product));

            } else {

                $err['products'][] = $product;
            }
        }

        if (!empty($err['products'])) {

            $error['products'] = 'Les types de produits : ';

            foreach ($err['products'] as $key => $err) {

                $error['products'] .= $err .',';
            }

            $error['products'] .= ' existe(nt) déjà.';

            $_SESSION['error_msg'] = 'Erreur. Certains ou tout ces types de produits existent déjà.';

        } else {

            $newdata['products'] = $data['products'];
        }

    } else {

        if (!checkingThirdParam('product_type', 'name', ucfirst(trim($products)))) {

            $newdata['products'] = ucfirst(trim($products));
        } else {
    
            $error['products'] = $products . ' existe déjà.';

            $_SESSION['error_msg'] = 'Erreur. Ce type de produit existe déjà.';
        }
    }

} else {

    $error['products'] = 'Ce champs est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
}

if (!empty($insurance)) {

    $updata['insurance'] = $insurance;

} else {

    $error['insurance'] = 'Ce type de produit dispose d\'un tarif assurance incluse ?';

    $_SESSION['error_msg'] = 'Erreur. Veuillez sélectionner une réponse entre Oui ou Non au niveau du champs Assurance.';
}

if (!empty($bill)) {

    $updata['bill'] = $bill;

} else {

    $error['bill'] = 'Ce champs est requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
}

if ($insurance == 'non') {

    if (!empty($unit)) {

        $updata['unit'] = $unit;

        if ($unit == 'KG') {
            $newdata['billing_per_kg'] = $bill;
        } else {
            $newdata['billing_per_kg'] = 0;
        }
        if ($unit == 'CBM') {
            $newdata['billing_per_cbm'] = $bill;
        } else {
            $newdata['billing_per_cbm'] = 0;
        }
        if ($unit == 'PCS') {
            $newdata['billing_per_pcs'] = $bill;
        } else {
            $newdata['billing_per_pcs'] = 0;
        }
    } else {

        $updata['unit'] = $unit;

        $error['unit'] = 'Ce champs est requis.';

        $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
    }

    $newdata['billing_per_kg_with_insurance'] = 0;
    $newdata['billing_per_cbm_with_insurance'] = 0;
    $newdata['billing_per_pcs_with_insurance'] = 0;

    $newdata['have_insurance'] = 0;
}

if ($insurance == 'oui') {

    if (!empty($bill_insuranceIn)) {

        $updata['bill_insuranceIn'] = $bill_insuranceIn;

    } else {

        $error['bill_insuranceIn'] = 'Ce champs est requis.';

        $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
    }

    if (!empty($unit)) {

        $updata['unit'] = $unit;

        if ($unit == 'KG') {
            $newdata['billing_per_kg'] = $bill;
            $newdata['billing_per_kg_with_insurance'] = $bill_insuranceIn;
        } else {
            $newdata['billing_per_kg'] = 0;
            $newdata['billing_per_kg_with_insurance'] = 0;
        }
        if ($unit == 'CBM') {
            $newdata['billing_per_cbm'] = $bill;
            $newdata['billing_per_cbm_with_insurance'] = $bill_insuranceIn;
        } else {
            $newdata['billing_per_cbm'] = 0;
            $newdata['billing_per_cbm_with_insurance'] = 0;
        }
        if ($unit == 'PCS') {
            $newdata['billing_per_pcs'] = $bill;
            $newdata['billing_per_pcs_with_insurance'] = $bill_insuranceIn;
        } else {
            $newdata['billing_per_pcs'] = 0;
            $newdata['billing_per_pcs_with_insurance'] = 0;
        }
    } else {

        $error['unit'] = 'Ce champs est requis.';

        $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
    }

    $newdata['have_insurance'] = 1;
}


if (empty($error)) {

    if (!is_array($newdata['products'])) {

        if (addProduct($newdata['products'], $newdata['billing_per_kg'], $newdata['billing_per_cbm'], $newdata['billing_per_pcs'], $newdata['billing_per_kg_with_insurance'], $newdata['billing_per_cbm_with_insurance'], $newdata['billing_per_pcs_with_insurance'], $newdata['have_insurance'])) {
        
            $_SESSION['success_msg'] = 'Nouveau type de produit ajouté avec succès';
    
            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/products-type'));
        } else {

            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous';
    
            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-products-type'));
        }
    } else {

        foreach($newdata['products'] as $key => $products) {

            if (addProduct($products, $newdata['billing_per_kg'], $newdata['billing_per_cbm'], $newdata['billing_per_pcs'], $newdata['billing_per_kg_with_insurance'], $newdata['billing_per_cbm_with_insurance'], $newdata['billing_per_pcs_with_insurance'], $newdata['have_insurance'])) {
        
                $_SESSION['success_msg'] = 'Nouveaux types de produits ajoutés avec succès';
        
                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/products-type'));
        
            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous';
        
                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-products-type'));
            }
        }
    }


} elseif (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_prodtype_errors'] = $error;

    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-products-type'));
}
