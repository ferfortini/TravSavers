$(document).ready(function () {
    const hotelData = JSON.parse(localStorage.getItem('selectedHotel'));

    if (hotelData) displayHotelInfo(hotelData);
    fetchHotelDetails(formData(hotelData));

    // Add validation message container after room-cards
    $('#room-cards').after('<div id="room-validation-message" class="text-danger text-center mt-3" style="display: none;">Please select a room before proceeding with booking.</div>');

    // Handle room selection
    $(document).on('click', '.select-room', function () {
        const roomId = $(this).data('room-id');
        const roomName = $(this).data('room-name');
        const packageId = $(this).data('package-id');

        // Set the room ID in the modal's hidden input
        $('#room_id').val(roomId);
        $('#package_id').val(packageId);
        // Update modal title with room name
        $('#guestModal .modal-title').html(`Room Name - ${roomName}`);

        // Show the modal
        $('#guestModal').modal('show');

        // Hide validation message since room is selected
        $('#room-validation-message').hide();
    });

    // Reset room_id when modal is closed
    $('#guestModal').on('hidden.bs.modal', function () {
        $('#room_id').val('');
    });

    // Guest form validation
    $('#guest-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        const roomId = $('#room_id').val();
        const bookingType = $('#booking_type').val();

        if (!roomId) {
            alert('Please select a room before submitting the form.');
            $('#guestModal').modal('hide');
            $('#room-validation-message').show();
            $('html, body').animate({
                scrollTop: $('#room-cards').offset().top - 100
            }, 500);
            return false;
        }

        // Perform field validations
        const isValid = [
            validateInput($('#fname'), $('#fname-error'), 'Please enter first name'),
            validateInput($('#lname'), $('#lname-error'), 'Please enter last name'),
            validateInput($('#email'), $('#email-error'), 'Please enter email'),
            validateInput($('#mobile_no'), $('#mobile_no-error'), 'Please enter mobile number', { numeric: true, digitsBetween: [6, 13] }),
            validateInput($('#zip'), $('#zip-error'), 'Please enter postal code'),
            validateCheckobox($('#checkPrivacy1'), $('#checkPrivacy1-error'), 'Please check privacy policy')
        ];

        if (!isValid.includes(false)) {
            const guestFormData = {
                room_id: $('#room_id').val(),
                package_id: $('#package_id').val(),
                fname: $('#fname').val(),
                lname: $('#lname').val(),
                email: $('#email').val(),
                mobile: $('#mobile_no').val(),
                zip: $('#zip').val(),
                checkPrivacy1: $('#checkPrivacy1').is(':checked'),
                booking_type: bookingType
            };
            localStorage.setItem('guestFormData', JSON.stringify(guestFormData));
            $('#guestModal').modal('hide');
            window.location.href = 'booking.php';
        }
    });
});

let galleryMain = null;
let galleryThumbs = null;

