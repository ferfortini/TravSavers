let arrival, departure, adults, childAges = [];
let allHotels = []; // Store all hotels for filtering
let map = null; // Leaflet map instance (desktop)
let mapMobile = null; // Leaflet map instance (mobile)
let markers = []; // Store map markers
let markersMobile = []; // Store map markers (mobile)
let destinationMarker = null; // Destination marker
let destinationMarkerMobile = null; // Destination marker (mobile)

// Update hero image dynamically if no curated image exists
function updateHeroImage(destination, hotels) {
    const heroSection = $('.hero-section');
    if (!heroSection.length) {
        console.log('Hero section not found');
        return;
    }
    
    // Check current background image
    const currentBg = heroSection.css('background-image');
    const dataHeroImage = heroSection.data('hero-image') || '';
    
    // List of curated image filenames (don't override these)
    const curatedImages = ['miami.jpg', 'vegas.jpg', 'orlando.jpg', 'myrtle-beach.jpg', 'branson.jpg'];
    const hasCuratedImage = curatedImages.some(img => {
        return (currentBg && currentBg.includes(img)) || (dataHeroImage && dataHeroImage.includes(img));
    });
    
    // Only update if we don't have a curated image (i.e., using default.jpg or no image)
    if (hasCuratedImage) {
        console.log('Curated hero image already set, skipping hotel image fallback');
        return;
    }
    
    // Only use hotel image if current image is default or missing
    if (currentBg && !currentBg.includes('default.jpg') && currentBg !== 'none' && !currentBg.includes('url("")')) {
        console.log('Hero image already set (not default), skipping update');
        return;
    }
    
    // Try to use hotel image if available (better than default or missing images)
    if (hotels && hotels.length > 0) {
        // Try to get hotel image - check multiple possible structures
        let hotelImage = null;
        const firstHotel = hotels[0];
        
        if (firstHotel.images && firstHotel.images.length > 0 && firstHotel.images[0].url) {
            hotelImage = firstHotel.images[0].url;
        } else if (firstHotel.image) {
            hotelImage = firstHotel.image;
        } else if (firstHotel.imageUrl) {
            hotelImage = firstHotel.imageUrl;
        }
        
        if (hotelImage) {
            // Add cache-busting parameter to prevent browser caching
            // Use both timestamp and random number for maximum cache-busting
            const separator = hotelImage.includes('?') ? '&' : '?';
            const timestamp = Date.now();
            const random = Math.floor(Math.random() * 1000000);
            const cacheBuster = `_t=${timestamp}&_r=${random}`;
            const imageUrl = `${hotelImage}${separator}${cacheBuster}`;
            
            // Force browser to reload by creating new image object
            const img = new Image();
            img.onload = function() {
                // Set background image only after image is loaded
                heroSection.css('background-image', `url("${imageUrl}")`);
                console.log('Updated hero image from hotel API (cache-busted):', imageUrl);
            };
            img.onerror = function() {
                console.log('Failed to load hotel image:', imageUrl);
            };
            img.src = imageUrl;
        } else {
            console.log('No hotel image available in hotel data:', firstHotel);
        }
    } else {
        console.log('No hotels available for hero image');
    }
}

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
const destLoc = atob(urlParams.get('dest_loc') || '');
const hotelName = atob(urlParams.get('hotel_name') || '');
adults = parseInt(atob(urlParams.get('adults') || ''));
const child = atob(urlParams.get('child') || '');
childAges = (child || '')
    .split(',')
    .map(age => parseInt(age))
    .filter(age => !isNaN(age) && age >= 0);
