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

</head>

<body>

    <div class="limiter">
        <div class="container">
            <div class="wrap-login100 col">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src='<?= PROJECT ?>public/images/a_e_c.jpg' alt="">
                </div>

                <form class="login100-form validate-form">
                    <span class="login100-form-title">
                        <i class="fa fa-unlock-alt"></i>
                        Administrateur
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="">
                        <input class="input100" type="text" name="email" placeholder="Adresse email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Récupérer mot de passe
                        </button>
                    </div>

                    <div class="text-center p-t-15">
                        <a class="txt2" href="<?= PROJECT ?>admin/register">
                            S'inscrire
                        </a>
                    </div>

                    <div class="text-center p-t-2">
                        <a class="txt2" href="<?= PROJECT ?>admin/login">
                            Se connecter
                        </a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

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

    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>

</body>

</html>