function initSwiper() {
    // Destroy existing instances if they exist
    if (galleryMain) {
        galleryMain.destroy(true, true);
        galleryMain = null;
    }
    if (galleryThumbs) {
        galleryThumbs.destroy(true, true);
        galleryThumbs = null;
    }

    // Wait for images to load
    const images = document.querySelectorAll('.detailPage_swiper-main img, .detailPage_swiper-thumbs img');
    const imagePromises = Array.from(images).map(img => {
        if (img.complete) return Promise.resolve();
        return new Promise(resolve => {
            img.onload = resolve;
            img.onerror = resolve; // Resolve even on error to not block initialization
        });
    });

    Promise.all(imagePromises).then(() => {
        let slidesQuantity;
        $(".detailPage_swiper-container .swiper-container").each(function () {
            slidesQuantity = this.querySelectorAll(".swiper-slide").length;
        });

        function updSwiperNumericPagination() {
            $(".swiper-counter").html('<span class="count">' + (this.realIndex + 1) + '</span>/<span class="total">' +
                slidesQuantity + "</span>");
        }

        galleryThumbs = new Swiper(".detailPage_swiper-thumbs", {
            centeredSlides: true,
            centeredSlidesBounds: true,
            slidesPerView: 3.5,
            spaceBetween: 12,
            watchOverflow: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            direction: 'vertical',
            responsive: true,
            breakpoints: {
                320: {
                    slidesPerView: 3,
                    spaceBetween: 8,
                    direction: 'horizontal',
                },
                577: {
                    slidesPerView: 2.5,
                    direction: 'vertical',
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 12
                },
                992: {
                    slidesPerView: 3.5,
                }
            }
        });

        galleryMain = new Swiper(".detailPage_swiper-main", {
            watchOverflow: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            preventInteractionOnTransition: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            thumbs: {
                swiper: galleryThumbs
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            on: {
                init: updSwiperNumericPagination,
                slideChange: updSwiperNumericPagination
            }
        });

        galleryMain.on('slideChangeTransitionStart', function () {
            galleryThumbs.slideTo(galleryMain.activeIndex);
        });

        galleryThumbs.on('transitionStart', function () {
            galleryMain.slideTo(galleryThumbs.activeIndex);
        });

        $('.swiper-heart').on('click', function () {
            $(this).find('i').toggleClass('bi-heart bi-heart-fill');
        });
    });
}
function displayHotelInfo(data) {
    const previewRate = parseFloat(data.resortPreviewPrice);

    $('#hotel-name').text(data.hotelName);
    $('#image').attr('src', data.hotelImage || 'default.jpg');
    $('#hotel-address').text(data.hotelAddress);
    $('#check-in').text(formatDate(data.checkInDate));
    $('#check-out').text(formatDate(data.checkOutDate));
    $('#preview-rate').text(`$${previewRate}`);

    if (!data.everydayTravSaverPrice) {
        $('.every-day-rate-section').hide();
    } else {
        $('.resort-preview-rate-section').hide();
        $('#every-day-rate').text(`$${data.everydayTravSaverPrice}`);
    }
}


function formData(hotelData) {
    return {
        marginator: { percentage: 0 },
        sessionKey: { value: null, expireDate: "2025-05-12", isInvalid: false },
        hotelRequest: {
            residency: "US",
            location: hotelData.locationCode,
            checkIn: hotelData.checkInDate,
            checkOut: hotelData.checkOutDate,
            rooms: [{
                adultsCount: hotelData.adultsCount || 2,
                kidsAges: hotelData.kidsAges || []
            }],
            hotelId: hotelData.hotelId
        },
        currency: "USD",
        lifeStyle: null
    };
}

function fetchHotelDetails(formData) {
    $.ajax({
        type: 'POST',
        url: 'hotel_detail_api_call.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        beforeSend: () => {
            $('#skeleton-loading').show();
            $('#actual-content').hide();
        },
        success: response => {
            if (response?.code && response.code !== '') {
                const messageHtml = `
                    <div class="alert text-center p-xl-5 p-4 full-alert-section d-flex flex-column justify-content-center" role="alert">
                        <h4 class="alert-heading text-danger mb-3">OOPS! Sorry</h4>
                        <p class="mb-2">There are <strong>no rooms available</strong> on date selected for this Package.</p>
                        <p>Please select a different Date and SAVE hundreds! Dates not flexible? Search for available Hotels in Destinations and still Save hundreds there.</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" onclick="history.back()">
                                <i class="bi bi-arrow-left me-2"></i>Go Back
                            </button>
                        </div>
                    </div>
                `;
                $('.detailPage').html(messageHtml);
            }
            const hotelImages = (response?.hotelDetails?.images || []).filter(img => img.width === 1000);
            // Inject images into Swiper containers
            const mainWrapper = $('.detailPage_swiper-main .swiper-wrapper');
            const thumbWrapper = $('.detailPage_swiper-thumbs .swiper-wrapper');
            mainWrapper.empty();
            thumbWrapper.empty();

            hotelImages.forEach((img, i) => {
                mainWrapper.append(`<div class="swiper-slide"><img src="${img.url}" alt="Hotel Image ${i + 1}"></div>`);
                thumbWrapper.append(`<div class="swiper-slide"><img src="${img.url}" alt="Thumb ${i + 1}"></div>`);
            });
            $('#hotel-name').text(response?.hotelDetails?.title);
            $('#hotel-address').html(`<i class="bi bi-geo-alt-fill me-1"></i>` + response?.hotelDetails?.address + ', ' + response?.hotelDetails?.city + ', ' + response?.hotelDetails?.state + ' ' + response?.hotelDetails?.zipCode);
            $.each(response?.hotelDetails?.descriptions, function (index, description) {
                $('#hotel-description').append(`<li class="d-flex gap-2">
                                                  <i class="bi bi-check-circle-fill"></i>
                                                  <span>${description.trim().replace(/^"|"$/g, '')}</span>
                                              </li>`);
            });

            $.each(response?.hotelDetails?.amenities, function (index, amenities) {
                $('#amenities').append(`<div class="amenity-item">
                                        <div class="amenity-icon d-flex justify-content-center align-items-center">
                                            <i class="bi bi-check2-all"></i>
                                        </div>
                                        <div class="amenity-content">
                                            <p class="amenity-name">${amenities.name}</p>
                                        </div>
                                    </div>`);
            });

            const totalGroupedPackages = response?.adjustedPackageGroups?.reduce((total, group) => {
                return total + (group?.groupedPackages?.length || 0);
            }, 0);

            $('#room-availability').text(`Room availability: ${totalGroupedPackages}`);

            // Clear existing room cards
            $('#room-cards').empty();

            // Add container for view more button
            $('#room-cards').after('<div id="view-more-container" class="text-center mt-3"></div>');

            const roomsPerChunk = 9;
            let displayedRooms = 0;

            function displayRooms(start, count) {
                const end = start + count;
                $.each(response?.adjustedPackageGroups?.slice(start, end), function (index, room) {
                    const roomPackage = room?.groupedPackages?.[0]?.rooms?.[0];
                    const roomId = roomPackage?.id;
                    const matchedRoomContent = response?.roomsContent?.find(rc => rc.roomKey === roomId);
                    const roomImage = matchedRoomContent?.images?.[0] || 'assets/images/heros/default.jpg';

                    $('#room-cards').append(`<div class="col-md-6 col-lg-4">
                                    <div class="card room-card overflow-hidden position-relative">
                                    <div class="card-body p-0 overflow-hidden">
                                            <img src=${roomImage}
                                                class="img-fluid" alt="Product Image Title">
                                            <div class="room-card-content p-3">
                                                <h3 class="title text-primary">
                                                    ${room.groupedPackages[0].rooms[0].roomName}
                                                </h3>
                                                <input type="hidden" name="room_id" value="${room.groupedPackages[0].rooms[0].id}">
                                                <div
                                                    class="d-xl-flex d-lg-block d-md-flex justify-content-between align-items-center mt-2">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary select-room" 
                                                    data-room-id="${room.groupedPackages[0].rooms[0].id}"
                                                    data-room-name="${room.groupedPackages[0].rooms[0].roomName}"
                                                    data-package-id="${room.groupedPackages[0].packageId}"
                                                    style="float: right;">Select room</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                });
                return Math.min(count, response?.adjustedPackageGroups?.length - start);
            }

            // Display initial chunk of rooms
            displayedRooms = displayRooms(0, roomsPerChunk);

            // Add view more button if there are more rooms
            if (response?.adjustedPackageGroups?.length > roomsPerChunk) {
                const updateViewMoreButton = () => {
                    const remainingRooms = response?.adjustedPackageGroups?.length - displayedRooms;
                    const buttonText = `View More Rooms (${remainingRooms} remaining)`;

                    if (remainingRooms > 0) {
                        $('#view-more-container').html(`
                            <button id="view-more-rooms" class="btn btn-outline-primary">
                                ${buttonText}
                            </button>
                        `);
                    } else {
                        $('#view-more-container').hide();
                    }
                };

                updateViewMoreButton();

                // Handle view more click
                $(document).on('click', '#view-more-rooms', function () {
                    const remainingRooms = response?.adjustedPackageGroups.length - displayedRooms;
                    const roomsToShow = Math.min(roomsPerChunk, remainingRooms);

                    const displayedCount = displayRooms(displayedRooms, roomsToShow);
                    displayedRooms += displayedCount;

                    updateViewMoreButton();
                });
            }

            $('#hotel-rating').html(`${response?.hotelDetails?.reviews}<small>/5</small>`);
            $('#hotel-reviews').text(`${response?.hotelDetails?.reviewsCount} reviews`);

            // Function to calculate percentage from rating
            function calculateRatingPercentage(rating) {
                return ((parseFloat(rating) / 5) * 100).toFixed(0) + '%';
            }

            // Update ratings and progress bars
            const ratingMappings = {
                'comfort': '#hotel-rating-comfort',
                'amenities': '#hotel-rating-amenties',
                'cleanliness': '#hotel-rating-cleanliness',
                'condition': '#hotel-rating-condition',
                'service': '#hotel-rating-service'
            };

            Object.entries(ratingMappings).forEach(([key, selector]) => {
                const rating = response?.hotelDetails?.guestRatings?.[key];
                if (rating) {
                    // Update rating text
                    $(selector).text(rating);
                    // Update progress bar
                    $(selector)
                        .closest('.rating-item')
                        .find('.progress-fill')
                        .css('width', calculateRatingPercentage(rating));
                }
            });
            function generateRatingStars(rating) {
                const full = Math.floor(rating);
                const half = rating % 1 >= 0.5 ? 1 : 0;
                const empty = 5 - full - half;
                return `${'<i class="fas fa-star text-warning"></i>'.repeat(full)}
                ${half ? '<i class="fas fa-star-half-alt text-warning"></i>' : ''}
                ${'<i class="far fa-star text-warning"></i>'.repeat(empty)}`;
            }
            const stars = generateRatingStars(response?.hotelDetails?.guestRatings?.overall);
            $('#hotel-rating-stars').html(stars);
            initSwiper();
            $('#skeleton-loading').hide();
            $('#actual-content').show();

            // Enable buttons after successful API response
            if (response?.hotelDetails) {
                $('#book-resort-preview').prop('disabled', false);
                $('#book-travsaver').prop('disabled', false);
            }

            // After injecting the alert
            setFullAlertSectionHeight();
            window.addEventListener('resize', setFullAlertSectionHeight);
        },
        error: function (xhr, status, error) {
            const container = $('.detailPage');
            $('#skeleton-loading').hide();
            $('#actual-content').show();
            // Keep buttons disabled on error
            $('#book-resort-preview, #book-travsaver').prop('disabled', true);
            container.empty();
            
            let errorMessage = 'Oops! We got lost on the way...';
            let errorDetails = 'For some reason we did not find any results for your search.';
            
            if (status === 'timeout') {
                errorDetails = 'The request took too long to complete.';
            } else if (xhr.status === 0) {
                errorDetails = 'Unable to connect to the server. Please check your internet connection.';
            }
            
            container.append(`
                <div class="alert text-center col-md-12">
                    <h4 class="mb-3">${errorMessage}</h4>
                    <p>${errorDetails}</p>
                    <p class="mb-0">Don't worry! Try again but changing your search criteria.</p>
                </div>
            `);

            // After injecting the alert
            setFullAlertSectionHeight();
            window.addEventListener('resize', setFullAlertSectionHeight);
        }
    });
}

