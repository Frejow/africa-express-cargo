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
$_SESSION['status'] = 'Tout Afficher';

// Cinquième paramètre, le numéro de suivi à rechercher. "UNDEFINED" par défaut dans le cas où aucune recherche n'est lancée
$_SESSION['search'] = 'UNDEFINED';

// Sixième paramètre
$_SESSION['type'] = 'Tous les colis';

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page précédente)
if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page suivante)
if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page actuel)
if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
    $_SESSION['page'] = $_SESSION['actual_page'];
}

/**
 * Nouvelle valeur du troisième paramètre, nombre de colis par page, lorsqu'un autre nombre autre que 10 est sélectionné 
 * par l'utilisateur poiur afficher le nombre de colis par page
 */
if (isset($_SESSION['selected_rows_per_page']) && !empty($_SESSION['selected_rows_per_page'])) {
    $_SESSION['rows_per_page'] = $_SESSION['selected_rows_per_page'];
}

/**
 * Nouvelle valeur du quatrième paramètre, type de statut, lorsque l'utilisateur décide de filtrer la liste selon un 
 * statut autre que celui par défaut
 */
if (isset($_SESSION['selected_status']) && !empty($_SESSION['selected_status'])) {
    $_SESSION['status'] = $_SESSION['selected_status'];
}

//Nouvelle valeur du cinquième paramètre, le numéro de suivi à rechercher dans la table "package"
if (isset($_SESSION['research']) && !empty($_SESSION['research'])) {
    $_SESSION['search'] = $_SESSION['research'];
}

//Nouvelle valeur du sixième paramètre
if (isset($_SESSION['packages_type']) && !empty($_SESSION['packages_type'])) {
    $_SESSION['type'] = $_SESSION['packages_type'];
}
//die(var_dump($_SESSION['package']));

//Affectation du retour de la fonction listings avec les cinq paramètres suscités à la variable $packages_lisitngs
$packages_listings = listings($table, $_SESSION['page'], $_SESSION['rows_per_page'], $_SESSION['status'], strtoupper($_SESSION['search']), $_SESSION['type'], null);

/**
 * Affectation du retour de la fonction countRowsInTable avec pour paramètre la table concernée par le listings à la 
 * variable $rows. Cette fonction retourne le nombre de lignes dans la table avec le champs is_deleted = 0
 */
$rows = countRowsInTable($table, $_SESSION['package'], null);

?>

<!--
    Ce bloc de formulaire prend en charge le tableau de listings des colis. Toutes les possibles valeurs des différents 
    paramètres de la fonction listings sont soumises et récupérées via la méthode POST. Ici, aucune valeur ne transite par
    l'url.
