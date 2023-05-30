<?php include 'app/common/customer/1stpart.php'; ?>

<div class="page-header d-print-none">
    <div class="container-xl d-flex" style="justify-content: center;">
        <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
            <form action="">
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="ribbon ribbon-top bg-red">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8.812 4.793l3.188 -1.793l8 4.5v8.5m-2.282 1.784l-5.718 3.216l-8 -4.5v-9l2.223 -1.25"></path>
                                <path d="M14.543 10.57l5.457 -3.07"></path>
                                <path d="M12 12v9"></path>
                                <path d="M12 12l-8 -4.5"></path>
                                <path d="M16 5.25l-4.35 2.447m-2.564 1.442l-1.086 .611"></path>
                                <path d="M3 3l18 18"></path>
                            </svg>
                        </div>
                        <div class="">
                            <a href="" data-bs-toggle="modal" data-bs-target="#previous-image"><img src='<?= PROJECT ?>public/images/jow-p.jpg' alt=""></a>
                        </div>
                        <div class="text-center mb-2 mt-2">
                            <a class="btn btn-ghost-red" data-bs-toggle="modal" data-bs-target="#claim-modal">
                                Réclamer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal modal-blur fade" id="claim-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <input type="text" class="form-control" name="example-text-input" placeholder="Entrez le numéro de suivi">
                                <div class="text-center"><button class="btn btn-ghost-warning mt-2" type="submit">Soumettre à la vérification</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="previous-image">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <img class="" src='<?= PROJECT ?>public/images/jow-p.jpg' alt="User profile picture">
        </div>
    </div>
</div>

<?php include 'app/common/customer/2ndpart.php' ?>