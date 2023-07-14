<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_pack_errors'] = [];

$package_id = $_SESSION['package_id'];

$package_to_edit = getPackageToEdit($package_id);

if ($package_to_edit['package_units_number'] != 0) {
    $unit = 'pcs';
    $quantity = $package_to_edit['package_units_number'];
} elseif ($package_to_edit['net_weight'] != 0) {
    $unit = 'kg';
    $quantity = $package_to_edit['net_weight'];
} elseif ($package_to_edit['volumetric_weight'] != 0) {
    $unit = 'cbm';
    $quantity = $package_to_edit['volumetric_weight'];
}

extract($_POST);

if (!empty($status)) {

    if ($status != $package_to_edit['status']) {
        $newdata['status'] = secure($status);
    } else {
        $newdata['status'] = $package_to_edit['status'];
    }

    $updata['status'] = secure($status);

} else {

    $error['status'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Statut soumis vide.';
    }
}

if (!empty($productSelect)) {

    if (($package_to_edit['product_type_id'] . '&' . $package_to_edit['product_type'] != $productSelect) || ($package_to_edit['product_type_id'] . '&' . $package_to_edit['product_type'] . '&insurance' != $productSelect)) {

        if (!empty(explode('&', $productSelect)[2])) {
            $newdata['productSelectId'] = secure(explode('&', $productSelect)[0]);
            $newdata['productSelectName'] = secure(explode('&', $productSelect)[1]);
            $updata['insurance'] = secure(explode('&', $productSelect)[2]);
        } elseif (!empty(explode('&', $productSelect)[1])) {
            $newdata['productSelectId'] = secure(explode('&', $productSelect)[0]);
            $newdata['productSelectName'] = secure(explode('&', $productSelect)[1]);
        }

    } else {

        $newdata['productSelectId'] = $package_to_edit['product_type_id'];
        $newdata['productSelectName'] = $package_to_edit['product_type'];
    }

    $updata['productSelect'] = secure($productSelect);

} else {

    $error['productSelect'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Type de produits soumis vide.';
    }
}

if (!empty($pack_unit)) {

    if ($pack_unit != $unit) {
        $newdata['pack_unit'] = secure($pack_unit);
    } else {
        $newdata['pack_unit'] = $unit;
    }
    
    $updata['pack_unit'] = secure($pack_unit);

} else {

    $error['pack_unit'] = 'Veuillez sélectionner une unité parmi celles proposées.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Aucune unité de mesure soumise.';
    }
}

