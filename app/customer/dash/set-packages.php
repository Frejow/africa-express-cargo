<?php
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}
include '..' . PROJECT . 'app/common/customer/1stpart.php'; ?>

<form action="
<?php
if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
    echo PROJECT . 'customer/dash-treatment/set-packages' . '?theme=light';
} elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
    echo PROJECT . 'customer/dash-treatment/set-packages' . '?theme=dark';
} else {
    echo PROJECT . 'customer/dash-treatment/set-packages' . '?theme=light';
}
?>
" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="
                                <?php
                                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                                    echo PROJECT . 'customer/dash/packages-listings' . '?theme=light';
                                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                                    echo PROJECT . 'customer/dash/packages-listings' . '?theme=dark';
                                } else {
                                    echo PROJECT . 'customer/dash/packages-listings' . '?theme=light';
                                }
                                ?>
                                " class="btn btn-link link-secondary" style="border:none; width:fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                    </svg>Retour
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom du colis</label>
                                        <input type="text" required class="form-control" name="pack_name" placeholder="Entrez le nom de votre colis">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Valeur [FCFA]</label>
                                        <input type="number" required class="form-control" name="pack_cost" placeholder="Coût d'achat">
                                    </div>
                                </div>
                            </div>
                            <label class="form-label">Type de produits</label>
                            <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="pack_type" value="Normal" class="form-selectgroup-input" checked>
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
                                        <input type="radio" name="pack_type" value="Spécial" class="form-selectgroup-input">
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
                                        <input type="radio" name="pack_type" value="A batterie" class="form-selectgroup-input">
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
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro de suivi</label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" required class="form-control ps-0" name="pack_trackN" value="" placeholder="XXXXXXXX" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Net [KG]</label>
                                        <input type="number" class="form-control" name="pack_netW" value="0">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Volumétrique [CBM]</label>
                                        <input type="number" class="form-control" name="pack_metricW" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="form-label">Description du colis</label>
                                        <textarea class="form-control" required name="pack_descp" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card-body text-center">
                                    <h3 class="card-title"></h3>
                                    <label for="importButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                            <path d="M7 9l5 -5l5 5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                    </label>
                                    <input type="file" name="filesToUpload[]" id="filesToUpload" style="display:none" multiple onchange="updatebuttonLabel()">
                                    <input type="button" class="mb-2 btn link-warning" value="AJOUTER DES IMAGES [ MAXIMUM 04 ]" id="importButton" onclick="document.getElementById('filesToUpload').click();" />
                                    <!--<input type="submit" value="Envoyer" name="submit">-->

                                    <div style="display: flex;" id="preview"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="
                            <?php
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
                                echo PROJECT . 'customer/dash/packages-listings' . '?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
                                echo PROJECT . 'customer/dash/packages-listings' . '?theme=dark';
                            } else {
                                echo PROJECT . 'customer/dash/packages-listings' . '?theme=light';
                            }
                            ?>
                            " class="btn btn-link link-secondary" style="border:none;">
                                Annuler
                            </a>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include '..' . PROJECT . 'app/common/customer/2ndpart.php' ?>