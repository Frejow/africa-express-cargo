<?php include 'app/common/auth/1stpart.php'; ?>


<body>

    <div class="limiter">
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form id="password" class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-unlock-alt"></i>
                        Mot de passe oublié
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="email" id="mail" name="mail" placeholder="Adresse email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="submitButton" type="submit">
                            Soumettre
                            <span class="loader"></span>
                        </button>
                    </div>

                    <div class="text-center p-t-15">
                        <a class="txt2" href="<?= PROJECT ?>customer/register">
                            S'inscrire
                        </a>
                    </div>

                    <div class="text-center p-t-2">
                        <a class="txt2" href="<?= PROJECT ?>customer/login">
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