<?php

$newdata = [];
$error = [];
$updata = [];
$_SESSION['set_pack_errors'] = [];

extract($_POST); //die(var_dump($_FILES["filesToUpload"])); 
//die(var_dump(floatval(str_replace(',', '.', $pack_weight))));

if (!empty($customerSelect)) {

    if ($customerSelect != 38) {
        if (!empty(explode('&', $customerSelect)[1])) {
            $newdata['customerId'] = secure(explode('&', $customerSelect)[0]);
            $newdata['customerUsername'] = secure(explode('&', $customerSelect)[1]);
            $updata['customerSelect'] = secure($customerSelect);
        } else {
            $error['customerSelect'] = '';

            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer.';
        }
    } else {
        $updata['customerSelect'] = secure($customerSelect);
    }
} else {

    $error['customerSelect'] = 'Champs requis.';

    $_SESSION['error_msg'] = 'Erreur. Champs requis soumis vide.';
}

if (!empty($pack_trackN)) {

    if (!checkingThirdParam('package', 'tracking_number', secure(strtoupper($pack_trackN)))) {

        $newdata['pack_trackN'] = secure(strtoupper($pack_trackN));
    } else {

        $error['pack_trackN'] = 'Ce numéro de suivi appartient déjà à un colis. Vérifier votre saisie.';
    }

    $updata['pack_trackN'] = secure($pack_trackN);
} else {

    $error['pack_trackN'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Numéro de suivi soumis vide.';
    }
}

if (!empty($pack_descp)) {

    $newdata['pack_descp'] = secure($pack_descp);

    $updata['pack_descp'] = secure($pack_descp);
} else {

    $error['pack_descp'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Description soumis vide.';
    }
}

if (!empty($productSelect)) {

    if (!empty(explode('&', $productSelect)[2])) {
        $newdata['productSelectId'] = secure(explode('&', $productSelect)[0]);
        $newdata['productSelectName'] = secure(explode('&', $productSelect)[1]);
        $updata['insurance'] = secure(explode('&', $productSelect)[2]);
        $updata['productSelect'] = secure($productSelect);
    } elseif (!empty(explode('&', $productSelect)[1])) {
        $newdata['productSelectId'] = secure(explode('&', $productSelect)[0]);
        $newdata['productSelectName'] = secure(explode('&', $productSelect)[1]);
        $updata['productSelect'] = secure($productSelect);
    }
} else {

    $error['productSelect'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Type de produits soumis vide.';
    }
}

if (!empty($pack_unit)) {

    $newdata['pack_unit'] = secure($pack_unit);
    $updata['pack_unit'] = secure($pack_unit);
} else {

    $error['pack_unit'] = 'Veuillez sélectionner une unité parmi celles proposées.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Aucune unité de mesure soumise.';
    }
}

if (!empty($pack_insur)) {

    $newdata['pack_insur'] = secure($pack_insur);
    $updata['pack_insur'] = secure($pack_insur);

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

if (!empty($pack_weight)) {

    if (!empty($newdata['pack_unit'])) {

        $updata['pack_weight'] = secure($pack_weight);

        if ($newdata['pack_unit'] == 'kg' || $newdata['pack_unit'] == 'cbm') {

            if (ctype_digit($pack_weight) >= 0 || is_numeric($pack_weight) >= 0) {

                if (ctype_digit($pack_weight)) {

                    if ($newdata['pack_unit'] == 'kg') {
                        $newdata['pack_netWeight'] = secure($pack_weight);
                    } else {
                        $newdata['pack_netWeight'] = 0;
                    }
    
                    if ($newdata['pack_unit'] == 'cbm') {
                        $newdata['pack_metricWeight'] = secure($pack_weight);
                    } else {
                        $newdata['pack_metricWeight'] = 0;
                    }
                } elseif (is_numeric($pack_weight)) {

                    if ($newdata['pack_unit'] == 'kg') {
                        $newdata['pack_netWeight'] = secure($pack_weight);
                    } else {
                        $newdata['pack_netWeight'] = 0;
                    }
    
                    if ($newdata['pack_unit'] == 'cbm') {
                        $newdata['pack_metricWeight'] = secure($pack_weight);
                    } else {
                        $newdata['pack_metricWeight'] = 0;
                    }
                }
            } else {

                $error['pack_weight'] = 'Veuillez entrer des nombres entiers ou décimaux positifs.';

                if (empty($_SESSION['error_msg'])) {
                    $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                }
            }
            
            if (!empty(explode(',', $pack_weight)[1])) {

                $is_numeric = str_replace(',', '.', $pack_weight);
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
                    $error['pack_weight'] = 'Veuillez entrer des nombres entiers ou décimaux positifs.';

                    if (empty($_SESSION['error_msg'])) {
                        $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                    }
                }
            } 

            $newdata['pack_pcs'] = 0;

        } elseif ($newdata['pack_unit'] == 'pcs') {

            if ($pack_weight > 0 && ctype_digit($pack_weight)) {

                $newdata['pack_pcs'] = secure($pack_weight);

                $newdata['pack_metricWeight'] = 0;

                $newdata['pack_netWeight'] = 0;
            } else {
                $error['pack_weight'] = 'Veuillez entrer des nombres entiers positifs.';

                if (empty($_SESSION['error_msg'])) {
                    $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Nombre.';
                }
            }
        }
    }
} else {

    $error['pack_weight'] = 'Champs requis';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Nombre soumis vide.';
    }
}

