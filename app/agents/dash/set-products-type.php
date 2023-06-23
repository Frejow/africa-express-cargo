<?php include 'app/common/agents/1stpart.php';

$error = [];

if (isset($_SESSION["set_prodtype_errors"]) && !empty($_SESSION["set_prodtype_errors"])) {
    $error = $_SESSION["set_prodtype_errors"];
}

$updata = [];

if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
}

?>

<form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/set-products-type') ?>" method="post" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/products-type') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content;">
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
                            <div class="row mb-3">
                                <div class="col-lg">
                                    <div class="">
                                        <label for="products" class="form-label">Type de produit <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="products" class="form-control ps-1" name="products" value="<?php echo (isset($updata["products"]) && !empty($updata["products"])) ? $updata["products"] : "" ?>" placeholder="Noms (Ordinateur ou Ordinateur-Téléphones portables si les deux types ont un même tarif.)" autocomplete="off">
                                        </div>
                                        <?php
                                        if (isset($error["products"]) && !empty($error["products"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["products"] . "</p>";
                                        }
                                        ?>
                                        <p class="text-muted">Vous pouvez inscrire plusieurs types de produits de même tarif en les séparant par un tiret de 6 '-'.</p>
                                    </div>
                                </div>
                            </div>
                            <label class="form-label">Assurance possible ? <span class="text-danger">[ Requis ]</span></label>
                            <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-6">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" id="radio" onchange="insuranceBlockVisibility()" <?php echo (!empty($updata["insurance"]) && $updata["insurance"] == "oui") ? "checked" : "" ?> name="insurance" value="oui" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">Oui</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" id="radio" onchange="insuranceBlockVisibility()" name="insurance" <?php echo (!empty($updata["insurance"]) && $updata["insurance"] == "non") ? "checked" : "" ?> value="non" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">Non</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <?php
                                if (!empty($error["insurance"])) {
                                    echo "<p style = 'color:red; font-size:13px;'>" . $error["insurance"] . "</p>";
                                }
                                ?>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="bill" class="form-label">Tarif normal ( EN FCFA ) <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="bill" class="form-control ps-1" name="bill" value="<?= !empty($updata["bill"]) ? $updata["bill"] : "" ?>" placeholder="Montant" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["bill"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["bill"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="unit" class="form-label">Par <span class="text-danger">[ Requis ]</span></label>
                                        <div class="mb-3">
                                            <select class="form-select" name="unit" id="unit">
                                                <option <?php echo (!empty($updata["unit"]) && $updata["unit"] == "KG") ? "selected" : "" ?> value="KG">KILOGRAMME ( KG )</option>
                                                <option <?php echo (!empty($updata["unit"]) && $updata["unit"] == "CBM") ? "selected" : "" ?> value="CBM">METRE CUBE ( CBM )</option>
                                                <option <?php echo (!empty($updata["unit"]) && $updata["unit"] == "PCS") ? "selected" : "" ?> value="PCS">PIECE ( PCS )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["unit"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["unit"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row mb-3" id="insuranceBlock" style="<?php echo (!empty($updata["insurance"]) && $updata["insurance"] == "oui") ? "display: block;" : "display: none;" ?>">
                                <div class="offset-lg-3 col-lg-6">
                                    <div class="">
                                        <label for="bill_insuranceIn" class="form-label">Tarif avec assurance ( EN FCFA ) <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="bill_insuranceIn" class="form-control ps-1" name="bill_insuranceIn" value="<?= !empty($updata["bill_insuranceIn"]) ? $updata["bill_insuranceIn"] : "" ?>" placeholder="Montant" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["bill_insuranceIn"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["bill_insuranceIn"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/products-type') ?>" class="btn btn-link link-secondary" style="border:none;">
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

<?php include 'app/common/agents/2ndpart.php';

unset($_SESSION['set_prodtype_errors'], $_SESSION['data']);
?>