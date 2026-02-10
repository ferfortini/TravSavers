let arrival, departure, adults, childAges = [];

// Define utility functions at the top level
function showSkeletonLoaders(count = 3) {
    const container = $('#hotel-results');
    container.empty();

    for (let i = 0; i < count; i++) {
        container.append(`
            <div class="skeleton-list-card">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div>
                        <div class="skeleton-list-title"></div>
                        <div class="skeleton-list-text"></div>
                        <div class="skeleton-list-text"></div>
                        <div class="skeleton-list-text short"></div>
                    </div>
                    <div>
                        <div class="skeleton-price"></div>
                        <div class="skeleton-button"></div>
                    </div>
                </div>
            </div>
        `);
    }
}


let debounceTimeout;
$('#dest_loc').on('input', function () {
    let self = this;
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(function () {
        let inputVal = $(self).val().trim();
        if (inputVal.length >= 3) {
            $.ajax({
                type: 'GET',
                url: 'auto_suggestion_destination_api_call.php',
                data: {
                    SearchString: encodeURIComponent(inputVal)
                },
                dataType: 'json',
                success: function (response) {
                    let responseData = response;

                    // Remove existing suggestions if any
                    $('#suggestions-list').remove();

                    let suggestions = '';
                    $.each(responseData.locations, function (index, value) {
                        suggestions += '<li class="suggestion-item" value="' + value.code + '"longitude="' + value.geoLocation.longitude + '" latitude="' + value.geoLocation.latitude + '">' + value.name + '</li>';
                    });

                    // Append the list
                    $('#dest_loc').after('<ul id="suggestions-list">' + suggestions + '</ul>');

                    $('#suggestions-list').on('click', 'li', function () {
                        let selectedValue = $(this).text();
                        let longitude = $(this).attr('longitude');
                        let latitude = $(this).attr('latitude');
                        let locationCode = $(this).attr('value');
                        $('#dest_loc').val(selectedValue);
                        $('#longitude').val(longitude);
                        $('#latitude').val(latitude);
                        $('#location_code').val(locationCode);
                        $('#suggestions-list').remove();
                    });
                    // Show the list
                    $('#suggestions-list').show();
                    $('#dest_loc').on('keyup', function () {
                        if ($(this).val() === '') {
                            $('#suggestions-list').remove();
                        }
                    });
                },

                error: function (xhr, status, error) {
                    $('.loader').hide();
                    handleError(error);
                }
            });
        }
    }, 500);
});

const urlParams = new URLSearchParams(window.location.search);
const destLoc = atob(urlParams.get('dest_loc'));
const hotelName = atob(urlParams.get('hotel_name'));
adults = parseInt(atob(urlParams.get('adults')));
const child = atob(urlParams.get('child'));
childAges = (child || '')
    .split(',')
    .map(age => parseInt(age))
    .filter(age => !isNaN(age) && age >= 0);
arrival = atob(urlParams.get('arrival'));
departure = atob(urlParams.get('departure'));
const latitude = atob(urlParams.get('latitude'));
const longitude = atob(urlParams.get('longitude'));
const locationCode = atob(urlParams.get('location_code'));

$('#destination').text(destLoc);
$('#dest_loc').val(destLoc);
$('#hotel_name').val(hotelName);
$('#date_range').val(formatDate(arrival) + ' to ' + formatDate(departure));
/*To show selected value in calendar */
e.flatPicker(); 

$('#latitude').val(latitude);
$('#longitude').val(longitude);
$('#location_code').val(locationCode);
$('.adults').text(adults);
$('.child').text(childAges.length);
let guestText = (adults + childAges.length) > 1 ? "Guests" : "Guest";
let childText = childAges.length > 1 ? "Child" : "Child";
let resultText = (adults + childAges.length) + " " + guestText + " " + childAges.length + " " + childText;
$('.selection-result').val(resultText);

$('.adult-add').on('click', function () {
    adults++;
    $('.adults').text(adults);
    updateResultText();
});

$('.child-add').on('click', function () {
    childAges.push(childAges.length);
    $('.child').text(childAges.length);
    updateResultText();
});

