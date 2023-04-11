<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Compte validé</title>
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
        <div class="modal-status bg-warning"></div>
        <div class="modal-body text-center py-4">
            <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 12l0 .01"></path>
                <path d="M7 12l10 0"></path>
                <path d="M21 12l0 .01"></path>
            </svg>
            <h3>Un problème est survenu. Les causes probables :</h3>
            <div class="text-muted">1. Il se peut que votre compte soit déjà validé. <a href="<?= PROJECT ?>customer/login" style="color: #FFA73B;">Connectez-vous</a> pour vérifier.</div>
            <div class="text-muted">2. Si ce n'est le cas du point 1, il se peut alors que vous essayez d'accéder à cette ressource de manière détournée. <a href="<?= PROJECT ?>" style="color: #FFA73B;">Retourner à l'accueil.</a> </div>
        </div>
    </div>

    <script src="<?= PROJECT ?>public/jquery/jquery.js"></script>
    <script src="<?= PROJECT ?>public/js/tabler.js?202302251230" defer></script>
    <script src="<?= PROJECT ?>public/js/demo.js?202302251230" defer></script>

</body>

</html>