<?php
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

include '..' . PROJECT . 'app/common/customer/1stpart.php';

//unset($_SESSION['next_page']);

$_SESSION['page'] = 1; //die (var_dump($_SESSION['page']));

$_SESSION['packages_nb_per_page'] = 10;

$_SESSION['status'] = 'undefined';

$_SESSION['search'] = 'UNDEFINED';

if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
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

$packages_listings = packages_list($_SESSION['page'], $_SESSION['packages_nb_per_page'], $_SESSION['status'], strtoupper($_SESSION['search']));

//die (var_dump($packages_listings));

$rows = count_rows_in_package_table();

?>

<?php
if (isset($_SESSION['success_msg']) && !empty($_SESSION['success_msg'])) {
    $msg = $_SESSION['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    unset($_SESSION['success_msg']);
}
?>

<?php
if (isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])) {
    $msg = $_SESSION['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    unset($_SESSION['error_msg']);
}
?>

<form id="myForm" action="
    <?php
    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        echo PROJECT . 'customer/dash-treatment/packages-listings' . '?theme=light';
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        echo PROJECT . 'customer/dash-treatment/packages-listings' . '?theme=dark';
    } else {
        echo PROJECT . 'customer/dash-treatment/packages-listings' . '?theme=light';
    }
    ?>
    " method="post">
    <div class="page-header d-print-none">
        <div class="container-xl d-flex" style="justify-content: center;">
            <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                <!-- Page title actions -->
                <div class="col-12 col-lg-auto ms-auto d-print-none">
                    <div class="btn-list justify-content-center">
                        <a href="
                            <?php
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=dark';
                            } else {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=light';
                            }
                            ?>
                            " class="btn d-none text-white d-sm-inline-block btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Nouveau colis
                        </a>
                        <a href="
                            <?php
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=dark';
                            } else {
                                echo PROJECT . 'customer/dash/set-packages' . '?theme=light';
                            }
                            ?>
                            " class="btn d-sm-none text-white btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Nouveau Colis
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
                                <div class="col-lg-4 col-xs mb-2 text-muted ms-auto">
                                    Rechercher :
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
                                            <option disabled selected value="">Statut</option>
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
                                        <th>Groupe Colis</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (isset($packages_listings) && !empty($packages_listings)) {
                                        $n = 0;
                                        foreach ($packages_listings as $key => $package) {
                                    ?>
                                            <tr>
                                                <td><?= $key + 1 ?><input class="form-check-input m-0 align-middle row-check" type="checkbox" value="BN95F621" name="checkbox" aria-label="Select invoice"></td>
                                                <td>
                                                    <?= $packages_listings[$key]["tracking_number"] ?>
                                                </td>
                                                <td class="">
                                                    <span></span>
                                                    <?= !empty($packages_listings[$key]["product_type"]) ? $packages_listings[$key]["product_type"] : '-' ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success me-1"></span> <?= $packages_listings[$key]["status"] ?>
                                                </td>
                                                <td>
                                                    <?= !empty($packages_listings[$key]["customer_package_group_id"]) ? '<a href = "#">Oui -> ' . $packages_listings[$key]["customer_package_group_id"] . '</a>' : 'Non' ?>
                                                </td>
                                                <td class="text-end">
                                                    <span class="">
                                                        <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="<?= '#modal-packages-detail' . $key ?>">
                                                            Détails
                                                        </a>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <span class="">
                                                        <a class="btn-link link-warning" href='
                                                    <?php
                                                    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                                                        echo PROJECT . 'customer/dash/edit-packages' . '?theme=light';
                                                    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                                                        echo PROJECT . 'customer/dash/edit-packages' . '?theme=dark';
                                                    } else {
                                                        echo PROJECT . 'customer/dash/edit-packages' . '?theme=light';
                                                    }
                                                    ?>
                                                    '>
                                                            Modifier
                                                        </a>
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <span class="">
                                                        <a class="btn-link link-danger" href="" data-bs-toggle="modal" data-bs-target="">
                                                            Supprimer
                                                        </a>
                                                    </span>
                                                </td>
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
                            <p class="m-0 text-muted">Affichage de <span><?= $n ?></span> ligne (s) sur <span><?= $rows[0]['COUNT(*)'] ?></span> au total</p>
                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item <?= ($_SESSION['page'] == 1) ? "disabled" : "" ?>">
                                    <button type="submit" name="previous" class="page-link">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 6l-6 6l6 6" />
                                        </svg>
                                        précédent
                                    </button>
                                </li>
                                <li class="page-item page-link active"><?= $_SESSION['page'] ?></li>
                                <li class="page-item">
                                    <button type="submit" name="next" class="page-link">
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

<?php include '..' . PROJECT . 'app/common/customer/2ndpart.php';

unset($_SESSION['selected_status'], $_SESSION['select_packages_nb_per_page'], $_SESSION['next_page'], $_SESSION['research']);
?>