if (!empty($pack_cost)) {

    $updata['pack_cost'] = secure($pack_cost);

    if ($pack_cost > 0 && ctype_digit($pack_cost)) {

        $newdata['pack_cost'] = secure(($pack_cost));

    } else {

        $error['pack_cost'] = 'Veuillez entrer une valeur positive.';

        if (empty($_SESSION['error_msg'])) {
            $_SESSION['error_msg'] = 'Erreur. Valeur soumise incorrecte au niveau du champs Coût Unitaire du Colis.';
        }
    }
} else {

    $error['pack_cost'] = 'Champs requis';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Coût Unitaire du Colis soumis vide.';
    }
}

if (!empty($shipping)) {

    if (!empty(explode('&', $shipping)[1])) {
        $newdata['shipping_type_id'] = secure(explode('&', $shipping)[0]);
        $newdata['shipping_type'] = secure(explode('&', $shipping)[1]);
        $updata['shipping'] = secure($shipping);
    }
} else {

    $error['shipping'] = 'Champs requis.';

    if (empty($_SESSION['error_msg'])) {
        $_SESSION['error_msg'] = 'Erreur. Champs Envoi soumis vide.';
    }
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

//if ($customerSelect != 38) {

//} 

if (!empty($_FILES["filesToUpload"])) {

    if (!empty($newdata['customerUsername']) && !empty($newdata['pack_trackN'])) {

        $newdata['images'] = [];

        if (sizeof($_FILES["filesToUpload"]['error']) <= 3) {

            foreach ($_FILES["filesToUpload"]['error'] as $key => $value) {

                if ($_FILES["filesToUpload"]['error'][$key] == 0) {

                    if ($_FILES["filesToUpload"]["size"][$key] <= 2000000) {

                        $file_name = $_FILES["filesToUpload"]["name"][$key];

                        $file_info = pathinfo($file_name);

                        $file_ext = $file_info["extension"];

                        $allowed_ext = ["png", "jpg", "jpeg", "gif"];

                        if (in_array(strtolower($file_ext), $allowed_ext)) {

                            $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                            $newfolder = $rootpath . '/' . $newdata['customerUsername'] . '/packages/' . $newdata['pack_trackN'];

                            if (!file_exists($newfolder)) {

                                mkdir($newfolder, 0700, true);
                            }

                            move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$key], $newfolder . '/' . basename($_FILES['filesToUpload']['name'][$key]));

                            $newdata["images"][$key] = PROJECT . 'public/images/uploads/' . $newdata['customerUsername'] . '/packages/' . $newdata['pack_trackN'] . '/' . basename($_FILES['filesToUpload']['name'][$key]);

                            if (!empty($error['images'])) {
                                deleteDir($newfolder);
                            }
                        } else {

                            $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                            $newfolder = $rootpath . '/' . $newdata['customerUsername'] . '/packages/' . $newdata['pack_trackN'];

                            if (is_dir($newfolder)) {

                                deleteDir($newfolder);

                                $error["images"][$key] = "L'extension du fichier " . $file_name . " n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                                $updata['images'][$key] = $file_name;

                                if (empty($_SESSION['error_msg'])) {
                                    $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';
                                }
                            } else {

                                $error["images"][$key] = "L'extension du fichier " . $file_name . " n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                                $updata['images'][$key] = $file_name;

                                if (empty($_SESSION['error_msg'])) {
                                    $_SESSION['error_msg'] = 'Erreur niveau extension de fichier(s). Extensions autorisées [ PNG/JPG/JPEG/GIF ]';
                                }
                            }
                        }
                    } else {

                        $file_name = $_FILES["filesToUpload"]["name"][$key];

                        $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                        $newfolder = $rootpath . '/' . $newdata['customerUsername'] . '/packages/' . $newdata['pack_trackN'];

                        if (is_dir($newfolder)) {

                            deleteDir($newfolder);

                            $error["images"][$key] = "Le fichier " . $file_name . " est trop lourd. Poids maximum autorisé : 2mo";

                            $updata['images'][$key] = $file_name;

                            if (empty($_SESSION['error_msg'])) {
                                $_SESSION['error_msg'] = 'Erreur niveau poids de fichier(s). Poids maximum autorisé : 2mo';
                            }
                        } else {

                            $error["images"][$key] = "Le fichier " . $file_name . " est trop lourd. Poids maximum autorisé : 2mo";

                            $updata['images'][$key] = $file_name;

                            if (empty($_SESSION['error_msg'])) {
                                $_SESSION['error_msg'] = 'Erreur niveau poids de fichier(s). Poids maximum autorisé : 2mo';
                            }
                        }
                    }
                }
            }
        } else {

            $updata['images'][0] = 'AJOUTER DES IMAGES [ TROIS (03) MAXIMUM ]';

            $_SESSION['data'] = json_encode($updata);

            $_SESSION['error_msg'] = 'Vous essayez une importation de plus de 03 fichiers.';

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

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

//die(var_dump(($newdata['pack_netWeight'])));

if (empty($error)) {
    //die('in');

    if (!empty($_POST)) {

        if (
            !empty($newdata['pack_trackN']) && !empty($newdata['pack_cost']) && !empty($newdata['pack_descp']) && !empty($newdata['shipping_unit_cost']) && !empty($newdata['shipping_cost'])
            && !empty($newdata['productSelectName']) && !empty($newdata['shipping_type']) && !empty($newdata['customerId']) && !empty($newdata['productSelectId']) && !empty($newdata['shipping_type_id'])
        ) {
            if (addPackge(
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
                $newdata['customerId'],
                $newdata['productSelectId'],
                $newdata['shipping_type_id']
            )) {

                if (!empty($newdata['images'])) {

                    for ($i = 0; $i < sizeof($newdata['images']); $i++) {

                        if (!addImagesForPackage(getPackageId($newdata['pack_trackN'])['id'], $newdata['images'][$i], $newdata['customerId'])) {

                            $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                            $_SESSION['data'] = json_encode($updata);

                            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

                            exit;
                        } else {
                            $_SESSION['imgs_insertion'] = 'Done';
                        }
                    }

                    if (isset($_SESSION['imgs_insertion'])) {

                        $_SESSION['success_msg'] = 'Votre colis a été ajouté avec succès';

                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings'));
                    } else {

                        $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                        $_SESSION['data'] = json_encode($updata);

                        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

                        exit;
                    }
                } else {

                    $_SESSION['success_msg'] = 'Votre colis a été ajouté avec succès';

                    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings'));
                }
            } else {

                $_SESSION['error_msg'] = 'Une erreur est survenue. Réessayer. Si cela persiste, contactez-nous.';

                $_SESSION['data'] = json_encode($updata);

                header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

                exit;
            }
        } else {

            $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

            $newfolder = $rootpath . '/' . $newdata['customerUsername'] . '/packages/' . $newdata['pack_trackN'];

            if(is_dir($newfolder)) {
                deleteDir($newfolder);
            }

            $_SESSION['data'] = json_encode($updata);

            $_SESSION['error_msg'] = 'Une erreur est survenue. Une action inattendue bloque le processus. Réessayer. Contactez nous si cela persiste.';

            header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

            exit;
        }
    } else {

        $_SESSION['error_msg'] = 'Une erreur est survenue. Cause probable : Importation de fichier(s) lourds et dépassant la limite autorisée (Poids Max/Fichier : 2Mo). Réessayer en respectant la limite autorisée. Contactez nous si cela persiste.';

        header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));

        exit;
    }
} elseif (!empty($error)) {

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['set_pack_errors'] = $error;

    header("location:" . redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages'));
}
