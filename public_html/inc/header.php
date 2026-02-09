<?php
require 'inc/db_connect.php';
require 'head-link.php';
$is_home = basename($_SERVER['PHP_SELF']) == 'index.php';
$packageLink = $is_home ? 'index.php#packages' : '/index.php#packages';
$destinationLink = $is_home ? 'index.php#destinations' : '/index.php#destinations';
$ticketLink = $is_home ? 'index.php#tickets' : '/index.php#tickets';
?>

<!-- Header START -->
<header class="navbar-light header-sticky">

    <nav class="navbar navbar-expand-xl">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img class="light-mode-item navbar-brand-item" src="assets/images/logo/TravSavers-Logo.svg" alt="logo">
                <img class="dark-mode-item navbar-brand-item" src="assets/images/logo/TravSavers-Logo-White.svg" alt="logo">
            </a>

            <button class="navbar-toggler ms-auto mx-3 p-0 p-sm-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">
                    <li class="nav-item"> <a class="nav-link active" href="/">Home</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo $destinationLink ?>">Destinations</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo $packageLink ?>">Packages</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?php echo $ticketLink ?>">Tickets</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/blog" target="_blank">Blog</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Contact</a></li>
                    <li>|</li>
                    <li class="nav-item"> <a class="nav-link fw-bold text-info" href="tel:8006562780">+1 (800) 656-2780</a></li>

                </ul>
            </div>

        </div>
    </nav>
</header>
