<?php include 'app/common/auth/1stpart.php'; ?>

<body>

    <div class="limiter">
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form id="resetPassword" class="login100-form validate-form">

                    <label for="pass" class="ml-3">Nouveau mot de passe<span class="text-danger">*</span></label>
                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="password" id="pass" name="pass" placeholder="Entrez un nouveau mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <label for="repass" class="ml-3">Confirmer mot de passe<span class="text-danger">*</span></label>
                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="password" id="repass" name="repass" placeholder="Répéter le précédent mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="submitButton" type="submit">
                            Réinitialiser
                            <span class="loader"></span>
                        </button>
                    </div>

                    <div class="text-center p-t-15">
                        <a class="txt2" href="<?= PROJECT ?>agents/register">
                            S'inscrire
                        </a>
                    </div>

                    <div class="text-center p-t-2">
                        <a class="txt2" href="<?= PROJECT ?>agents/login">
                            Se connecter
                        </a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>