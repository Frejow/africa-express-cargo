<?php 
if (connected()) {
    $_SESSION['current_url'] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

include 'app/common/customer/1stpart.php'; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Votre avis compte : Nous sommes impatients de vous lire !
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Votre message</label>
                    <form method="post" action="../app/feedback/feedback.php">
                        <textarea id="tinymce-mytextarea"></textarea>
                        <button type="submit" class="btn btn-ghost-warning mt-2 text-center">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/common/customer/2ndpart.php' ?>
