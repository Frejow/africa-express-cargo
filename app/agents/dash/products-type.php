<?php include 'app/common/agents/1stpart.php' ?>

<div class="page-header d-print-none">
    <div class="container-xl d-flex" style="justify-content: center;">
        <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
            <!-- Page title actions -->
            <div class="col-12 col-lg-auto ms-auto d-print-none">
                <div class="btn-list justify-content-center">
                    <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-products-type') ?>" class="btn d-none text-white d-sm-inline-block btn-warning">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Nouveau type
                    </a>
                    <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/set-products-type') ?>" class="btn d-sm-none text-white btn-warning">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Nouveau
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex justify-content-center">
                            <div class="">
                                Rechercher :
                                <div class="ms-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Type de produits</th>
                                    <th>Tarif / kg</th>
                                    <th>Tarif / cbm</th>
                                    <th>Tarif / pcs</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/common/agents/2ndpart.php' ?>