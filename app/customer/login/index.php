<?php

//die (var_dump(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1]));
//die (var_dump(rawurldecode(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1])));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Africa Express Cargo | Connexion</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->
    <link rel="shortcut icon" href="<?= PROJECT ?>public/images/aec_favicon.png" type="image/x-icon">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/vendor/bootstrap/css/bootstrap.min.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/fonts/font-awesome-4.7.0/css/font-awesome.min.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/vendor/animate/animate.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/vendor/css-hamburgers/hamburgers.min.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/vendor/select2/select2.min.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/css/util.css'>
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/css/main.css'>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href='<?= PROJECT ?>public/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'>
</head>

<body>

    <div class="limiter">
        
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form action="<?= PROJECT ?>customer/login/login" method="post" class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-sign-in"></i>
                        <?php
                        if (isset($_COOKIE['psp']) && !empty($_COOKIE['psp'])){
                            echo 'Reconnectez-vous avec votre nouveau mot de passe';
                            setcookie('psp', '', time() - 3600, '/');
                        } else {
                            echo 'Connexion';
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

                    <!--<label for="m_ps" class="ml-3">Email ou Nom d'Utilisateur<span class="text-danger">*</span></label>-->
                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="text" id="m_ps" name="m_ps" placeholder="Adresse email" value="<?php echo (isset($data["m_ps"]) && !empty($data["m_ps"])) ? $data["m_ps"] : "" ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope <?= isset($errors["m_ps"])? 'text-danger' : ''?>" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($errors["m_ps"]) && !empty($errors["m_ps"])) {
                        echo "<p style = 'color:red; font-size:12px;' class='float-right mr-3'>" . $errors["m_ps"] . "</p>";
                    }
                    ?>

                    <!--<label for="pass" class="ml-3">Mot de passe<span class="text-danger">*</span></label>-->
                    <div class="wrap-input100 validate-input" data-validate="Champs requis">
                        <input class="input100" type="password" autocomplete="new-password" id="pass" name="pass" placeholder="Mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock <?= isset($errors["pass"])? 'text-danger' : ''?>" aria-hidden="true"></i>
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
    <?php
    session_destroy();
    ?>
    <!--===============================================================================================-->
    <script src='<?= PROJECT ?>public/vendor/jquery/jquery-3.2.1.min.js'></script>
    <!--===============================================================================================-->
    <script src='<?= PROJECT ?>public/vendor/bootstrap/js/popper.js'></script>
    <script src='<?= PROJECT ?>public/vendor/bootstrap/js/bootstrap.min.js'></script>
    <!--===============================================================================================-->
    <script src='<?= PROJECT ?>public/vendor/select2/select2.min.js'></script>
    <!--===============================================================================================-->
    <script src='<?= PROJECT ?>public/vendor/tilt/tilt.jquery.min.js'></script>
    <!--===============================================================================================-->
    <script src='<?= PROJECT ?>public/js/main.js'></script>
    <script src='<?= PROJECT ?>public/sweetalert2/sweetalert2.min.js'></script>

    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 8000
            });

            if($('.swalDefaultSuccess').length) {
                Toast.fire({
                    icon: 'success',
                    title: '<?= $msg ?>'
                });
            }
            
            if($('.swalDefaultError').length) {
                Toast.fire({
                    icon: 'error',
                    title: '<?= $msg ?>'
                });
            }
        });
    </script>

    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>

</body>

</html>