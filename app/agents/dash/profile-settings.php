<?php

include 'app/common/agents/1stpart.php';
//die(var_dump($data));
?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Paramètres du compte
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">

                <div class="col d-flex flex-column">
                    <div class="card-body" style="display: flex;flex-direction: column;align-items:center;">
                        <h3 class="mb-2 text-center">
                            Avatar
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                        </h3>

                        <p class="text-muted text-center"> Poids Maximum : 2Mo. Extensions autorisées [ PNG/JPG/JPEG/GIF ]</p>

                        <?php

                        $error = [];

                        if (isset($_SESSION["avatar_error"]) && !empty($_SESSION["avatar_error"])) {
                            $error = $_SESSION["avatar_error"];
                        }

                        $updata = [];

                        if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
                            $updata = json_decode($_SESSION["data"], true);
                        }

                        ?>
                        <div class="row align-items-center">

                            <div id="pBlock1" class="mb-2" style="display: none;">
                                <span id="preview" class="col-auto avatar avatar-xl"></span>
                            </div>

                            <div id="pBlock2" class="col-auto mb-2">
                                <a href="" class="modal-fade" data-bs-toggle="modal" data-bs-target="#previous-image">
                                    <span class="avatar avatar-xl" style='background-image: url("<?= $data['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $data['avatar'] ?>");'></span>
                                </a>
                            </div>

                            <?php
                            if ($data['avatar'] != 'null') {
                            ?>
                                <div class="modal fade" id="previous-image">
                                    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                                        <div class="modal-content">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            <img class="" src="<?= $data['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $data['avatar'] ?>" alt="User profile picture">
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($error["pass_w"]) && !empty($error["pass_w"])) {
                            echo "<p style = 'color:red; font-size:12px;'>" . $error["pass_w"] . "</p>";
                        }
                        ?>
                        <?php
                        if (isset($error["avatar"]) && !empty($error["avatar"])) {
                            echo "<p style = 'color:red; font-size:12px;'>" . $error["avatar"] . "</p>";
                        }
                        ?>

                        <form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/avatar-updating') ?>" class="text-center" method="post" enctype="multipart/form-data">

                            <div class="row">

                                <div id="fileBlock" class="col-md mt-2">

                                    <input type="file" accept=".png,.jpg,.jpeg,.gif" name="fileToUpload" id="fileToUpload" style="display: none;" onchange="updateButtonLabel()">

                                    <input type="button" class="btn link-secondary" style="text-decoration: none; width: auto;" value="Importer image" id="importbutton" onclick="document.getElementById('fileToUpload').click();" />

                                </div>

                                <div id="submissionBlock" class="col-md mt-2 mb-1" style="display: none;">
                                    <a href="#" class="btn link-warning" data-bs-toggle="modal" data-bs-target="#modal-warning1" style="text-decoration: none;">Appliquer</a>
                                </div>

                                <?php
                                if ($data['avatar'] != 'null') {
                                ?>
                                    <div class="col-md mt-2">
                                        <button type="submit" name="avatar_deletion" class="btn link-danger" style="text-decoration: none;">
                                            Supprimer
                                        </button>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>

                            <div class="modal modal-blur fade" id="modal-warning1" data-bs-backdrop='static' tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="modal-status bg-warning"></div>
                                        <div class="modal-body text-center py-4">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 9v2m0 4v.01" />
                                                <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                            </svg>

                                            <div class="text-muted">Entrez votre mot de passe dans le champs suivant et cliquez sur le bouton "S'authentifier".</div>

                                            <input type="password" autocomplete="new-password" class="mt-1 form-control" name="pass_w" placeholder="Entrez votre mot de passe">

                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                            Annuler
                                                        </a></div>
                                                    <div class="col"><button type="submit" name="auth" class="btn btn-warning w-100" data-bs-dismiss="modal">
                                                            S'authentifier
                                                        </button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="col-lg-11" id="div_none" style="display: flex; flex-direction: column;">
                            <h3 class="mt-4 text-center">
                                Mes informations personnelles
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M9 9l1 0"></path>
                                    <path d="M9 13l6 0"></path>
                                    <path d="M9 17l6 0"></path>
                                </svg>
                            </h3>
                            <?php
                            if (isset($_SESSION['personal_error']) && !empty($_SESSION['personal_error'])) {
                            ?>
                                <p class="text-center" style="color: red; font-size : 12px;"><?= $_SESSION['personal_error'] ?></p>
                            <?php
                            }
                            //session_destroy();
                            ?>
                            <div class="row g-3 mt-2">
                                <div class="col-md">
                                    <h3 class="form-label">Nom</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-username" value="<?= $data['name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Prénoms</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-username" value="<?= $data['first_names'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Nom d'Utilisateur</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-username" value="<?= $data['user_name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-md">
                                    <h3 class="form-label">Pays</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-location" value="<?= $data['country'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <h3 class="form-label">Adresse Email</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-mail" value="<?= $data['mail'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Numéro de téléphone</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="text" class="form-control focon" id="input-field-phone" value="<?= $data['phone_number'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-3 text-muted">Cliquez ce bouton pour modifier
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 3l0 12"></path>
                                    <path d="M16 11l-4 4"></path>
                                    <path d="M8 11l4 4"></path>
                                    <path d="M12 20m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                </svg>
                            </p>
                            <div class="row">
                                <div class="col text-center">
                                    <div class="btn link-warning" id="click" style="text-decoration: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <path d="M10 18l5 -5a1.414 1.414 0 0 0 -2 -2l-5 5v2h2z"></path>
                                        </svg>
                                        Modifier mes informations personnelles
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="col-lg-11" action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/personal-informations-updating') ?>" method="post" id="form_appear" style="display: flex; flex-direction: column; display: none;">
                            <h3 class="mt-4 text-center">Mise à jour - Informations Personnelles</h3>
                            <div class="row g-3">
                                <div class="col-md">
                                    <h3 class="form-label">Nom</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control" name="nom" id="input-field-username" value="<?= $data['name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Prénoms</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control" name="prenoms" id="input-field-username" value="<?= $data['first_names'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Nom d'Utilisateur</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control" name="pseudo" id="input-field-username" value="<?= $data['user_name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-md">
                                    <h3 class="form-label">Pays</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" name="pays" id="input-field-location" value="<?= $data['country'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <h3 class="form-label text-muted">Adresse Email
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M10.507 10.498l-1.507 1.502v3h3l1.493 -1.498m2 -2.01l4.89 -4.907a2.1 2.1 0 0 0 -2.97 -2.97l-4.913 4.896"></path>
                                            <path d="M16 5l3 3"></path>
                                            <path d="M3 3l18 18"></path>
                                        </svg>
                                    </h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input disabled type="email" class="form-control focon" name="mail" id="input-field-mail" value="<?= $data['mail'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="form-label">Numéro de téléphone</h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="text" class="form-control focon" name="tel" id="input-field-phone" value="<?= $data['phone_number'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3" style="display:flex; justify-content:center;">
                                <div class="col-auto text-center">
                                    <a href="" class="btn link-danger" id="abort" style="text-decoration: none;">
                                        Annuler
                                    </a>
                                </div>
                                <div class="col-auto text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-warning" class="btn link-warning" id="submit-button-update" style="text-decoration: none;">
                                        Appliquer les changements
                                    </a>
                                </div>
                            </div>

                            <div class="modal modal-blur fade" id="modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="modal-status bg-warning"></div>
                                        <div class="modal-body text-center py-4">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 9v2m0 4v.01" />
                                                <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                            </svg>
                                            <h3>Êtes-vous sûr ?</h3>
                                            <div class="text-muted">Selon les informations que vous changez, vous pourrez être amener à vous reconnecter. Si vous êtes certain de vous, entrez votre mot de passe dans le champs suivant et cliquez sur le bouton "Mettre à jour".</div>

                                            <input type="password" autocomplete="new-password" class="mt-1 form-control" name="pass" placeholder="Entrez votre mot de passe">

                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                            Annuler
                                                        </a></div>
                                                    <div class="col"><button type="submit" class="btn btn-warning w-100" data-bs-dismiss="modal">
                                                            Mettre à jour
                                                        </button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/password-updating') ?>" method="post" style="display: flex;flex-direction: column;align-items:center;">

                            <?php

                            $error = [];

                            if (isset($_SESSION["password_error"]) && !empty($_SESSION["password_error"])) {
                                $error = $_SESSION["password_error"];
                            }

                            $updata = [];

                            if (isset($_SESSION["data"]) && !empty($_SESSION["data"])) {
                                $updata = json_decode($_SESSION["data"], true);
                            }

                            ?>

                            <h3 class="mt-4">
                                Sécurité
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2"></path>
                                    <path d="M4 16v2a2 2 0 0 0 2 2h2"></path>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v2"></path>
                                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2"></path>
                                    <path d="M8 11m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z"></path>
                                    <path d="M10 11v-2a2 2 0 1 1 4 0v2"></path>
                                </svg>
                            </h3>
                            <h3 class="text-center">-> Réinitialisation de Mot de passe</h3>
                            <div class="text-danger bold text-center mt-2">Important ! En changeant votre mot de passe, vous allez être déconnecté. Vous n'aurez qu'à vous reconnecter avec votre nouveau mot de passe.</div>
                            <div class="row g-3 mt-2" id="updatePasswordBlock">
                                <div class="col-md-12">
                                    <h3 class="form-label">
                                        Mot de passe actuel
                                        <a class="password-toggle ml">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                    </h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="password" autocomplete="new-password" required name="passw" id="password" class="form-control" value="<?php echo (isset($updata["passw"]) && !empty($updata["passw"])) ? $updata["passw"] : "" ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($error["passw"]) && !empty($error["passw"])) {
                                        echo "<p style = 'color:red; font-size:12px;'>" . $error["passw"] . "</p>";
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="form-label">
                                        Nouveau mot de passe
                                        <a class="repassword-toggle">
                                            <i class="fa fa-eye-slash"></i>
                                        </a>
                                    </h3>
                                    <div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="password" pattern="^[a-zA-Z0-9]{8,}$" title="Ce champs doit recevoir 08 caractères minimum, les caractères spéciaux étant exclus." required name="newpass" id="repassword" class="form-control" value="<?php echo (isset($updata["newpass"]) && !empty($updata["newpass"])) ? $updata["newpass"] : "" ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($error["newpass"]) && !empty($error["newpass"])) {
                                        echo "<p style = 'color:red; font-size:12px;'>" . $error["newpass"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-auto">
                                    <button id="clicktoUpdate" type="submit" class="btn link-warning">
                                        Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>

                        <h3 class="mt-3">
                            Section Dangereuse
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"></path>
                                <path d="M12 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M12 12l0 2.5"></path>
                            </svg>
                        </h3>

                        <div class="row">

                            <form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/account-deactivation') ?>" method="post">

                                <?php

                                $error = [];

                                if (isset($_SESSION["deactivation_error"]) && !empty($_SESSION["deactivation_error"])) {
                                    $error = $_SESSION["deactivation_error"];
                                }

                                ?>

                                <div class="col-md text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-danger" class="btn btn-ghost-danger">
                                        Désactiver mon compte
                                    </a>
                                    <?php
                                    if (isset($error["pass-w"]) && !empty($error["pass-w"])) {
                                        echo "<p style = 'color:red; font-size:12px;'>" . $error["pass-w"] . "</p>";
                                    }
                                    ?>
                                </div>


                                <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
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

                                                <h3>Êtes-vous sûr ?</h3>

                                                <div class="text-muted">En désactivant votre compte, vous ne pourrez plus y accéder tant qu'il n'est pas réactivé soit par vous même (en procédant à une réinitialisation de votre mot de passe) soit par les responsables de la plateforme à votre demande sur notre support d'aide (<a class="text-warning" href="mailto:contact.support@africa-express-cargo.com">contact.support@africa-express-cargo.com</a>).Entrez votre mot de passe dans le champs suivant et confirmez la désactivation de votre compte.</div>

                                                <input type="password" autocomplete="new-password" class="mt-1 form-control" name="pass-w" placeholder="Entrez votre mot de passe">

                                            </div>
                                            <div class="modal-footer">
                                                <div class="w-100">
                                                    <div class="row">
                                                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                                Annuler
                                                            </a></div>
                                                        <div class="col"><button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                Confirmer
                                                            </button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <form action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/account-deletion') ?>" method="post">

                                <?php

                                $error = [];

                                if (isset($_SESSION["deletion_error"]) && !empty($_SESSION["deletion_error"])) {
                                    $error = $_SESSION["deletion_error"];
                                }

                                ?>
                                <div class="col-md text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-danger1" class="btn btn-ghost-danger">
                                        Supprimer mon compte
                                    </a>
                                    <?php
                                    if (isset($error["pass--w"]) && !empty($error["pass--w"])) {
                                        echo "<p style = 'color:red; font-size:12px;'>" . $error["pass--w"] . "</p>";
                                    }
                                    ?>
                                </div>

                                <div class="modal modal-blur fade" id="modal-danger1" tabindex="-1" role="dialog" aria-hidden="true">
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

                                                <h3>Êtes-vous sûr ?</h3>

                                                <div class="text-muted">Cette action est irréversible. En supprimant votre compte, vous perdez toutes vos informations sur ce compte sans aucune possibilité de vous reconnecter à nouveau à moins de créer un nouveau compte. Entrez votre mot de passe dans le champs suivant et confirmez la suppression de votre compte.</div>

                                                <input type="password" autocomplete="new-password" class="mt-1 form-control" name="pass--w" placeholder="Entrez votre mot de passe">

                                            </div>
                                            <div class="modal-footer">
                                                <div class="w-100">
                                                    <div class="row">
                                                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                                Annuler
                                                            </a></div>
                                                        <div class="col"><button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                Confirmer
                                                            </button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/common/agents/2ndpart.php';

unset(
    $_SESSION['avatar_error'],
    $_SESSION['personal_error'],
    $_SESSION['password_error'],
    $_SESSION['deactivation_error'],
    $_SESSION['deletion_error'],
    $_SESSION['data'],
);

?>