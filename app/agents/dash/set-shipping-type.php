<?php include 'app/common/agents/1stpart.php';

$error = [];

if (isset($_SESSION["set_shiptype_errors"]) && !empty($_SESSION["set_shiptype_errors"])) {
    $error = $_SESSION["set_shiptype_errors"];
}

$updata = [];

if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
    $updata = json_decode($_SESSION["data"], true);
}
//die(var_dump($updata));

?>

<form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/set-shipping-type') ?>" method="post" class="mt-3">
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div>
                                <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/shipping-type') ?>" class="btn btn-link link-secondary" style="border:none; width:fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                                    </svg>Retour
                                </a>
                            </div>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Ajouter
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="mb-3">
                                        <label for="shipping" class="form-label">Type d'envoi <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="shipping" class="form-control ps-1" name="shipping" value="<?= !empty($updata["shipping"]) ? $updata["shipping"] : "" ?>" placeholder="Nom du type d'envoi" autocomplete="off">
                                        </div>
                                        <?php
                                        if (isset($error["shipping"]) && !empty($error["shipping"])) {
                                            echo "<p style = 'color:red; font-size:13px;'>" . $error["shipping"] . "</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="deliv_time" class="form-label">Délai de livraison <span class="text-danger">[ Requis ]</span></label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" id="deliv_time" class="form-control ps-1" name="deliv_time" value="<?= !empty($updata["deliv_time"]) ? $updata["deliv_time"] : "" ?>" placeholder="Délai de livraison" autocomplete="off">
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($error["deliv_time"])) {
                                        echo "<p style = 'color:red; font-size:13px;'>" . $error["deliv_time"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/shipping-type') ?>" class="btn btn-link link-secondary" style="border:none;">
                                Annuler
                            </a>
                            <button type="submit" class="btn text-white ms-auto btn-warning">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'app/common/agents/2ndpart.php';

unset($_SESSION['set_shiptype_errors'], $_SESSION['data']);
?>