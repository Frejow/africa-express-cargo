<?php
//die (var_dump($_SERVER['QUERY_STRING']));
//die (var_dump($_SERVER));
//die (var_dump($params[2]));
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php
    if (isset($params[2]) && !empty($params[2])) {
        switch ($params[2]) {
            case "customers-packages-listings":
                echo "<title>Colis clients</title>";
                break;
            case "update-customers-packages":
                echo "<title>Mettre à jour Colis clients</title>";
                break;
            case "customers-packages-group-listings":
                echo "<title>Groupe de colis clients</title>";
                break;
            case "update-customers-packages-group":
                echo "<title>Mettre à jour Groupe de colis clients</title>";
                break;
            case "agents-packages-group-listings":
                echo "<title>Groupe de colis agents</title>";
                break;
            case "update-agents-packages-group":
                echo "<title>Mettre à jour Groupe de colis agents</title>";
                break;
            case "shipping-packages-group-listings":
                echo "<title>Groupe de colis</title>";
                break;
            case "add-packages-inshipping-packagesgroup":
                echo "<title>Ajouter colis au groupe de colis</title>";
                break;
            case "set-shipping-packages-group":
                echo "<title>Ajouter Groupe de colis</title>";
                break;
            case "edit-shipping-packages-group":
                echo "<title>Modifier Groupe de colis</title>";
                break;
            case "noaddressee-packages-listings":
                echo "<title>Colis sans destinataire</title>";
                break;
            case "set-noaddressee-packages":
                echo "<title>Ajouter Colis sans destinataire</title>";
                break;
            case "edit-noaddressee-packages":
                echo "<title>Modifier Colis sans destinataire</title>";
                break;
            case "profile":
                echo "<title>Mon Compte</title>";
                break;
            case "profile-settings":
                echo "<title>Paramètres du compte</title>";
                break;
            case "feedback":
                echo "<title>Feedback</title>";
                break;
            case "notifications":
                echo "<title>Notifications</title>";
                break;
            case "customers-listings":
                echo "<title>Liste des clients</title>";
                break;
            case "agents-listings":
                echo "<title>Liste des agents</title>";
                break;
            case "packages-listings":
                echo "<title>Mes colis</title>";
                break;
            case "set-packages":
                echo "<title>Ajouter colis</title>";
                break;
            case "edit-packages":
                echo "<title>Modifier colis</title>";
                break;
            case "packages-group-listings":
                echo "<title>Groupe de colis</title>";
                break;
            case "add-packages-ingroup":
                echo "<title>Ajouter colis au groupe de colis</title>";
                break;
            case "set-packages-group":
                echo "<title>Ajouter groupe de colis</title>";
                break;
            case "edit-packages-group":
                echo "<title>Modifier groupe de colis</title>";
                break;
            default:
                echo "<title>Erreur 404</title>";
                break;
        }
    } else {
        echo "<title>Erreur 404</title>";
    }
    ?>
    <!-- CSS files -->
    <link href='<?= PROJECT ?>public/libs/dropzone/dist/dropzone.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-flags.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-payments.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/packstyle.css' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
    <link href='<?= PROJECT ?>public/css/fontawesome-free/css/all.min.css' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/select2/css/select2.css' rel="stylesheet">
    <link href='<?= PROJECT ?>public/select2-bootstrap4-theme/select2-bootstrap4.css' rel="stylesheet">
    <link href='<?= PROJECT ?>public/datatables-bs4/css/dataTables.bootstrap4.css' rel="stylesheet">
    <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .row-check {
            display: none;
        }

        .modal {
            pointer-events: none;
        }

        .modal-dialog {
            pointer-events: initial;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }
    </style>

</head>

