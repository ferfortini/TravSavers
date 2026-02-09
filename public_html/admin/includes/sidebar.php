<nav class="navbar sidebar navbar-expand-xl navbar-light bg-light">
    <div class="d-flex align-items-center">
        <a class="navbar-brand" href="dashboard.php">
            <img class="navbar-brand-item" src="../assets/images/logo/TravSavers-Logo.svg" alt="logo">
        </a>
    </div>
    <div class="offcanvas offcanvas-start flex-row custom-scrollbar h-100" data-bs-backdrop="true" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-body sidebar-content d-flex flex-column pt-4">
           <ul class="navbar-nav flex-column" id="navbar-sidebar">

                    <li class="nav-item"><a href="dashboard.php" class="nav-link <?php echo ($page == 'dashboard') ? "active" : ""; ?>"><i class="bi bi-speedometer2 fa-fw me-2"></i>Dashboard</a></li>


                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="" href="#collapsebooking" role="button" aria-expanded="false" aria-controls="collapsebooking">
                            <i class="bi bi-box-seam fa-fw me-2"></i> Package Builder
                        </a>
                        <!-- Submenu -->
                        <ul class="nav  flex-column" id="collapsebooking" data-bs-parent="#navbar-sidebar">
                            <li class="nav-item"> <a class="nav-link <?php echo ($page == 'create-package') ? "active" : ""; ?>" href="manage-packages.php"><i class="bi bi-plus-circle fa-fw me-2"></i> Manage Packages</a></li>
                            <li class="nav-item"> <a class="nav-link <?php echo ($page == 'manage-perks') ? "active" : ""; ?>" href="manage-perks.php"><i class="bi bi-stars fa-fw me-2"></i> Manage Perks</a></li>
                            <li class="nav-item"> <a class="nav-link <?php echo ($page == 'custom-values') ? "active" : ""; ?>" href="manage-custom-values.php"><i class="bi bi-card-list fa-fw me-2"></i> Custom Values</a></li>
                            <li class="nav-item"> <a class="nav-link <?php echo ($page == 'manage-promo-codes') ? "active" : ""; ?>" href="manage-promo-codes.php"><i class="bi bi-ticket fa-fw me-2"></i> Manage Promo Codes</a></li>
                        </ul>
                    </li>
                </ul>
        </div>
    </div>
</nav>
