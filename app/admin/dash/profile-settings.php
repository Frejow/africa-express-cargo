<?php include '..'.PROJECT.'app/common/admin/1stpart.php' ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Paramètres du compte
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">

                <div class="col d-flex flex-column">
                    <div class="card-body" style="display: flex;flex-direction: column;align-items:center;">
                        <div class="row align-items-center">
                            <a href="" class="modal-fade" data-bs-toggle="modal" data-bs-target="#previous-image">
                                <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url(<?= PROJECT ?>public/images/jow-p.jpg);"></span>
                                </div>
                            </a>
                            <div class="modal fade" id="previous-image">
                                <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <img class="" src="<?= PROJECT ?>public/images/jow-p.jpg" alt="User profile picture">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-auto"><a href="#" class="btn link-warning" style="text-decoration: none;">
                                    Changer Avatar
                                </a></div>
                            <div class="col-auto"><a href="#" class="btn link-danger" style="text-decoration: none;">
                                    Supprimer Avatar
                                </a></div>
                        </div>

                        <form action="" style="display: flex;flex-direction: column;">
                            <h3 class="mt-4 text-center">Informations Personnelles</h3>
                            <div class="row g-3 mt-1">
                                <div class="col-md">
                                    <h3 class="form-label">Nom d'Utilisateur</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" id="input-field-username" value="Jow Doe">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Adresse Physique</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" id="input-field-location" value="Cotonou, Bénin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Adresse Email</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" id="input-field-mail" value="jow.doe@outlook.com">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Numéro de téléphone</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" id="input-field-phone" value="(+229) 97959694">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="row mt-2 text-sm text-muted">Pour mettre à jour toutes ou certaines de vos informations, éditez les champs concernés puis cliquez ensuite sur le bouton "Appliquer les changements"</p>

                            <div class="row mt-3">
                                <div class="col" style="display: none;"><a href="#" class="btn link-warning" id="restore-values-button" style="text-decoration: none;">
                                        Restaurer les valeurs par défaut
                                    </a></div>
                                <div class="col text-center"><button disabled type="submit" class="btn link-warning" id="submit-button-update" style="text-decoration: none;">
                                        Appliquer les changements
                                    </button></div>
                            </div>
                        </form>

                        <form action="" style="display: flex;flex-direction: column;align-items:center;">
                            <h3 class="mt-4">Sécurité</h3>
                            <div class="row g-3 mt-1" style="display: none;" id="updatePasswordBlock">
                                <div class="col-md">
                                    <h3 class="form-label">
                                        Mot de passe actuel
                                        <a class="password-toggle">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                    </h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="password" id="password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">
                                        Nouveau mot de passe   
                                        <a class="repassword-toggle">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                    </h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="password" id="repassword" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-auto"><a id="clicktoChange" class="btn link-warning">
                                        Cliquez ici pour changer de mot de passe
                                    </a></div>
                                <div class="col-auto">
                                    <button" id="clicktoUpdate" style="display: none;" type="submit" class="btn link-warning">
                                        Appliquer les changements
                                        </button>
                                </div>
                            </div>
                        </form>

                        <div class="col-auto text-center mt-4"><a href="#" class="btn btn-ghost-danger">
                                Désactiver mon compte
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '..'.PROJECT.'app/common/admin/2ndpart.php' ?>