arrival = atob(urlParams.get('arrival') || '');
departure = atob(urlParams.get('departure') || '');
// Parse coordinates and ensure they're numbers
const latitudeStr = atob(urlParams.get('latitude') || '');
const longitudeStr = atob(urlParams.get('longitude') || '');
const latitude = parseFloat(latitudeStr) || 40.7128; // Default to NYC if invalid
const longitude = parseFloat(longitudeStr) || -74.0060; // Default to NYC if invalid
const locationCode = atob(urlParams.get('location_code') || '');

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
    return $.ajax({
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
            allHotels = hotels; // Store hotels for filtering
            
            // Apply star filter if any selected
            const selectedStars = $('.star-filter:checked').map(function() {
                return parseInt($(this).val());
            }).get();
            
            let hotelsToDisplay = hotels;
            if (selectedStars.length > 0) {
                hotelsToDisplay = hotels.filter(hotel => {
                    const hotelStars = hotel.starRating || 0;
                    return selectedStars.some(star => hotelStars >= star);
                });
            }
            
            renderHotels(hotelsToDisplay);
            
            // Update hero image with hotel image if no curated image exists
            // Use a small delay to ensure DOM is ready
            setTimeout(function() {
                updateHeroImage(destLoc, hotelsToDisplay);
            }, 100);
            
            // Initialize maps if needed
            if (!map && window.innerWidth >= 992) {
                initHotelMap();
            }
            if (!mapMobile && window.innerWidth < 992) {
                initHotelMapMobile();
            }
            
            // Wait a bit for map to initialize, then update markers
            setTimeout(function() {
                if (map && window.innerWidth >= 992) {
                    updateMapMarkers(hotelsToDisplay);
                } else if (mapMobile && window.innerWidth < 992) {
                    updateMapMarkersMobile(hotelsToDisplay);
                } else {
                    // Retry if map not ready
                    if (window.innerWidth >= 992) {
                        initHotelMap();
                        if (map) {
                            updateMapMarkers(hotelsToDisplay);
                        }
                    } else {
                        initHotelMapMobile();
                        if (mapMobile) {
                            updateMapMarkersMobile(hotelsToDisplay);
                        }
                    }
                }
            }, 500);
            
            // Setup hotel detail button click handlers
            $(document).off('click', '.hotel-detail-button').on('click', '.hotel-detail-button', function (e) {
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
                // Use filtered hotels if in filtered view, otherwise use all hotels
                const currentHotels = $('.star-filter:checked').length > 0 ? 
                    allHotels.filter(hotel => {
                        const hotelStars = hotel.starRating || 0;
                        const selectedStars = $('.star-filter:checked').map(function() {
                            return parseInt($(this).val());
                        }).get();
                        return selectedStars.some(star => hotelStars >= star);
                    }) : allHotels;
                const selectedHotel = currentHotels[index];
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

                // Store hotel data for later use
                localStorage.setItem('selectedHotel', JSON.stringify(selectedData));
                
                // Show lead capture modal instead of redirecting
                $('#guestModal').modal('show');
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
        
        // Validate 3-night minimum stay
        if (arrivalDate && departureDate) {
            const checkIn = new Date(convertToYMD(arrivalDate));
            const checkOut = new Date(convertToYMD(departureDate));
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 3) {
                const dateRangeInput = $(this).find('.destinations_date_range');
                const dateRangeError = $(this).find('.destinations_date_range-error');
                dateRangeError.text('Minimum stay is 3 nights. Please select a departure date at least 3 nights after arrival.');
                dateRangeInput.addClass('is-invalid');
                
                // Show toast notification
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Minimum stay is 3 nights. Please adjust your dates.', 'Notice');
                }
                return;
            }
        }
        
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

//Sorting - Preserve current filter state
$('#sort').on('change', function (event) {
    event.preventDefault();
    const sortingValue = $(this).val();
    
    if (!sortingValue || sortingValue === '') {
        return; // Don't sort if no value selected
    }
    
    // Store current star filter selections before sorting
    const selectedStars = $('.star-filter:checked').map(function() {
        return parseInt($(this).val());
    }).get();
    
    Object.assign(formData, {
        sortBy: sortingValue
    });
    // Reset page number to 1 when sorting changes
    formData.pageNumber = 1;
    
    // Fetch hotels with new sorting
    // The fetchHotels function will handle re-applying filters after data loads
    fetchHotels(formData);
    
    // Note: Star filters will be re-applied in fetchHotels success callback
    // since it checks for selected stars and filters accordingly
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

// Initialize Leaflet Map
function initHotelMap() {
    if (typeof L === 'undefined') {
        console.log('Leaflet not loaded yet, retrying...');
        setTimeout(initHotelMap, 500);
        return;
    }

    const mapElement = document.getElementById('hotel-map');
    if (!mapElement) {
        console.log('Map element not found yet, retrying...');
        setTimeout(initHotelMap, 500);
        return;
    }

    // Use destination coordinates - already parsed as numbers
    const destLat = latitude;
    const destLng = longitude;
    
    // Validate coordinates
    if (isNaN(destLat) || isNaN(destLng) || destLat === 0 || destLng === 0) {
        console.error('Invalid coordinates:', destLat, destLng);
        return;
    }
    
    console.log('Initializing Leaflet map at:', [destLat, destLng]);
    
    // Initialize Leaflet map with proper zoom
    map = L.map(mapElement).setView([destLat, destLng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add a marker for the destination location
    destinationMarker = L.marker([destLat, destLng], {
        icon: L.divIcon({
            className: 'destination-marker',
            html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(map);
    
    destinationMarker.bindPopup(destLoc || 'Destination').openPopup();
}

// Wait for Leaflet to load and coordinates to be available
function waitForLeaflet() {
    if (typeof L !== 'undefined' && latitude && longitude && !isNaN(latitude) && !isNaN(longitude)) {
        // Only initialize desktop map if on desktop
        if (window.innerWidth >= 992) {
            initHotelMap();
        }
        // Only initialize mobile map if on mobile and map view is selected
        if (window.innerWidth < 992 && $('input[name="viewMode"]:checked').val() === 'map') {
            initHotelMapMobile();
        }
    } else {
        setTimeout(waitForLeaflet, 100);
    }
}

// Start waiting for Leaflet after coordinates are parsed
$(document).ready(function() {
    // Clear any cached hero image on page load
    const heroSection = $('.hero-section');
    if (heroSection.length) {
        // Force clear background image to prevent caching
        heroSection.css('background-image', 'none');
        // Remove any inline style that might be cached
        const currentBg = heroSection.attr('style');
        if (currentBg) {
            // Remove background-image from style attribute
            const newStyle = currentBg.replace(/background-image[^;]*;?/gi, '');
            heroSection.attr('style', newStyle);
        }
    }
    
    waitForLeaflet();
});

// Initialize mobile map
function initHotelMapMobile() {
    if (typeof L === 'undefined') {
        setTimeout(initHotelMapMobile, 500);
        return;
    }

    const mapElement = document.getElementById('hotel-map-mobile');
    if (!mapElement) {
        setTimeout(initHotelMapMobile, 500);
        return;
    }

    // Use destination coordinates - already parsed as numbers
    const destLat = latitude;
    const destLng = longitude;
    
    // Validate coordinates
    if (isNaN(destLat) || isNaN(destLng) || destLat === 0 || destLng === 0) {
        console.error('Invalid coordinates:', destLat, destLng);
        return;
    }
    
    // Initialize Leaflet map with proper zoom
    mapMobile = L.map(mapElement).setView([destLat, destLng], 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(mapMobile);
    
    // Add destination marker
    destinationMarkerMobile = L.marker([destLat, destLng], {
        icon: L.divIcon({
            className: 'destination-marker',
            html: '<div style="background-color: red; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(mapMobile);
    
    destinationMarkerMobile.bindPopup(destLoc || 'Destination').openPopup();
}

// Update mobile map markers
function updateMapMarkersMobile(hotels) {
    if (!mapMobile) {
        return;
    }
    
    markersMobile.forEach(marker => mapMobile.removeLayer(marker));
    markersMobile = [];
    
    if (hotels.length === 0) {
        mapMobile.setView([latitude, longitude], 13);
        return;
    }
    
    const bounds = [];
    
    // Add destination to bounds
    if (latitude && longitude && !isNaN(latitude) && !isNaN(longitude)) {
        bounds.push([latitude, longitude]);
    }
    
    hotels.forEach((hotel, index) => {
        if (hotel.geoLocation && hotel.geoLocation.latitude && hotel.geoLocation.longitude) {
            const lat = parseFloat(hotel.geoLocation.latitude);
            const lng = parseFloat(hotel.geoLocation.longitude);
            const position = [lat, lng];
            
            // Create custom marker with number
            const marker = L.marker(position, {
                icon: L.divIcon({
                    className: 'hotel-marker',
                    html: `<div style="background-color: #0066cc; color: white; width: 28px; height: 28px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">${index + 1}</div>`,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                })
            }).addTo(mapMobile);
            
            const popupContent = `
                <div style="padding: 10px; max-width: 250px;">
                    <h6 style="margin: 0 0 5px 0; font-weight: bold;">${hotel.displayName || hotel.name}</h6>
                    <p style="margin: 0 0 5px 0; font-size: 12px; color: #666;">${hotel.city || ''}, ${hotel.state || ''}</p>
                    ${hotel.starRating ? `<p style="margin: 0 0 5px 0;">${generateStars(hotel.starRating)}</p>` : ''}
                    <button class="btn btn-sm btn-success mt-2" onclick="window.location.href='#hotel-${index}'">View Details</button>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            markersMobile.push(marker);
            bounds.push(position);
        }
    });
    
    if (bounds.length > 0) {
        const group = new L.featureGroup(markersMobile);
        if (destinationMarkerMobile) {
            group.addLayer(destinationMarkerMobile);
        }
        mapMobile.fitBounds(group.getBounds().pad(0.1));
        
        if (mapMobile.getZoom() > 15) {
            mapMobile.setZoom(15);
        }
    }
}

// Handle window resize - reinitialize maps if needed
$(window).on('resize', function() {
    if (window.innerWidth >= 992) {
        // Desktop: show desktop map, hide mobile map
        $('#map-column-desktop').removeClass('d-none');
        $('#map-column-mobile').hide();
        if (!map) {
            initHotelMap();
        }
    } else {
        // Mobile: hide desktop map
        $('#map-column-desktop').addClass('d-none');
        if ($('input[name="viewMode"]:checked').val() === 'map') {
            $('#map-column-mobile').show();
            if (!mapMobile) {
                initHotelMapMobile();
            }
        }
    }
});

// View Toggle (List/Map) - Mobile only
$('input[name="viewMode"]').on('change', function() {
    const viewMode = $(this).val();
    
    // Only apply on mobile (desktop always shows both)
    if (window.innerWidth < 992) {
        if (viewMode === 'map') {
            // Hide list and filters, show only map
            $('#results-column').addClass('d-none');
            $('#filters-sidebar').addClass('d-none');
            $('#map-column-mobile').show();
            
            // Initialize mobile map if not already initialized
            if (!mapMobile) {
                initHotelMapMobile();
            }
            
            // Update map with current hotels
            if (mapMobile && allHotels.length > 0) {
                const selectedStars = $('.star-filter:checked').map(function() {
                    return parseInt($(this).val());
                }).get();
                
                let hotelsToDisplay = allHotels;
                if (selectedStars.length > 0) {
                    hotelsToDisplay = allHotels.filter(hotel => {
                        const hotelStars = hotel.starRating || 0;
                        return selectedStars.some(star => hotelStars >= star);
                    });
                }
                updateMapMarkersMobile(hotelsToDisplay);
            }
        } else {
            // Show list and filters, hide map
            $('#results-column').removeClass('d-none');
            $('#filters-sidebar').removeClass('d-none');
            $('#map-column-mobile').hide();
        }
    }
});

// Star Rating Filter
$('.star-filter').on('change', function() {
    const selectedStars = $('.star-filter:checked').map(function() {
        return parseInt($(this).val());
    }).get();
    
    filterHotelsByStars(selectedStars);
});

// Filter hotels by star rating
function filterHotelsByStars(selectedStars) {
    if (selectedStars.length === 0) {
        // Show all hotels if no filter selected
        renderHotels(allHotels);
        // Update hero image
        updateHeroImage(destLoc, allHotels);
        if (window.innerWidth >= 992) {
            if (map) {
                updateMapMarkers(allHotels);
            } else {
                initHotelMap();
                setTimeout(function() {
                    if (map) updateMapMarkers(allHotels);
                }, 500);
            }
        } else {
            if (mapMobile) {
                updateMapMarkersMobile(allHotels);
            } else {
                initHotelMapMobile();
                setTimeout(function() {
                    if (mapMobile) updateMapMarkersMobile(allHotels);
                }, 500);
            }
        }
        return;
    }
    
    const filteredHotels = allHotels.filter(hotel => {
        const hotelStars = hotel.starRating || 0;
        return selectedStars.some(star => hotelStars >= star);
    });
    
    renderHotels(filteredHotels);
    // Update hero image with filtered hotels
    updateHeroImage(destLoc, filteredHotels);
    if (window.innerWidth >= 992) {
        if (map) {
            updateMapMarkers(filteredHotels);
        } else {
            initHotelMap();
            setTimeout(function() {
                if (map) updateMapMarkers(filteredHotels);
            }, 500);
        }
    } else {
        if (mapMobile) {
            updateMapMarkersMobile(filteredHotels);
        } else {
            initHotelMapMobile();
            setTimeout(function() {
                if (mapMobile) updateMapMarkersMobile(filteredHotels);
            }, 500);
        }
    }
}

// Update map markers
function updateMapMarkers(hotels) {
    if (!map) {
        console.log('Map not initialized yet, cannot update markers');
        return;
    }
    
    // Clear existing markers (except destination marker)
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    if (hotels.length === 0) {
        // If no hotels, just center on destination
        map.setView([latitude, longitude], 13);
        return;
    }
    
    const bounds = [];
    
    // Add destination to bounds
    if (latitude && longitude && !isNaN(latitude) && !isNaN(longitude)) {
        bounds.push([latitude, longitude]);
    }
    
    hotels.forEach((hotel, index) => {
        if (hotel.geoLocation && hotel.geoLocation.latitude && hotel.geoLocation.longitude) {
            const lat = parseFloat(hotel.geoLocation.latitude);
            const lng = parseFloat(hotel.geoLocation.longitude);
            const position = [lat, lng];
            
            // Create custom marker with number
            const marker = L.marker(position, {
                icon: L.divIcon({
                    className: 'hotel-marker',
                    html: `<div style="background-color: #0066cc; color: white; width: 28px; height: 28px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">${index + 1}</div>`,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                })
            }).addTo(map);
            
            // Popup content
            const popupContent = `
                <div style="padding: 10px; max-width: 250px;">
                    <h6 style="margin: 0 0 5px 0; font-weight: bold;">${hotel.displayName || hotel.name}</h6>
                    <p style="margin: 0 0 5px 0; font-size: 12px; color: #666;">${hotel.city || ''}, ${hotel.state || ''}</p>
                    ${hotel.starRating ? `<p style="margin: 0 0 5px 0;">${generateStars(hotel.starRating)}</p>` : ''}
                    <button class="btn btn-sm btn-success mt-2" onclick="window.location.href='#hotel-${index}'">View Details</button>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            markers.push(marker);
            bounds.push(position);
        }
    });
    
    // Fit map to show all markers and destination
    if (bounds.length > 0) {
        const group = new L.featureGroup(markers);
        if (destinationMarker) {
            group.addLayer(destinationMarker);
        }
        map.fitBounds(group.getBounds().pad(0.1));
        
        // Ensure minimum zoom level
        if (map.getZoom() > 15) {
            map.setZoom(15);
        }
    }
}

// Extract render logic to separate function
function renderHotels(hotels) {
    const container = $('#hotel-results');
    container.empty();
    
    if (hotels.length === 0) {
        container.append('<div class="alert alert-info text-center col-md-12">No hotels match your filters.</div>');
        return;
    }
    
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
                <div class="card shadow p-2" id="hotel-${index}">
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

                                        <h4 class="card-title mb-1 hotel-detail-button" data-index="${index}">
                                    <a href="#">${hotel.displayName || hotel.name}</a>
                                </h4>
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
                                                    <h4 class="fw-bold text-dark mb-1">$${formatPrice(hotel.publicPrices[0].price)}</h4>
                                                    <div class="text-dark fw-semibold" style="font-size: 0.75rem;">Total Price incl. taxes</div>
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
                                                <h4 class="fw-bold text-success mb-1">$${(hotel.price - 200) >= 0 ? formatPrice(hotel.price - 200) : formatPrice(12 * diffDate)}</h4>
                                                <div class="text-dark fw-semibold" style="font-size: 0.75rem;">Total Price incl. taxes</div>
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
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').each(function() {
        new bootstrap.Tooltip(this);
    });
}
