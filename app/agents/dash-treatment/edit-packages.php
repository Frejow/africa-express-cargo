<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_pack_errors'] = [];

$package_id = $_SESSION['package_id'];

$package_to_edit = getPackageToEdit($package_id);

$package_img = getPackageImages($package_id);

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

if (!empty($pack_trackN)) {

    if ($pack_trackN != $package_to_edit['tracking_number']) {

        if (!checkingThirdParam('package', 'tracking_number', secure(strtoupper($pack_trackN)))) {

            $newdata['pack_trackN'] = secure(strtoupper($pack_trackN));

        } else {
    
            $error['pack_trackN'] = 'Ce numéro de suivi appartient déjà à un colis. Vérifier votre saisie.';
        }
    } else {

        $newdata['pack_trackN'] = $package_to_edit['tracking_number'];
    }

    $updata['pack_trackN'] = secure($pack_trackN);

} else {

    $error['pack_trackN'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Numéro de suivi soumis vide.';
    }
}

if (!empty($pack_descp)) {

    if ($pack_descp != $package_to_edit['description']) {
        $newdata['pack_descp'] = secure($pack_descp);
    } else {
        $newdata['pack_descp'] = $package_to_edit['description'];
    }

    $updata['pack_descp'] = secure($pack_descp);

} else {

    $error['pack_descp'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Description soumis vide.';
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

if (!empty($_FILES["filetoupload"])) {

    if (!empty($newdata['pack_trackN'])) {

        $newdata['images'] = [];

        if ($_FILES["filetoupload"]['error'] == 0) {

            if ($_FILES["filetoupload"]["size"] <= 2000000) {

                $file_name = $_FILES["filetoupload"]["name"];

                $file_info = pathinfo($file_name);

                $file_ext = $file_info["extension"];

                $allowed_ext = ["png", "jpg", "jpeg", "gif"];

                if (in_array(strtolower($file_ext), $allowed_ext)) {

                    $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                    $prevfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $package_to_edit['tracking_number'];

                    $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                    if (!is_dir($newfolder)) {

                        mkdir($newfolder, 0700, true);
                    }

                    move_uploaded_file($_FILES['filetoupload']['tmp_name'], $newfolder . '/' . basename($_FILES['filetoupload']['name']));

                    $newdata["images"] = PROJECT . 'public/images/uploads/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'] . '/' . basename($_FILES['filetoupload']['name']);

                    if (!empty($error['images'])) {
                        deleteDir($newfolder);
                    }
                } else {

                    $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                    $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                    if (is_dir($newfolder)) {

                        deleteDir($newfolder);

                        $error["images"] = "L'extension du fichier " . $file_name . " n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                        $updata['images'] = $file_name;

                        if (empty($_SESSION['error_msg'])) {
                            $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';
                        }
                    } else {

                        $error["images"] = "L'extension du fichier " . $file_name . " n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                        $updata['images'] = $file_name;

                        if (empty($_SESSION['error_msg'])) {
                            $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';
                        }
                    }
                }
            } else {

                $file_name = $_FILES["filetoupload"]["name"];

                $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                if (is_dir($newfolder)) {

                    deleteDir($newfolder);

                    $error["images"] = "Le fichier " . $file_name . " est trop lourd. Poids maximum autorisé : 2mo";

                    $updata['images'] = $file_name;

                    if (empty($_SESSION['error_msg'])) {
                        $_SESSION['error_msg'] = 'Erreur niveau poids de fichier. Poids maximum autorisé : 2mo';
                    }
                } else {

                    $error["images"] = "Le fichier " . $file_name . " est trop lourd. Poids maximum autorisé : 2mo";

                    $updata['images'] = $file_name;

                    if (empty($_SESSION['error_msg'])) {
                        $_SESSION['error_msg'] = 'Erreur niveau poids de fichier. Poids maximum autorisé : 2mo';
                    }
                }
            }
        } elseif ($_FILES["filetoupload"]['error'] == 4) {

            $newdata['images'] = [];

        } else {

            $updata['images'][0] = 'IMPORTER UNE IMAGE [POIDS MAXIMUM: 2Mo]';

            $_SESSION['data'] = json_encode($updata);

            $_SESSION['error_msg'] = 'Une erreur est survenue avec votre fichier. Réessayer.';

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

            exit;
        }
    } else {
        $error['images'] = '';

        if (empty($_SESSION['error_msg'])) {

            $_SESSION['error_msg'] = 'Erreur. Veuillez bien remplir les champs précédents celui pour importation.';
        }
    }
} else {

    $newdata['images'] = [];
}


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
            !empty($newdata['pack_trackN']) && !empty($newdata['pack_cost']) && !empty($newdata['pack_descp']) && !empty($newdata['shipping_unit_cost']) && !empty($newdata['shipping_cost'])
            && !empty($newdata['productSelectName']) && !empty($newdata['shipping_type']) && !empty($newdata['productSelectId']) && !empty($newdata['shipping_type_id'])
        ) {
            if (updatePackageTable(
                $package_id,
                $newdata['pack_trackN'],
                $newdata['pack_pcs'],
                $newdata['pack_cost'],
                $newdata['pack_descp'],
                $newdata['pack_netWeight'],
                $newdata['pack_metricWeight'],
                $newdata['shipping_unit_cost'],
                $newdata['shipping_cost'],
                $newdata['productSelectName'],
                $newdata['shipping_type'],
                'Entrepôt Bénin',
                ANONYMOUS_ID,
                $newdata['productSelectId'],
                $newdata['shipping_type_id']
            )) {

                if (!empty($newdata['images'])) {

                    if (is_dir($prevfolder)) {
                        deleteDir($prevfolder);
                    }

                    deleteImgInPackageImagesTable($package_id);

                    if (!addImagesForPackage(getPackageId($newdata['pack_trackN'])['id'], $newdata['images'], ANONYMOUS_ID)) {

                        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                        $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                        if (is_dir($newfolder)) {

                            deleteDir($newfolder);
                        }

                        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                        $_SESSION['data'] = json_encode($updata);

                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

                        exit;
                    } else {
                        $_SESSION['imgs_insertion'] = 'Done';
                    }

                    if (isset($_SESSION['imgs_insertion'])) {

                        $_SESSION['success_msg'] = 'Modification effectuée avec succès';

                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings'));
                    } else {

                        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                        $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                        if (is_dir($newfolder)) {

                            deleteDir($newfolder);
                        }

                        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                        $_SESSION['data'] = json_encode($updata);

                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

                        exit;
                    }
                } else {

                    $_SESSION['success_msg'] = 'Modification effectuée avec succès';

                    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings'));
                }
            } else {

                $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

                if (is_dir($newfolder)) {

                    deleteDir($newfolder);
                }

                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                $_SESSION['data'] = json_encode($updata);

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

                exit;
            }
        } else {

            $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

            $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

            if (is_dir($newfolder)) {

                deleteDir($newfolder);
            }

            $_SESSION['data'] = json_encode($updata);

            $_SESSION['error_msg'] = 'Une erreur est survenue. Une action inattendue bloque le processus. Réessayer. Contactez nous si cela persiste.';

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

            exit;
        }
    } else {

        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

        $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

        if (is_dir($newfolder)) {

            deleteDir($newfolder);
        }

        $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier lourd et dépassant la limite autorisée (Poids Max: 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));

        exit;
    }
} elseif (!empty($error)) {

    $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

    $newfolder = $rootpath . '/PACKAGES_WITHOUT_ADDRESSEES' . '/packages/' . $newdata['pack_trackN'];

    if (is_dir($newfolder)) {
        deleteDir($newfolder);
    }

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_pack_errors'] = $error;

    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages'));
}
