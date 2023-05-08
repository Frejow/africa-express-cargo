<?php include 'app/common/admin/1stpart.php' ?>

    <form action="" method="post">
        <div class="page-header">
            <div class="container-xl d-flex" style="justify-content: center;">
                <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                    <!-- Page title actions -->
                    <div class="col-12 col-lg-auto ms-auto d-print-none">
                        <div class="btn-list justify-content-center">
                            <a href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=light';
                            }
                            ?>
                            " class="btn d-none text-white d-sm-inline-block btn-warning">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Nouveau colis
                            </a>
                            <a href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/set-noaddressee-packages'.'?theme=light';
                            }
                            ?>
                            " class="btn d-sm-none text-white btn-warning">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Nouveau Colis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl text-center">
                <p id="instruction" class="text-muted" style="display: none;">( Cocher les cases des colis devant constituer le groupe de colis puis cliquer ensuite sur le bouton "Ajouter au Groupe" )</p>
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
                                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" id="check-all" aria-label="Select all invoices"></th>
                                            <th class="">N° de suivi</th>
                                            <th>Type de produits</th>
                                            <th>Statut</th>
                                            <th></th>
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
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link link-warning" href="
                                                    <?php 
                                                    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                        echo PROJECT.'admin/dash/edit-noaddressee-packages'.'?theme=light';
                                                    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                        echo PROJECT.'admin/dash/edit-noaddressee-packages'.'?theme=dark';
                                                    } else {
                                                        echo PROJECT.'admin/dash/edit-noaddressee-packages'.'?theme=light';
                                                    }
                                                    ?>
                                                    ">
                                                        Modifier
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" name="checkbox1" value="FX956J21" type="checkbox" aria-label="Select invoice"></td>
                                            <td>
                                                FX956J21
                                            </td>
                                            <td>
                                                <span class=""></span>
                                                Mixte
                                            </td>
                                            <td>
                                                <span class="badge bg-warning me-1"></span> En transit
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link link-warning" href="" data-bs-toggle="modal" data-bs-target="">
                                                        Modifier
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" name="checkbox2" value="YT95V621" type="checkbox" aria-label="Select invoice"></td>
                                            <td>
                                                YT95V621
                                            </td>
                                            <td>
                                                <span class=""></span>
                                                Normal
                                            </td>
                                            <td>
                                                <span class="badge bg-primary me-1"></span> Entrepôt Chine
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link link-warning" href="" data-bs-toggle="modal" data-bs-target="">
                                                        Modifier
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" name="checkbox3" value="ML95F421" type="checkbox" aria-label="Select invoice"></td>
                                            <td>
                                                ML95F421
                                            </td>
                                            <td>
                                                <span class=""></span>
                                                Normal
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary me-1"></span> Entrepôt Bénin
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link link-warning" href="" data-bs-toggle="modal" data-bs-target="">
                                                        Modifier
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" name="checkbox4" value="KR95Y621" type="checkbox" aria-label="Select invoice"></td>
                                            <td>
                                                KR95Y621
                                            </td>
                                            <td>
                                                <span class=""></span>
                                                A batterie
                                            </td>
                                            <td>
                                                <span class="badge bg-danger me-1"></span> Non reçu
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link" href="" data-bs-toggle="modal" data-bs-target="#modal-packages-detail">
                                                        Détails
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="">
                                                    <a class="btn-link link-warning" href="" data-bs-toggle="modal" data-bs-target="">
                                                        Modifier
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
