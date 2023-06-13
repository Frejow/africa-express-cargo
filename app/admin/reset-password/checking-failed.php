<?php include 'app/common/auth/1stpart.php'; ?>

<body>

    <div class="">
        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">
            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 9v2m0 4v.01" />
                <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
            </svg>
            <h3>Echec de la vérification.</h3>
            <div class="text-muted">Ce lien a déjà été utilisé. <a href="<?= PROJECT ?>admin/login" style="color: #FFA73B;">Retour</a> </div>
            <div class="text-muted"><a href="mailto:contact.support@africa-express-cargo.com" target="_blank" style="color: #FFA73B;">Besoin d'aide ? Contactez-nous ici</a></div>
        </div>
    </div>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>