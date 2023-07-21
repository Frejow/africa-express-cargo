<?php
//Inclure l'en-tête 
include 'app/common/agents/1stpart.php';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Initialisation des valeurs par défaut des différents paramètres de la fonction de listings

//Premier paramètre, le nom de la table en base de données à lister. Table "package" pour le cas présent
$table = "package";

//Second paramètre, le numéro de la page. 1 par défaut
if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page'])) {
    $_SESSION['page'] = 1;
}

//Troisième paramètre, nombre de colis à afficher par page. 10 par défaut
$_SESSION['rows_per_page'] = 10;

//Quatrième paramètre, le type de statut suivant lequel filtrer la liste. "Tout Afficher" par défaut
$_SESSION['status'] = 'Entrepôt Bénin';

// Cinquième paramètre, le numéro de suivi à rechercher. "UNDEFINED" par défaut dans le cas où aucune recherche n'est lancée
$_SESSION['search'] = 'UNDEFINED';

//
$_SESSION['customer_id'] = 0;

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page précédente)
if (!empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page suivante)
if (!empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page actuel)
if (!empty($_SESSION['actual_page'])) {
    $_SESSION['page'] = $_SESSION['actual_page'];
}

/**
 * Nouvelle valeur du troisième paramètre, nombre de colis par page, lorsqu'un autre nombre autre que 10 est sélectionné 
 * par l'utilisateur poiur afficher le nombre de colis par page
 */
if (!empty($_SESSION['selected_rows_per_page'])) {
    $_SESSION['rows_per_page'] = $_SESSION['selected_rows_per_page'];
}

/**
 * Nouvelle valeur du quatrième paramètre, type de statut, lorsque l'utilisateur décide de filtrer la liste selon un 
 * statut autre que celui par défaut
 */
if (!empty($_SESSION['selected_status'])) {
    $_SESSION['status'] = $_SESSION['selected_status'];
}

//Nouvelle valeur du cinquième paramètre, le numéro de suivi à rechercher dans la table "package"
if (!empty($_SESSION['research'])) {
    $_SESSION['search'] = $_SESSION['research'];
}

//
if (!empty($_SESSION['selected_customer'])) {
    $_SESSION['customer_id'] = $_SESSION['selected_customer'];
}

//Affectation du retour de la fonction listings avec les cinq paramètres suscités à la variable $packages_lisitngs
$packages_listings = listings($table, $_SESSION['page'], $_SESSION['rows_per_page'], $_SESSION['status'], strtoupper($_SESSION['search']), null, $_SESSION['customer_id']);

$error = [];

if (!empty($_SESSION["generate_invoice_errors"])) {
    $error = $_SESSION["generate_invoice_errors"];
}

$updata = [];

if (!empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
}


?>

<!--
    Ce bloc de formulaire prend en charge le tableau de listings des colis. Toutes les possibles valeurs des différents 
    paramètres de la fonction listings sont soumises et récupérées via la méthode POST. Ici, aucune valeur ne transite par
    l'url.
