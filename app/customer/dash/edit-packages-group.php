<?php 
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}
include '..'.PROJECT.'app/common/customer/1stpart.php'; ?>

<form action="" method="post">
    <div class="page-header d-print-none">
    </div>
    <div class="page-body">
        <div class="container-xl text-center">
            <p id="instruction" class="text-muted text-sm">Ajout : Cliquer sur le bouton "Ajouter"</p>
            <p id="instruction" class="text-muted text-sm">Retrait : Cocher les cases des colis à retirer puis cliquer ensuite sur le bouton "Retirer"</p>
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    Afficher
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="5" size="3" aria-label="Invoices count">
                                    </div>
                                    lignes
                                </div>
                                <div class="ms-auto text-muted">
                                    <div class=" d-inline-block">
                                        Groupe de colis [N° de suivi]
                                    </div>
                                </div>
                                <div class="ms-auto text-muted">
                                    Rechercher :
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" id="check-all" aria-label="Select all invoices"></th>
                                        <th class="">N° de suivi</th>
                                        <th>Type de produits</th>
                                        <th>Statut</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox" value="BN95F621" name="checkbox" aria-label="Select invoice"></td>
                                        <td>
                                            BN95F621
                                        </td>
                                        <td class="">
                                            <span></span>
                                            A batterie
                                        </td>
                                        <td>
                                            <span class="badge bg-success me-1"></span> Livrer Au Client
                                        </td>
                                        <td class="text-end">
                                            <span class="">
                                                <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-detail">
                                                    Détails
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted">Affichage <span>1</span> à <span>5</span> sur <span>20</span> lignes</p>
                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 6l-6 6l6 6" />
                                        </svg>
                                        précédent
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        suivant <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 6l6 6l-6 6" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl d-flex" style="justify-content: center;">
        <div class="row">
            <!-- Page title actions -->
            <div class="btn-list justify-content-center col-4 col-lg-4">
                <a href="
                <?php 
                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                    echo PROJECT.'customer/dash/packages-group-listings'.'?theme=light';
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                    echo PROJECT.'customer/dash/packages-group-listings'.'?theme=dark';
                } else {
                    echo PROJECT.'customer/dash/packages-group-listings'.'?theme=light';
                }
                ?>
                " class="btn btn-link link-secondary" style="border:none; width:fit-content; text-decoration:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                    </svg>Retour
                </a>
            </div>
            <div class="btn-list justify-content-center col-4 col-lg-4">
                <button class="link-danger btn btn-link d-none d-sm-inline-block" style="border:none; text-decoration:none;">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    Retirer
                </button>
                <button class="link-danger btn btn-link d-sm-none" style="border:none; text-decoration:none;">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    Retirer
                </button>
            </div>
            <div class="btn-list justify-content-center col-4 col-lg-4">
                <a href="
                <?php 
                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=light';
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=dark';
                } else {
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=light';
                }
                ?>
                " class="link-warning btn btn-link d-none d-sm-inline-block" style="border:none; text-decoration:none;">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    Ajouter
                </a>
                <a href="
                <?php 
                if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=light';
                } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=dark';
                } else {
                    echo PROJECT.'customer/dash/add-packages-ingroup'.'?theme=light';
                }
                ?>
                " class="link-warning btn btn-link d-sm-none" style="border:none; text-decoration:none;">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    Ajouter
                </a>
            </div>
        </div>
    </div>
</form>

<?php include '..'.PROJECT.'app/common/customer/2ndpart.php' ?>