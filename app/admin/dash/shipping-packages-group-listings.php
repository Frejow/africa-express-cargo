<?php include 'app/common/admin/1stpart.php' ?>

    <form action="" method="post">
        <div class="page-header d-print-none">
            <div class="container-xl d-flex" style="justify-content: center;">
                <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                    <div class="col-12 col-lg-auto ms-auto d-print-none">
                        <div class="btn-list justify-content-center" id="">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT.'admin/dash/set-shipping-packages-group') ?>" class="btn d-none text-white d-sm-inline-block btn-warning" data-bs-toggle="" data-bs-target="">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Créer un groupe de colis
                            </a>
                            <a href="<?= redirect($_SESSION['theme'], PROJECT.'admin/dash/set-shipping-packages-group') ?>" class="btn d-sm-none text-white btn-warning" data-bs-toggle="" data-bs-target="">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Groupe de colis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl text-center">
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
                                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" id="check-all" aria-label="Select all invoices" style="display:none;"></th>
                                            <th class="">N° de suivi</th>
                                            <th>Statut</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" value="BN95F621" name="checkbox" aria-label="Select invoice" style="display:none;"></td>
                                            <td>
                                                BN95F621
                                            </td>
                                            <td>
                                                <span class="badge bg-success me-1"></span> Entrepôt Bénin
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-group-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="link-warning link" href="<?= redirect($_SESSION['theme'], PROJECT.'admin/dash/edit-shipping-packages-group') ?>">
                                                        Modifier
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="link-danger link" href="" data-bs-toggle="" data-bs-target="">
                                                        Supprimer
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
    </form>

<?php include 'app/common/admin/2ndpart.php' ?>