function updateResultText() {
    let guestText = (adults + childAges.length) > 1 ? "Guests" : "Guest";
    let childText = childAges.length > 1 ? "Children" : "Child";
    let resultText = (adults + childAges.length) + " " + guestText + " " + childAges.length + " " + childText;
    $('.selection-result').val(resultText);
}
$('.adult-remove').on('click', function () {
    if (adults > 0) {
        adults--;
        $('.adults').text(adults);
        updateResultText();
    }
});

$('.child-remove').on('click', function () {
    if (childAges.length > 0) {
        childAges.pop();
        $('.child').text(childAges);
        updateResultText();
    }
});
// Get the form data
const formData = {
    hotelsRequest: {
        residency: "US",
        locationCode: locationCode,
        location: {
            code: locationCode,
            name: destLoc,
            type: "City",
            geoLocation: {
                latitude: latitude,
                longitude: longitude
            }
        },
        checkIn: arrival || '',
        checkOut: departure || '',
        rooms: [{
            adultsCount: adults || 2,
            kidsAges: (childAges && childAges.length > 0) ? childAges : []
        }]
    },
    filter: {
        accessibilities: [],
        accommodationType: [],
        amenities: [],
        boardNames: [],
        budgetRanges: [],
        neighbourhoods: [],
        popularLocations: [],
        refundable: [],
        starRatings: [],
        propertyName: hotelName || '',
        distanceInMiles: 10,
        exactSearch: true
    },
    sortBy: "BiggestSavingsPercentage",
    pageNumber: 1,
    pageSize: 10,
    quick: false,
    searchHomes: "All",
    currency: "USD",
    sessionKey: null
};

fetchHotels(formData);

function onPageChange(newPage) {
    const updatedFormData = {
        ...formData,
        pageNumber: newPage
    }; // create a new formData object with the updated pageNumber
    fetchHotels(updatedFormData); // fetch hotels with the updated formData
}

