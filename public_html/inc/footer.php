<?php

$is_home = basename($_SERVER['PHP_SELF']) == 'index.php';
$packageLink = $is_home ? 'index.php#packages' : '/index.php#packages';
$destinationLink = $is_home ? 'index.php#destinations' : '/index.php#destinations';
$ticketLink = $is_home ? 'index.php#tickets' : '/index.php#tickets';
?>
<footer class="bg-charcoal pt-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-3">
                <a href="dashboard.php">
                    <img class="h-60px" src="assets/images/logo/TravSavers-Logo-White.svg" alt="logo">
                </a>
                <p class="mb-2 mt-3"><a href="tel:8006562780" class="text-body-secondary text-primary-hover"><i class="bi bi-telephone me-2"></i>+1 (800) 656-2780</a> </p>
                <p class="mb-0"><a href="mailto:support@travsavers.com" class="text-body-secondary text-primary-hover"><i class="bi bi-envelope me-2"></i>support@travsavers.com</a></p>
            </div>

            <div class="col-lg-8 ms-auto">
                <div class="row g-4">
                    <div class="col-6 col-md-3">

                    </div>

                    <div class="col-6 col-md-3">
                        <h5 class="text-white mb-2 mb-md-4">Search</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link text-body-secondary" data-bs-toggle="tab" href="<?php echo $destinationLink ?>" onclick="scrollToTop()">Destinations</a></li>
                            <li class="nav-item"><a class="nav-link text-body-secondary" data-bs-toggle="tab" href="<?php echo $packageLink ?>" onclick="scrollToTop()">Packages</a></li>
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="<?php echo $ticketLink ?>" onclick="scrollToTop()">Tickets</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-3">
                        <h5 class="text-white mb-2 mb-md-4">Company</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="#">About</a></li>
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="#">Contact</a></li>
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="/blog" target="_blank">Blog</a></li>

                        </ul>
                    </div>

                    <div class="col-6 col-md-3">
                        <h5 class="text-white mb-2 mb-md-4">Profile</h5>
                        <ul class="nav flex-column text-primary-hover">
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="#">Log In</a></li>
                            <li class="nav-item"><a class="nav-link text-body-secondary" href="#">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4 justify-content-between mt-3 mt-md-4">

            <div class="col-sm-7 col-md-6 col-lg-4">
                <h5 class="text-white mb-2">Secure Payments:</h5>
                <ul class="list-inline mb-0 mt-3">
                    <li class="list-inline-item"> <a href="#"><img src="assets/images/element/paypal.svg" class="h-30px" alt=""></a></li>
                    <li class="list-inline-item"> <a href="#"><img src="assets/images/element/visa.svg" class="h-30px" alt=""></a></li>
                    <li class="list-inline-item"> <a href="#"><img src="assets/images/element/mastercard.svg" class="h-30px" alt=""></a></li>
                    <li class="list-inline-item"> <a href="#"><img src="assets/images/element/expresscard.svg" class="h-30px" alt=""></a></li>
                </ul>
            </div>

            <div class="col-sm-5 col-md-6 col-lg-3 text-sm-end">
                <h5 class="text-white mb-2">Connect with us</h5>
                <ul class="list-inline mb-0 mt-3">
                    <li class="list-inline-item"> <a class="btn btn-sm px-2 bg-facebook mb-0" href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-instagram mb-0" href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-twitter mb-0" href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
                    <li class="list-inline-item"> <a class="btn btn-sm shadow px-2 bg-linkedin mb-0" href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                </ul>
            </div>
        </div>

        <hr class="mt-4 mb-0">

        <div class="row">
            <div class="container">
                <div class="d-lg-flex justify-content-between align-items-center py-3 text-center text-lg-start">
                    <!-- copyright text -->
                    <div class="text-body-secondary text-primary-hover"> Copyright ©2025 TravSavers. Built by <a href="https://www.travcoding.com/" class="text-body-secondary">&lt;travcoding&gt;</a> </div>
                    <!-- copyright links-->
                    <div class="nav mt-2 mt-lg-0">
                        <ul class="list-inline text-primary-hover mx-auto mb-0">
                            <li class="list-inline-item me-0"><a class="nav-link text-body-secondary py-1" href="#">Privacy policy</a></li>
                            <li class="list-inline-item me-0"><a class="nav-link text-body-secondary py-1" href="#">Terms and conditions</a></li>
                            <li class="list-inline-item me-0"><a class="nav-link text-body-secondary py-1 pe-0" href="#">Refund policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="back-top"></div>

<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="assets/vendor/tiny-slider/tiny-slider.js"></script>
<script src="assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.js"></script>
<script src="assets/vendor/flatpickr/js/flatpickr.min.js"></script>
<script src="assets/vendor/choices/js/choices.min.js"></script>
<script src="assets/vendor/jarallax/jarallax.min.js"></script>
<script src="assets/vendor/jarallax/jarallax-video.min.js"></script>
<script src="assets/vendor/sticky-js/sticky.min.js"></script>
<script src="assets/vendor/apexcharts/js/apexcharts.min.js"></script>
<script src="assets/vendor/nouislider/nouislider.min.js"></script>

