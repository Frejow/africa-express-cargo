<?php
//Récupération de l'url de la page
$_SESSION['customer_current_url'] = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$notifications = getNotifications($data['id']);
$activeNotifications = getActiveNotifications($data['id']);

$invoices = getInvoices();

if (!empty($_SESSION['invoice_id'])) {
    foreach ($invoices as $key => $Invoice) {
        if ($Invoice['id'] = $_SESSION['invoice_id']) {
            $invoice = $Invoice;
        }
    }
}

/*
$dom = new DOMDocument();
$dom->loadHTMLFile(__FILE__);

$xpath = new DOMXPath($dom);
$elements = $xpath->query('//span[contains(@class, "notification")]');

if ($elements->length > 0) {
    foreach ($elements as $element) {
        $classAttribute = $element->getAttribute('class');

        $classesToCheck = array('text-danger', 'badge-blink');

        $classList = explode(' ', $classAttribute);
        $classesPresent = array_intersect($classesToCheck, $classList);

        if (!empty($classesPresent)) {
            echo "Les classes suivantes sont présentes : " . implode(', ', $classesPresent);
        } else {
            echo "Aucune des classes spécifiées n'est présente.";
        }
    }
} else {
    echo "Aucun élément avec la classe 'notification' n'a été trouvé.";
}
*/

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php
    if (isset($params[2]) && !empty($params[2])) {
        switch ($params[2]) {
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
            case "packages-listings":
                echo "<title>Mes colis</title>";
                break;
            case "noaddressee-packages-listings":
                echo "<title>Colis sans destinataire</title>";
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
            case "products-type":
                echo "<title>Type de produits</title>";
                break;
            case "shipping-type":
                echo "<title>Type d'envoi</title>";
                break;
            case "invoices":
                echo "<title>Mes Factures</title>";
                break;
            case "generate-invoice":
                echo "<title>Générer facture</title>";
                break;
            case "insight":
                if (!empty($invoice)) {
                    echo '<title>Facture N°' . $invoice['invoices_number'] . '</title>';
                } else {
                    echo "<title>Aperçu</title>";
                }
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
    <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/packstyle.css' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
    <link href='<?= PROJECT ?>public/css/fontawesome-free/css/all.min.css' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/select2/css/select2.css' rel="stylesheet">
    <link href='<?= PROJECT ?>public/select2-bootstrap4-theme/select2-bootstrap4.css' rel="stylesheet">
    <link href='<?= PROJECT ?>public/datatables-bs4/css/dataTables.bootstrap4.css' rel="stylesheet">
    <link href='<?= PROJECT ?>public/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css' rel="stylesheet" type="text/css">
    <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>
    <script src='<?= PROJECT ?>public/js/ajax.js'></script>

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

        .loader-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .loader {
            width: 40px;
            height: 40px;
            border: 6px solid #2b348d;
            border-top-color: #f58337;
            border-radius: 50%;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #preview img {
            max-width: 7rem;
            max-height: 7rem;
            width: auto;
            height: auto;
            border-radius: 4px;
            filter: blur(1.5px);
        }

        #_preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #_preview img {
            margin: 2px;
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
        }

        #previews {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #previews img {
            margin: 2px;
            max-width: 250px;
            max-height: 250px;
            width: auto;
            height: auto;
        }

        #importButton {
            width: 500px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 575px) {
            #importButton {
                width: 150px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .img_container {
                display: flex;
                flex-wrap: wrap;
            }
        }

        #importButton:hover {
            overflow: auto;
        }

        .img_container {
            display: flex;
            flex-wrap: wrap;
        }

        .img_container img {
            width: 100%;
            height: auto;
            margin: 5px;
            max-width: 250px;
            max-height: 250px;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
            }

            header,
            footer {
                display: none;
            }
        }
    </style>
</head>

