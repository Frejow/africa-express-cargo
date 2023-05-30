<?php include 'app/common/auth/1stpart.php'; ?>


<body>

    <div class="limiter">
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form action="<?= PROJECT ?>agents/password/password" method="post" class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-unlock-alt"></i>
                        Mot de passe oublié
                    </span>

                    <?php

                        $errors = [];

                        if (isset($_SESSION["password_error"]) && !empty($_SESSION["password_error"])) {
                            $error = $_SESSION["password_error"];
                        }

                        $data = [];

                        if (isset($_COOKIE["user_passdata"]) && !empty($_COOKIE["user_passdata"])) {
                            $data = $_COOKIE["user_passdata"];
                        }

                    ?>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="email" name="mail" placeholder="Adresse email" value="<?php echo (isset($data) && !empty($data)) ? $data : "" ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope <?= isset($error["mail"])? 'text-danger' : ''?>" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($error["mail"]) && !empty($error["mail"])) {
                        echo "<p style = 'color:red; font-size:12px;' class='float-right mr-3'>" . $error["mail"] . "</p>";
                    }
                    setcookie('user_passdata', '', time() - 3600, '/');
                    ?>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Soumettre
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

    <?php
    unset($_SESSION["password_error"]); 
    ?>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>