<script src="assets/js/functions.js"></script>

<script>
    $(document).ready(function() {
        // Handle card click
        $(document).on('click', '.card', function() {
            const radio = $(this).find('input[type=radio]');
            if (!radio.prop('checked')) {
                radio.prop('checked', true).trigger('change');
            }
        });

        // Handle radio change
        $(document).on('change', 'input:radio', function() {
            removeActive();
            const id = $(this).attr('id');
            makeActive(id);
        });

        // Handle close slider
        $('.slider .close-slider').on('click', function() {
            removeActive();
            $('input:radio').prop('checked', false);
        });
    });

    // Remove active class from all cards
    function removeActive() {
        $(".card").removeClass("active-radio");
    }

    // Add active class to selected card
    function makeActive(id) {
        $("#" + id + "-card").addClass("active-radio");
    }
</script>

<!-- Child age input -->
<script>
    $(document).ready(function() {
        let childCount = parseInt($('.guest-selector-count.child').text()) || 0;
        let packageChildCount = parseInt($('.package-guest-selector-count').text()) || 0;

        function updateAgeFields(container, count, selector) {
            if (count > 0) {
                container.collapse('show');
            } else {
                container.collapse('hide');
            }

            let values = [];
            container.find('input').each(function() {
                values.push($(this).val());
            });
            container.empty();
            for (let i = 1; i <= count; i++) {
                const inputGroup = `
                <div class="form-icon-input form-size-lg form-fs-lg mb-3">
                 <input type="text" min="0" max="13" class="form-control form-control-lg" id="child-age-${i}" name="child_${i}_age" placeholder="Child ${i} Age" value="${values[i-1] || ''}">
                 <span class="form-icon"><i class="bi bi-person-plus fs-5"></i></span>
                 </div>
                `;
                container.append(inputGroup);
            }

            $(selector).text(count);
        }

        $('.child-add').on('click', function() {
            if (childCount < 8) {
                childCount++;
                updateAgeFields($('#child-ages-wrapper'), childCount, '.guest-selector-count.child');
            }
        });

        $('.child-remove').on('click', function() {
            if (childCount > 0) {
                childCount--;
                updateAgeFields($('#child-ages-wrapper'), childCount, '.guest-selector-count.child');
            }
        });

        $('.package-child-add').on('click', function() {
            if (packageChildCount < 8) {
                packageChildCount++;
                updateAgeFields($('#package-child-ages-wrapper'), packageChildCount, '.package-guest-selector-count');
            }
        });

        $('.package-child-remove').on('click', function() {
            if (packageChildCount > 0) {
                packageChildCount--;
                updateAgeFields($('#package-child-ages-wrapper'), packageChildCount, '.package-guest-selector-count');
            }
        });

        // Initial render
        updateAgeFields($('#child-ages-wrapper'), childCount, '.guest-selector-count.child');
        updateAgeFields($('#package-child-ages-wrapper'), packageChildCount, '.package-guest-selector-count');
    });
</script>
<script>
$(document).ready(function () {
    const handleHashTab = () => {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = $(`.nav-tabs a[href="${hash}"]`);
            if (tabTrigger.length > 0) {
                new bootstrap.Tab(tabTrigger[0]).show();
            }
        }
    };

    handleHashTab();

    $('.nav-tabs').on('click', '.nav-link', function (e) {
        const target = $(this);
        if (target.attr('data-bs-toggle') === 'tab') {
            const targetHash = target.attr('href');
            if (targetHash && targetHash.startsWith('#')) {
                history.replaceState(null, null, targetHash);
            }
        }
    });

    $('a[href^="index.php#"]').on('click', function (e) {
        e.preventDefault();
        const targetUrl = $(this).attr('href');
        const targetHash = targetUrl.split('#')[1];
        if (targetHash) {
            const tabTrigger = $(`.nav-tabs a[href="#${targetHash}"]`);
            if (tabTrigger.length > 0) {
                new bootstrap.Tab(tabTrigger[0]).show();
                history.replaceState(null, null, `#${targetHash}`);
            }
        }
    });
   
});
function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}
function setFullAlertSectionHeight() {
    const header = document.querySelector('header');
    const footer = document.querySelector('footer');
    const alertSection = document.querySelector('.full-alert-section');

    if (!alertSection) return;

    const headerHeight = header ? header.offsetHeight : 0;
    const footerHeight = footer ? footer.offsetHeight : 0;
    const windowHeight = window.innerHeight;

    // Set height so it fills the space between header and footer
    alertSection.style.minHeight = (windowHeight - headerHeight - footerHeight - 16) + 'px';
    alertSection.style.display = 'flex';
    alertSection.style.flexDirection = 'column';
    alertSection.style.justifyContent = 'center';
}
</script>
</body>

</html>