<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/config/bootstrap.php';

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

/*echo("<!DOCTYPE html>
<html lang='en'>

<head>

    <meta charset='utf-8'>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>

    <title>Willness</title>
    <meta content='' name='description'>
    <meta content='' name='keywords'>

    <!-- Favicons -->
    <link href='assets/img/favicon.png' rel='icon'>
    <link href='assets/img/apple-touch-icon.png' rel=a'pple-touch-icon'>

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>

    <!-- Vendor CSS Files -->

    <link href='assets/vendor/animate.css/animate.min.css') ' rel='stylesheet'>
    <link href='assets/vendor/aos/aos.css' rel='stylesheet'>
    <link href='assets/vendor/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
    <link href='assets/vendor/bootstrap-icons/bootstrap-icons.css' rel='stylesheet'>
    <link href='assets/vendor/boxicons/css/boxicons.min.css' rel='stylesheet'>
    <link href='assets/vendor/remixicon/remixicon.css' rel='stylesheet'>
    <link href='assets/vendor/swiper/swiper-bundle.min.css' rel='stylesheet'>

    <!-- Template Main CSS File -->
     <link href='assets/css/style.css' rel='stylesheet'>


    <!-- =======================================================
    * Template Name: Mentor - v4.1.0
* Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
    * Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<header id='header' class='fixed-top'>
    <div class='container d-flex align-items-center'>

        <h1 class='logo me-auto'><a href='index.html'>Wellness</a></h1>


        <nav id='navbar' class='navbar order-last order-lg-0'>
            <ul>
                <li><a class='active' href=\"visiteur\">Aceuil</a></li>
                 <li><a href='courses.html'>Evennement</a></li>
                   <li><a href='trainers.html'></a></li>
                <li><a href='events.html'>Events</a></li>
                <li><a href='pricing.html'>Pricing</a></li>#}
                <li class='dropdown'><a href='#'><span>Gestion Formations</span> <i class='bi bi-chevron-down'></i></a>
                    <ul>
                        <li class='dropdown'><a href='{{ path('ajoutform') }}'><span>Ajouter Formation</span> <i class='bi bi-chevron-right'></i></a>
                            <ul>
                                <li><a href='{{ path('ajoutcour') }}'>Ajouter Cour</a></li>


                            </ul>
                        <li><a href='{{ path('upf') }}'>Nos formation</a></li>
                        </li>
                    </ul>
                </li>

                <li class='dropdown'><a href='#'><span>Formations</span> <i class='bi bi-chevron-down'></i></a>
                    <ul>
                        <li><a href='{ path('formationc') }}'>Nos Formations</a></li>
                        <li><a href='#'>Mes Formations</a></li>

                        <li class='dropdown'><a href='#'><span>Deep Drop Down</span> <i class='bi bi-chevron-right'></i></a>
                            <ul>
                                <li><a href='{{ path('formationc') }}'>Deep Drop Down 1</a></li>
                                <li><a >Deep Drop Down 2</a></li>
                                <li><a >Deep Drop Down 3</a></li>
                                <li><a >Deep Drop Down 4</a></li>
                                <li><a >Deep Drop Down 5</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href='contact.html'>Contact</a></li>
            </ul>
            <i class='bi bi-list mobile-nav-toggle'></i>
        </nav><!-- .navbar -->

        <a href='courses.html' class='get-started-btn'>Se connecter</a>

    </div>
</header><!-- End Header -->

{% block body %}
<!-- ======= Hero Section ======= -->
<section id='hero' class='d-flex justify-content-center '>

    <div class='container position-relative' data-aos='zoom-in' data-aos-delay='100'>
        <h1>Learning Today,<br>Leading Tomorrow</h1>
        <h2>We are team of talented designers making websites with Bootstrap</h2>
       <a href='courses.html' class='btn-get-started'>Get Started</a>
    </div>

</section><!-- End Hero -->
{% endblock  %}








<!-- Vendor JS Files -->
<script src='assets/vendor/aos/aos.js'></script>
<script src='assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}'></script>
<script src='assets/vendor/php-email-form/validate.js')}}'></script>
<script src='assets/vendor/purecounter/purecounter.js'></script>
<script src='assets/vendor/swiper/swiper-bundle.min.js'></script>

<!-- Template Main JS File -->
<script src='assets/js/main.js'></script>

</body>

</html>")
*/

?>
