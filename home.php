<?php
session_start();
include "app/common/functions.php";
//die(var_dump(connected()));

?>


<!DOCTYPE html>
<html lang="fr">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Africa Express Cargo | Accueil</title>
   <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" type="text/css" href="public/css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="public/css/responsive.css">
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="public/css/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" type="text/css" href="public/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
   <!-- owl stylesheets -->
   <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Raleway:400,700,800&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="public/css/owl.carousel.min.css">
   <link rel="stylesheet" href="public/css/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <link rel="shortcut icon" href="public/images/aec_favicon.png" type="image/x-icon">
</head>

<body>
   
   <!-- header section start -->
   <div class="header_section header_bg">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a href="" class="logo"><img src="public/images/aec_lightlogo.png"></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <?php
         if (!connected()) {
         ?>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="">Accueil</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">A propos</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#contact">Contactez-Nous</a>
               </li>
               
               <li class="nav-item d-lg-none">
                  <a class="nav-link" href="customer/login/">Connexion</a>
               </li>
               <li class="nav-item d-lg-none">
                  <a class="nav-link" href="customer/register/">Inscription</a>
               </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
               <div class="login_menu">
                  <ul>
                     <li><a href="customer/login/">Connexion</a></li>
                     <li><a href="customer/register/">Inscription</a></li>
                  </ul>
               </div>
               <div></div>
            </form>
         </div>
         
         <div id="main">
            <span style="font-size:36px;cursor:pointer; color: #fff" onclick="openNav()"><img src="public/images/toggle-icon.png" style="height: 30px;"></span>
         </div>
         <?php
         }
         ?>
         <?php
         if (connected()) {
         ?>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="">Accueil</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">A propos</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#contact">Contactez-Nous</a>
               </li>
               <li class="nav-item d-lg-none">
                  <a class="nav-link" href="<?= $_SESSION['current_url'] ?>"> Page Précédente </a>
               </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
               <div class="login_menu">
                  <ul>
                     <li><a href="<?= $_SESSION['current_url'] ?>"> Page Précédente </a></li>
                  </ul>
               </div>
               <div></div>
            </form>
         </div>
         
         <div id="main">
            <span style="font-size:36px;cursor:pointer; color: #fff" onclick="openNav()"><img src="public/images/toggle-icon.png" style="height: 30px;"></span>
         </div>
         <?php
         }
         ?>
      </nav>
      <!-- banner section start -->
      <div class="banner_section layout_padding">
         <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="row hero-center">
                        <div class="col-md-7 imgs">
                           <div class="image_1"><img src="public/images/aec_img.png"></div>
                        </div>
                        <div class="col-md-5">
                           <h1 class="banner_taital">Achetez depuis la chine</h1>
                           <p class="banner_text">Faites vos achats depuis la chine en toute quiétude</p>
                           <div class="contact_bt mb-5"><a href="#">En savoir plus</a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row hero-center">
                        <div class="col-md-7 imgs">
                           <div class="image_1"><img src="public/images/aec_img2.png"></div>
                        </div>
                        <div class="col-md-5">
                           <h1 class="banner_taital">Recevez vos colis chez vous</h1>
                           <p class="banner_text">Nous importons vos colis jusqu'à vous</p>
                           <div class="contact_bt mb-5"><a href="#">En savoir plus</a></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev carousel-control-btn" href="#main_slider" role="button" data-slide="prev">
               <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next carousel-control-btn" href="#main_slider" role="button" data-slide="next">
               <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
      <!-- banner section end -->
   </div>
   <!-- header section end -->
   <!-- cycle section start -->
   <div class="cycle_section layout_padding">
      <div class="container">
         <h1 class="cycle_taital">Qui sommes-nous ?</h1>
         <p class="cycle_text">Africa Express Cargo, votre partenaire pour importer des produits depuis la Chine. Nous simplifions le processus en fournissant un service client exceptionnel et en prenant en charge tous les aspects de l'importation, de la recherche de produits à la gestion des expéditions et des douanes.</p>
         <div class="cycle_section_2 layout_padding">
            <div class="row">
               <div class="col-md-6">
                  <h1 class="cycles_text">Produits & services</h1>
                  <p class="lorem_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                  <div class="btn_main">
                     <div class="buy_bt"><a href="#">Buy Now</a></div>
                     <h4 class="price_text">Price <span style=" color: #f7c17b">$</span> <span style=" color: #325662">200</span></h4>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="box_main">
                     <div class="image_2"><img src="public/images/aec_img1.png"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="cycle_section_3 layout_padding">
            <div class="row">
               <div class="col-md-6">
                  <div class="box_main_3">
                     <h6 class="number_text_2">02</h6>
                     <div class="image_2"><img src="public/images/aec_img3.png"></div>
                  </div>
               </div>
               <div class="col-md-6">
                  <h1 class="cycles_text">Stylis Cycle</h1>
                  <p class="lorem_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                  <div class="btn_main">
                     <div class="buy_bt"><a href="#">Buy Now</a></div>
                     <h4 class="price_text">Price <span style=" color: #f7c17b">$</span> <span style=" color: #325662">200</span></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="cycle_section_2 layout_padding">
            <div class="row">
               <div class="col-md-6">
                  <div class="box_main_3">
                     <h6 class="number_text_2">03</h6>
                     <div class="image_2"><img src="public/images/img-4.png"></div>
                  </div>
               </div>
               <div class="col-md-6">
                  <h1 class="cycles_text">Mordern <br>Cycle</h1>
                  <p class="lorem_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                  <div class="btn_main">
                     <div class="buy_bt"><a href="#">Buy Now</a></div>
                     <h4 class="price_text">Price <span style=" color: #f7c17b">$</span> <span style=" color: #325662">200</span></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="read_btn_main">
            <div class="read_bt"><a href="#">Read More</a></div>
         </div>
      </div>
   </div>
   <!-- cycle section end -->
   <!-- about section start -->
   <div class="about_section layout_padding">
      <div class="container">
         <h1 class="about_taital">About Our cycle Store</h1>
         <p class="about_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters
         </p>
         <div class="about_main">
            <img src="public/images/img-5.png" class="image_5">
         </div>
         <div class="read_bt_1"><a href="#">Read More</a></div>
      </div>
   </div>
   <!-- about section end -->
   <!-- client section start -->
   <div class="client_section layout_padding">
      <div id="my_slider" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="container">
                  <div class="client_main">
                     <h1 class="client_taital">Says Customers</h1>
                     <div class="client_section_2">
                        <div class="client_left">
                           <div><img src="public/images/client-img.png" class="client_img"></div>
                        </div>
                        <div class="client_right">
                           <div class="quote_icon"><img src="public/images/quote-icon.png"></div>
                           <p class="client_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                           <h3 class="client_name">Channery</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <div class="container">
                  <div class="client_main">
                     <h1 class="client_taital">Says Customers</h1>
                     <div class="client_section_2">
                        <div class="client_left">
                           <div><img src="public/images/client-img.png" class="client_img"></div>
                        </div>
                        <div class="client_right">
                           <div class="quote_icon"><img src="public/images/quote-icon.png"></div>
                           <p class="client_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                           <h3 class="client_name">Channery</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <div class="container">
                  <div class="client_main">
                     <h1 class="client_taital">Says Customers</h1>
                     <div class="client_section_2">
                        <div class="client_left">
                           <div><img src="public/images/client-img.png" class="client_img"></div>
                        </div>
                        <div class="client_right">
                           <div class="quote_icon"><img src="public/images/quote-icon.png"></div>
                           <p class="client_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                           <h3 class="client_name">Channery</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
            <i class="fa fa-angle-left"></i>
         </a>
         <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
            <i class="fa fa-angle-right"></i>
         </a>
      </div>
   </div>
   <!-- client section end -->
   <!-- news section start -->
   <div class="news_section layout_padding">
      <div class="container">
         <h1 class="news_taital">News</h1>
         <p class="news_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using </p>
         <div class="news_section_2 layout_padding">
            <div class="row">
               <div class="col-sm-4">
                  <div class="box_main_1">
                     <div class="zoomout frame"><img src="public/images/img-6.png"></div>
                     <div class="padding_15">
                        <h2 class="speed_text">Speed cycle</h2>
                        <div class="post_text">Post by : Den <span style="float: right;">20-12-2019</span></div>
                        <p class="long_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using </p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="box_main_1">
                     <div class="zoomout frame"><img src="public/images/img-7.png"></div>
                     <div class="padding_15">
                        <h2 class="speed_text">Speed cycle</h2>
                        <div class="post_text">Post by : Den <span style="float: right;">20-12-2019</span></div>
                        <p class="long_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using </p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="box_main_1">
                     <div class="zoomout frame"><img src="public/images/img-8.png"></div>
                     <div class="padding_15">
                        <h2 class="speed_text">Jaump cycle</h2>
                        <div class="post_text">Post by : Den <span style="float: right;">20-12-2019</span></div>
                        <p class="long_text">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- news section end -->
   <!-- contact section start -->
   <div class="contact_section layout_padding" id="contact">
      <div class="container">
         <div class="contact_main">
            <h1 class="request_text">A Call Back</h1>
            <form action="/action_page.php">
               <div class="form-group">
                  <input type="text" class="email-bt" placeholder="Name" name="Name">
               </div>
               <div class="form-group">
                  <input type="text" class="email-bt" placeholder="Email" name="Name">
               </div>
               <div class="form-group">
                  <input type="text" class="email-bt" placeholder="Phone Number" name="Email">
               </div>
               <div class="form-group">
                  <textarea class="massage-bt" placeholder="Message" rows="5" id="comment" name="Massage"></textarea>
               </div>
            </form>
            <div class="send_btn"><a href="#">SEND</a></div>
         </div>
      </div>
   </div>
   <!-- contact section end -->
   <!-- footer section start -->
   <div class="footer_section layout_padding">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-8 col-sm-12 padding_0">
               <div class="map_main">
                  <div class="map-responsive">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15860.465625428425!2d2.4151806!3d6.378972!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102355a7a3430c35%3A0x1c073bcfea7dbd6f!2sAfrica%20Express%20Cargo!5e0!3m2!1sfr!2sbj!4v1679323500509!5m2!1sfr!2sbj" width="600" height="400" style="border:0; width: 100%;" allowfullscreen=""></iframe>   
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-sm-12">
               <div class="call_text"><a href="#"><img src="public/images/map-icon.png"><span class="padding_left_0">Page when looking at its layou</span></a></div>
               <div class="call_text"><a href="#"><img src="public/images/call-icon.png"><span class="padding_left_0">Call Now +01 123467890</span></a></div>
               <div class="call_text"><a href="#"><img src="public/images/mail-icon.png"><span class="padding_left_0">demo@gmail.com</span></a></div>
               <div class="social_icon">
                  <ul>
                     <li><a href="#"><img src="public/images/fb-icon1.png"></a></li>
                     <li><a href="#"><img src="public/images/twitter-icon.png"></a></li>
                     <li><a href="#"><img src="public/images/linkedin-icon.png"></a></li>
                     <li><a href="#"><img src="public/images/instagram-icon.png"></a></li>
                  </ul>
               </div>
               <input type="text" class="email_text" placeholder="Enter Your Email" name="Enter Your Email">
               <div class="subscribe_bt"><a href="#">Subscribe</a></div>
            </div>
         </div>
      </div>
   </div>
   <!-- footer section end -->
   <!-- copyright section start -->
   <div class="copyright_section">
      <div class="container">
         <p class="copyright_text">Copyright &copy; 
            <script>
               document.write(new Date().getFullYear())
            </script>
            Tous droits réservés par<a href=""> Africa Express Cargo </p>
         <p class="copyright_text">By <a href="#">Logic;</a></p>
      </div>
   </div>
   <!-- copyright section end -->
   <!-- Javascript files-->
   <script src="public/js/jquery.min.js"></script>
   <script src="public/js/popper.min.js"></script>
   <script src="public/js/bootstrap.bundle.min.js"></script>
   <script src="public/js/jquery-3.0.0.min.js"></script>
   <script src="public/js/plugin.js"></script>
   <!-- sidebar -->
   <script src="public/js/jquery.mCustomScrollbar.concat.min.js"></script>
   <script src="public/js/custom.js"></script>
   <!-- javascript -->
   <script src="public/js/owl.carousel.js"></script>
   <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   <script>
      function openNav() {
         document.getElementById("mySidenav").style.width = "250px";
         document.getElementById("main").style.marginLeft = "250px";
      }

      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
         document.getElementById("main").style.marginLeft = "0";

      }

      $("#main").click(function() {
         $("#navbarSupportedContent").toggleClass("nav-normal")
      })
   </script>
</body>

</html>