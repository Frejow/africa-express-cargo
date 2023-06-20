<?php include 'app/common/agents/1stpart.php';

//Initialisation des valeurs par défaut des différents paramètres de la fonction de othListings

//Premier paramètre, le nom de la table en base de données à lister. Table "user" pour le cas présent
$table = "user";

//Second paramètre, le numéro de la page. 1 par défaut
if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page'])) {
    $_SESSION['page'] = 1;
}

//Troisième paramètre, nombre d'agents à afficher par page. 10 par défaut
$_SESSION['rows_per_page'] = 10;

//Quatrième paramètre, la valeur suivant laquelle trier la liste. "Par défaut" par défaut
$_SESSION['order'] = 'Par défaut';

// Cinquième paramètre, le nom de l'agent à rechercher. "UNDEFINED" par défaut dans le cas où aucune recherche n'est lancée
$_SESSION['search'] = 'UNDEFINED';

// Sixième paramètre
$_SESSION['research_by'] = 'name';

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page précédente)
if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
    $_SESSION['page'] = $_SESSION['previous_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page suivante)
if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
    $_SESSION['page'] = $_SESSION['next_page'];
}

//Nouvelle valeur du second paramètre, le numéro de page selon le cas (page actuel)
if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
    $_SESSION['page'] = $_SESSION['actual_page'];
}

/**
 * Nouvelle valeur du troisième paramètre, nombre d'agents par page, lorsqu'un autre nombre autre que 10 est sélectionné 
 * par l'utilisateur poiur afficher le nombre de type de produits par page
 */
if (isset($_SESSION['selected_rows_per_page']) && !empty($_SESSION['selected_rows_per_page'])) {
    $_SESSION['rows_per_page'] = $_SESSION['selected_rows_per_page'];
}

/**
 * Nouvelle valeur du quatrième paramètre, le tri, lorsque l'utilisateur décide de trier la liste selon un 
 * ordre autre que celui par défaut
 */
if (isset($_SESSION['selected_order']) && !empty($_SESSION['selected_order'])) {
    $_SESSION['order'] = $_SESSION['selected_order'];
}

//Nouvelle valeur du cinquième paramètre, le type de produit à rechercher dans la table "user"
if (isset($_SESSION['research']) && !empty($_SESSION['research'])) {
    $_SESSION['search'] = $_SESSION['research'];
}

//die(var_dump($_SESSION['agents_listings']));

//Affectation du retour de la fonction othListings avec les six paramètres suscités à la variable $packages_lisitngs
$agents_listings = othListings($table, $_SESSION['page'], $_SESSION['rows_per_page'], strtoupper($_SESSION['search']), $_SESSION['research_by'], $_SESSION['order'], 'AGENT', $data['id']);

/**
 * Affectation du retour de la fonction countRowsInTable avec pour paramètre la table concernée par le listings à la 
 * variable $rows. Cette fonction retourne le nombre de lignes dans la table avec le champs is_deleted = 0
 */
$rows = countRowsInTable($table, null, null, 'AGENT', $data['id']);

?>

