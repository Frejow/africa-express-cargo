<?php include 'app/common/admin/1stpart.php' ?>

<div class="container-xl">
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive card-body">
                    <table id="example1" class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Agents</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2" style="background-image: url(<?= PROJECT ?>public/images/jow-p.jpg)"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">Jow Doe</div>
                                            <div class="text-muted"><a href="#" class="text-reset">jow.doe@outlook.com</a></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Cotonou, Bénin</div>
                                </td>
                                <td class="">
                                    +229 97959896
                                </td>
                                <td>
                                    <a href="#" class="btn-link link-danger">Désactiver</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/common/admin/2ndpart.php' ?>
