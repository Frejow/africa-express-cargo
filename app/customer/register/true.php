<?php

$_SESSION['current_url'] = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

include 'app/common/auth/1stpart.php';

?>

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
        <h3>Super !!! Vous êtes inscrit. Prochaine étape, la confirmation de votre compte.</h3>
        <div class="text-muted">Un email de validation de compte vient d'être envoyé à votre adresse email. Merci de vérifier votre boite de réception ou vos spams et valider votre compte pour continuer. Le lien de validation expire dans 10min à compter de maintenant.</div>
    </div>
</div>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>