<form id="myForm" action="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash-treatment/agents-listings') ?>" method="post">
    <div class="page-header d-print-none">
        <div class="container-xl d-flex" style="justify-content: center;">
            <div class="row g-2 align-items-center " style="flex-wrap: wrap;">
                <!-- Page title actions -->
                <div class="col-12 col-lg-auto ms-auto d-print-none">
                    <div class="btn-list justify-content-center">
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/new-agent') ?>" class="btn d-none text-white d-sm-inline-block btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Nouvel agent
                        </a>
                        <a href="<?= redirect($_SESSION['theme'], PROJECT . 'agents/dash/new-agent') ?>" class="btn d-sm-none text-white btn-warning">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Agent
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

                            <div class="row">

                                <div class="col-lg-4 col-xs mb-2 text-muted">
                                    Afficher
                                    <div class="mx-2 d-inline-block">
                                        <select class="form-select" name="select" id="mySelect">
                                            <option value="10">10</option>
                                            <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 15) {
                                                        echo 'selected';
                                                    } ?> value="15">15</option>
                                            <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 20) {
                                                        echo 'selected';
                                                    } ?> value="20">20</option>
                                            <option <?php if (isset($_SESSION['selected_rows_per_page']) && $_SESSION['selected_rows_per_page'] == 30) {
                                                        echo 'selected';
                                                    } ?> value="30">30</option>
                                        </select>
                                    </div>
                                    lignes
                                </div>

                                <div class="col-lg-4 col-xs mb-2 text-muted ms-auto" style="display: flex;">
                                    <div>
                                        <span>Rechercher</span>
                                    </div>

                                    <div class="ms-2 d-inline-block">
                                        <input type="text" name="search" class="form-control" value="<?= isset($_SESSION['research']) ? $_SESSION['research'] : '' ?>" placeholder="Nom de l'agent">
                                    </div>
                                    <button type="submit" class="btn-link link-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="col-lg-4 col-xs ms-auto text-muted">
                                    Trier :
                                    <div class="ms-2 d-inline-block">
                                        <select class="form-select" name="orderBy" id="mySelect2">
                                            <option <?php if (isset($_SESSION['selected_order']) && $_SESSION['selected_order'] == 'Par défaut') {
                                                        echo 'selected';
                                                    } ?> data-value="Par défaut">Par défaut</option>
                                            <option <?php if (isset($_SESSION['selected_order']) && $_SESSION['selected_order'] == 'A - Z') {
                                                        echo 'selected';
                                                    } ?> data-value="A - Z">A - Z</option>
                                            <option <?php if (isset($_SESSION['selected_order']) && $_SESSION['selected_order'] == 'Z - A') {
                                                        echo 'selected';
                                                    } ?> data-value="Z - A">Z - A</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                            Bloc d'affichage des types de produits
                        -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead class="text-center">
                                    <tr>
                                        <th class="w-1">#</th>
                                        <th>Agents</th>
                                        <th>Nom d'utilisateur</th>
                                        <th>Numéro de téléphone</th>
                                        <th>Pays</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-orange-lt">
                                    <tr>
                                        <td>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning icon-xs" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M15 4.5l-4 4l-4 1.5l-1.5 1.5l7 7l1.5 -1.5l1.5 -4l4 -4" fill="currentColor"></path>
                                                <path d="M9 15l-4.5 4.5"></path>
                                                <path d="M14.5 4l5.5 5.5"></path>
                                            </svg>
                                        </td>
                                        <td>
                                            <div class=" py-1 align-items-center">
                                                <a href="" class="modal-fade" data-bs-toggle="modal" data-bs-target="#previous-image">
                                                    <span class="avatar me-2" style="background-image: url(<?= $data['avatar'] != 'null' ? $data['avatar'] : PROJECT . 'public/images/default-user-profile.jpg' ?>)"></span>
                                                </a>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?= !empty($data['name']) ? $data['name'] . ' ' . $data['first_names'] : '' ?> <span>( Moi )</span></div>
                                                    <div class="text-muted"><a href="mailto:<?= !empty($data['mail']) ? $data['mail'] : ''  ?>" class="text-reset"><?= !empty($data['mail']) ? $data['mail'] : '' ?></a></div>
                                                </div>
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
                                        </td>
                                        <td>
                                            <?= !empty($data['user_name']) ? $data['user_name'] : '' ?>
                                        </td>
                                        <td>
                                            <?= !empty($data['phone_number']) ? $data['phone_number'] : '' ?>
                                        </td>
                                        <td>
                                            <?= !empty($data['country']) ? $data['country'] : '' ?>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="text-center">
                                    <?php
                                    if (isset($agents_listings) && !empty($agents_listings)) {

                                        $n = 0; //Cette variable stocke le nombre de lignes affiché lorsque la table "product_type" ne contient logiquement pas de type de produit. Donc $n restera 0
                                        $m = 0; //Cette variable stocke le numéro de page en cours d'affichage.
                                        $en = 0; // Cette variable stocke au fur et à mesure le nombre de lignes afficher sous forme de numérotation.

                                        if (isset($_SESSION['next_page']) && !empty($_SESSION['next_page'])) {
                                            $m = $_SESSION['next_page'];
                                        }
                                        if (isset($_SESSION['previous_page']) && !empty($_SESSION['previous_page'])) {
                                            $m = $_SESSION['previous_page'];
                                        }
                                        if (isset($_SESSION['actual_page']) && !empty($_SESSION['actual_page'])) {
                                            $m = $_SESSION['actual_page'];
                                        }

                                        foreach ($agents_listings as $key => $agent) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php

                                                    if ($_SESSION['page'] == 1) {

                                                        $en = $key + 1;

                                                        echo $en;
                                                    } elseif ($_SESSION['page'] == 2) {

                                                        $en = $_SESSION['rows_per_page'] + $key + 1;

                                                        echo $en;
                                                    } elseif ($_SESSION['page'] > 2 && $m > 2) {

                                                        $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;

                                                        echo $en;
                                                    } else {

                                                        $en = ($_SESSION['rows_per_page'] * ($m - 1)) + $key + 1;

                                                        echo $en;
                                                    }

                                                    ?>
                                                </td>
                                                <td>
                                                    <div class=" py-1 align-items-center">
                                                        <a href="" class="modal-fade" data-bs-toggle="modal" data-bs-target="#previous-image<?=$key?>">
                                                            <span class="avatar me-2" style="background-image: url(<?= $agent['avatar'] != 'null' ? $agent['avatar'] : PROJECT . 'public/images/default-user-profile.jpg' ?>)"></span>
                                                        </a>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium"><?= !empty($agent['name']) ? $agent['name'] . ' ' . $agent['first_names'] : '' ?></div>
                                                            <div class="text-muted"><a href="mailto:<?= !empty($agent['mail']) ? $agent['mail'] : ''  ?>" class="text-reset"><?= !empty($agent['mail']) ? $agent['mail'] : '' ?></a></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($agent['avatar'] != 'null') {
                                                    ?>
                                                        <div class="modal fade" id="previous-image<?=$key?>">
                                                            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                                                                <div class="modal-content">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    <img class="" src="<?= $agent['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $agent['avatar'] ?>" alt="User profile picture">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= !empty($agent['user_name']) ? $agent['user_name'] : '' ?>
                                                </td>
                                                <td>
                                                    <?= !empty($agent['phone_number']) ? $agent['phone_number'] : '' ?>
                                                </td>
                                                <td>
                                                    <?= !empty($agent['country']) ? $agent['country'] : '' ?>
                                                </td>
                                                <?php
                                                if ($agent["is_active"] == 0) {
                                                ?>
                                                    <td class="text-end">
                                                        <span class="">
                                                            <button class="btn-link link-primary" type="submit" name="activation">
                                                                Activer
                                                            </button>
                                                        </span>
                                                    </td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        $n = $key + 1;
                                    } else {
                                        $n = 0;
                                        ?>
                                        <tr>Aucun élément trouvé</tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive card-footer d-flex align-items-center">

                            <?php

                            $s = null; //Cette variable stocke la valeur du numéro de la première ligne sur une page

                            if (!isset($_SESSION['previous_page']) && !isset($_SESSION['next_page']) && !isset($_SESSION['actual_page'])) {

                                $s = $_SESSION['page'];

                                if (!isset($agents_listings) || empty($agents_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] == 2) {

                                $s = $_SESSION['rows_per_page'] + 1;

                                if (!isset($agents_listings) || empty($agents_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } elseif ((isset($_SESSION['previous_page']) || isset($_SESSION['next_page']) || isset($_SESSION['actual_page'])) && $_SESSION['page'] > 2) {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($agents_listings) || empty($agents_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            } else {

                                $s = ($_SESSION['rows_per_page'] * ($_SESSION['page'] - 1)) + 1;

                                if (!isset($agents_listings) || empty($agents_listings)) {
                                    $s = 'de ' . $n . ' ligne';
                                }

                            ?>

                                <p class="m-0 text-muted">
                                    Affichage
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        de la ligne
                                    <?php
                                    }
                                    ?>
                                    <span><?= $s ?></span>
                                    <?php if (isset($agents_listings) && !empty($agents_listings)) {
                                    ?>
                                        à la ligne <span><?= $en ?></span>
                                    <?php
                                    }
                                    ?> sur <span><?= $rows['COUNT(*)'] ?></span> ligne(s) au total
                                </p>

                            <?php
                            }

                            ?>

                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item <?= ($_SESSION['page'] == 1) ? "disabled" : "" ?>">
                                    <button type="submit" name="previous" value="<?= $_SESSION['page'] - 1 ?>" class="page-link">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 6l-6 6l6 6" />
                                        </svg>
                                        précédent
                                    </button>
                                </li>
                                <li class="page-item page-link active"><?= $_SESSION['page'] ?></li>
                                <li class="page-item <?php if (!isset($agents_listings) || empty($agents_listings)) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <button type="submit" name="next" value="<?= $_SESSION['page'] + 1 ?>" class="page-link">
                                        suivant <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 6l6 6l-6 6" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include 'app/common/agents/2ndpart.php';

if (isset($_SESSION['next_page']) && $_SESSION['next_page'] == $_SESSION['page']) {
    unset($_SESSION['next_page']);
} elseif (isset($_SESSION['previous_page']) && $_SESSION['previous_page'] == $_SESSION['page']) {
    unset($_SESSION['previous_page']);
} elseif (isset($_SESSION['actual_page']) && $_SESSION['actual_page'] == $_SESSION['page']) {
    unset($_SESSION['actual_page']);
}

unset($_SESSION['research']);
?>