<?php include 'app/common/agents/1stpart.php' ?>

<form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/set-packages') ?>" method="post" class="mt-3">
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
                                Ajouter
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 ">
                                <label for="selection" class="form-label">Client [ Laissez ce champs tel quel s'il s'agit d'un colis sans destinataire ] </label>
                                <div class="">
                                    <select class="form-select select2bs4" id="selection" onchange="updateBlockVisibility()" name="customerSelect" data-placeholder="Laissez ce champs vide s'il s'agit d'un colis sans destinataire" style="width: 100%;">
                                        <option value="38">Sans destinataire</option>
                                        <?php
                                        $customersListing = customersListing();
                                        if (!empty($customersListing)) {
                                            foreach ($customersListing as $key => $value) {
                                        ?>
                                                <option value="<?= $value['id'] ?>"><?= $value['name'] . ' ' . $value['first_names'] ?></option>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="block1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pack_trackN" class="form-label">Numéro de suivi <span class="text-danger">[ Requis ]</span></label>
                                            <div class="input-group input-group-flat">
                                                <input type="text" id="pack_trackN" class="form-control ps-0" name="pack_trackN" value="" placeholder="XXXXXXXX" autocomplete="off">
                                            </div>
                                            <?php
                                            if (isset($error["pack_trackN"]) && !empty($error["pack_trackN"])) {
                                                echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_trackN"] . "</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pack_count" class="form-label">Nombre <span class="text-danger">[ Requis ]</span></label>
                                            <input type="text" id="pack_count" class="form-control" name="pack_count" value="<?php echo (isset($updata["pack_count"]) && !empty($updata["pack_count"])) ? $updata["pack_count"] : "" ?>" placeholder="Nombre de pièce(s)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="pack_weight" class="form-label">Poids <span class="text-danger">[ Requis ]</span></label>
                                            <input type="text" id="pack_weight" class="form-control" name="pack_weight" value="" placeholder="0">
                                        </div>
                                        <?php
                                        if (isset($error["pack_weight"]) && !empty($error["pack_weight"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_weight"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label" for="unit">Unité de mesure <span class="text-danger">[ Requis ]</span></label>
                                        <div class="mb-3">
                                            <select class="form-select" name="unit" id="unit">
                                                <option value="KG">KILOGRAMME ( KG )</option>
                                                <option value="CBM">METRE CUBE ( CBM )</option>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($error["unit"]) && !empty($error["unit"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["unit"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div>
                                            <label for="pack_descp" class="form-label">Description du colis <span class="text-danger">[ Requis ]</span></label>
                                            <textarea class="form-control" id="pack_descp" name="pack_descp" rows="3"></textarea>
                                        </div>
                                        <?php
                                        if (isset($error["pack_descp"]) && !empty($error["pack_descp"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_descp"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <label class="form-label">Type de produits <span class="text-danger">[ Requis ]</span></label>
                                <div class="form-selectgroup-boxes row mb-3">
                                    <div class="col-lg-4">
                                        <label class="form-selectgroup-item">
                                            <input type="radio" name="pack_type" value="1" class="form-selectgroup-input">
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
                                            <input type="radio" name="pack_type" value="1" class="form-selectgroup-input">
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
                                            <input type="radio" name="pack_type" value="1" class="form-selectgroup-input">
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
                                    <?php
                                    if (isset($error["pack_type"]) && !empty($error["pack_type"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_type"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="pack_shiptype">Type d'Envoi <span class="text-danger">[ Requis ]</span></label>
                                            <select type="text" class="form-select" name="pack_shiptype" id="pack_shiptype" value="">
                                                <option value="Aérien">Aérien</option>
                                                <option value="Maritime">Maritime</option>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($error["pack_shiptype"]) && !empty($error["pack_shiptype"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_shiptype"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="pack_status">Statut <span class="text-danger">[ Requis ]</span></label>
                                            <select type="text" class="form-select" name="pack_status" placeholder="" id="pack_status" value="">
                                                <option value="Entrepôt Bénin">Entrepôt Bénin</option>
                                                <option value="Entrepôt Chine">Entrepôt Chine</option>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($error["pack_status"]) && !empty($error["pack_status"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_status"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="pack_ushipcost">Coût Unitaire d'Expédition [FCFA] <span class="text-danger">[ Requis ]</span></label>
                                            <div class="input-group input-group-flat">
                                                <input type="number" class="number form-control" id="pack_ushipcost" name="pack_ushipcost" value="" placeholder="" autocomplete="off">
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($error["pack_ushipcost"]) && !empty($error["pack_ushipcost"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_ushipcost"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="pack_shipcost">Coût d'Expédition [FCFA] <span class="text-danger">[ Requis ]</span></label>
                                            <input type="number" class="form-control" id="pack_shipcost" name="pack_shipcost" value="" placeholder="" autocomplete="off">
                                        </div>
                                        <?php
                                        if (isset($error["pack_shipcost"]) && !empty($error["pack_shipcost"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["pack_shipcost"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-body text-center">
                                        <h3 class="card-title"></h3>

                                        <p class="text-muted"> Poids Maximum : 2Mo. Extensions autorisées [ PNG/JPG/JPEG/GIF ]</p>

                                        <label for="importButton">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                <path d="M7 9l5 -5l5 5"></path>
                                                <path d="M12 4l0 12"></path>
                                            </svg>
                                        </label>
                                        <input type="file" name="fileToUpload" id="filesToUpload" style="display:none" onchange="updatebuttonLabel()">
                                        <input type="button" class="mb-2 btn <?= isset($updata["images"]) ? 'btn-danger' : 'link-warning' ?>" value="<?= !empty($updata["images"]) ? $value : "IMPORTER UNE IMAGE" ?>" id="importButton" onclick="document.getElementById('filesToUpload').click();" />
                                        <?= !empty($error["images"]) ? "<p style = 'color:red; font-size:13px;'>" . $value . "</p>" : "" ?>
                                        <div style="display: flex;" id="preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none;" id="block2">
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
                                <div class="row">
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
                                        <input type="file" name="filesToUpload[]" id="filesToUpload" style="display:none" multiple onchange="updatebuttonLabel()">
                                        <input type="button" class="mb-2 btn <?= isset($updata["images"]) ? 'btn-danger' : 'link-warning' ?>" value="<?php
                                                                                                                                                        if (!empty($updata["images"])) {
                                                                                                                                                            foreach ($updata["images"] as $key => $value) {
                                                                                                                                                                echo $value . ' ';
                                                                                                                                                            }
                                                                                                                                                        } else {
                                                                                                                                                            echo  "AJOUTER DES IMAGES [ MAXIMUM 03 ]";
                                                                                                                                                        }
                                                                                                                                                        ?>" id="importButton" onclick="document.getElementById('filesToUpload').click();" />

                                        <?php
                                        if (!empty($error["images"])) {
                                            //die(var_dump($error["images"]));
                                            foreach ($error["images"] as $key => $value) {
                                                echo "<p style = 'color:red; font-size:13px;'>" . $value . "</p>";
                                            }
                                        }
                                        ?>
                                        <div style="display: flex;" id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/packages-listings') ?>" class="btn btn-link link-secondary" style="border:none;">
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

<?php include 'app/common/agents/2ndpart.php' ?>