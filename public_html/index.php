<?php
// Authenticate with API to get access token
include_once 'api_auth.php';

$page = "home";
$title = "Book Online in No Time!";
include "inc/header.php";
// Include common functions for image path handling
include "admin/common.php";
$experiences = mysqli_query($con, "SELECT * FROM experiences ORDER BY id DESC");
$destinations = mysqli_query($con, "SELECT * FROM custom_locations ORDER BY id DESC");
?>
<style>
    #featuredPackagesCarousel {
        position: relative;
    }
    #featuredPackagesCarousel .carousel-control-prev,
    #featuredPackagesCarousel .carousel-control-next {
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
    }
    #featuredPackagesCarousel .carousel-control-prev:hover,
    #featuredPackagesCarousel .carousel-control-next:hover {
        opacity: 1;
        background-color: rgba(0, 0, 0, 0.7);
    }
    #featuredPackagesCarousel .carousel-control-prev {
        left: -25px;
    }
    #featuredPackagesCarousel .carousel-control-next {
        right: -25px;
    }
    #featuredPackagesCarousel .carousel-indicators {
        margin-bottom: -30px;
    }
    #featuredPackagesCarousel .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.3);
        border: 2px solid transparent;
    }
    #featuredPackagesCarousel .carousel-indicators button.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    @media (max-width: 768px) {
        #featuredPackagesCarousel .carousel-control-prev,
        #featuredPackagesCarousel .carousel-control-next {
            width: 40px;
            height: 40px;
        }
        #featuredPackagesCarousel .carousel-control-prev {
            left: -15px;
        }
        #featuredPackagesCarousel .carousel-control-next {
            right: -15px;
        }
    }