-->
<form id="myForm" action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/generate-invoice') ?>" method="post">
    <?php
    if (empty($_SESSION['tax']) && empty($_SESSION['packages_to_linked_id']) && empty($_SESSION['customer'])) {
    ?>
        <!-- Bouton de création de colis -->
        <div class="page-header d-print-none row row-deck row-cards">
            <div class="row mt-3">
                <div class="col-md text-center">
                    <select class="form-select select2bs4" id="mySelect4" name="customerSelect" data-placeholder="Sélectionner Client">
                        <option data-value=""></option>
                        <?php
                        $customersListing = selectFieldListing('user', 'CUSTOMER');
                        if (!empty($customersListing)) {
                            foreach ($customersListing as $key => $value) {
                        ?>
                                <option <?php echo (!empty($updata["customerSelect"]) && $updata["customerSelect"] == $value['id']) ? "selected" : "" ?> data-value="<?= $value['id'] ?>"><?= $value['name'] . ' ' . $value['first_names'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php
                if (!empty($error["customerSelect"])) {
                    echo "<p style = 'color:red; font-size:13px;'>" . $error["customerSelect"] . "</p>";
                }
                ?>
            </div>
            <div class="">
                TYPE DE PAIEMENT : &nbsp; &nbsp;
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php echo (!empty($updata["payment"]) && $updata["payment"] == "cash") ? "checked" : "" ?> value="cash" name="payment" checked>
                    <span class="form-check-label">CASH
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                            <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                            <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
                        </svg>
                    </span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php echo (!empty($updata["payment"]) && $updata["payment"] == "mobile money") ? "checked" : "" ?> value="mobile money" name="payment">
                    <span class="form-check-label">MOBILE MONEY
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M13 9h6a2 2 0 0 1 2 2v6m-2 2h-10a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2"></path>
                            <path d="M12.582 12.59a2 2 0 0 0 2.83 2.826"></path>
                            <path d="M17 9v-2a2 2 0 0 0 -2 -2h-6m-4 0a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
                            <path d="M3 3l18 18"></path>
                        </svg>
                    </span>
                </label>
                <?php
                if (!empty($error["payment"])) {
                    echo "<p style = 'color:red; font-size:13px;'>" . $error["payment"] . "</p>";
                }
                ?>
            </div>
        </div>
        <!-- Tableau d'affichage des données de colis récupérées depuis la base de données -->
        <div class="page-body">
            <div class="container-xl text-center">
                <div class="row row-deck row-cards">
                    <div class="container-xl d-flex" style="justify-content: center;">
                        <div class="row g-2" style="flex-wrap: wrap;">
                            <!-- Page title actions -->
                            <div class="col-12 col-lg-auto ms-auto d-print-none">
                                <button type="submit" id="generateButton" name="generate" value="generate" class="btn text-white ms-auto btn-warning">
                                    Générer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body border-bottom py-3">
                                <div class="row">
                                    <!-- 
                                    Bloc select de sélection des différentes valeurs proposées pour le nombre de colis à 
                                    afficher par page. Ici un script Js facilite la soumission de la valeur à la sélection
                                    d'une des options. Ce script se base sur l'id du champs select et l'id du formulaire
                                    pour envoyer la valeur correspondante au fichier de traiment du formulaire.
                                -->
                                    <div class="col-lg-6 col-xs mb-2 text-muted">
                                        Afficher
                                        <div class="mx-2 d-inline-block">
                                            <select class="form-select" name="select" id="mySelect">
                                                <option value="10">10</option>
                                                <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 15) {
                                                            echo 'selected';
                                                        } ?> value="15">15</option>
                                                <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 20) {
                                                            echo 'selected';
                                                        } ?> value="20">20</option>
                                                <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 30) {
                                                            echo 'selected';
                                                        } ?> value="30">30</option>
                                            </select>
                                        </div>
                                        lignes
                                    </div>
                                    <!--
                                    Bloc de la barre de recherche de colis par numéro de suivi.
                                
                                    <div class="col-lg-4 col-xs mb-2 text-muted ms-auto" style="display: flex;">
                                        <div>
                                            <span>Rechercher</span>
                                        </div>

                                        <div class="ms-2 d-inline-block">
                                            <input type="text" name="search" class="form-control" value="<?= isset($_SESSION['research']) ? $_SESSION['research'] : '' ?>" placeholder="N° de suivi">
                                        </div>
                                        <button type="submit" class="btn-link link-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                <path d="M21 21l-6 -6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    -->
                                    <!-- 
                                    Bloc select de sélection des différents statuts possibles suivant lesquels filtrer 
                                    l'affichage des colis. Ici un script Js facilite la soumission de la valeur à la 
                                    sélection d'une des options. Ce script se base sur l'id du champs select et l'id du 
                                    formulaire pour envoyer la valeur correspondante au fichier de traiment du formulaire.
                                -->
                                    <div class="col-lg-6 col-xs ms-auto text-muted">
                                        Statuts :
                                        <div class="ms-2 d-inline-block">
                                            <select class="form-select" name="statusSelect" id="mySelect2">
                                                <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Entrepôt Bénin') {
                                                            echo 'selected';
                                                        } ?> data-value="Entrepôt Bénin">Entrepôt Bénin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            Bloc d'affichage des colis
                        -->
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap">
                                    <thead class="text-center">
                                        <tr>
                                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" id="check-all" aria-label="Select all"></th>
                                            <th class="">N° de suivi</th>
                                            <th>Type de produits</th>
                                            <th>Statut</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        if (!empty($packages_listings)) {

                                            $n = 0; //Cette variable stocke le nombre de lignes affiché lorsque la table "package" ne contient logiquement pas de colis. Donc $n restera 0
                                            $m = 0; //Cette variable stocke le numéro de page en cours d'affichage.
                                            $en = 0; // Cette variable stocke au fur et à mesure le nombre de lignes afficher sous forme de numérotation.

                                            if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
                                                $m = $_SESSION['next_page'];
                                            }
                                            if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
                                                $m = $_SESSION['previous_page'];
                                            }
                                            if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
                                                $m = $_SESSION['actual_page'];
                                            }

                                            foreach ($packages_listings as $key => $package) {
                                                if (is_null($package['invoice_id'])) {
                                                    $is_null = 1;
                                        ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            if ($_SESSION['page'] == 1) {
                                                                $en = $key + 1;
                                                            } elseif ($_SESSION['page'] == 2) {
                                                                $en = $_SESSION['rows_per_page'] + $key + 1;
                                                            } elseif ($_SESSION['page'] > 2 && $m > 2) {
                                                                $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;
                                                            } else {
                                                                $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;
                                                            }
                                                            ?>
                                                            <input class="form-check-input m-0 align-middle ischecked" type="checkbox" value="<?= $package["id"] ?>" name="checkboxes[]" aria-label="Select package">
                                                        </td>
                                                        <td>
                                                            <?= $package["tracking_number"] ?>
                                                        </td>
                                                        <td class="">
                                                            <span></span>

                                                            <?= !empty($package["product_type"]) ? $package["product_type"] : '-' ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge
                                                    <?php if ($package["status"] == 'En attente...') {
                                                        echo 'bg-danger-lt';
                                                    } elseif ($package["status"] == 'En transit') {
                                                        echo 'bg-primary-lt';
                                                    } elseif ($package["status"] == 'Entrepôt Chine') {
                                                        echo 'bg-secondary-lt';
                                                    } elseif ($package["status"] == 'Entrepôt Bénin') {
                                                        echo 'bg-warning-lt';
                                                    } elseif ($package["status"] == 'Livrer') {
                                                        echo 'bg-teal-lt';
                                                    } elseif ($package["status"] == 'Livrer et Confirmer') {
                                                        echo 'bg-success';
                                                    }
                                                    ?>
                                                    me-1"><?= $package["status"] ?></span>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="">
                                                                <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="<?= '#modal-packages-detail' . $key ?>">
                                                                    Détails
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                            <?php
                                                } else {
                                                }
                                                $n = $key + 1;
                                            }
                                        } else {
                                            $n = 0;
                                            ?>
                                            <tr>Aucun élément trouvé</tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive card-footer d-flex align-items-center">



                                <ul class="pagination m-0 ms-auto">
                                    <li class="page-item <?= ($_SESSION['page'] == 1) ? "disabled" : "" ?>">
                                        <button type="submit" name="previous" value="<?= $_SESSION['page'] - 1 ?>" class="page-link">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 6l-6 6l6 6" />
                                            </svg>
                                            précédent
                                        </button>
                                    </li>
                                    <li class="page-item page-link active"><?= $_SESSION['page'] ?></li>
                                    <li class="page-item <?php if (!isset($packages_listings) || empty($packages_listings)) {
                                                                echo 'disabled';
                                                            } ?>">
                                        <button type="submit" name="next" value="<?= $_SESSION['page'] + 1 ?>" class="page-link">
                                            suivant <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 6l6 6l-6 6" />
                                            </svg>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- Invoice Insight before insertion -->

    <?php
    if (!empty($_SESSION['tax']) && !empty($_SESSION['packages_to_linked_id']) && !empty($_SESSION['customer'])) {

        $tax = $_SESSION['tax']; 
        $customer = $_SESSION['customer'];
        $packages_to_linked_id = $_SESSION['packages_to_linked_id'];
        $get_packages = [];

        foreach ($packages_to_linked_id as $key => $package_id) {
            if (!empty(getPackage($package_id))) {
                $get_packages[] = getPackage($package_id);
            }
        }

        $sum = 0;

        if (!empty($get_packages)) {
            foreach ($get_packages as $key => $value) {
                if ($key < sizeof($get_packages)) {
                    $sum = $sum + $value['shipping_cost'];
                }
            }
        }

        if ($tax == '1.03 %') {
            $tax_amount = $sum * 0.0103;
            $sum_tax_in = $tax_amount + $sum;
        }

    ?>
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <p class="text-muted text-center">Veuillez vérifier une dernière fois les principales lignes qui figureront sur la facture. Si correct, cliquez sur le bouton "Correct, Générer".</p>
                    <!-- Page title actions -->
                    <div class="col-md-auto ms-auto d-print-none">
                        <button type="submit" name="generate" value="confirm" class="btn btn-warning">
                            Correct, Générer
                        </button>
                    </div>
                    <div class="col">
                        <button type="submit" id="cancelButton" name="generate" value="cancel" onclick="cancelSubmission()" class="btn btn-ghost-danger">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h3">AFRICA EXPRESS CARGO</p>
                                <address>
                                    Houéyihô - Cotonou, Bénin<br>
                                    10BP308<br>
                                    express.africa.cargo@gmail.com
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3"><?= $customer ?></p>
                            </div>
                            <div class="col-12 my-5">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-transparent">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%"></th>
                                        <th>Colis</th>
                                        <th class="text-center" style="width: 1%">Quantité (KG/CBM/PCS)</th>
                                        <th class="text-end" style="width: 1%">Coût unitaire d'expédition (FCFA)</th>
                                        <th class="text-end" style="width: 1%">Coût d'expédition (FCFA)</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($get_packages)) {
                                    foreach ($get_packages as $key => $package) {
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td>
                                                <p class="strong mb-1"><?= $package['tracking_number'] ?></p>
                                                <div class="text-muted"><?= $package['description'] ?></div>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if ($package['package_units_number'] != 0) {
                                                    echo $package['package_units_number'];
                                                } elseif ($package['net_weight'] != 0) {
                                                    echo $package['net_weight'];
                                                } elseif ($package['volumetric_weight'] != 0) {
                                                    echo $package['volumetric_weight'];
                                                }
                                                ?>
                                            </td>
                                            <td class="text-end"><?= $package['shipping_unit_cost'] ?></td>
                                            <td class="text-end"><?= $package['shipping_cost'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="4" class="strong text-end">Total HT</td>
                                    <td class="text-end"><?= $sum . ' FCFA' ?></td>
                                </tr>
                                <?php
                                if (!empty($tax) && $tax == '1.03 %') {
                                ?>
                                    <tr>
                                        <td colspan="4" class="strong text-end">Taxe de retrait mobile money</td>
                                        <td class="text-end"><?= $tax ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="strong text-end">Montant Frais de retrait</td>
                                        <td class="text-end"><?= $tax_amount ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="font-weight-bold text-uppercase text-end">Net à payer</td>
                                        <td class="font-weight-bold text-end"><?= $sum_tax_in . ' FCFA' ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                if (!empty($tax) && $tax == '1') {
                                ?>
                                    <tr>
                                        <td colspan="4" class="font-weight-bold text-uppercase text-end">Net à payer</td>
                                        <td class="font-weight-bold text-end"><?= $sum . ' FCFA' ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</form>

<!--
    Modal d'affichage des détails d'un colis
-->

<?php
if (isset($packages_listings) && !empty($packages_listings)) {

    foreach ($packages_listings as $key => $package) {

?>
        <div class="modal modal-blur fade" id="<?= 'modal-packages-detail' . $key ?>" tabindex="-1" data-bs-backdrop='static' role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Détails Colis</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Description</div>
                                <div class="datagrid-content">
                                    <?= $package["description"] ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Type d'Envoi</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["shipping_type"]) ? $package["shipping_type"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Poids Net (KG)</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["net_weight"]) ? $package["net_weight"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Poids Volumétrique (CBM)</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["metric_weight"]) ? $package["metric_weight"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Coût unitaire du Colis (FCFA)</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["worth"]) ? $package["worth"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Nombre de Pièces (PCS)</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["package_units_number"]) ? $package["package_units_number"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Coût Unitaire D'Expédition (CUE)</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["shipping_unit_cost"]) ? $package["shipping_unit_cost"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Coût Expédition [ CUE*(PCS/KG/CBM) ]</div>
                                <div class="datagrid-content">
                                    <?= !empty($package["shipping_cost"]) ? $package["shipping_cost"] : '-' ?>
                                </div>
                            </div>
                        </div><br>
                        <div class="row row-cols g-3">
                            <?php
                            if (checkPackageId('packages_images', 'package_id', $package["id"])) {
                                $select_images = getPackageImages($package["id"]);
                                if (!empty($select_images)) {
                                    foreach ($select_images as $_key => $value) {
                            ?>
                                        <div class="col">
                                            <a data-fslightbox="gallery" href='<?= $value['images'] ?>'>
                                                <!-- Photo -->
                                                <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?= $select_images[$_key]['images'] ?>)"></div>
                                            </a>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
<?php

    }
}
?>

<?php include 'app/common/agents/2ndpart.php';

if (isset($_SESSION['next_page']) && $_SESSION['next_page'] == $_SESSION['page']) {
    unset($_SESSION['next_page']);
} elseif (isset($_SESSION['previous_page']) && $_SESSION['previous_page'] == $_SESSION['page']) {
    unset($_SESSION['previous_page']);
} elseif (isset($_SESSION['actual_page']) && $_SESSION['actual_page'] == $_SESSION['page']) {
    unset($_SESSION['actual_page']);
}

unset($_SESSION['research'], $_SESSION['selected_customer'], $_SESSION["data"], $_SESSION["generate_invoice_errors"]);
//unset($_SESSION['tax'], $_SESSION['packages_to_linked_id'], $_SESSION['customer'], $_SESSION['payment_method'], $_SESSION['user_id'], $_SESSION['invoice_number']);

?>