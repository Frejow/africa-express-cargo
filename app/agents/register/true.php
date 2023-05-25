<?php

$_SESSION['current_url'] = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Inscription effectuée</title>
    <!-- CSS files -->
    <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
    <link href='<?= PROJECT ?>public/css/fontawesome-free/css/all.min.css' rel="stylesheet" />
    <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>

<div class="">
    <div class="modal-status bg-success"></div>
    <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
            <path d="M9 12l2 2l4 -4" />
        </svg>
        <h3>Super !!! Vous êtes inscrit. Vous recevrez un mail après examen et validation de votre compte.</h3>
        <div class="text-muted">Si vous ne recevez pas de mail dans l'heure qui suit, <a href="mailto:contact.support@africa-express-cargo.com" target="_blank" >contactez-nous ici</a></div>
    </div>
</div>

    <script src="<?= PROJECT ?>public/jquery/jquery.js"></script>
    <script src="<?= PROJECT ?>public/js/tabler.js?202302251230" defer></script>
    <script src="<?= PROJECT ?>public/js/demo.js?202302251230" defer></script>

</body>

</html>