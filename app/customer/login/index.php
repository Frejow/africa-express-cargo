<?php include 'app/common/auth/1stpart.php'; ?>

<body>

    <div class="limiter">

        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form id="login" class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-sign-in"></i>
                        <?php
                        if (!empty($_COOKIE['psp'])) {
                            echo 'Reconnectez-vous';
                            setcookie('psp', '', time() - 3600, '/');
                        } else {
                            echo 'Connexion';
                        }
                        ?>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="text" id="m_ps" name="m_ps" placeholder="Email ou Nom d'Utilisateur">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="password" autocomplete="new-password" id="pass" name="pass" placeholder="Mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="submitButton" type="submit">
                            <span>Me connecter</span>
                            <span class="loader"></span>
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="<?= PROJECT ?>customer/password">
                            Mot de passe
                        </a>
                        <span class="txt1">
                            oublié ?
                        </span>
                    </div>

                    <div class="text-center p-t-10">
                        <a class="txt2" href="<?= PROJECT ?>">
                            <i class="fa fa-long-arrow-left m-r-5" aria-hidden="true"></i>
                            Aller à la page d'accueil
                        </a>
                        |
                        <a class="txt2" href="<?= PROJECT ?>customer/register">
                            Nouveau ? S'inscrire ici
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>