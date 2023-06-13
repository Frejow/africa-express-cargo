<?php

include 'app/common/auth/1stpart.php';

?>

<body class=" border-top-wide border-primary d-flex flex-column">
  <script src="./dist/js/demo-theme.min.js?1674944402"></script>
  <div class="page page-center">
    <div class="container-tight py-4">
      <div class="empty">
        <div class="empty-header">404</div>
        <p class="empty-title">Oops… Vous êtes tombé sur une page d'erreur.</p>
        <p class="empty-subtitle text-muted">
          Nous sommes désolé, mais la ressource à laquelle vous tentez d'accéder est introuvable.
        </p>
        <div class="empty-action">
          <a href="<?= $_SESSION['current_url'] ?>" class="btn btn-primary">
            <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M5 12l14 0" />
              <path d="M5 12l6 6" />
              <path d="M5 12l6 -6" />
            </svg>
            Retour
          </a>
        </div>
      </div>
    </div>
  </div>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>