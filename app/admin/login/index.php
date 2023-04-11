<?php
session_start();
//die (var_dump(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1]));
//die (var_dump(rawurldecode(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1])));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Africa Express Cargo | Admin</title>
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
            <?php
            /*
            if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) 
            && isset(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1]) 
            && !empty(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1]) 
            && explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[0] = 'success') {
                $msg = rawurldecode(explode('=', explode('?', $_SERVER['REQUEST_URI'])[1])[1]);
                */
            if (isset($_SESSION['success']) && !empty($_SESSION['success'])){
                $msg = $_SESSION['success'];
            ?>
                <div class="swalDefaultSuccess" role="alert">
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($_GET["error"]) && !empty($_GET["error"])) {
            ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= $_GET["error"]; ?>
                </div>
            <?php
            }
            ?>
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form action="<?= PROJECT ?>admin/login/login" method="post" class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-sign-in"></i>
                        Administrateur
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="password" name="pass" placeholder="Mot de passe">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="form-check text-center">
                        <input class="form-check-input" type="checkbox" name="remember_me" value="" id="flexCheckChecked" />
                        <label class="" for="flexCheckChecked" style="font-size: 14px; color: #666;">Se souvenir de moi</label>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Me connecter
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="<?= PROJECT ?>admin/password">
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
                        <a class="txt2" href="<?= PROJECT ?>admin/register">
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
                timer: 3000
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