<?php
include 'app/common/customer/1stpart.php';

$table = "customer_package_group";

if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page'])) {
    $_SESSION['page'] = 1;
}

$_SESSION['packages_nb_per_page'] = 10;

$_SESSION['status'] = 'Tout Afficher';

$_SESSION['search'] = 'UNDEFINED';

if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
}

if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
    $_SESSION['page'] = $_SESSION['actual_page'];
}

if (isset($_SESSION['select_packages_nb_per_page']) && !empty($_SESSION['select_packages_nb_per_page'])) {
    $_SESSION['packages_nb_per_page'] = $_SESSION['select_packages_nb_per_page'];
}

if (isset($_SESSION['selected_status']) && !empty($_SESSION['selected_status'])) {
    $_SESSION['status'] = $_SESSION['selected_status'];
}

if (isset($_SESSION['research']) && !empty($_SESSION['research'])) {
    $_SESSION['search'] = $_SESSION['research'];
}

$packages_group_listings = listings($table, $_SESSION['page'], $_SESSION['packages_nb_per_page'], $_SESSION['status'], strtoupper($_SESSION['search']), null, $data['id']);

$rows = countRowsInTable($table, null, $data['id']);

?>

<form id="myForm" action="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash-treatment/packages-group-listings') ?>" method="post">
    <div class="page-header d-print-none">
        <div class="container-xl d-flex" style="justify-content: center;">
            <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                <!-- Page title actions -->
                <div class="col-12 col-lg-auto ms-auto d-print-none">
                    <div class="btn-list justify-content-center">
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/set-packages-group') ?>" class="btn d-none text-white d-sm-inline-block btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Créer un groupe de colis
                        </a>
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/set-packages-group') ?>" class="btn d-sm-none text-white btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Groupe colis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl text-center">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border-bottom py-3">
                            <div class="row">
                                <div class="col-lg-4 col-xs mb-2 text-muted">
                                    Afficher
                                    <div class="mx-2 d-inline-block">
                                        <select class="form-select" name="select" id="mySelect">
                                            <option value="10">10</option>
                                            <option <?php if (isset($_SESSION['select_packages_nb_per_page']) && $_SESSION['select_packages_nb_per_page'] == 15) {
                                                        echo 'selected';
                                                    } ?> value="15">15</option>
                                            <option <?php if (isset($_SESSION['select_packages_nb_per_page']) && $_SESSION['select_packages_nb_per_page'] == 20) {
                                                        echo 'selected';
                                                    } ?> value="20">20</option>
                                            <option <?php if (isset($_SESSION['select_packages_nb_per_page']) && $_SESSION['select_packages_nb_per_page'] == 30) {
                                                        echo 'selected';
                                                    } ?> value="30">30</option>
                                        </select>
                                    </div>
                                    lignes
                                </div>
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
                                <div class="col-lg-4 col-xs ms-auto text-muted">
                                    Filtrer :
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

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-1">#<input class="form-check-input m-0 align-middle row-check" type="checkbox" id="check-all" aria-label="Select all invoices"></th>
                                        <th class="">N° de suivi</th>
                                        <th>Type de produits</th>
                                        <th>Statut</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($packages_group_listings) && !empty($packages_group_listings)) {

                                        $n = 0;
                                        $m = 0;
                                        $en = 0;

                                        if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
                                            $m = $_SESSION['next_page'];
                                        }
                                        if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
                                            $m = $_SESSION['previous_page'];
                                        }
                                        if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
                                            $m = $_SESSION['actual_page'];
                                        }

                                        foreach ($packages_group_listings as $key => $packages_group) {

                                            $packages_ingrouplistings = getAllPackagesLinkedToSpecificPackagesGroup($packages_group_listings[$key]['id']);

                                            if (sizeof($packages_ingrouplistings) >= 1) {

                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php

                                                        if ($_SESSION['page'] == 1) {

                                                            $en = $key + 1;

                                                            echo $en;
                                                        } elseif ($_SESSION['page'] == 2) {

                                                            $en = $_SESSION['packages_nb_per_page'] + $key + 1;

                                                            echo $en;
                                                        } elseif ($_SESSION['page'] > 2 && $m > 2) {

                                                            $en = ($_SESSION['packages_nb_per_page'] * ($m - 1)) + $key + 1;

                                                            echo $en;
                                                        } else {

                                                            $en = ($_SESSION['packages_nb_per_page'] * ($m - 1)) + $key + 1;

                                                            echo $en;
                                                        }

                                                        ?><input class="form-check-input m-0 align-middle row-check" type="checkbox" value="BN95F621" name="checkbox" aria-label="Select invoice"></td>
                                                    <td>
                                                        <?= $packages_group_listings[$key]["tracking_number"] ?>
                                                    </td>
                                                    <td class="">
                                                        <span></span>

                                                        <?= !empty($packages_group_listings[$key]["product_type"]) ? $packages_group_listings[$key]["product_type"] : '-' ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge 
                                                    <?php if ($packages_group_listings[$key]["status"] == 'En attente...') {
                                                        echo 'bg-secondary';
                                                    } elseif ($packages_group_listings[$key]["status"] == 'En transit') {
                                                        echo 'bg-primary';
                                                    } elseif ($packages_group_listings[$key]["status"] == 'Entrepôt Chine') {
                                                        echo 'bg-danger';
                                                    } elseif ($packages_group_listings[$key]["status"] == 'Entrepôt Bénin') {
                                                        echo 'bg-warning';
                                                    } elseif ($packages_group_listings[$key]["status"] == 'Livrer') {
                                                        echo 'bg-success';
                                                    }
                                                    ?>
                                                    me-1"></span>

                                                        <?= $packages_group_listings[$key]["status"] ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="">
                                                            <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="<?= '#modal-packages-group-detail' . $key ?>">
                                                                Détails
                                                            </a>
                                                        </span>
                                                    </td>

                                                    <td class="text-end">
                                                        <span class="">
                                                            <button class="btn-link link-warning" name="packages_group_edition" value="<?= $packages_group_listings[$key]["tracking_number"] . '&' . $packages_group_listings[$key]["id"] ?>" type="submit">
                                                                Modifier
                                                            </button>
                                                        </span>
                                                    </td>

                                                    <td class="text-end">
                                                        <span class="">
                                                            <a class="btn-link link-danger
                                                        <?php if ($packages_group_listings[$key]["status"] === 'En attente...') {
                                                            echo '';
                                                        } else {
                                                            echo 'disabled text-muted';
                                                        }
                                                        ?>
                                                        " href="#" data-bs-toggle="modal" data-bs-target="<?= "#package_group_deletionModal" . $key ?>">
                                                                Supprimer
                                                            </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <div class="modal modal-blur fade" id="<?= "package_group_deletionModal" . $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            <div class="modal-status bg-danger"></div>
                                                            <div class="modal-body text-center py-4">
                                                                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M12 9v2m0 4v.01" />
                                                                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                                                </svg>

                                                                <h3>Cette action est irréversible. Êtes-vous sûr(e) ?</h3>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="w-100">
                                                                    <div class="row">
                                                                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                                                Annuler
                                                                            </a></div>
                                                                        <div class="col"><button type="submit" name="package_group_deletion" value="<?= $packages_group_listings[$key]["tracking_number"] . '&' . $packages_group_listings[$key]["id"] ?>" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                                Confirmer
                                                                            </button></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            } else {
                                                deletedPackageOrPackagesGroup($packages_group_listings[$key]["tracking_number"], 'customer_package_group');
                                            }
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

                            $s = null;

                            if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page']) && !isset($_SESSION['actual_page'])) {

                                $s = $_SESSION['page'];

                                if (!isset($packages_group_listings) || empty($packages_group_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] == 2) {

                                $s = $_SESSION['packages_nb_per_page'] + 1;

                                if (!isset($packages_group_listings) || empty($packages_group_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] > 2) {

                                $s = ($_SESSION['packages_nb_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($packages_group_listings) || empty($packages_group_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } else {

                                $s = ($_SESSION['packages_nb_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($packages_group_listings) || empty($packages_group_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($packages_group_listings) && !empty($packages_group_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

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
                                <li class="page-item <?php if (!isset($packages_group_listings) || empty($packages_group_listings)) {
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
    Modal d'affichage des détails d'un groupe de colis
-->

<?php
if (isset($packages_group_listings) && !empty($packages_group_listings)) {

    foreach ($packages_group_listings as $key => $packages_group) {

        $packages_ingrouplistings = getAllPackagesLinkedToSpecificPackagesGroup($packages_group_listings[$key]['id']);
?>
        <div class="modal modal-blur fade" data-bs-backdrop='static' id="<?= 'modal-packages-group-detail' . $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Détails Groupe</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Nombre de Colis</div>
                                <div class="datagrid-content"><?= sizeof($packages_ingrouplistings) ?></div>
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
                                                    <th>Statut</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($packages_ingrouplistings) && !empty($packages_ingrouplistings)) {

                                                    foreach ($packages_ingrouplistings as $key => $packages_ingroup) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?= $packages_ingroup["tracking_number"] ?>
                                                            </td>
                                                            <td class="">
                                                                <span></span>
                                                                <?= !empty($packages_ingroup["product_type"]) ? $packages_ingroup["product_type"] : '-' ?>
                                                            </td>
                                                            <td>
                                                                <span class="badge
                                                                    <?php if ($packages_ingroup["status"] == 'En attente...') {
                                                                        echo 'bg-danger-lt';
                                                                    } elseif ($packages_ingroup["status"] == 'En transit') {
                                                                        echo 'bg-primary-lt';
                                                                    } elseif ($packages_ingroup["status"] == 'Entrepôt Chine') {
                                                                        echo 'bg-secondary-lt';
                                                                    } elseif ($packages_ingroup["status"] == 'Entrepôt Bénin') {
                                                                        echo 'bg-warning-lt';
                                                                    } elseif ($packages_ingroup["status"] == 'Livrer') {
                                                                        echo 'bg-teal-lt';
                                                                    } elseif ($packages_ingroup["status"] == 'Livrer et Confirmer') {
                                                                        echo 'bg-success';
                                                                    }
                                                                    ?>
                                                                    me-1"><?= $packages_ingroup["status"] ?>
                                                                </span>
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
<?php

    }
}
?>

<?php include 'app/common/customer/2ndpart.php';

if (isset($_SESSION['next_page']) && $_SESSION['next_page'] == $_SESSION['page']) {
    unset($_SESSION['next_page']);
} elseif (isset($_SESSION['previous_page']) && $_SESSION['previous_page'] == $_SESSION['page']) {
    unset($_SESSION['previous_page']);
} elseif (isset($_SESSION['actual_page']) && $_SESSION['actual_page'] == $_SESSION['page']) {
    unset($_SESSION['actual_page']);
}

unset($_SESSION['research']);

?>