<body>

    <script src="<?= PROJECT ?>public/js/demo-theme.min.js?202302251230"></script>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="#">
                        <img src='<?= PROJECT ?>public/images/aec_darklogo.png' width="110" height="32" alt="Tabler" class="navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row d-lg-none">
                    <div class="d-flex d-lg-flex">
                        <a href="<?= $_SERVER['REDIRECT_URL']."?theme=dark"?>" class="nav-link px-0 hide-theme-dark" title="Mode sombre" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="<?= $_SERVER['REDIRECT_URL']."?theme=light"?>" class="nav-link px-0 hide-theme-light" title="Mode éclairé" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red badge-blink"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Notifications</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 1</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Change deprecated html tags to text decoration classes (#29604)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 2</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        justify-content:between ⇒ justify-content:space-between (#29734)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions show">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 3</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Update change-version.js (#29736)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 4</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Regenerate package-lock.json (#29730)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(<?= PROJECT ?>public/images/jow-p.jpg)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Jow Doe</div>
                                <div class="mt-1 small text-muted">Dev</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href='
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/profile'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/profile'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/profile'.'?theme=light';
                            }
                            ?>
                            ' class="dropdown-item">Mon Compte</a>
                            <a href='
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=light';
                            }
                            ?>
                            ' class="dropdown-item">Paramètres du compte</a>
                            <a href="./sign-in.html" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item d-lg-none <?= $params[2] == 'notifications' ? 'active' : '' ?>">
                            <a class="nav-link" href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/notifications'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/notifications'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/notifications'.'?theme=light';
                            }
                            ?>
                            ">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Notifications
                                </span>
                            </a>
                        </li>
                        <li class="nav-item 
                            <?php
                            if ($params[2] == 'noaddressee-packages-listings' || $params[2] == 'set-noaddressee-packages' || $params[2] == 'edit-noaddressee-packages'){
                                echo 'active';
                            }
                            ?>
                            ">
                            <a class="nav-link" href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/noaddressee-packages-listings'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/noaddressee-packages-listings'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/noaddressee-packages-listings'.'?theme=light';
                            }
                            ?>
                            ">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8.812 4.793l3.188 -1.793l8 4.5v8.5m-2.282 1.784l-5.718 3.216l-8 -4.5v-9l2.223 -1.25"></path>
                                        <path d="M14.543 10.57l5.457 -3.07"></path>
                                        <path d="M12 12v9"></path>
                                        <path d="M12 12l-8 -4.5"></path>
                                        <path d="M16 5.25l-4.35 2.447m-2.564 1.442l-1.086 .611"></path>
                                        <path d="M3 3l18 18"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Colis sans destinataire
                                </span>
                            </a>
                        </li>
                        <li class="nav-item 
                            <?php
                            if ($params[2] == 'shipping-packages-group-listings' || $params[2] == 'set-shipping-packages-group' || $params[2] == 'edit-shipping-packages-group' || $params[2] == 'add-packages-inshipping-packagesgroup'){
                                echo 'active';
                            }
                            ?>
                            ">
                            <a class="nav-link" href="
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/shipping-packages-group-listings'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/shipping-packages-group-listings'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/shipping-packages-group-listings'.'?theme=light';
                            }
                            ?>
                            ">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                        <path d="M2 13.5v5.5l5 3"></path>
                                        <path d="M7 16.545l5 -3.03"></path>
                                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                        <path d="M12 19l5 3"></path>
                                        <path d="M17 16.5l5 -3"></path>
                                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path>
                                        <path d="M7 5.03v5.455"></path>
                                        <path d="M12 8l5 -3"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Groupe de colis
                                </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" href="#">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Clients
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <div class="dropend">
                                            <a class="dropdown-item <?= $params[2] == 'customers-listings' ? 'active' : '' ?>" 
                                            href="
                                            <?php 
                                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                echo PROJECT.'admin/dash/customers-listings'.'?theme=light';
                                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                echo PROJECT.'admin/dash/customers-listings'.'?theme=dark';
                                            } else {
                                                echo PROJECT.'admin/dash/customers-listings'.'?theme=light';
                                            }
                                            ?>
                                            ">  
                                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M13 5h8"></path>
                                                        <path d="M13 9h5"></path>
                                                        <path d="M13 15h8"></path>
                                                        <path d="M13 19h5"></path>
                                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                                    </svg>
                                                </span>
                                                Liste Clients
                                            </a>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item 
                                            <?php
                                            if ($params[2] == 'customers-packages-listings' || $params[2] == 'update-customers-packages'){
                                                echo 'active';
                                            }
                                            ?>" 
                                            href="
                                            <?php 
                                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                echo PROJECT.'admin/dash/customers-packages-listings'.'?theme=light';
                                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                echo PROJECT.'admin/dash/customers-packages-listings'.'?theme=dark';
                                            } else {
                                                echo PROJECT.'admin/dash/customers-packages-listings'.'?theme=light';
                                            }
                                            ?>
                                            ">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>
                                                        <path d="M12 12l8 -4.5"></path>
                                                        <path d="M12 12l0 9"></path>
                                                        <path d="M12 12l-8 -4.5"></path>
                                                        <path d="M16 5.25l-8 4.5"></path>
                                                    </svg>
                                                </span>
                                                Liste Colis
                                            </a>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item 
                                            <?php
                                            if ($params[2] == 'customers-packages-group-listings' || $params[2] == 'update-customers-packages-group'){
                                                echo 'active';
                                            }
                                            ?>" 
                                            href="
                                            <?php 
                                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                echo PROJECT.'admin/dash/customers-packages-group-listings'.'?theme=light';
                                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                echo PROJECT.'admin/dash/customers-packages-group-listings'.'?theme=dark';
                                            } else {
                                                echo PROJECT.'admin/dash/customers-packages-group-listings'.'?theme=light';
                                            }
                                            ?>
                                            ">  
                                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                                        <path d="M2 13.5v5.5l5 3"></path>
                                                        <path d="M7 16.545l5 -3.03"></path>
                                                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                                        <path d="M12 19l5 3"></path>
                                                        <path d="M17 16.5l5 -3"></path>
                                                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path>
                                                        <path d="M7 5.03v5.455"></path>
                                                        <path d="M12 8l5 -3"></path>
                                                    </svg>
                                                </span>
                                                Groupe de Colis
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" href="#">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 21v-13l9 -4l9 4v13"></path>
                                        <path d="M13 13h4v8h-10v-6h6"></path>
                                        <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3"></path>
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Agents
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-columns">
                                    <div class="dropdown-menu-column">
                                        <div class="dropend">
                                            <a class="dropdown-item <?= $params[2] == 'agents-listings' ? 'active' : '' ?>" 
                                            href="
                                            <?php 
                                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                echo PROJECT.'admin/dash/agents-listings'.'?theme=light';
                                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                echo PROJECT.'admin/dash/agents-listings'.'?theme=dark';
                                            } else {
                                                echo PROJECT.'admin/dash/agents-listings'.'?theme=light';
                                            }
                                            ?>
                                            ">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M13 5h8"></path>
                                                        <path d="M13 9h5"></path>
                                                        <path d="M13 15h8"></path>
                                                        <path d="M13 19h5"></path>
                                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                                    </svg>
                                                </span>
                                                Liste Agents
                                            </a>
                                        </div>
                                        <div class="dropend">
                                            <a class="dropdown-item 
                                            <?php
                                            if ($params[2] == 'agents-packages-group-listings' || $params[2] == 'update-agents-packages-group'){
                                                echo 'active';
                                            }
                                            ?>" 
                                            href="
                                            <?php 
                                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                                echo PROJECT.'admin/dash/agents-packages-group-listings'.'?theme=light';
                                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                                echo PROJECT.'admin/dash/agents-packages-group-listings'.'?theme=dark';
                                            } else {
                                                echo PROJECT.'admin/dash/agents-packages-group-listings'.'?theme=light';
                                            }
                                            ?>
                                            ">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                                        <path d="M2 13.5v5.5l5 3"></path>
                                                        <path d="M7 16.545l5 -3.03"></path>
                                                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                                        <path d="M12 19l5 3"></path>
                                                        <path d="M17 16.5l5 -3"></path>
                                                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path>
                                                        <path d="M7 5.03v5.455"></path>
                                                        <path d="M12 8l5 -3"></path>
                                                    </svg>
                                                </span>
                                                Groupe de Colis
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
            <div class="container-xl justify-content-end">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">
                        <a href="<?= $_SERVER['REDIRECT_URL']."?theme=dark"?>" class="nav-link px-0 hide-theme-dark" title="Mode sombre" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="<?= $_SERVER['REDIRECT_URL']."?theme=light"?>" class="nav-link px-0 hide-theme-light" title="Mode éclairé" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red badge-blink"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Notifications</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 1</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Change deprecated html tags to text decoration classes (#29604)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 2</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        justify-content:between ⇒ justify-content:space-between (#29734)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions show">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 3</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Update change-version.js (#29736)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 4</a>
                                                    <div class="d-block text-muted text-truncate mt-n1">
                                                        Regenerate package-lock.json (#29730)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(<?= PROJECT ?>public/images/jow-p.jpg)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Jow Doe</div>
                                <div class="mt-1 small text-muted">Dev</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href='
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/profile'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/profile'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/profile'.'?theme=light';
                            }
                            ?>
                            ' class="dropdown-item">Mon Compte</a>
                            <a href='
                            <?php 
                            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light"){
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=light';
                            } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark"){
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=dark';
                            } else {
                                echo PROJECT.'admin/dash/profile-settings'.'?theme=light';
                            }
                            ?>
                            ' class="dropdown-item">Paramètres du compte</a>
                            <a href="./sign-in.html" class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <div class="page-body">