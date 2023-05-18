<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lien expiré</title>
    <!-- CSS files -->
    <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
    <link href='<?= PROJECT ?>public/css/fontawesome-free/css/all.min.css' rel="stylesheet" />
    <script src='<?= PROJECT ?>public/js/jquery/jquery-3.6.3.min.js'></script>
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'>

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

    <form action="<?= PROJECT.'customer/account-validation/link-expiredtreat' ?>" method="post">
        <div class="">
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M10 14a3.5 3.5 0 0 0 4.47 .444m2.025 -1.94c.557 -.556 1.392 -1.39 2.505 -2.504a3.536 3.536 0 0 0 -5 -5l-.5 .5"></path>
                    <path d="M9.548 9.544a3.5 3.5 0 0 0 -.548 .456l-4 4a3.536 3.536 0 0 0 5 5l.5 -.5"></path>
                    <path d="M3 3l18 18"></path>
                    <path d="M3 3l18 18"></path>
                </svg>
                <h3 class="mb-4">Ce lien a expiré</h3>
                <button class="btn btn-primary mb-3 <?= isset($_SESSION['user_id']) ? '' : 'disabled' ?>" name="resend_mail" value="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''?>" type="submit">Renvoyer un nouveau mail de réinitialisation de mot de passe</button>
                <div class="text-muted"><a href="mailto:contact.support@africa-express-cargo.com" target="_blank" >Besoin d'aide ? Contactez-nous ici</a></div>
            </div>
        </div>
    </form>

    <script src="<?= PROJECT ?>public/jquery/jquery.js"></script>
    <script src="<?= PROJECT ?>public/js/tabler.js?202302251230" defer></script>
    <script src="<?= PROJECT ?>public/js/demo.js?202302251230" defer></script>
    <script src='<?= PROJECT ?>public/sweetalert2/sweetalert2.min.js'></script>

    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: true,
                timer: 20000
            });

            if($('.swalDefaultSuccess').length) {
                Toast.fire({
                    icon: 'success',
                    title: '<?= $msg ?>'
                });
            }
            
            if($('.swalDefaultError').length) {
                Toast.fire({
                    icon: 'error',
                    title: '<?= $msg ?>'
                });
            }
        });
    </script>

</body>

</html>