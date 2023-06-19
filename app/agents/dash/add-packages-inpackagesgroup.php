<?php include 'app/common/agents/1stpart.php' ?>

<form action="" method="post">
    <div class="page-header d-print-none">
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="">
                                    <select class="form-select select2bs4" multiple="multiple" data-placeholder="Selectionnez colis" style="width: 100%;">
                                        <option>HT58Y562</option>
                                        <option>SD89T526</option>
                                        <option>RD58K964</option>
                                        <option>DR2136FT</option>
                                        <option>AZ8SD5TH</option>
                                        <option>OP96RF57</option>
                                        <option>SD1024FG</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row d-flex">
                                <div class="col-6 text-center">
                                    <a href="<?= redirect($_SESSION['theme'], PROJECT.'agents/dash/edit-shipping-packages-group') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content; text-decoration:none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                                        </svg>Retour
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <button type="submit" class="btn text-white ms-auto btn-warning">
                                        Terminé
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'app/common/agents/2ndpart.php' ?>