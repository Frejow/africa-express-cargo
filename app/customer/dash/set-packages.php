<?php
include 'app/common/customer/1stpart.php';

$error = [];

if (isset($_SESSION["set_pack_errors"]) && !empty($_SESSION["set_pack_errors"])) {
    $error = $_SESSION["set_pack_errors"];
}

$updata = [];

if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
}

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
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro de suivi <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" required class="form-control" name="pack_trackN" value="<?php echo (isset($updata["pack_trackN"]) && !empty($updata["pack_trackN"])) ? $updata["pack_trackN"] : "" ?>" placeholder="0X0YZ1" autocomplete="off">
                                        </div>
                                        <?php
                                        if (isset($error["pack_trackN"]) && !empty($error["pack_trackN"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_trackN"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="pack_count" value="<?php echo (isset($updata["pack_count"]) && !empty($updata["pack_count"])) ? $updata["pack_count"] : "" ?>" placeholder="Nombre d'unités">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Valeur [FCFA]</label>
                                        <input type="number" class="form-control" name="pack_cost" value="<?php echo (isset($updata["pack_cost"]) && !empty($updata["pack_cost"])) ? $updata["pack_cost"] : "" ?>" placeholder="Coût d'achat">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="form-label">Description du colis <span class="text-danger">[ Requis ]</span></label>
                                        <textarea class="form-control" required name="pack_descp" rows="3"><?php echo (isset($updata["pack_descp"]) && !empty($updata["pack_descp"])) ? $updata["pack_descp"] : "" ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <label class="form-label">Type de produits</label>
                            <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_type" <?php echo (isset($updata["pack_type"]) && !empty($updata["pack_type"]) && $updata["pack_type"] == "Normal") ? "checked" : "" ?> value="Normal" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">Normal</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_type" <?php echo (isset($updata["pack_type"]) && !empty($updata["pack_type"]) && $updata["pack_type"] == "Spécial") ? "checked" : "" ?> value="Spécial" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">Spécial</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_type" <?php echo (isset($updata["pack_type"]) && !empty($updata["pack_type"]) && $updata["pack_type"] == "A batterie") ? "checked" : "" ?> value="A batterie" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <span class="form-selectgroup-check"></span>
                                            </span>
                                            <span class="form-selectgroup-label-content">
                                                <span class="form-selectgroup-title strong mb-1">A batterie</span>
                                                <span class="d-block text-muted"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Net [KG]</label>
                                        <input type="number" step="0.00000000001" class="form-control" placeholder="0" name="pack_netW" value="<?php echo (isset($updata["pack_netW"]) && !empty($updata["pack_netW"])) ? $updata["pack_netW"] : "" ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Volumétrique [CBM]</label>
                                        <input type="number" step="0.00000000001" class="form-control" placeholder="0" name="pack_metricW" value="<?php echo (isset($updata["pack_metricW"]) && !empty($updata["pack_metricW"])) ? $updata["pack_metricW"] : "" ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                                    <input type="button" class="mb-2 btn <?= isset($updata["images"]) ? 'btn-danger' : 'link-warning' ?>" value="<?php
                                                                                                                                                    if (isset($updata["images"]) && !empty($updata["images"])) {
                                                                                                                                                        foreach ($updata["images"] as $key => $value) {
                                                                                                                                                            echo $updata["images"][$key] . ' ';
                                                                                                                                                        }
                                                                                                                                                    } else {
                                                                                                                                                        echo  "AJOUTER DES IMAGES [ MAXIMUM 03 ]";
                                                                                                                                                    }
                                                                                                                                                    ?>" id="importButton" style="width: auto;" onclick="document.getElementById('filesToUpload').click();" />

                                    <?php
                                    if (isset($error["images"]) && !empty($error["images"])) {
                                        //die(var_dump($error["images"]));
                                        foreach ($error["images"] as $key => $value) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["images"][$key] . "</p>";
                                        }
                                    }
                                    ?>
                                    <div style="display: flex;" id="preview"></div>
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