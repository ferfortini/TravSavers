<?php
include('../inc/db_connect.php');
include('head-link.php');
include 'includes/sidebar.php';
?>

<main>
    <div class="page-content">

        <!-- Top bar START -->
        <nav class="navbar top-bar navbar-light py-0 py-xl-3">
            <div class="container-fluid p-0">
                <div class="d-flex align-items-center w-100">

                    <!-- Mobile Logo START -->
                    <div class="d-flex align-items-center d-xl-none">
                        <a class="navbar-brand" href="index.php">
                            <img class="navbar-brand-item h-40px" src="../assets/images/logo/TravSavers-Logo.svg" alt="">
                        </a>
                    </div>

                    <!-- Toggler for sidebar START -->
                    <div class="navbar-expand-xl sidebar-offcanvas-menu">
                        <button class="navbar-toggler me-auto p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-expanded="false" aria-label="Toggle navigation" data-bs-auto-close="outside">
                            <i class="bi bi-list text-primary fa-fw" data-bs-target="#offcanvasMenu"></i>
                        </button>
                    </div>

                    <!-- Top bar left -->
                    <div class="navbar-expand-lg ms-auto ms-xl-0">


                        <!-- Topbar menu left -->
                        <div class="collapse navbar-collapse w-100 z-index-1" id="navbarTopContent">
                            <div class="nav my-3 my-xl-0 flex-nowrap align-items-center">
                                <div class="nav-item w-100">
                                    <div class="h5 pt-2">Welcome, <?php echo $_SESSION['username']; ?>!</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top bar right -->
                    <ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">

                        <li class="nav-item ms-3 dropdown">
                            <a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="icon-md rounded-circle bg-info text-white mb-0"><i class="fa-solid fa-user fa-fw"></i></div>
                            </a>

                            <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                                <li class="px-3 mb-3">
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <a class="h6 mt-2 mt-sm-0" href="#">Brandon Bizar</a>
                                            <p class="small m-0"><?php echo $_SESSION['email']; ?></p>
                                        </div>
                                    </div>
                                </li>

                                <!-- Links -->
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="dashboard.php"><i class="bi bi-speedometer2 fa-fw me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="manage-packages.php"><i class="bi bi-plus-circle fa-fw me-2"></i>Manage Packages</a></li>
                                <li><a class="dropdown-item" href="manage-perks.php"><i class="bi bi-stars fa-fw me-2"></i>Manage Perks</a></li>
                                <li><a class="dropdown-item" href="manage-custom-values.php"><i class="bi bi-card-list fa-fw me-2"></i>Custom Values</a></li>
                                <li><a class="dropdown-item " href="manage-promo-codes.php"><i class="bi bi-ticket fa-fw me-2"></i> Manage Promo Codes</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item bg-danger-soft-hover" href="logout.php"><i class="bi bi-power fa-fw me-2"></i>Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>