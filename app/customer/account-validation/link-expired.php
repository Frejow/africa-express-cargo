<?php

$_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

include 'app/common/auth/1stpart.php';

?>

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
                <button class="btn btn-primary mb-3 <?= isset($_SESSION['user_id']) ? '' : 'disabled' ?>" name="resend_mail" value="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''?>" type="submit">Renvoyer un nouveau mail de validation</button>
                <div class="text-muted"><a href="mailto:contact.support@africa-express-cargo.com" target="_blank" >Besoin d'aide ? Contactez-nous ici</a></div>
            </div>
        </div>
    </form>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>