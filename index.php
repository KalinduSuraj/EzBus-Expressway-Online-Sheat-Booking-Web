<?php
session_start(); // Ensure session is started

if (isset($_SESSION['logedUser'])) {
    // Access the logged user data safely
    $user = $_SESSION['logedUser'];
} else {
    // Handle the case where the user is not logged in
    $user = null; // or redirect, or display a message
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>EzBus</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="   https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MDB Bootstrap CSS (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <!-- MDB Bootstrap JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style type="text/css">
        /* body{
        background-color: yellow;
        
        Color of the links BEFORE scroll */

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;

        }

        @font-face {
            font-family: 'LonaBC';
            src: url('fonts/LonaBC-Regular.ttf') format('truetype');
        }


        .navbar-scroll .nav-link,
        .navbar-scroll .navbar-toggler .fa-bars {
            color: #fff;
        }


        .navbar-scroll {
            transition: top 1s ease, background-color 0.5s ease, padding 0.5s ease;
        }

        header.sticky .navbar-scroll .nav-link,
        .navbar-scroll .navbar-toggler .fa-bars {
            color: #fff;
        }

        header.sticky .navbar-scroll {
            background-color: rgba(35, 35, 35, 0.9);
            color: white;
            top: 0;

        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            /* Send it to the back */
        }

        video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            /* Maintain aspect ratio */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .overlay-text {
            position: absolute;
            color: white;
            font-family: 'LonaBC', serif;
            text-align: left;
            z-index: 1;
            opacity: 0;
            animation: fadeInText 3s forwards;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centers text vertically */
            height: 100%;
            /* Full height of video */
        }

        .overlay-text h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .overlay-text p {
            font-size: 1.5rem;
            font-weight: 400;
        }

        /* Text fade-in animation */
        @keyframes fadeInText {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .overlay-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .carousel-caption {
            text-align: left;
        }

        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .carousel-indicators {
            position: relative;
        }

        .custom-indicator {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
        }

        @import url("https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900");

        .body1 {
            margin-top: 30%;

            display: flex;
            align-items: left;
            justify-content: left;
        }

        .body2 {

            margin-left: 26%;
            display: flex;
            align-items: left;
            justify-content: left;
            margin-bottom: 10%;
        }

        .content {
            position: relative;
        }

        .content h2 {
            color: #fff;
            font-size: 8em;
            position: absolute;
            transform: translate(-50%, -50%);
        }

        .content h2:nth-child(1) {
            color: transparent;
            -webkit-text-stroke: 2px #4efed6;
        }

        .content h2:nth-child(2) {
            color: #4efed6;
            animation: animate 4s ease-in-out infinite;
        }

        @keyframes animate {

            0%,
            100% {
                clip-path: polygon(0% 45%,
                        16% 44%,
                        33% 50%,
                        54% 60%,
                        70% 61%,
                        84% 59%,
                        100% 52%,
                        100% 100%,
                        0% 100%);
            }

            50% {
                clip-path: polygon(0% 60%,
                        15% 65%,
                        34% 66%,
                        51% 62%,
                        67% 50%,
                        84% 45%,
                        100% 46%,
                        100% 100%,
                        0% 100%);
            }
        }

        /* Footer */
        .footer {
            background-color: #212529;
            color: #ffffff;
            padding: 20px 0;
        }

        .footer h5 {
            color: #ffffff;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
        }

        .footer a:hover {
            color: #f8f9fa;
            text-decoration: underline;
        }

        .footer ul {
            padding: 0;
            list-style-type: none;
        }

        .footer .list-unstyled li {
            margin-bottom: 10px;
        }

        .footer .bi {
            font-size: 1.5rem;
        }

        @media only screen and (max-width: 768px) {
            .footer {
                text-align: center;
            }

            .footer .row>div {
                margin-bottom: 20px;
            }
        }
    </style>

</head>



<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">


    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <header>
        <!-- Animated navbar-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-scroll" data-mdb-navbar-init>

            <div class="container-fluid">
                <!-- Toggler/collapsing button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01" aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars" style="color:white;"></i>
                    </span>
                </button>


                <!-- Collapsible navbar content -->
                <div class="collapse navbar-collapse align-items-center" id="navbarExample01">
                    <a class="navbar-brand gap-2" href="#">
                        <img src="gallery/logo.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"><b>EzBus</b>
                    </a>
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item ">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="selectroot.php" rel="nofollow">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                    <?php
                    if (!isset($_SESSION['logedUser'])) {
                        // If the user is not logged in, show the Sign In link
                        echo '<a id="btnSignIn" href="signin.php" style="color:white">Sign in</a>';
                    } elseif ($_SESSION['logedUser']['UserType'] === "Passenger") {
                        // If the user is logged in and is a Passenger, greet them
                        echo '<h4 class="gap-5 mt-2">Hi!,' . htmlspecialchars($_SESSION['logedUser']['Name']) . ' 
          <a href="PassengerPanel/PassengerProfile.php" class="gap-3 text-dark"><i class="bi bi-person-circle"></i></a></h4>';
                    } else {
                        // You can handle other user types here, if necessary
                    }
                    ?>

                </div>
            </div>
        </nav>


        <!-- Background video -->
        <div id="intro" class="bg-image" style="
/* background-image: url(gallery/113.jpg); */
height: 100vh;
">
            <div class="mask text-white" style="background-color: rgba(0, 0, 0, 0.1)">
                <div class="container d-flex align-items-center text-center vh-100">
                    <div class="video-background">
                        <video autoplay loop muted>
                            <source src="http://localhost/testweb/GitHub/images/express2.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>

                    <div class="overlay-background"></div>

                    <!-- Text over the video -->
                    <div class="overlay-text body1">
                        <div class="body2" style="margin-left: 0;">
                            <h2>Welcome to</h2>
                        </div>
                        <section>
                            <div class="content body2">
                                <h2>EzBus</h2>
                                <h2>EzBus</h2>

                            </div>
                        </section>

                        <div>

                            <p>Your trusted solution for expressway ticket booking!</p>
                            <h4>Fast, reliable, and easy-to-use platform for all your travel needs.</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Background image -->
    </header>


    </div><!--header-wrap-->

    <section id="billboard">


        <section id="client-holder" data-aos="fade-up">
            <div class="container">
                <div class="row">
                    <div class="inner-content">
                        <div class="logo-wrap">
                            <div class="grid ">
                                <a href="#"><img src="images/client-image1.gif" alt="client"></a>
                                <a href="#"><img src="images/client-image2.gif" alt="client"></a>
                                <a href="#"><img src="images/client-image3.gif" alt="client"></a>
                                <a href="#"><img src="images/client-image4.gif" alt="client"></a>
                                <a href="#"><img src="images/client-image5.gif" alt="client"></a>
                                <a href="#"><img src="images/client-image6.gif" alt="client"></a>
                            </div>
                        </div><!--image-holder-->
                    </div>
                </div>
            </div>
        </section>

        <div>

            <section id="quotation" class="align-center pb-5 mb-5 mt-5">
                <div class="inner-content">
                    <h2 class="section-title divider">Your Journey, Your Way: Book with Ease!</h2>
                    <blockquote data-aos="fade-up">
                        <q>“With EzBus, booking your expressway bus ticket is quick and simple. Enjoy comfortable rides,
                            on-time departures, and great prices. Whether it's a short trip or a regular commute, EzBus
                            makes your journey easy. Book today and travel with ease!”</q>

                    </blockquote>
                </div>
            </section>
        </div>
        <!-- Sign in process with artical -->
        <section id="subscribe">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-md-8">
                        <div class="row">

                            <div class="col-md-6">

                                <div class="title-element">
                                    <h2 class="section-title divider">Seamless Sign-In: Just a Few Clicks Away!</h2>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="subscribe-content" data-aos="fade-up">
                                    <p>Signing in to EzBus is fast and effortless. With just a few simple steps, you’ll
                                        be ready to book your next trip in no time. Enjoy a smooth experience and get
                                        started with ease!</p>
                                    <form id="form">

                                        <button class="btn-subscribe justify-content-center d-flex">
                                            <span>sign in</span>
                                            <i class="icon icon-send"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>



        <section id="latest-blog" class="py-5 my-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="section-header align-center">
                            <div class="title">
                                <span>About us</span>
                            </div>
                            <h2 class="section-title">Explore Our Journey</h2>
                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <article class="column" data-aos="fade-up">

                                    <figure>
                                        <a href="#" class="image-hvr-effect">
                                            <img src="images/post-img1.webp" alt="post" class="post-image">
                                        </a>
                                    </figure>

                                    <div class="post-item">
                                        <div class="meta-date">Mar 30, 2024</div>
                                        <h3><a href="#">Experience the future of travel with EzBus Express—where sleek
                                                design meets vibrant cityscapes for a smooth, modern journey.</a></h3>

                                        <div class="links-element">
                                            <div class="categories">inspiration</div>
                                            <div class="social-links">
                                                <ul>
                                                    <li>
                                                        <a href="#"><i class="icon icon-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-behance-square"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!--links-element-->

                                    </div>
                                </article>

                            </div>
                            <div class="col-md-4">

                                <article class="column" data-aos="fade-up" data-aos-delay="200">
                                    <figure>
                                        <a href="#" class="image-hvr-effect">
                                            <img src="images/post-img2.webp" alt="post" class="post-image">
                                        </a>
                                    </figure>
                                    <div class="post-item">
                                        <div class="meta-date">Mar 29, 2024</div>
                                        <h3><a href="#">Experience the future of travel with EzBus Express—where sleek
                                                design meets vibrant cityscapes for a smooth, modern journey.</a></h3>

                                        <div class="links-element">
                                            <div class="categories">inspiration</div>
                                            <div class="social-links">
                                                <ul>
                                                    <li>
                                                        <a href="#"><i class="icon icon-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-behance-square"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!--links-element-->

                                    </div>
                                </article>

                            </div>
                            <div class="col-md-4">

                                <article class="column" data-aos="fade-up" data-aos-delay="400">
                                    <figure>
                                        <a href="#" class="image-hvr-effect">
                                            <img src="images/post-img3.webp" alt="post" class="post-image">
                                        </a>
                                    </figure>
                                    <div class="post-item">
                                        <div class="meta-date">Feb 27, 2024</div>
                                        <h3><a href="#">Experience the future of travel with EzBus Express—where sleek
                                                design meets vibrant cityscapes for a smooth, modern journey.</a></h3>

                                        <div class="links-element">
                                            <div class="categories">inspiration</div>
                                            <div class="social-links">
                                                <ul>
                                                    <li>
                                                        <a href="#"><i class="icon icon-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-behance-square"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!--links-element-->

                                    </div>
                                </article>

                            </div>

                        </div>

                        <div class="row">

                            <div class="btn-wrap align-center">
                                <a href="#" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">About Us<i class="icon icon-ns-arrow-right"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer bg-dark text-light">
            <div class="container py-4 ">
                <div class="row">
                    <div class="col-12 col-md-4 mb-4">
                        <h5 class="text-uppercase">Follow Us</h5>
                        <ul class="list-unstyled  ">
                            <li class="d-flex align-items-center mb-2">
                                <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i><span class="ms-2">Facebook</span></a>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <a href="#" class="text-light me-2"><i class="bi bi-twitter"></i><span class="ms-2">Twitter</span></a>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i><span class="ms-2">Instagram</span></a>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <a href="#" class="text-light me-2"><i class="bi bi-linkedin"></i><span class="ms-2">Linkedin</span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-4 mb-4">
                        <h5 class="text-uppercase">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-light">Home</a></li>
                            <li><a href="#" class="text-light">Services</a></li>
                            <li><a href="#" class="text-light">Contact Us</a></li>
                            <li><a href="#" class="text-light">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-4 mb-4">
                        <h5 class="text-uppercase">About Us</h5>
                        <p>
                            We are a dedicated team providing secure and reliable web solutions to enhance your online
                            experience. Feel free to explore our services.
                        </p>
                        <ul class="list-unstyled  ">
                            <li class=" mb-2 mt-3">
                                <a href="EzBusLogin.php" class="text-light me-2" id="adminlogin"><i class="bi bi-person-lines-fill"></i><span class="ms-2">Administrator
                                        Login</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center pt-3 border-top">
                    <p class="mb-0">&copy; 2024 Your Company. All rights reserved.</p>
                </div>
            </div>
        </footer>


        <script type="text/javascript">
            window.addEventListener("scroll", function() {
                var header = document.querySelector("header");
                header.classList.toggle("sticky", window.scrollY > 0);
            });

            window._be = window._be || {};
            window.__be = window.__be || {}; // Initialize window.__be if it doesn't exist
            window.__be.id = "66ee25a29e34e600072d928d";

            (function() {
                var be = document.createElement('script');
                be.type = 'text/javascript';
                be.async = true;
                be.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.chatbot.com/widget/plugin.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(be, s);
            })();

            $(document).ready(function() {
                function sendBulkMail() {
                    $.ajax({
                        url: "process.php",
                        type: "POST",
                        data: {
                            action: "bulkMail"
                        },
                        success: function(response) {
                            console.log("Bulk mail sent:", response);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred:", error);
                        }
                    });
                }
                setInterval(function() {
                    sendBulkMail();
                }, 300000);
            });
        </script>


        <script src="js/jquery-1.11.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <script src="js/plugins.js"></script>
        <script src="js/script.js"></script>


</body>

</html>