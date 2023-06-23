<?php 
include 'app/common/customer/1stpart.php'; 

$error = [];

if (isset($_SESSION["add_pack_ingroup_errors"]) && !empty($_SESSION["add_pack_ingroup_errors"])) {
    $error = $_SESSION["add_pack_ingroup_errors"];
}

?>

<form action="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash-treatment/add-packages-ingroup') ?>" method="post">
    <div class="page-header d-print-none">
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!--
                            <div class="mb-3">
                                <label class="form-label">Numéro de Suivi</label>
                                <input type="text" readonly class="form-control" value="<?= uniqid() ?>" name="" placeholder="">
                            </div>
                            -->
                            <div class="mb-3">
                                <div class="">
                                    <select class="form-select select2bs4" multiple="multiple" required name="packSelect[]" data-placeholder="Selectionnez colis" style="width: 100%;">
                                    <?php
                                    $packages_listing = selectFieldListing('package', $data['id']);
                                    if (isset($packages_listing) && !empty($packages_listing)) {
                                        foreach ($packages_listing as $key => $value) {
                                    ?>
                                        <option value="<?= $packages_listing[$key]['tracking_number'] ?>"><?= $packages_listing[$key]['tracking_number'] ?></option>

                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if (isset($error["packselect"]) && !empty($error["packselect"])) {
                                echo "<p style = 'color:red; font-size:13px;'>" . $error["packselect"] . "</p>";
                            }
                            ?>
                            <div class="mb-3 row d-flex">
                                <div class="col-6 text-center">
                                    <a href="<?= redirect($_SESSION['theme'], PROJECT.'customer/dash/edit-packages-group') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content; text-decoration:none;">
                                        Annuler
                                    </a>
                                </div>
                                <div class="col-6 text-center">
                                    <button type="submit" name="add-pack-ingrp" value="<?= $_SESSION['packages_group_id'] ?>" class="btn text-white ms-auto btn-warning">
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

<?php include 'app/common/customer/2ndpart.php';

unset($_SESSION['add_pack_ingroup_errors']);

?>