<?php
include 'app/common/customer/1stpart.php';

$table = "invoices";

if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page'])) {
    $_SESSION['page'] = 1;
}

$_SESSION['rows_per_page'] = 10;

$_SESSION['filter'] = 'Plus récentes';

$_SESSION['search'] = 'UNDEFINED';

$_SESSION['research_by'] = 'invoices_number';

if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
}

if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
    $_SESSION['page'] = $_SESSION['actual_page'];
}

if (isset($_SESSION['selected_rows_per_page']) && !empty($_SESSION['selected_rows_per_page'])) {
    $_SESSION['rows_per_page'] = $_SESSION['selected_rows_per_page'];
}

if (isset($_SESSION['selected_filter']) && !empty($_SESSION['selected_filter'])) {
    $_SESSION['filter'] = $_SESSION['selected_filter'];
}

if (isset($_SESSION['research']) && !empty($_SESSION['research'])) {
    $_SESSION['search'] = $_SESSION['research'];
}

$invoices_listings = othListings($table, $_SESSION['page'], $_SESSION['rows_per_page'], strtoupper($_SESSION['search']), $_SESSION['research_by'], $_SESSION['filter'], null, $data['id']);

$rows = countRowsInTable($table, null, $data['id']);

?>

<form id="myForm" action="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash-treatment/invoices') ?>" method="post">
    <div class="page-header d-print-none">
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
                                <div class="col-lg-4 col-xs mb-2 text-muted ms-auto" style="display: flex;">
                                    <div>
                                        <span>Rechercher</span>
                                    </div>

                                    <div class="ms-2 d-inline-block">
                                        <input type="text" name="search" class="form-control" value="<?= isset($_SESSION['research']) ? $_SESSION['research'] : '' ?>" placeholder="N° Facture">
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
                                        <select class="form-select" name="filterSelect" id="mySelect2">
                                            <option <?php if (isset($_SESSION['selected_filter']) && $_SESSION['selected_filter'] == 'Plus récentes') {
                                                        echo 'selected';
                                                    } ?> data-value="Plus récentes">Plus récentes</option>
                                            <option <?php if (isset($_SESSION['selected_filter']) && $_SESSION['selected_filter'] == 'Plus anciennes') {
                                                        echo 'selected';
                                                    } ?> data-value="Plus anciennes">Plus anciennes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th class="">N° de Facture</th>
                                        <th>Generer le</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($invoices_listings) && !empty($invoices_listings)) {

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

                                        foreach ($invoices_listings as $key => $invoice) {

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

                                                    ?></td>
                                                <td>
                                                    <?= $invoice["invoices_number"] ?>
                                                </td>
                                                <td class="">
                                                    <span></span>

                                                    <?= !empty($invoice["created_at"]) ? date("d/m/Y H:i:s", strtotime($invoice['created_at'])) : '-' ?>
                                                </td>
                                                <td class="text-end">
                                                    <span class="">
                                                        <button class="btn-link" type="submit" name="insight" value="<?= $invoice["id"] ?>">
                                                            Aperçu
                                                        </button>
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
                            <?php

                            $s = null;

                            if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page']) && !isset($_SESSION['actual_page'])) {

                                $s = $_SESSION['page'];

                                if (!isset($invoices_listings) || empty($invoices_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] == 2) {

                                $s = $_SESSION['rows_per_page'] + 1;

                                if (!isset($invoices_listings) || empty($invoices_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] > 2) {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($invoices_listings) || empty($invoices_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

                            <?php

                            } else {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($invoices_listings) || empty($invoices_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>
                                <p class="m-0 text-muted">Affichage <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> de la ligne <?php } ?> <span><?= $s ?></span> <?php if (isset($invoices_listings) && !empty($invoices_listings)) { ?> à la ligne <span><?= $en ?></span> <?php } ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total</p>

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
                                <li class="page-item <?php if (!isset($invoices_listings) || empty($invoices_listings)) {
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


<div class="d-lg-none" style="display: none;">

</div>

<!--
    Modal d'aperçu des factures
-->

<?php
if (isset($invoices_listings) && !empty($invoices_listings)) {

    foreach ($invoices_listings as $key => $invoice) {

        $packages_linked_to_this_invoice = getAllPackagesLinkedToInvoice($invoice["id"]);

        $sum = 0;
        $taxes = '-';

        for ($i = 0; $i < sizeof($packages_linked_to_this_invoice); $i++) {
            foreach ($packages_linked_to_this_invoice as $key => $value) {
                $sum = $sum + $value['shipping_cost'];
            }
        }

?>
        <div class="modal modal-blur fade" id="<?= 'modal-invoice-insight' . $key ?>" tabindex="-1" data-bs-backdrop='static' role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><?= date("d/m/Y", strtotime(explode(' ', $invoice['created_at'])[0])) ?></h3>
                        <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Print Invoice
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="page-body">
                            <div class="container-xl">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="h3">Africa Express Cargo</p>
                                        <address>
                                            Houéyihô<br>
                                            Cotonou<br>
                                            10BP308<br>
                                            express.africa.cargo@gmail.com
                                        </address>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="h3"><?= $data['name'] . ' ' . $data['first_names'] ?></p>
                                        <address>
                                            <?= $data['mail'] ?>
                                        </address>
                                    </div>
                                    <div class="col-12 my-5">
                                        <h1>Facture <?= $invoice["invoices_number"] ?></h1>
                                    </div>
                                </div>
                                <table class="table table-transparent table-responsive">
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
                                    foreach ($packages_linked_to_this_invoice as $key => $package) {
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
                                    ?>
                                    <tr>
                                        <td colspan="4" class="strong text-end">Total HT</td>
                                        <td class="text-end"><?= $sum ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="strong text-end">TVA</td>
                                        <td class="text-end"><?= $taxes ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="strong text-end">Montant TVA</td>
                                        <td class="text-end"><?= $taxes ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="font-weight-bold text-uppercase text-end">Net à payer</td>
                                        <td class="font-weight-bold text-end"><?= $sum ?></td>
                                    </tr>
                                </table>
                                <p class="text-muted text-center mt-5">Merci beaucoup de faire affaire avec nous. Nous sommes impatients de travailler avec
                                    vous de nouveau!</p>
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