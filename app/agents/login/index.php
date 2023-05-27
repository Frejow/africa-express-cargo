<?php

$_SESSION['current_url'] = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

include 'app/common/auth/1stpart.php';

?>

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
                        if (isset($_COOKIE['psp']) && !empty($_COOKIE['psp'])) {
                            echo 'Reconnectez-vous avec votre nouveau mot de passe';
                            setcookie('psp', '', time() - 3600, '/');
                        } else {
                            echo 'Agents';
                        }
                        ?>
                    </span>

                    <?php

                    $errors = [];

                    if (isset($_SESSION["login_errors"]) && !empty($_SESSION["login_errors"])) {
                        $errors = $_SESSION["login_errors"];
                    }

                    $data = [];

                    if (isset($_COOKIE["ud"]) && !empty($_COOKIE["ud"])) {
                        $data = json_decode($_COOKIE["ud"], true);
                    }

                    if (isset($_COOKIE["cud"]) && !empty($_COOKIE["cud"])) {
                        $data = json_decode($_COOKIE["cud"], true);
                    }

                    ?>

                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="text" id="m_ps" name="m_ps" placeholder="Adresse email" value="<?php echo (isset($data["m_ps"]) && !empty($data["m_ps"])) ? $data["m_ps"] : "" ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope <?= isset($errors["m_ps"]) ? 'text-danger' : '' ?>" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($errors["m_ps"]) && !empty($errors["m_ps"])) {
                        echo "<p style = 'color:red; font-size:12px;' class='float-right mr-3'>" . $errors["m_ps"] . "</p>";
                    }
                    ?>

                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="password" autocomplete="new-password" id="pass" name="pass" placeholder="Mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock <?= isset($errors["pass"]) ? 'text-danger' : '' ?>" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($errors["pass"]) && !empty($errors["pass"])) {
                        echo "<p style = 'color:red; font-size:12px;' class='float-right mr-3'>" . $errors["pass"] . "</p>";
                    }
                    ?>

                    <div class="form-check text-center">
                        <input class="form-check-input" <?= isset($_COOKIE['cud']) ? 'checked' : '' ?> type="checkbox" name="remember_me" id="flexCheckChecked" />
                        <label class="" for="flexCheckChecked" style="font-size: 14px; color: #666;">Se souvenir de moi</label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Me connecter
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="<?= PROJECT ?>agents/password">
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
                        <a class="txt2" href="<?= PROJECT ?>agents/register">
                            Nouveau ? S'inscrire ici
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    unset($_SESSION["login_errors"]);
    ?>

    <script>
        
    </script>


</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>