<?php include 'app/common/customer/1stpart.php'; ?>

<form action="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash-treatment/edit-packages-group') ?>" method="post">
    <div class="page-header d-print-none">
        <div class="container-xl d-flex" style="justify-content: center;">
            <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                <!-- Page title actions -->
                <div class="col-12 col-lg-auto ms-auto d-print-none">
                    <div class="btn-list justify-content-center">
                        <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/add-packages-ingroup') ?>" class="btn d-none text-white d-sm-inline-block btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Ajouter de nouveau colis au groupe
                        </a>
                        <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/add-packages-ingroup') ?>" class="btn d-sm-none text-white btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Ajouter colis
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
                            <div class="d-flex justify-content-center">
                                <div class="">
                                    <h3 class="d-inline-block">
                                        Groupe N° <?= $_SESSION['packages_group_tracking_number'] ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">#<input class="form-check-input m-0 align-middle row-check" type="checkbox" id="check-all" aria-label="Select all invoices"></th>
                                        <th class="">N° de suivi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $packages_ingrouplistings = getAllPackagesLinkedToSpecificPackagesGroup($_SESSION['packages_group_id']);

                                    if (isset($packages_ingrouplistings) && !empty($packages_ingrouplistings)) {

                                        foreach ($packages_ingrouplistings as $key => $packages_ingroup) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <?= $key + 1 ?>
                                                </td>
                                                <td>
                                                    <?= $packages_ingrouplistings[$key]["tracking_number"] ?>
                                                </td>
                                                <td class="">
                                                    <span class="">
                                                        <a class="btn-link link-danger" href="#" data-bs-toggle="modal" data-bs-target="<?= "#withdraw_packageModal" . $key ?>">
                                                            Retirer
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <div class="modal modal-blur fade" id="<?= "withdraw_packageModal" . $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <div class="modal-status bg-danger"></div>
                                                        <div class="modal-body text-center py-4">
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 9v2m0 4v.01" />
                                                                <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                                            </svg>

                                                            <h3>Cette action est irréversible. Êtes-vous sûr(e) ?</h3>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="w-100">
                                                                <div class="row">
                                                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                                            Annuler
                                                                        </a></div>
                                                                    <div class="col"><button type="submit" name="withdraw_package_ingroup" value="<?= $packages_ingrouplistings[$key]["tracking_number"] . '&' . $packages_ingrouplistings[$key]["customer_package_group_id"] ?>" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                            Confirmer
                                                                        </button></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php

                                        }
                                    } else {
                                        ?>
                                        <tr>Groupe vide. Veuillez ajouter des colis pour conserver le groupe.</tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="container-xl d-flex" style="justify-content: center;">
        <div class="row">

            <div class="btn-list justify-content-center col-4 col-lg-4">
                <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content; text-decoration:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                    </svg>Retour
                </a>
            </div>

        </div>
    </div>
 -->
    <div class="container-xl d-flex" style="justify-content: space-around; flex-wrap :wrap;">

        <div class="btn-list mb-1">
            <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/packages-group-listings') ?>" class=" text-center btn link-danger" style="border:none; width:fit-content; text-decoration:none;">
                <- Liste Groupe de colis </a>
        </div>

        <div class="btn-list mt-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#withdraw_allpackageModal" class=" text-center btn btn-danger" style="border:none; width:fit-content; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 7l16 0"></path>
                    <path d="M10 11l0 6"></path>
                    <path d="M14 11l0 6"></path>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                </svg>
                Vider tout le groupe
            </a>
        </div>

        <div class="modal modal-blur fade" id="withdraw_allpackageModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center py-4">
                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v2m0 4v.01" />
                            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                        </svg>

                        <h3>Cette action est irréversible. Êtes-vous sûr(e) ?</h3>

                        <div class="text-muted">Si vous retirez tous les colis du groupe sans en ajouter de nouveau(x), le groupe vide sera supprimé de la liste des groupes de colis.</div>

                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                        Annuler
                                    </a></div>
                                <div class="col"><button type="submit" name="withdraw_allpackages_ingroup" value="<?= $_SESSION['packages_group_id'] ?>" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                        Confirmer
                                    </button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'app/common/customer/2ndpart.php' ?>