<!doctype html>

<html lang="fr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Erreur 404</title>
    <!-- CSS files -->
    <link href='<?= PROJECT ?>public/css/tabler.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/tabler-vendors.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/css/demo.min.css?202302251230' rel="stylesheet" />
    <link href='<?= PROJECT ?>public/images/aec_favicon.png' type="image/x-icon" rel="shortcut icon">
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
  <body  class=" border-top-wide border-primary d-flex flex-column">
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
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
              Retour
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <script src="./dist/js/tabler.min.js?1674944402" defer></script>
    <script src="./dist/js/demo.min.js?1674944402" defer></script>
  </body>
</html>