</style>
<main>

    <section class="pt-0">
        <div class="container-fluid" style="background-image:url(assets/images/heros/travsavers-home4.jpg); background-position: center left; background-size: cover;">
            <div class="row">
                <div class="col-md-6 mx-auto text-center pt-7 pb-9">
                    <h1 class="text-white">Find your perfect vacation</h1>
                    <p class="lead text-white mb-5">Get the best prices on 200,000+ properties and packages, worldwide</p>
                </div>
            </div>
        </div>

        <div class="container mt-n8">
            <div class="row">
                <div class="col-8 col-lg-8 col-xl-6 mx-auto">
                    <ul class="nav nav-tabs nav-bottom-line nav-justified nav-responsive bg-mode rounded-top z-index-9 position-relative pt-2 pb-0 px-4">
                        <li class="nav-item">
                            <a class="nav-link mb-0 active" data-bs-toggle="tab" href="#destinations"><i class="bi bi-compass fs-6 fa-fw me-2"></i>Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0" data-bs-toggle="tab" href="#packages"><i class="bi bi-suitcase-lg fs-6 fa-fw me-2"></i>Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0" data-bs-toggle="tab" href="#tickets"><i class="bi bi-ticket-perforated fs-6 fa-fw me-2"></i>Tickets</a>
                        </li>
                    </ul>
                </div>

                <div class="col-9 mx-auto">
                    <div class="tab-content" id="nav-tabContent">

                        <!-- Tab 1 -->
                        <div class="tab-pane fade show active" id="destinations" data-tab-id="destinations">
                            <form class="card shadow p-0" autocomplete="off" id="destintions-form">
                                <div class="card-header p-4">
                                    <h5 class="mb-0"><i class="bi bi-compass fs-4 me-2"></i>Destinations</h5>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <input type="text" name="dest_loc" id="dest_loc" class="form-control form-control-lg destinations" placeholder="Destination">
                                                <input type="hidden" name="latitude" id="latitude">
                                                <input type="hidden" name="longitude" id="longitude">
                                                <input type="hidden" name="location_code" id="location_code">
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                                <span id="loader" class="loader" style="position: absolute; top: 40%; right: 10px; transform: translateY(-50%);"></span>
                                            </div>
                                            <div class="invalid-feedback destinations-error"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <input type="text" class="form-control form-control-lg" name="hotel_name" placeholder="Hotel Name (Optional)">
                                                <span class="form-icon"><i class="bi bi-building fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                                                    <ul class="dropdown-menu guest-selector-dropdown">
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Adults</h6>
                                                                <small>Ages 13 or above</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 dest-adults">2</h6>
                                                                <button type="button" class="btn btn-link adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        <!-- Child selection -->
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Child</h6>
                                                                <small>Ages 13 below</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 child">0</h6>
                                                                <button type="button" class="btn btn-link child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr destinations_date_range" name="date_range" id="date_range" data-date-format="d/m/y" data-mode="range" placeholder="Date Range">
                                                <span class="form-icon"><i class="bi bi-calendar-week fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback destinations_date_range-error"></div>
                                        </div>

                                    </div>
                                    <div class="col-md-12 collapse" id="child-ages-wrapper">
                                    </div>
                                    <div class="text-center pt-0">
                                        <button type="submit" class="btn btn-lg btn-primary mb-n7">Search Hotels <i class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2 -->
                        <div class="tab-pane fade" id="packages" data-tab-id="packages">
                            <form class="card shadow p-0" autocomplete="off" id="packages-form">
                                <div class="card-header p-4">
                                    <h5 class="mb-0"><i class="bi bi-suitcase-lg fs-4 me-2"></i>Vacation Packages</h5>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice experience" name="experience" id="experience" data-search-enabled="false">
                                                    <option value="" disabled selected>Select Experience</option>
                                                    <?php while ($experience = mysqli_fetch_array($experiences)) { ?>
                                                        <option value="<?php echo $experience['id']; ?>"><?php echo $experience['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback experience-error"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice destinations" name="destination" data-search-enabled="false">
                                                    <option value="">Destination</option>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-geo-alt fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback destinations-error"></div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg package-selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                                    <ul class="dropdown-menu guest-selector-dropdown">
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Adults</h6>
                                                                <small>Ages 13 or above</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link package-adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 package-adults">2</h6>
                                                                <button type="button" class="btn btn-link package-adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Child</h6>
                                                                <small>Ages 13 below</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link package-child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="package-guest-selector mb-0 package-child">0</h6>
                                                                <button type="button" class="btn btn-link package-child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr arrivalDate" name="package_arrival_date" id="package_arrival_date" placeholder="Arrival">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                            <div class="invalid-feedback arrivalDate-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 collapse" id="package-child-ages-wrapper">
                                    </div>
                                    <div class="text-center pt-0">
                                        <button type="submit" class="btn btn-lg btn-primary mb-n7">Search Packages <i class="bi bi-arrow-right ps-3"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 3 -->
                        <div class="tab-pane fade" id="tickets">
                            <form class="card shadow p-0">
                                <div class="card-header p-4">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-md-6">
                                            <h5 class="mb-0"><i class="bi bi-ticket-perforated fs-4 fa-fw me-2"></i>Tickets</h5>
                                        </div>

                                        <div class="col-md-6 d-flex justify-content-end">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                                <label class="form-check-label" for="inlineCheckbox1">Shows</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" checked>
                                                <label class="form-check-label" for="inlineCheckbox2">Attractions</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" checked>
                                                <label class="form-check-label" for="inlineCheckbox3">Dining</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-4 pt-0">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-icon-input form-size-lg form-fs-lg">
                                                <select class="form-select js-choice" data-search-enabled="true">
                                                    <option value="">Select Location</option>
                                                    <option value="94511">Las Vegas, NV</option>
                                                    <option value="34467">Orlando, FL</option>
                                                    <option value="28632">Miami, FL</option>
                                                    <option value="145014">Myrtle Beach, SC</option>
                                                    <option value="150747">Gatlinburg, TN</option>
                                                    <option value="151709">Pigeon Forge, TN</option>
                                                    <option value="144760">Hilton Head, SC</option>
                                                    <option value="87419">Branson, MO</option>
                                                    <option value="171657">Virginia Beach, VA</option>
                                                    <option value="163309">Park City, UT</option>
                                                </select>
                                                <span class="form-icon"><i class="bi bi-search fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <div class="dropdown guest-selector me-2">
                                                    <input type="text" class="form-guest-selector form-control form-control-lg selection-result" placeholder="Group Size" data-bs-auto-close="outside" data-bs-toggle="dropdown">

                                                    <ul class="dropdown-menu guest-selector-dropdown">
                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Adults</h6>
                                                                <small>Ages 13 or above</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link adult-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 adults">2</h6>
                                                                <button type="button" class="btn btn-link adult-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        <li class="d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="mb-0">Child</h6>
                                                                <small>Ages 13 below</small>
                                                            </div>

                                                            <div class="hstack gap-1 align-items-center">
                                                                <button type="button" class="btn btn-link child-remove p-0 mb-0"><i class="bi bi-dash-circle fs-5 fa-fw"></i></button>
                                                                <h6 class="guest-selector-count mb-0 child">0</h6>
                                                                <button type="button" class="btn btn-link child-add p-0 mb-0"><i class="bi bi-plus-circle fs-5 fa-fw"></i></button>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <span class="form-icon"><i class="bi bi-people fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" placeholder="Start Date">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-icon-input form-fs-lg">
                                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" placeholder="End Date">
                                                <span class="form-icon"><i class="bi bi-calendar fs-5"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="text-center pt-0">
                                        <a class="btn btn-lg btn-primary mb-n7" href="#">Search Tickets <i class="bi bi-arrow-right ps-3"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="h3 mb-2">Feature Packages</h2>
                    <p class="text-muted">Discover our most popular destinations</p>
                </div>
            </div>
            <?php
            // Fetch featured packages (published packages with images, limit to 8)
            $featuredPackagesQuery = "
                SELECT 
                    p.id,
                    p.package_title,
                    p.description,
                    p.preview_rate,
                    p.everyday_rate,
                    p.nights,
                    p.image,
                    p.location_id,
                    p.experience_id,
                    GROUP_CONCAT(DISTINCT CONCAT(cl.city, ', ', cl.state) SEPARATOR '; ') AS location_names
                FROM packages p
                LEFT JOIN custom_locations cl ON JSON_CONTAINS(p.location_id, JSON_QUOTE(CAST(cl.id AS CHAR)))
                WHERE p.status = 1 
                    AND p.image IS NOT NULL 
                    AND p.image != ''
                GROUP BY p.id
                ORDER BY p.published_at DESC, p.id DESC
                LIMIT 8
            ";
            $featuredPackagesResult = mysqli_query($con, $featuredPackagesQuery);
            $featuredPackages = [];
            if ($featuredPackagesResult) {
                while ($row = mysqli_fetch_assoc($featuredPackagesResult)) {
                    $featuredPackages[] = $row;
                }
            }
            
            if (count($featuredPackages) > 0):
                // Group packages into slides (4 per slide)
                $packagesPerSlide = 4;
                $totalSlides = ceil(count($featuredPackages) / $packagesPerSlide);
            ?>
            <div id="featuredPackagesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <?php if ($totalSlides > 1): ?>
                <div class="carousel-indicators">
                    <?php for ($ind = 0; $ind < $totalSlides; $ind++): ?>
                    <button type="button" data-bs-target="#featuredPackagesCarousel" data-bs-slide-to="<?php echo $ind; ?>" <?php echo $ind === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $ind + 1; ?>"></button>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
                <div class="carousel-inner">
                    <?php
                    
                    for ($slideIndex = 0; $slideIndex < $totalSlides; $slideIndex++):
                        $isActive = $slideIndex === 0 ? 'active' : '';
                    ?>
                    <div class="carousel-item <?php echo $isActive; ?>">
                        <div class="row g-4">
                            <?php
                            $startIndex = $slideIndex * $packagesPerSlide;
                            $endIndex = min($startIndex + $packagesPerSlide, count($featuredPackages));
                            
                            for ($i = $startIndex; $i < $endIndex; $i++):
                                $package = $featuredPackages[$i];
                                
                                // Handle image path - images are stored as filenames in the database
                                $rawImage = $package['image'] ?? '';
                                
                                if (!empty($rawImage)) {
                                    // Check if it's already a full URL
                                    if (strpos($rawImage, 'http') === 0) {
                                        $imageUrl = $rawImage;
                                    } 
                                    // Check if it already has a path separator (might be stored with path)
                                    elseif (strpos($rawImage, '/') !== false || strpos($rawImage, '\\') !== false) {
                                        // If it starts with /, use as is, otherwise prepend /
                                        $imageUrl = (strpos($rawImage, '/') === 0) ? $rawImage : '/' . ltrim($rawImage, '/');
                                    } 
                                    // Just a filename - construct the path
                                    else {
                                        $imageUrl = '/admin/uploads/' . $rawImage;
                                    }
                                } else {
                                    $imageUrl = '/assets/images/heros/default.jpg';
                                }
                                
                                $locationName = !empty($package['location_names']) 
                                    ? explode('; ', $package['location_names'])[0] 
                                    : 'Explore Destination';
                                
                                // Build proper search URL with base64 encoded parameters
                                // Destination ID map (matching the JavaScript)
                                $destinationIdMap = [
                                    'Las Vegas, NV' => 94511,
                                    'Orlando, FL' => 34467,
                                    'Miami, FL' => 28632,
                                    'Myrtle Beach, SC' => 145014,
                                    'Gatlinburg, TN' => 150747,
                                    'Pigeon Forge, TN' => 151709,
                                    'Hilton Head, SC' => 144760,
                                    'Branson, MO' => 87419,
                                    'Virginia Beach, VA' => 171657,
                                    'Park City, UT' => 163309
                                ];
                                
                                // Get destination ID if location matches
                                $destinationId = $destinationIdMap[$locationName] ?? null;
                                $experienceId = $package['experience_id'] ?? '';
                                
                                // Default date (today + 7 days for check-in, +10 days for check-out)
                                $defaultCheckIn = date('Y-m-d', strtotime('+7 days'));
                                $defaultAdults = 2;
                                
                                // Build URL with base64 encoded parameters
                                if ($experienceId && $destinationId) {
                                    $packageUrl = 'search-package.php?' . http_build_query([
                                        'experience' => base64_encode($experienceId),
                                        'destination_id' => base64_encode($destinationId),
                                        'destination_name' => base64_encode($locationName),
                                        'checkIn' => base64_encode($defaultCheckIn),
                                        'adults' => base64_encode($defaultAdults),
                                        'child' => ''
                                    ]);
                                } else {
                                    // Fallback: link to home page package search tab
                                    $packageUrl = 'index.php#packages';
                                }
                            ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="card shadow-sm h-100 overflow-hidden position-relative" style="border: none; border-radius: 12px;">
                                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                                        <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                                             onerror="this.src='/assets/images/heros/default.jpg';" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover; transition: transform 0.3s ease;" 
                                             alt="<?php echo htmlspecialchars($package['package_title']); ?>"
                                             onmouseover="this.style.transform='scale(1.1)'"
                                             onmouseout="this.style.transform='scale(1)'">
                                        <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                            <h5 class="text-white mb-0 fw-bold"><?php echo htmlspecialchars($package['package_title']); ?></h5>
                                            <?php if (!empty($locationName)): ?>
                                            <small class="text-white-50"><?php echo htmlspecialchars($locationName); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body text-center p-3">
                                        <div class="mb-2">
                                            <span class="text-primary fw-bold fs-5">$<?php echo number_format($package['preview_rate']); ?></span>
                                            <small class="text-muted d-block"><?php echo $package['nights']; ?> night<?php echo $package['nights'] > 1 ? 's' : ''; ?></small>
                                        </div>
                                        <a href="<?php echo $packageUrl; ?>" class="btn btn-primary btn-sm w-100">Explore Packages</a>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <?php if ($totalSlides > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#featuredPackagesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredPackagesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center">
                <p class="mb-0">No featured packages available at the moment. Check back soon!</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="bg-light mt-5">
        <div class="container my-4 py-2">
            <div class="row g-4 g-md-5">
                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-calendar-week" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Search Deals</h5>
                            <p class="mb-0">Search for the best deals on cruises, day trips, vacation packages, tours, and exclusive getaways! TravNow Members save even more.</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-chat-right-text" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Chat with an Agent</h5>
                            <p class="mb-0">Click or call 1-770-821-6831 to speak with an expert TravNow agent to ensure the best travel or vacation experience at the best value.</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex">
                        <i class="bi bi-award" style="font-size:50px;"></i>
                        <div class="ms-3">
                            <h5 class="mb-2">Why TravSavers?</h5>
                            <p class="mb-0">Personal Service + Best Prices! We've spent decades uncovering hundreds of thousands of exclusive travel deals, nationally and worldwide.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
<!-- Modal -->
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Arrival Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="package-price-form">
                    <input type="hidden" name="price" id="selectedPrice">
                    <div class="row">
                        <!-- Arrival Date -->
                         <div class="col-md-6 mb-3">
                            <label for="arrivalDate" class="form-label">Arrival Date</label>
                            <input type="text" name="arrivalDate" id="arrivalDate" class="form-control flatpickr arrivalDate" placeholder="Select arrival date">
                            <div class="invalid-feedback arrivalDate-error"></div>
                        </div> 

                        <!-- Departure Date -->
                         <div class="col-md-6 mb-3">
                            <label for="departureDate" class="form-label">Departure Date</label>
                            <input type="text" name="departureDate" id="departureDate" class="form-control flatpickr departureDate" placeholder="Select departure date" readonly>
                            <div class="invalid-feedback departureDate-error"></div>
                        </div> 
                        <!-- <div class="col-lg-6">
                            <div class="form-icon-input form-fs-lg">
                                <input type="text" class="form-control form-control-lg flatpickr" data-date-format="d/m/y" data-mode="range" placeholder="Date Range">
                                <span class="form-icon"><i class="bi bi-calendar-week fs-5"></i></span>
                            </div>
                            <div class="invalid-feedback destinations_date_range-error"></div>
                        </div> -->
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" id="submitDates" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php";
?>
<script src="./assets/js/frontend/index.js"></script>