if (!empty($pack_insur)) {

    $updata['pack_insur'] = secure($pack_insur);

    $newdata['pack_insur'] = secure($pack_insur);
    if ($pack_insur == 'oui') {

        if (!empty($newdata['productSelectId'])) {

            $product = getProduct($newdata['productSelectId']);

            if (!empty($newdata['pack_unit'])) {

                foreach ($product as $key => $prod) {
                    if (stripos($key, $newdata['pack_unit'])) {
                        if ($prod != 0) {
                            if (stripos($key, 'insurance')) {
                                $unit_bill = $prod;
                            }
                        } else {
                            if (empty($unit_bill)) {
                                $error['pack_unit'] = 'Veuillez sélectionner l\'unité qui correspond aux tarifs. Exemple :  
                                    Type de produit : Ordinateurs portables | Tarif / KG : 16000 FCFA <br>
                                    L\'unité dans ce cas est KG.';

                                if (empty($_SESSION['error_msg'])) {
                                    $_SESSION['error_msg'] = 'Erreur! Unité de mesure erronée.';
                                }
                            }
                        }
                    }
                }
            } //die(var_dump($unit_bill));
        }
    } else {

        if (!empty($newdata['productSelectId'])) {

            $product = getProduct($newdata['productSelectId']);

            if (!empty($newdata['pack_unit'])) {

                foreach ($product as $key => $prod) {
                    if (stripos($key, $newdata['pack_unit'])) {
                        if ($prod != 0) {
                            if (!stripos($key, 'insurance')) {
                                $unit_bill = $prod;
                            }
                        } else {
                            if (empty($unit_bill)) {
                                $error['pack_unit'] = 'Veuillez sélectionner l\'unité qui correspond aux tarifs. Exemple :  
                                    Type de produit : Ordinateurs portables | Tarif / KG : 16000 FCFA <br>
                                    L\'unité dans ce cas est KG.';

                                if (empty($_SESSION['error_msg'])) {
                                    $_SESSION['error_msg'] = 'Erreur! Unité de mesure erronée.';
                                }
                            }
                        }
                    }
                }
                //die(var_dump($unit_bill));
            }
        }
    }

} else {

    if (!empty($updata['insurance'])) {

        $error['pack_insur'] = 'Quel tarif choisissez-vous ? Avec ou sans assurance ?';

        if (empty($_SESSION['error_msg'])) {
            $_SESSION['error_msg'] = 'Erreur. Veuillez choisir une réponse entre OUI ou NON au niveau du champs Assurance.';
        }
    } else {

        if (!empty($newdata['productSelectId'])) {

            $product = getProduct($newdata['productSelectId']);

            if (!empty($newdata['pack_unit'])) {

                foreach ($product as $key => $prod) {
                    if (stripos($key, $newdata['pack_unit'])) {
                        if ($prod != 0) {
                            if (!stripos($key, 'insurance')) {
                                $unit_bill = $prod;
                            }
                        } else {
                            if (empty($unit_bill)) {
                                $error['pack_unit'] = 'Veuillez sélectionner l\'unité qui correspond aux tarifs. Exemple :  
                                    Type de produit : Ordinateurs portables | Tarif / KG : 16000 FCFA <br>
                                    L\'unité dans ce cas est KG.';

                                if (empty($_SESSION['error_msg'])) {
                                    $_SESSION['error_msg'] = 'Erreur! Unité de mesure erronée.';
                                }
                            }
                        }
                    }
                }
                //die(var_dump($unit_bill));
            }
        }
    }
}

if (!empty($packweight)) {

    if (!empty($newdata['pack_unit'])) {

        $updata['packweight'] = secure($packweight);

        if ($newdata['pack_unit'] == 'kg' || $newdata['pack_unit'] == 'cbm') {

            if (ctype_digit($packweight) >= 0 || is_numeric($packweight) >= 0) {

                if (ctype_digit($packweight)) {

                    if ($newdata['pack_unit'] == 'kg') {
                        $newdata['pack_netWeight'] = secure($packweight);
                    } else {
                        $newdata['pack_netWeight'] = 0;
                    }

                    if ($newdata['pack_unit'] == 'cbm') {
                        $newdata['pack_metricWeight'] = secure($packweight);
                    } else {
                        $newdata['pack_metricWeight'] = 0;
                    }
                } elseif (is_numeric($packweight)) {

                    if ($newdata['pack_unit'] == 'kg') {
                        $newdata['pack_netWeight'] = secure($packweight);
                    } else {
                        $newdata['pack_netWeight'] = 0;
                    }

                    if ($newdata['pack_unit'] == 'cbm') {
                        $newdata['pack_metricWeight'] = secure($packweight);
                    } else {
                        $newdata['pack_metricWeight'] = 0;
                    }
                }
            } else {

                $error['packweight'] = 'Veuillez entrer des nombres entiers ou décimaux positifs.';

                if (empty($_SESSION['error_msg'])) {
                    $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                }
            }

            if (!empty(explode(',', $packweight)[1])) {

                $is_numeric = str_replace(',', '.', $packweight);
                $isnumeric = floatval($is_numeric);

                if ($isnumeric >= 0) {

                    if ($newdata['pack_unit'] == 'kg') {
                        $newdata['pack_netWeight'] = secure($isnumeric);
                    } else {
                        $newdata['pack_netWeight'] = 0;
                    }

                    if ($newdata['pack_unit'] == 'cbm') {
                        $newdata['pack_metricWeight'] = secure($isnumeric);
                    } else {
                        $newdata['pack_metricWeight'] = 0;
                    }
                } else {
                    $error['packweight'] = 'Veuillez entrer des nombres entiers ou décimaux positifs.';

                    if (empty($_SESSION['error_msg'])) {
                        $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                    }
                }
            }

            $newdata['pack_pcs'] = 0;
        } elseif ($newdata['pack_unit'] == 'pcs') {

            if ($packweight > 0 && ctype_digit($packweight)) {

                $newdata['pack_pcs'] = secure($packweight);

                $newdata['pack_metricWeight'] = 0;

                $newdata['pack_netWeight'] = 0;
            } else {
                $error['packweight'] = 'Veuillez entrer des nombres entiers positifs.';

                if (empty($_SESSION['error_msg'])) {
                    $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                }
            }
        }
    }
} else {

    $error['packweight'] = 'Champs requis';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Nombre soumis vide.';
    }
}