-->
<form id="myForm" action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/packages-listings') ?>" method="post">
    <!-- Bouton de création de colis -->
    <div class="page-header d-print-none">
        <div class="container-xl d-flex" style="justify-content: center;">
            <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                <!-- Page title actions -->
                <div class="col-12 col-lg-auto ms-auto d-print-none">
                    <div class="btn-list justify-content-center">
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages') ?>" class="btn d-none text-white d-sm-inline-block btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Ajouter colis
                        </a>
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-packages') ?>" class="btn d-sm-none text-white btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Ajouter Colis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tableau d'affichage des données de colis récupérées depuis la base de données -->
    <div class="page-body">
        <div class="container-xl text-center">
            <div class="row row-deck row-cards">
                <div class="col-lg col-xs ms-auto text-muted">
                    <div class="ms-2 d-inline-block">
                        <select class="form-select" name="packagesType" id="mySelect3">
                            <option <?php if (isset($_SESSION['packages_type']) && $_SESSION['packages_type'] == 'Tous les colis') {
                                        echo 'selected';
                                    } ?> data-value="Tous les colis">Tous les colis</option>
                            <option <?php if (isset($_SESSION['packages_type']) && $_SESSION['packages_type'] == 'Colis avec destinataire') {
                                        echo 'selected';
                                    } ?> data-value="Colis avec destinataire">Colis avec destinataire</option>
                            <option <?php if (isset($_SESSION['packages_type']) && $_SESSION['packages_type'] == 'Colis sans destinataire') {
                                        echo 'selected';
                                    } ?> data-value="Colis sans destinataire">Colis sans destinataire</option>
                        </select>
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
                                <div class="col-lg-4 col-xs mb-2 text-muted">
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
                                -->
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
                                <!-- 
                                    Bloc select de sélection des différents statuts possibles suivant lesquels filtrer 
                                    l'affichage des colis. Ici un script Js facilite la soumission de la valeur à la 
                                    sélection d'une des options. Ce script se base sur l'id du champs select et l'id du 
                                    formulaire pour envoyer la valeur correspondante au fichier de traiment du formulaire.
                                -->
                                <div class="col-lg-4 col-xs ms-auto text-muted">
                                    Statuts :
                                    <div class="ms-2 d-inline-block">
                                        <select class="form-select" name="statusSelect" id="mySelect2">
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Tout Afficher') {
                                                        echo 'selected';
                                                    } ?> data-value="Tout Afficher">Tout Afficher</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'En attente...') {
                                                        echo 'selected';
                                                    } ?> data-value="En attente...">En attente...</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'En transit') {
                                                        echo 'selected';
                                                    } ?> data-value="En transit">En transit</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Entrepôt Chine') {
                                                        echo 'selected';
                                                    } ?> data-value="Entrepôt Chine">Entrepôt Chine</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Entrepôt Bénin') {
                                                        echo 'selected';
                                                    } ?> data-value="Entrepôt Bénin">Entrepôt Bénin</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Livrer') {
                                                        echo 'selected';
                                                    } ?> data-value="Livrer">Livrer</option>
                                            <option <?php if (isset($_SESSION['selected_status']) && $_SESSION['selected_status'] == 'Livrer et Confirmer') {
                                                        echo 'selected';
                                                    } ?> data-value="Livrer et Confirmer">Livrer et Confirmer</option>
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
                                        <th class="w-1">#<input class="form-check-input m-0 align-middle row-check" type="checkbox" id="check-all" aria-label="Select all invoices"></th>
                                        <th class="">N° de suivi</th>
                                        <th>Type de produits</th>
                                        <th>Statut</th>
                                        <th>Groupe Colis</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    if (isset($packages_listings) && !empty($packages_listings)) {

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

                                            /**
                                             * Chaque colis a la possibilité d'appartenir à un groupe de colis. Lorsque c'est le cas, l'identifiant du groupe auquel appartient 
                                             * le colis est associé au colis. Pour un affichage plus détaillé, il a été mis en place la possibilité pour l'utilisateur de voir 
                                             * un aperçu du groupe auquel appartient son colis et de bien visualiser le numéro de suivi de son colis dans la liste des colis appartenant
                                             * au groupe en question. Le contrôle suivant permet donc d'accéder au groupe de tout colis contenu dans ce dernier pour permettre l'affichage
                                             * en clair à l'utilisateur.
                                             */
                                            if (!empty($package["customer_package_group_id"])) {

                                                //Récupération du numéro de suivi du groupe de colis
                                                $packages_group_tracking_number = getPackagesGroupTrackingNumber($package["customer_package_group_id"])['tracking_number'];

                                                /**
                                                 * Récupération de tous les colis contenu dans le groupe. 
                                                 * La variable $packages_ingrouplistings sera appelée plus bas pour afficher la liste de tous les colis du groupe auquel 
                                                 * appartient le colis présentement concerné. Cette liste sera affichée dans un modal avec le numéro de suivi du colis
                                                 * présentement concerné surligné en orange pour permettre son identification rapide par l'utilisateur.
                                                 */
                                                $packages_ingrouplistings = getAllPackagesLinkedToSpecificPackagesGroup($package["customer_package_group_id"]);
                                            }
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php

                                                    if ($_SESSION['page'] == 1) {

                                                        $en = $key + 1;

                                                        echo $en;
                                                    } elseif ($_SESSION['page'] == 2) {

                                                        $en = $_SESSION['rows_per_page'] + $key + 1;

                                                        echo $en;
                                                    } elseif ($_SESSION['page'] > 2 && $m > 2) {

                                                        $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;

                                                        echo $en;
                                                    } else {

                                                        $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;

                                                        echo $en;
                                                    }

                                                    ?><input class="form-check-input m-0 align-middle row-check" type="checkbox" value="BN95F621" name="checkbox" aria-label="Select invoice"></td>
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
                                                <td>
                                                    <?= !empty($package["customer_package_group_id"]) ? 'Oui -> <a href = "#" data-bs-toggle="modal" data-bs-target="#' . $packages_group_tracking_number . $key . '">' . $packages_group_tracking_number . ' [ Voir ]</a>' : 'Non' ?>

                                                    <!--
                                                        Modal d'affichage des colis contenus dans un groupe de colis.
                                                    -->
                                                    <div class="modal modal-blur fade" data-bs-backdrop='static' id="<?= !empty($package["customer_package_group_id"]) ? $packages_group_tracking_number . $key : '' ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">Groupe N° <?= !empty($package["customer_package_group_id"]) ? $packages_group_tracking_number : '' ?></h3>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="datagrid">
                                                                        <div class="datagrid-item">
                                                                            <div class="datagrid-title">Nombre de Colis</div>
                                                                            <div class="datagrid-content"><?= !empty($package["customer_package_group_id"]) ? sizeof($packages_ingrouplistings) : '' ?></div>
                                                                        </div>
                                                                    </div><br>
                                                                    <div class="row row-deck row-cards text-center">
                                                                        <div class="col-12">
                                                                            <div class="card">
                                                                                <div class="card-body border-bottom py-3">
                                                                                    <div class="d-flex justify-content-center">
                                                                                        <div class="">
                                                                                            <h3 class="d-inline-block">
                                                                                                Colis du Groupe
                                                                                            </h3>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="table-responsive">
                                                                                    <table class="table card-table table-vcenter text-nowrap datatable">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="">N° de suivi</th>
                                                                                                <th>Type de produits</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            if (isset($packages_ingrouplistings) && !empty($packages_ingrouplistings)) {

                                                                                                foreach ($packages_ingrouplistings as $_key => $packages_ingroup) {
                                                                                            ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <?= $packages_ingroup["tracking_number"] == $package["tracking_number"] ? '<span class="badge bg-orange">' . $packages_ingrouplistings[$_key]["tracking_number"] . '</span>' : $packages_ingrouplistings[$_key]["tracking_number"] ?>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <?= !empty($packages_ingroup["product_type"]) ? $packages_ingroup["product_type"] : '-' ?>
                                                                                                        </td>
                                                                                                        <!--
                                                                                                        <td class="text-end">
                                                                                                            <span class="">
                                                                                                                <a class="btn-link" href="" data-bs-toggle="modal" data-bs-dismiss="false" data-bs-target="<?= "#modal-packages-ingroup-detail" . $key ?>">
                                                                                                                    Détails
                                                                                                                </a>
                                                                                                            </span>
                                                                                                        </td>
                                                                                                        -->
                                                                                                    </tr>
                                                                                            <?php

                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="text-end">
                                                    <span class="">
                                                        <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="<?= '#modal-packages-detail' . $key ?>">
                                                            Détails
                                                        </a>
                                                    </span>
                                                </td>
                                                <?php
                                                if ($package["user_id"] == 38) {
                                                ?>
                                                    <td class="text-end">
                                                        <span class="">
                                                            <a class="btn-link link-warning" href='<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/edit-packages') ?>'>
                                                                Modifier
                                                            </a>
                                                        </span>
                                                    </td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td class="text-end">
                                                        <span class="">
                                                            <a class="btn-link link-warning" href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/update-packages') ?>">
                                                                Mettre à jour
                                                            </a>
                                                        </span>
                                                    </td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        $n = $key + 1;
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

                            <?php

                            $s = null; //Cette variable stocke la valeur du numéro de la première ligne sur une page

                            if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page']) && !isset($_SESSION['actual_page'])) {

                                $s = $_SESSION['page'];

                                if (!isset($packages_listings) || empty($packages_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] == 2) {

                                $s = $_SESSION['rows_per_page'] + 1;

                                if (!isset($packages_listings) || empty($packages_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] > 2) {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($packages_listings) || empty($packages_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } else {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($packages_listings) || empty($packages_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($packages_listings) && !empty($packages_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            }

                            ?>

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
                            if (checkPackageIdInPackagesImagesTab($package["id"])) {
                                $select_images = getPackageImages($package["id"]);
                                if (!empty($select_images)) {
                                    foreach ($select_images as $_key => $value) {
                            ?>
                                        <div class="col">
                                            <a data-fslightbox="gallery" href='<?= $select_images[$_key]['images'] ?>'>
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

unset($_SESSION['research']);

?>