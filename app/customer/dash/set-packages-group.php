<?php 
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}
include '..'.PROJECT.'app/common/customer/1stpart.php'; 

$error = [];

if (isset($_SESSION["set_pack_group_errors"]) && !empty($_SESSION["set_pack_group_errors"])) {
    $error = $_SESSION["set_pack_group_errors"];
}

?>

<?php
if (isset($_SESSION['success_msg']) && !empty($_SESSION['success_msg'])) {
    $msg = $_SESSION['success_msg'];
?>
    <div class="swalDefaultSuccess" role="alert">
    </div>
<?php
    unset($_SESSION['success_msg']);
}
?>

<?php
if (isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])) {
    $msg = $_SESSION['error_msg'];
?>
    <div class="swalDefaultError" role="alert">
    </div>
<?php
    unset($_SESSION['error_msg']);
}
?>

<form action="
<?php
if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
    echo PROJECT . 'customer/dash-treatment/set-packages-group' . '?theme=light';
} elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
    echo PROJECT . 'customer/dash-treatment/set-packages-group' . '?theme=dark';
} else {
    echo PROJECT . 'customer/dash-treatment/set-packages-group' . '?theme=light';
}
?>
" method="post">
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
                                    $packages_listing = packages_listing_in_selectfield($data[0]['id']);
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
                                <div class="col-6 text-center">
                                    <button type="submit" name="set-pack-grp" value="<?= uniqid() ?>" class="btn text-white ms-auto btn-warning">
                                        Créer le groupe
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

<?php include '..'.PROJECT.'app/common/customer/2ndpart.php';

unset($_SESSION['set_pack_group_errors']);

?>