function fetchHotels(formData) {
    $.ajax({
        type: 'POST',
        url: 'hotel_search_api_call.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            showSkeletonLoaders(4);
        },
        success: function (response) {
            if (!response.searchHotels || response.searchHotels.length === 0) {
                const container = $('#hotel-results');
                container.empty();
                container.append('<div class="alert alert-danger text-center col-md-12"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> No data found.</font></font></div>');
                return;
            }
            const hotels = response.searchHotels || [];
            const container = $('#hotel-results');
            container.empty();

            hotels.forEach((hotel, index) => {
                const stars = generateStars(hotel.starRating || 0);
                
                // Limit amenities to top 4
                const allAmenities = hotel.amenities || [];
                const topAmenities = allAmenities.slice(0, 4);
                const amenitiesHTML = topAmenities.map(a => `<li class="nav-item">${a.name}</li>`).join('');
                const moreAmenitiesCount = allAmenities.length > 4 ? allAmenities.length - 4 : 0;
                const moreAmenitiesHTML = moreAmenitiesCount > 0 ? `<li class="nav-item"><small class="text-muted">+${moreAmenitiesCount} more</small></li>` : '';
                
                const checkInDate = formatDate(hotel.possibleStays[0].checkIn);
                const checkOutDate = formatDate(hotel.possibleStays[0].checkOut);
                let diffDate = calculateDateDifference(checkInDate, checkOutDate);
                
                // Format date more compactly
                const shortCheckIn = new Date(hotel.possibleStays[0].checkIn).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                const shortCheckOut = new Date(hotel.possibleStays[0].checkOut).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                
                const card = `
                        <div class="card shadow p-2">
                            <div class="row g-0">
                                <div class="col-md-5">
                                   <img src="${hotel.images[0].url ? hotel.images[0].url : 'assets/images/heros/image-not-available.jpg'}" id="hotel-image" class="card-img rounded-2" alt="No hotel image available">
                                </div>

                                <div class="col-md-7">
                                    <div class="card-body py-md-2 d-flex flex-column h-100">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="list-inline mb-0">
                                                ${stars}
                                            </ul>

                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <a href="#" class="btn btn-sm btn-round btn-light"><i class="fa-solid fa-fw fa-heart"></i></a>
                                                </li>
                                                <li class="list-inline-item dropdown">
                                                    <a href="#" class="btn btn-sm btn-round btn-light" role="button" id="dropdownShare2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-fw fa-share-alt"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end min-w-auto shadow rounded" aria-labelledby="dropdownShare2">
                                                        <li><a class="dropdown-item" href="#"><i class="fab fa-twitter-square me-2"></i>Twitter</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fab fa-facebook-square me-2"></i>Facebook</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fab fa-linkedin me-2"></i>LinkedIn</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-copy me-2"></i>Copy link</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>

                                        <h4 class="card-title mb-1 hotel-detail-button" data-index="${index}"><a href="#">${hotel.displayName}</a></h4>
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>${hotel?.city || ''}, ${hotel?.state || ''}</small>
                                        
                                        <ul class="nav nav-divider mt-2 mb-2">
                                            ${amenitiesHTML}${moreAmenitiesHTML}
                                        </ul>

                                        <div class="d-flex align-items-center text-info mb-3">
                                            <i class="bi bi-calendar-week me-2"></i>
                                            <small>${shortCheckIn} - ${shortCheckOut} (${diffDate} nights)</small>
                                        </div>

                                        <div class="mt-auto">
                                            <div class="row g-2 mb-3">
                                                <!-- Retail Rate Tile (Left) -->
                                                <div class="col-6">
                                                    <div class="border rounded p-2 h-100 text-center" style="background-color: #f8f9fa;">
                                                        <small class="text-muted d-block mb-1">Retail Rate</small>
                                                        ${hotel.publicPrices && hotel.publicPrices[0] ? `
                                                            <h4 class="fw-bold text-dark mb-0">$${formatPrice(hotel.publicPrices[0].price / diffDate)}</h4>
                                                            <small class="text-muted">Total Price incl. taxes</small>
                                                        ` : `
                                                            <h4 class="fw-bold text-dark mb-0">N/A</h4>
                                                        `}
                                                    </div>
                                                </div>
                                                
                                                <!-- Hotel Sponsored Rate Tile (Right) -->
                                                <div class="col-6">
                                                    <div class="border rounded p-2 h-100 text-center" style="background-color: #f8f9fa;">
                                                        <small class="d-block mb-1" style="color: #0d6e3d;">
                                                            Hotel Sponsored Rate
                                                            <i class="bi bi-info-circle ms-1 text-primary" 
                                                               data-bs-toggle="tooltip" 
                                                               data-bs-placement="top" 
                                                               data-bs-html="true"
                                                               title="While at the hotel, you and your spouse participate in a fun &amp; friendly no-obligation 2 hour preview of the resort. It's that easy!"></i>
                                                        </small>
                                                        <h4 class="fw-bold text-success mb-0">$${(hotel.price - 200) / diffDate >= 0 ? formatPrice((hotel.price - 200) / diffDate) : '12'}</h4>
                                                        <small class="text-muted">Total Price incl. taxes</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success w-100 hotel-detail-button" data-index="${index}">View Details <i class="bi bi-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                container.append(card);
            });
            
            // Initialize Bootstrap tooltips for the newly added cards
            const tooltipTriggerList = container.find('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.each(function() {
                new bootstrap.Tooltip(this);
            });
            
            $(document).on('click', '.hotel-detail-button', function (e) {
                e.preventDefault();
                const buttonId = $(this).attr('id');
                const urlParams = new URLSearchParams(window.location.search);
                const adults = parseInt(atob(urlParams.get('adults')));
                const child = atob(urlParams.get('child'));
                const childAges = (child || '')
                    .split(',')
                    .map(age => parseInt(age))
                    .filter(age => !isNaN(age) && age >= 0);
                const index = $(this).data('index');
                const selectedHotel = hotels[index];
                const hotelId = selectedHotel.hotelId;
                const hotelName = selectedHotel.displayName;
                const hotelAddress = selectedHotel.address + ', ' + selectedHotel.city + ', ' + selectedHotel.state + ', ' + selectedHotel.zipCode;
                const hotelImage = selectedHotel.images[0].url;
                const checkInDate = selectedHotel.possibleStays[0].checkIn;
                const checkOutDate = selectedHotel.possibleStays[0].checkOut;
                const adultsCount = adults;
                const kidsAges = childAges;
                const everydayTravSaverPrice = formatPrice(selectedHotel.publicPrices[0].price);
                let diffDate = calculateDateDifference(checkInDate, checkOutDate);
                const resortPreviewPrice = ((selectedHotel.price - 200) / diffDate) >= 0 ? formatPrice(((selectedHotel.price - 200) / diffDate) * diffDate) : '12' * diffDate;

                const selectedData = {
                    hotelId: hotelId,
                    locationCode: locationCode,
                    hotelName: hotelName,
                    hotelAddress: hotelAddress,
                    hotelImage: hotelImage,
                    everydayTravSaverPrice: everydayTravSaverPrice,
                    resortPreviewPrice: resortPreviewPrice,
                    checkInDate: checkInDate,
                    checkOutDate: checkOutDate,
                    adultsCount: adultsCount,
                    kidsAges: kidsAges
                };

                localStorage.setItem('selectedHotel', JSON.stringify(selectedData));
                window.location.href = 'hotel-detail.php';
            });
            
            const totalHotelsForPagination = response.counters.totalFilteredHotels;
            if (totalHotelsForPagination > 10) {
                renderPagination(totalHotelsForPagination, formData.pageNumber, formData.pageSize, onPageChange);
            }

        },
        error: function (xhr, status, error) {
            //hideSkeletonLoaders();
            const container = $('#hotel-results');
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
        }
    });
}

//Edit search
$('form').submit(function (event) {
    event.preventDefault();

    // Validate form fields
    const isDestinationsValid = validateInput(
        $(this).find('.destinations'),
        $(this).find('.destinations-error'),
        'Please select a destinations'
    );
    const isDateRangeValid = validateInput(
        $(this).find('.destinations_date_range'),
        $(this).find('.destinations_date_range-error'),
        'Please select a date range.'
    );

    // Only proceed with API call if all validations pass
    if (isDestinationsValid && isDateRangeValid) {
        const rating = $('input[name="starRatings"]:checked').map(function () {
            return parseInt($(this).val());
        }).get();
        formData.hotelsRequest.locationCode = $('#location_code').val();
        formData.hotelsRequest.location = {
            name: $('#dest_loc').val(),
            code: $('#location_code').val(),
            type: "City",
            geoLocation: {
                latitude: $('#latitude').val(),
                longitude: $('#longitude').val()
            }
        };
        const arrivalDate = $('#date_range').val().split(' to ')[0];
        const departureDate = $('#date_range').val().split(' to ')[1];
        formData.hotelsRequest.checkIn = convertToYMD(arrivalDate);
        formData.hotelsRequest.checkOut = convertToYMD(departureDate);
        formData.hotelsRequest.rooms = [{
            adultsCount: parseInt($('.adults').text()) || 2,
            kidsAges: (childAges && childAges.length > 0) ? childAges : []
        }];

        formData.filter.propertyName = $('#hotel_name').val();
        formData.filter.starRatings = rating;
        
        // Reset page number to 1 when filters change
        formData.pageNumber = 1;

        // Only call fetchHotels if validation passes
        fetchHotels(formData);
    }
});

//Sorting 
$('#sort').on('change', function (event) {
    event.preventDefault();
    const sortingValue = $(this).val();
    Object.assign(formData, {
        sortBy: sortingValue
    });
    // Reset page number to 1 when sorting changes
    formData.pageNumber = 1;
    fetchHotels(formData);
});

// Hotel name filter with debouncing
let hotelNameDebounceTimeout;
$('#hotel_name').on('input', function (event) {
    event.preventDefault();
    clearTimeout(hotelNameDebounceTimeout);
    
    hotelNameDebounceTimeout = setTimeout(function () {
        const hotelName = $('#hotel_name').val();
        formData.filter.propertyName = hotelName;
        // Reset page number to 1 when filters change
        formData.pageNumber = 1;
        fetchHotels(formData);
    }, 500); // 500ms delay to avoid too many API calls
});
