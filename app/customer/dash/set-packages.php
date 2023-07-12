<?php include 'app/common/customer/1stpart.php';

//$productsListing = selectFieldListing('product_type');
//die(var_dump(json_encode($productsListing)));
//die(var_dump($_SERVER));

$error = [];

if (isset($_SESSION["set_pack_errors"]) && !empty($_SESSION["set_pack_errors"])) {
    $error = $_SESSION["set_pack_errors"];
}

$updata = [];

if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
} //die(var_dump($updata));
?>

<form action="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash-treatment/set-packages') ?>" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/packages-listings') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                    </svg>Retour
                                </a>
                            </div>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Ajouter
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="pack_trackN" class="form-label">Numéro de suivi <span class="text-danger">[ Requis ]</span></label>
                                <div class="input-group input-group-flat">
                                    <input type="text" id="pack_trackN" class="form-control ps-2" name="pack_trackN" value="<?php echo (!empty($updata["pack_trackN"])) ? $updata["pack_trackN"] : "" ?>" placeholder="XXXXXXXX" autocomplete="off">
                                </div>
                                <?php
                                if (isset($error["pack_trackN"]) && !empty($error["pack_trackN"])) {
                                    echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_trackN"] . "</p>";
                                }
                                ?>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div>
                                        <label for="pack_descp" class="form-label">Description du colis <span class="text-danger">[ Requis ]</span></label>
                                        <textarea class="form-control" id="pack_descp" name="pack_descp" rows="3"><?php echo (!empty($updata["pack_descp"])) ? $updata["pack_descp"] : "" ?></textarea>
                                    </div>
                                    <?php
                                    if (isset($error["pack_descp"]) && !empty($error["pack_descp"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_descp"] . "</p>";
                                    }
                                    ?>
                                </div>
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
                                                        <option <?php echo (!empty($updata["productSelect"]) && $updata["productSelect"] == $value['id'] . '&' . $value['name']) ? "selected" : "" ?> value="<?= $value['id'] . '&' . $value['name'] ?>">
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
                                                        <option <?php echo (!empty($updata["productSelect"]) && $updata["productSelect"] == $value['id'] . '&' . $value['name'] . '&insurance') ? "selected" : "" ?> data-target="insurance" value="<?= $value['id'] . '&' . $value['name'] . '&insurance' ?>">
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
                                        <input type="radio" id="radio" name="pack_unit" <?php echo (!empty($updata["pack_unit"]) && $updata["pack_unit"] == "kg") ? "checked" : "" ?> value="kg" class="form-selectgroup-input">
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
                                        <input type="radio" name="pack_unit" <?php echo (!empty($updata["pack_unit"]) && $updata["pack_unit"] == "cbm") ? "checked" : "" ?> value="cbm" class="form-selectgroup-input">
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
                                        <input type="radio" name="pack_unit" <?php echo (!empty($updata["pack_unit"]) && $updata["pack_unit"] == "pcs") ? "checked" : "" ?> value="pcs" class="form-selectgroup-input">
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
                            <div id="insurance" style="<?= !empty($updata["insurance"]) ? "display: block;" : "display: none;" ?>">
                                <label class="form-label">Avec assurance ? <span class="text-danger">[ Requis ]</span></label>
                                <div class="form-selectgroup-boxes row mb-3">
                                    <div class="col-lg-6">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" id="radio" name="pack_insur" <?php echo (!empty($updata["pack_insur"]) && $updata["pack_insur"] == "oui") ? "checked" : "" ?> value="oui" class="form-selectgroup-input">
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
                                            <input type="radio" name="pack_insur" <?php echo (!empty($updata["pack_insur"]) && $updata["pack_insur"] == "non") ? "checked" : "" ?> value="non" class="form-selectgroup-input">
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
                            <div class="row mb-3">
                                <div class="col-lg-4">
                                    <div class="">
                                        <label for="pack_weight" class="form-label">Nombre ( Nombre de KG/CBM/PCS ) <span class="text-danger">[ Requis ]</span></label>
                                        <input type="text" id="pack_weight" class="form-control" name="pack_weight" value="<?php echo (!empty($updata["pack_weight"])) ? $updata["pack_weight"] : "" ?>" placeholder="Nombre de KG/CBM/PCS">
                                    </div>
                                    <?php
                                    if (isset($error["pack_weight"]) && !empty($error["pack_weight"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_weight"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="">
                                        <label for="pack_cost" class="form-label">Coût Unitaire du Colis ( en FCFA ) <span class="text-danger">[ Requis ]</span></label>
                                        <input type="text" id="pack_cost" class="form-control" name="pack_cost" value="<?php echo (!empty($updata["pack_cost"])) ? $updata["pack_cost"] : "" ?>" placeholder="Coût d'achat unitaire du Colis">
                                    </div>
                                    <?php
                                    if (isset($error["pack_cost"]) && !empty($error["pack_cost"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_cost"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="">
                                        <label for="shipping" class="form-label">Envoi <span class="text-danger">[ Requis ]</span></label>
                                        <div class="mb-3">
                                            <select class="form-select" name="shipping" id="shipping">
                                                <?php
                                                $shipping_listing = selectFieldListing('shipping_type');
                                                if (!empty($shipping_listing)) {
                                                    foreach ($shipping_listing as $key => $shipping) {

                                                ?>
                                                        <option <?php echo (!empty($updata["shipping"]) && $updata["shipping"] == $shipping['id'] . '&' . $shipping['name']) ? "selected" : "" ?> value="<?= $shipping['id'] . '&' . $shipping['name'] ?>"><?= !empty($shipping['name']) ? $shipping['name'] : '' ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["shipping"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["shipping"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body text-center">
                                    <h3 class="card-title"></h3>

                                    <p class="text-muted"> Poids Maximum : 2Mo / Fichier. Extensions autorisées [ PNG/JPG/JPEG/GIF ]</p>

                                    <label for="importButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                            <path d="M7 9l5 -5l5 5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                    </label>
                                    <input type="file" accept=".png,.jpg,.jpeg,.gif" name="filesToUpload[]" id="filesToUpload" style="display:none" multiple onchange="updatebuttonLabel()">
                                    <input type="button" style="width: auto;" class="mb-2 btn <?= isset($updata["images"]) ? 'btn-danger' : 'link-warning' ?>" value="
                                    <?php if (isset($updata["images"]) && !empty($updata["images"])) {
                                        foreach ($updata["images"] as $key => $value) {
                                            echo $updata["images"][$key] . ' ';
                                        }
                                    } else {
                                        echo  "AJOUTER DES IMAGES [ MAXIMUM 03 ]";
                                    } ?>
                                    " id="importButton" onclick="document.getElementById('filesToUpload').click();" />

                                    <?php
                                    if (isset($error["images"]) && !empty($error["images"])) {
                                        //die(var_dump($error["images"]));
                                        foreach ($error["images"] as $key => $value) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["images"][$key] . "</p>";
                                        }
                                    }
                                    ?>
                                    <div style="display: flex;" id="previews"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/packages-listings') ?>" class="btn btn-link link-secondary" style="border:none;">
                                Annuler
                            </a>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'app/common/customer/2ndpart.php';

unset($_SESSION['set_pack_errors'], $_SESSION['data']);
?>