if (!empty($_shipping)) {
    $updata['_shipping'] = secure($_shipping);

    if (($package_to_edit['shipping_type_id'] . '&' . $package_to_edit['shipping_type'] != $_shipping)) {
        if (!empty(explode('&', $_shipping)[1])) {
            $newdata['shipping_type_id'] = secure(explode('&', $_shipping)[0]);
            $newdata['shipping_type'] = secure(explode('&', $_shipping)[1]);
        }
    } else {
        $newdata['shipping_type_id'] = $package_to_edit['shipping_type_id'];
        $newdata['shipping_type'] = $package_to_edit['shipping_type'];
    }
    
} else {

    $error['_shipping'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Envoi soumis vide.';
    }
}

$newdata['pack_cost'] = '-';

if (!empty($unit_bill)) {
    $newdata['shipping_unit_cost'] = $unit_bill;
}

if (!empty($unit_bill) && !empty($newdata['pack_netWeight']) && $newdata['pack_netWeight'] != 0) {
    $newdata['shipping_cost'] = $newdata['pack_netWeight'] * $unit_bill;
} elseif (!empty($unit_bill) && !empty($newdata['pack_metricWeight']) && $newdata['pack_metricWeight'] != 0) {
    $newdata['shipping_cost'] = $newdata['pack_metricWeight'] * $unit_bill;
} elseif (!empty($unit_bill) && !empty($newdata['pack_pcs']) && $newdata['pack_pcs'] != 0) {
    $newdata['shipping_cost'] = $newdata['pack_pcs'] * $unit_bill;
} else {
    $newdata['shipping_cost'] = 0;
}

//die(var_dump($newdata['shipping_type_id']));

if (empty($error)) {

    if (!empty($_POST)) {
        if (
            !empty($newdata['status']) && !empty($newdata['pack_cost']) && !empty($newdata['shipping_unit_cost']) && !empty($newdata['shipping_cost'])
            && !empty($newdata['productSelectName']) && !empty($newdata['shipping_type']) && !empty($newdata['productSelectId']) && !empty($newdata['shipping_type_id'])
        ) {
            if (updatePackageTable(
                $package_id,
                $package_to_edit['tracking_number'],
                $newdata['pack_pcs'],
                $newdata['pack_cost'],
                $package_to_edit['description'],
                $newdata['pack_netWeight'],
                $newdata['pack_metricWeight'],
                $newdata['shipping_unit_cost'],
                $newdata['shipping_cost'],
                $newdata['productSelectName'],
                $newdata['shipping_type'],
                $newdata['status'],
                $package_to_edit['user_id'],
                $newdata['productSelectId'],
                $newdata['shipping_type_id']
            )) {

                $_SESSION['success_msg'] = 'Mise à jour effectuée avec succès';

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings'));
                
            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                $_SESSION['data'] = json_encode($updata);

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/update-packages'));

                exit;
            }
        } else {

            $_SESSION['data'] = json_encode($updata);

            $_SESSION['error_msg'] = 'Une erreur est survenue. Une action inattendue bloque le processus. Réessayer. Contactez nous si cela persiste.';

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/update-packages'));

            exit;
        }
    } else {

        $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier lourd et dépassant la limite autorisée (Poids Max: 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/update-packages'));

        exit;
    }
} elseif (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_pack_errors'] = $error;

    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/update-packages'));
}
