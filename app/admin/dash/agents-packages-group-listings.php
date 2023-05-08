<?php include 'app/common/admin/1stpart.php' ?>

    <form action="" method="post">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="table-responsive card-body">
                                <table id="example1" class="table text-center mt-2 card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" id="check-all" aria-label="Select all invoices" style="display:none;"></th>
                                            <th class="">N° de suivi</th>
                                            <th>Nom</th>
                                            <th>Statut</th>
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
                                            <td class="">
                                                <span></span>
                                                Groupe de Chaussures
                                            </td>
                                            <td>
                                                <span class="badge bg-success me-1"></span> Livrer Au Client
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
                                                    <a class="link-warning link" href="
                                                    <?php 
                                                    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                        echo PROJECT.'admin/dash/update-agents-packages-group'.'?theme=light';
                                                    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                        echo PROJECT.'admin/dash/update-agents-packages-group'.'?theme=dark';
                                                    } else {
                                                        echo PROJECT.'admin/dash/update-agents-packages-group'.'?theme=light';
                                                    }
                                                    ?>
                                                    ">
                                                        Mettre à jour
                                                    </a>
                                                </span>
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
    </form>

<?php include 'app/common/admin/2ndpart.php' ?>