<body>

    <script src="<?= PROJECT ?>public/js/demo-theme.min.js?202302251230"></script>
    <div class="loader-container" id="loader-wrapper">
        <div class="loader"></div>
    </div>
    <div class="page">
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?= PROJECT ?>">
                        <img src='
                        <?php
                        if ($_SERVER['REQUEST_URI'] === $_SERVER['REDIRECT_URL'] . "?theme=light") {
                            echo PROJECT . "public/images/aec_lightlogo.png";
                        } elseif ($_SERVER['REQUEST_URI'] === $_SERVER['REDIRECT_URL'] . "?theme=dark") {
                            echo PROJECT . "public/images/aec_darklogo.png";
                        }
                        if ($_SERVER['REQUEST_URI'] === $_SERVER['REDIRECT_URL']) {
                            echo PROJECT . "public/images/aec_lightlogo.png";
                        }
                        ?>
                        ' alt="Africa Express Cargo" title="Aller à l'accueil" data-bs-toggle="tooltip" data-bs-placement="top" class="px-0 navbar-brand-image">
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-none d-md-flex me-3">

                    </div>
                    <div class="d-flex d-md-flex">
                        <a href="<?= $_SERVER['REDIRECT_URL'] . "?theme=dark" ?>" class="nav-link px-0 hide-theme-dark" title="Mode sombre" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="<?= $_SERVER['REDIRECT_URL'] . "?theme=light" ?>" class="nav-link px-0 hide-theme-light" title="Mode éclairé" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-auto-close="false" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <span class="<?php echo (!empty($notifications) && !empty($activeNotifications)) ? 'notification text-danger badge-blink' : '' ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                    </svg>
                                </span>
                                <!--<span class="badge bg-red badge-blink"></span>-->
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
                                <div class="card" style="width: 400px;">
                                    <div class="card-header">
                                        <h3 class="card-title">Notifications</h3>
                                    </div>

                                    <div class="list-group scrollable list-group-flush list-group-hoverable">
                                        <?php
                                        if (!empty($notifications)) {
                                            foreach ($notifications as $key => $notification) {

                                        ?>
                                                <div class="list-group-item <?= 'notification' . $notification['id'] ?> <?= $notification['is_active'] == 1 ? 'bg-orange-lt' : '' ?>" data-notification-class="<?= 'notification' . $notification['id'] ?>">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto"><span class="status-dot <?= $notification['is_active'] == 1 ? 'status-dot-animated' : '' ?> bg-secondary d-block"></span></div>
                                                        <div class="col text-truncate">
                                                            <span class="text-body d-block"><?= $notification['type'] . ' [ ' . date("d/m/Y H:i", strtotime($notification['created_at']))  . ' ]' ?></span>
                                                            <div class="d-block text-muted text-truncate mt-n1">
                                                                <?= $notification['message'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <a href="#" class="list-group-item-actions delete-icon" data-notification-id="<?= $notification['id'] ?>" title="Supprimer" data-bs-toggle="tooltip" data-bs-placement="left">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M4 7h16"></path>
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                                    <path d="M10 12l4 4m0 -4l-4 4"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(<?= $data['avatar'] == 'null' ? PROJECT . 'public/images/default-user-profile.jpg' : $data['avatar'] ?>)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?= $data['first_names'] . ' ' . $data['name'] ?></div>
                                <div class="mt-1 small text-muted"><?= '@' . $data['user_name'] ?></div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href='<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/profile') ?>' class="dropdown-item">Mon Compte</a>
                            <a href='<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/feedback') ?>' class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div>
                            <a href='<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/profile-settings') ?>' class="dropdown-item">Paramètres du compte</a>
                            <a href='<?= redirect($_SESSION['theme'], PROJECT . 'customer/logout') ?>' class="dropdown-item">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar navbar-light">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item d-lg-none <?= $params[2] == 'notifications' ? 'active' : '' ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/notifications') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <span class="<?php echo (!empty($notifications) && !empty($activeNotifications)) ? 'notification text-danger badge-blink' : '' ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-title">
                                        Notifications
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item 
                            <?php
                            if ($params[2] == 'packages-listings' || $params[2] == 'set-packages' || $params[2] == 'edit-packages') {
                                echo 'active';
                            }
                            ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/packages-listings') ?>">
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
                                    <span class="nav-link-title">
                                        Mes Colis
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item 
                            <?php
                            if ($params[2] == 'packages-group-listings' || $params[2] == 'set-packages-group' || $params[2] == 'edit-packages-group' || $params[2] == 'add-packages-ingroup') {
                                echo 'active';
                            }
                            ?>
                            ">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/packages-group-listings') ?>">
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
                            <li class="nav-item <?= $params[2] == 'noaddressee-packages-listings' ? 'active' : '' ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/noaddressee-packages-listings') ?>">
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
                            <li class="nav-item <?= $params[2] == 'products-type' ? 'active' : '' ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/products-type') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 4h6v6h-6z"></path>
                                            <path d="M4 14h6v6h-6z"></path>
                                            <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            <path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Types de produits
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?= $params[2] == 'shipping-type' ? 'active' : '' ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/shipping-type') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 14l11 -11"></path>
                                            <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Types d'envoi
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item 
                            <?php
                            if ($params[2] == 'invoices' || $params[2] == 'generate-invoice') {
                                echo 'active';
                            }
                            ?>">
                                <a class="nav-link" href="<?= redirect($_SESSION['theme'], PROJECT . 'customer/dash/invoices') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Mes Factures
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">