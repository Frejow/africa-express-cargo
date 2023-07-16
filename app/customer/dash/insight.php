<?php include 'app/common/customer/1stpart.php'; ?>

<?php

$invoice_id = $_SESSION['invoice_id'];

$invoice = getInvoice($invoice_id);

$packages_linked_to_this_invoice = getAllPackagesLinkedToInvoice($invoice_id);

$sum = 0;
$taxes = '-';

for ($i = 0; $i < sizeof($packages_linked_to_this_invoice); $i++) {
    foreach ($packages_linked_to_this_invoice as $key => $value) {
        $sum = $sum + $value['shipping_cost'];
    }
}
?>
<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Facture <?= $invoice["invoices_number"] ?>
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                    <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                    </svg>
                    Télécharger ou Imprimer
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card card-lg">
            <div class="">
            <h3 class="card-title"><?= date("d/m/Y", strtotime(explode(' ', $invoice['created_at'])[0])) ?></h3>
            </div>
            <div class="card-body">
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



<?php include 'app/common/customer/2ndpart.php'; ?>