<?php include 'app/common/agents/1stpart.php' ?>

<form action="" method="post" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="
                                <?php 
                                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                    echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=light';
                                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                    echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=dark';
                                } else {
                                    echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=light';
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
                            <div class="mb-3 d-none">
                                <label class="form-label">Nom du colis</label>
                                <input type="text" class="form-control" name="example-text-input" placeholder="Entrez le nom de votre colis">
                            </div>
                            <label class="form-label">Type de produits</label>
                            <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
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
                                        <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
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
                                        <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
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
                                            <input type="text" class="form-control ps-0" value="" placeholder="XXXXXXXX" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Net [KG]</label>
                                        <input type="number" class="form-control" value="" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Poids Volumétrique [CBM]</label>
                                        <input type="number" class="form-control" value="" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type d'Envoi</label>
                                        <select type="text" class="form-select" placeholder="" id="" value="">
                                            <option disabled value="undefined">----</option>
                                            <option value="Maritime">Maritime</option>
                                            <option value="Aérien">Aérien</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Statut</label>
                                        <select type="text" class="form-select" placeholder="" id="" value="">
                                            <option disabled value="undefined">----</option>
                                            <option value="Livré"><span class="badge bg-success me-1"></span> Livrer Au Client</option>
                                            <option value="Transit"><span class="badge bg-warning me-1"></span> En transit</option>
                                            <option value="Chine"><span class="badge bg-primary me-1"></span> Entrepôt Chine</option>
                                            <option value="Bénin"><span class="badge bg-secondary me-1"></span> Entrepôt Bénin</option>
                                            <option value="Non reçu"><span class="badge bg-danger me-1"></span> Non reçu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Coût Unitaire d'Expédition [FCFA]</label>
                                        <div class="input-group input-group-flat">
                                            <input type="number" class="form-control" value="" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Coût d'Expédition [FCFA]</label>
                                        <input type="number" class="form-control" value="" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div>
                                        <label class="form-label">Description du colis</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="card-body">
                                    <h3 class="card-title"></h3>
                                    <div class="dropzone dz-clickable" id="dropzone-multiple" action="./" autocomplete="off" novalidate="">
                                        <div class="dz-default dz-message"><button class="dz-button" type="button">Téléverser Images</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=dark';
                            } else {
                                echo PROJECT.'agents/dash/noaddressee-packages-listings'.'?theme=light';
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

<?php include 'app/common/agents/2ndpart.php' ?>