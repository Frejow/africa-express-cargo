<?php include 'app/common/agents/1stpart.php';

$error = [];

if (isset($_SESSION["set_pack_errors"]) && !empty($_SESSION["set_pack_errors"])) {
    $error = $_SESSION["set_pack_errors"];
}

$updata = [];

if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
}

$package_id = $_SESSION['package_id'];

$package_to_edit = getPackageToEdit($package_id);

$product = getProduct($package_to_edit['product_type_id']);

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

foreach ($product as $key => $prod) {
    if (stripos($key, $unit)) {
        if ($prod != 0) {
            if (stripos($key, 'insurance')) {
                $bill_insuranceIn = $prod;
            } elseif (!stripos($key, 'insurance')) {
                $bill_insuranceNot = $prod;
            }
        }
    }
}

?>

<form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/update-packages') ?>" method="post" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                    </svg>Retour
                                </a>
                            </div>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Mettre à jour
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Statut <span class="text-danger">[ Requis ]</span></label>
                                        <select type="text" class="form-select" name="status" id="status">
                                            <option <?php echo ((!empty($updata["status"]) && $updata["status"] == 'Livrer') || $package_to_edit['status'] == 'Livrer') ? "selected" : "" ?> value="Livrer"><span class="badge bg-success me-1"></span>Livrer</option>
                                            <option <?php echo ((!empty($updata["status"]) && $updata["status"] == 'Entrepôt Bénin') || $package_to_edit['status'] == 'Entrepôt Bénin') ? "selected" : "" ?> value="Entrepôt Bénin"><span class="badge bg-secondary me-1"></span>Entrepôt Bénin</option>
                                            <option <?php echo ((!empty($updata["status"]) && $updata["status"] == 'Entrepôt Chine') || $package_to_edit['status'] == 'Entrepôt Chine') ? "selected" : "" ?> value="Entrepôt Chine"><span class="badge bg-primary me-1"></span>Entrepôt Chine</option>
                                            <option <?php echo ((!empty($updata["status"]) && $updata["status"] == 'En transit') || $package_to_edit['status'] == 'En transit') ? "selected" : "" ?> value="En transit"><span class="badge bg-warning me-1"></span>En transit</option>
                                            <option <?php echo ((!empty($updata["status"]) && $updata["status"] == 'En attente...') || $package_to_edit['status'] == 'En attente...') ? "selected" : "" ?> value="En attente..."><span class="badge bg-danger me-1"></span>En attente...</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                if (isset($error["status"]) && !empty($error["status"])) {
                                    echo "<p style = 'color:red; font-size:13px;'>" . $error["status"] . "</p>";
                                }
                                ?>
                            </div>
                            <div class="mb-3 ">
                                <label for="products" class="form-label">Type de produits <span class="text-danger">[ Requis ]</span></label>
                                <div class="">
                                    <select class="form-select" id="products" name="productSelect" style="width: 100%;">
                                        <option value="0">Sélectionner le type de produit</option>

                                        <optgroup label="Type de produits non assurables">
                                            <?php
                                            $productsListing = selectFieldListing('product_type');
                                            if (!empty($productsListing)) {
                                                foreach ($productsListing as $key => $value) {
                                            ?>
                                                    <?php
                                                    if ($value['have_insurance'] == 0) {
                                                    ?>
                                                        <option <?php echo ((!empty($updata["productSelect"]) && $updata["productSelect"] == $value['id'] . '&' . $value['name']) || ($package_to_edit['product_type_id'] . '&' . $package_to_edit['product_type'] == $value['id'] . '&' . $value['name'])) ? "selected" : "" ?> value="<?= $value['id'] . '&' . $value['name'] ?>">
                                                            <?= $value['name'] ?> |
                                                            <?= $value['billing_per_kg'] != 0 ? 'Tarif / KG : ' . $value['billing_per_kg'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_cbm'] != 0 ? 'Tarif / CBM : ' . $value['billing_per_cbm'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_pcs'] != 0 ? 'Tarif / PCS : ' . $value['billing_per_pcs'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_kg_with_insurance'] != 0 ? ' - Assurance incluse / KG : ' . $value['billing_per_kg_with_insurance'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_cbm_with_insurance'] != 0 ? ' - Assurance incluse / CBM : ' . $value['billing_per_cbm_with_insurance'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_pcs_with_insurance'] != 0 ? ' - Assurance incluse / PCS : ' . $value['billing_per_pcs_with_insurance'] . ' FCFA' : '' ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>

                                            <?php
                                                }
                                            }
                                            ?>
                                        </optgroup>

                                        <optgroup label="Type de produits assurables">
                                            <?php
                                            $productsListing = selectFieldListing('product_type');
                                            if (!empty($productsListing)) {
                                                foreach ($productsListing as $key => $value) {
                                            ?>
                                                    <?php
                                                    if ($value['have_insurance'] == 1) {
                                                    ?>
                                                        <option <?php echo ((!empty($updata["productSelect"]) && $updata["productSelect"] == $value['id'] . '&' . $value['name'] . '&insurance') || ($package_to_edit['product_type_id'] . '&' . $package_to_edit['product_type']  . '&insurance' == $value['id'] . '&' . $value['name']  . '&insurance')) ? "selected" : "" ?> data-target="insurance" value="<?= $value['id'] . '&' . $value['name'] . '&insurance' ?>">
                                                            <?= $value['name'] ?> |
                                                            <?= $value['billing_per_kg'] != 0 ? 'Tarif / KG : ' . $value['billing_per_kg'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_cbm'] != 0 ? 'Tarif / CBM : ' . $value['billing_per_cbm'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_pcs'] != 0 ? 'Tarif / PCS : ' . $value['billing_per_pcs'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_kg_with_insurance'] != 0 ? ' - Assurance incluse / KG : ' . $value['billing_per_kg_with_insurance'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_cbm_with_insurance'] != 0 ? ' - Assurance incluse / CBM : ' . $value['billing_per_cbm_with_insurance'] . ' FCFA' : '' ?>
                                                            <?= $value['billing_per_pcs_with_insurance'] != 0 ? ' - Assurance incluse / PCS : ' . $value['billing_per_pcs_with_insurance'] . ' FCFA' : '' ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>

                                            <?php
                                                }
                                            }
                                            ?>
                                        </optgroup>

                                    </select>
                                </div>
                                <?php
                                if (isset($error["productSelect"]) && !empty($error["productSelect"])) {
                                    echo "<p style = 'color:red; font-size:13px;'>" . $error["productSelect"] . "</p>";
                                }
                                ?>
                            </div>
                            <label class="form-label">Unité <span class="text-danger">[ Requis ]</span></label>
                            <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" id="radio" name="pack_unit" <?php echo ((!empty($updata["pack_unit"]) && $updata["pack_unit"] == "kg") || ($package_to_edit['net_weight'] != 0)) ? "checked" : "" ?> value="kg" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">KILOGRAMME ( KG )</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_unit" <?php echo ((!empty($updata["pack_unit"]) && $updata["pack_unit"] == "cbm") || ($package_to_edit['volumetric_weight'] != 0)) ? "checked" : "" ?> value="cbm" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">METRE CUBE ( CBM )</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_unit" <?php echo ((!empty($updata["pack_unit"]) && $updata["pack_unit"] == "pcs") || ($package_to_edit['package_units_number'] != 0)) ? "checked" : "" ?> value="pcs" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">PIECES ( PCS )</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <?php
                                if (isset($error["pack_unit"]) && !empty($error["pack_unit"])) {
                                    echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_unit"] . "</p>";
                                }
                                ?>
                            </div>
                            <div id="insurance" style="<?php echo (!empty($updata["insurance"]) || (!empty($bill_insuranceIn) && !empty($bill_insuranceNot))) ? "display: block;" : "display: none;" ?>">
                                <label class="form-label">Avec assurance ? <span class="text-danger">[ Requis ]</span></label>
                                <div class="form-selectgroup-boxes row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" id="radio" name="pack_insur" <?php echo ((!empty($updata["pack_insur"]) && $updata["pack_insur"] == "oui") || (!empty($bill_insuranceIn) && $package_to_edit['shipping_unit_cost'] == $bill_insuranceIn)) ? "checked" : "" ?> value="oui" class="form-selectgroup-input">
                                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                <span class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </span>
                                                <span class="form-selectgroup-label-content">
                                                    <span class="form-selectgroup-title strong mb-1">OUI</span>
                                                    <span class="d-block text-muted"></span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="pack_insur" <?php echo ((!empty($updata["pack_insur"]) && $updata["pack_insur"] == "non") || (!empty($bill_insuranceNot) && $package_to_edit['shipping_unit_cost'] == $bill_insuranceNot)) ? "checked" : "" ?> value="non" class="form-selectgroup-input">
                                            <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                <span class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </span>
                                                <span class="form-selectgroup-label-content">
                                                    <span class="form-selectgroup-title strong mb-1">NON</span>
                                                    <span class="d-block text-muted"></span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <?php
                                    if (isset($error["pack_insur"]) && !empty($error["pack_insur"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_insur"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="packweight" class="form-label">Nombre ( Nombre de KG/CBM/PCS ) <span class="text-danger">[ Requis ]</span></label>
                                        <input type="text" id="packweight" class="form-control" name="packweight" value="<?php echo (!empty($updata["packweight"])) ? $updata["packweight"] : $quantity ?>" placeholder="Nombre de KG/CBM/PCS">
                                    </div>
                                    <?php
                                    if (isset($error["packweight"]) && !empty($error["packweight"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["packweight"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="_shipping" class="form-label">Envoi <span class="text-danger">[ Requis ]</span></label>
                                        <div class="mb-3">
                                            <select class="form-select" name="_shipping" id="_shipping">
                                                <?php
                                                $shipping_listing = selectFieldListing('shipping_type');
                                                if (!empty($shipping_listing)) {
                                                    foreach ($shipping_listing as $key => $shipping) {

                                                ?>
                                                        <option <?php echo ((!empty($updata["_shipping"]) && $updata["_shipping"] == $shipping['id'] . '&' . $shipping['name']) || ($package_to_edit['shipping_type_id'] . '&' . $package_to_edit['shipping_type'] == $shipping['id'] . '&' . $shipping['name'])) ? "selected" : "" ?> value="<?= $shipping['id'] . '&' . $shipping['name'] ?>"><?= !empty($shipping['name']) ? $shipping['name'] : '' ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["_shipping"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["_shipping"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings') ?>" class="btn btn-link link-secondary" style="border:none;">
                                Annuler
                            </a>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<?php include 'app/common/agents/2ndpart.php' ?>