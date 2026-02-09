const container = $('#hotel-results');
const localContainer = $('<div></div>');
const destinationIdMap = {
    'Las Vegas, NV': 94511,
    'Orlando, FL': 34467,
    'Miami, FL': 28632,
    'Myrtle Beach, SC': 145014,
    'Gatlinburg, TN': 150747,
    'Pigeon Forge, TN': 151709,
    'Hilton Head, SC': 144760,
    'Branson, MO': 87419,
    'Virginia Beach, VA': 171657,
    'Park City, UT': 163309
};
const stateMap = {
    'Nevada': 'NV',
    'Florida': 'FL',
    'South Carolina': 'SC',
    'Tennessee': 'TN',
    'Missouri': 'MO',
    'Virginia': 'VA',
    'Utah': 'UT'
};
let apiData = {};
let currentApiHotels = [];
const urlParams = new URLSearchParams(window.location.search);
const packages = {
    init: function () {
        this.list();

        // Hide edit package section if price exists in URL
        if (urlParams.get('price')) {
            $('#edit_package').hide();
        }

        // Call on page load
        const initialExperience = atob(urlParams.get('experience') || '');
        if (initialExperience) {
            this.loadDestinations(initialExperience);
        }

        // Call on experience change
        this.bindExperienceChange();
    },
    bindExperienceChange: function () {
        $(document).on('change', '#experience', (e) => {
            const experience = $(e.target).val();
            if (experience) {
                this.loadDestinations(experience);
            }
        });
    },
    loadDestinations: function (experience) {
        $('#loader').show();
        $.ajax({
            url: 'get-destination-by-experience.php',
            type: 'POST',
            data: { experience: experience },
            dataType: 'json',
            success: function (response) {
                try {
                    const parsed = typeof response === 'string' ? JSON.parse(response) : response;
                    const destinationSelect = document.querySelector('select[name="destination"]');
                    const newChoices = parsed.map(value => ({
                        value: value.id,
                        label: `${value.city}, ${value.state}`
                    }));

                    if (destinationSelect?.choicesInstance) {
                        destinationSelect.choicesInstance.clearStore();

                        if (newChoices.length > 0) {
                            destinationSelect.choicesInstance.setChoices(newChoices, 'value', 'label', true);
                            // Only set the value from URL if it exists and we're not editing search
                            const urlDestination = atob(urlParams.get('destination_name') || '');
                            if (urlDestination && !$('#collapseFilter').hasClass('show')) {
                                destinationSelect.choicesInstance.setValue([urlDestination]);
                            }
                        } else {
                            destinationSelect.choicesInstance.setChoices([{
                                value: '',
                                label: 'No destinations found',
                                disabled: true
                            }], 'value', 'label', true);
                        }

                    } else {
                        $(destinationSelect).empty();
                        if (parsed?.length > 0) {
                            $.each(parsed, function (index, value) {
                                $(destinationSelect).append(`<option value="${value.id}">${value.city}, ${value.state}</option>`);
                            });

                        } else {
                            $(destinationSelect).append(`<option value="" disabled>No destinations found</option>`);
                        }
                    }

                } catch (e) {
                    console.error('Invalid JSON response:', e);
                }
                $('#loader').hide();
            },
            error: function () {
                $('#loader').hide();
            }
        });
    },
    list: function () {
        const arrival = urlParams.get('checkIn');
        const adults = parseInt(atob(urlParams.get('adults'))) || 2;
        const childAges = (atob(urlParams.get('child')) || '')
            .split(',')
            .map(age => parseInt(age))
            .filter(age => !isNaN(age) && age >= 0);
        $('#destination-name').text((urlParams.get('destination_name') ? atob(urlParams.get('destination_name')) : '') + (urlParams.get('price') ? ' $' + atob(urlParams.get('price')) : ''));
        $('#package_arrival_date').val(arrival ? formatDate(atob(arrival)) : '');
        /*To show selected value in calendar */
        e.flatPicker();
        if ($("#package_arrival_date")[0]._flatpickr) {
            $("#package_arrival_date")[0]._flatpickr.setDate(formatDate(atob(arrival)), true);
        }
        updateChoice('experience', atob(urlParams.get('experience') || ''));
        $('.adults').text(adults);
        $('.child').text(childAges.length);

        const guestText = (adults + childAges.length) > 1 ? "Guests" : "Guest";
        const childText = childAges.length > 1 ? "Children" : "Child";

        $('#package-selection-result').val(`${adults + childAges.length} ${guestText} ${childAges.length} ${childText}`);
        const hasCheckoutAndPrice = urlParams.get('checkOut') && urlParams.get('price');
        const params = hasCheckoutAndPrice
            ? ['experience', 'destination_id', 'destination_name', 'checkIn', 'checkOut', 'adults', 'child', 'price']
            : ['experience', 'destination_id', 'destination_name', 'checkIn', 'adults', 'child'];
        const data = Object.fromEntries(params.map(param => [param, atob(urlParams.get(param)) || '']));

        this.fetchPackages(data);
    },
    fetchPackages: function (data) {
        $.ajax({
            url: 'package_list.php',
            method: 'POST',
            data: data,
            beforeSend: () => packages.showSkeletonLoaders(4),
            success: (response) => {
                packages.hideSkeletonLoaders();
                const jsonData = JSON.parse(response);
                container.empty();

                if (jsonData.count === 0) {
                    container.append('<div class="alert alert-danger text-center col-md-12">No data found.</div>');
                    return;
                }

                const localHotels = jsonData.data.filter(pkg => pkg.use_hotel_api === 'No');
                const apiHotels = jsonData.data.filter(pkg => pkg.use_hotel_api === 'Yes');
                // Initialize localData
                let localData = '';

                if (localHotels.length > 0) {
                    localData = localHotels.map((hotel, index) => this.renderLocalHotelCard(hotel, container, index)).join('');
                    localContainer.append(localData);
                    container.append(localContainer);
                }

                // 🟡 If no price, call fetch per hotel
                if (apiHotels.length > 0) {
                    const firstHotel = apiHotels[0];
                    if (firstHotel?.price === undefined) {
                        apiHotels.forEach(hotel => {
                            const requestData = { ...data, checkOut: hotel.checkOut };
                            this.fetchApiHotels(requestData, [hotel], localData);
                        });
                    } else if (firstHotel.price > 0) {
                        const grouped = this.groupHotelsByLocation(apiHotels);
                        Object.keys(grouped).forEach(code => {
                            this.fetchApiHotels({ ...data, destination_id: code }, grouped[code], localData);
                        });
                    }
                }

                // Append local hotels if no API ones found
                if (apiHotels.length === 0 && localContainer.children().length > 0) {
                    container.append(localContainer);
                }
            },
            error: (xhr, status) => {
                packages.hideSkeletonLoaders();
                container.empty();
                const errorDetails = status === 'timeout'
                    ? 'The request took too long to complete.'
                    : xhr.status === 0
                        ? 'Unable to connect to the server.'
                        : 'No results found.';

                container.append(`
                    <div class="alert text-center col-md-12">
                        <h4 class="mb-3">Oops! We got lost on the way...</h4>
                        <p>${errorDetails}</p>
                        <p class="mb-0">Try changing your search criteria.</p>
                    </div>
                `);
            }
        });
    },

    // 🔁 Group hotels by location
    groupHotelsByLocation: function (apiHotels) {
        return apiHotels.reduce((acc, hotel) => {
            const loc = hotel.location_code;
            if (!acc[loc]) acc[loc] = [];
            acc[loc].push(hotel);
            return acc;
        }, {});
    },
    onPageChange: function (newPage) {
        packages.fetchApiHotels({ pageNumber: newPage }, currentApiHotels);
    },

    fetchApiHotels: function (data, apiHotels = []) {
        let requestPayload;
        let maxCost = '';
        let previewRate = apiHotels[0]?.preview_rate;
        let nights = apiHotels[0]?.nights;
        let cost = previewRate * nights;

        if (cost < 150 && nights == 2) {
            maxCost = 150;
        } else if (cost < 225 && nights == 3) {
            maxCost = 225;
        } else if (cost < 300 && nights == 4) {
            maxCost = 300;
        } else {
            maxCost = 400
        }

        // 👇 Check if we have a cached payload (i.e., this is a pagination request)
        if (this.cachedRequestPayload && data.pageNumber) {
            requestPayload = JSON.parse(JSON.stringify(this.cachedRequestPayload));
            requestPayload.pageNumber = data.pageNumber;
        } else {
            requestPayload = {
                hotelsRequest: {
                    residency: "US",
                    locationCode: data.destination_id ?? String(data),
                    location: {
                        code: data.destination_id ?? String(data),
                        name: data.destination_name ?? "",
                        type: "City",
                        geoLocation: {
                            latitude: "0.0",
                            longitude: "0.0"
                        }
                    },
                    checkIn: data.checkIn ?? atob(urlParams.get('checkIn')),
                    checkOut: data.checkOut ?? atob(urlParams.get('checkOut')),
                    rooms: [
                        {
                            adultsCount: !isNaN(parseInt(data.adults)) ? parseInt(data.adults) : 2,
                            kidsAges: []
                        }
                    ]
                },
                filter: {
                    accessibilities: [],
                    accommodationType: [],
                    amenities: [],
                    boardNames: [],
                    budgetRanges: [{ to: maxCost }],
                    neighbourhoods: [],
                    popularLocations: [],
                    refundable: [],
                    starRatings: data.starRatings ?? [],
                    propertyName: "",
                    distanceInMiles: 10,
                    exactSearch: true
                },
                sortBy: "BiggestSavingsPercentage",
                pageNumber: typeof data.pageNumber !== 'undefined' ? data.pageNumber : 1,
                pageSize: 10,
                quick: false,
                searchHomes: "All",
                currency: "USD",
                sessionKey: null
            };
            // ✅ Save this complete payload for pagination
            this.cachedRequestPayload = JSON.parse(JSON.stringify(requestPayload));
        }

        currentApiHotels = apiHotels;

        // Send API request
        $.ajax({
            type: 'POST',
            url: 'hotel_search_api_call.php',
            data: JSON.stringify(requestPayload),
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            beforeSend: () => packages.showSkeletonLoaders(4),
            success: (apiResponse) => {
                packages.hideSkeletonLoaders();
                container.append(localContainer);

                const hotels = apiResponse.searchHotels || [];

                if (hotels.length > 0) {
                    hotels.forEach((hotel, index) => {
                        this.renderHotelCard(hotel, container, apiHotels, requestPayload.hotelsRequest.locationCode);
                    });

                    if (apiResponse?.counters?.totalFilteredHotels > 10) {
                        renderPagination(
                            apiResponse.counters.totalFilteredHotels,
                            requestPayload.pageNumber,
                            requestPayload.pageSize,
                            packages.onPageChange
                        );
                    }
                } else {
                    container.append('<div class="alert alert-danger text-center col-md-12">No data found.</div>');
                }
            },
            error: (xhr, status) => {
                packages.hideSkeletonLoaders();
                container.empty();

                let errorDetails = 'For some reason we did not find any results for your search.';
                if (status === 'timeout') {
                    errorDetails = 'The request took too long to complete.';
                } else if (xhr.status === 0) {
                    errorDetails = 'Unable to connect to the server.';
                }

                container.append(`
                    <div class="alert text-center col-md-12">
                        <h4 class="mb-3">Oops! We got lost on the way...</h4>
                        <p>${errorDetails}</p>
                        <p class="mb-0">Don't worry! Try again but changing your search criteria.</p>
                    </div>
                `);
            }
        });
    },

    renderLocalHotelCard: function (hotel, container, index) {
        const arrivalDate = new Date(hotel.arrival);
        const departureDate = new Date(arrivalDate.getTime() + hotel.nights * 24 * 60 * 60 * 1000);
        const checkOutDate = departureDate.toISOString().split('T')[0];
        // Calculate date difference in days
        const diffDate = Math.round((departureDate - arrivalDate) / (1000 * 3600 * 24));
        let includePerks = [];
        if (hotel.include_perks) {
            try {
                includePerks = JSON.parse(`[${hotel.include_perks}]`);
            } catch (e) {
                console.error('Error parsing include_perks:', e);
                includePerks = [];
            }
        }

        const amenitiesHTML = includePerks.map(perksArray => {
            return perksArray.map(a => {
              const amenityName = a.split('(')[0].trim();
              return `<li class="nav-item">${amenityName}</li>`;
            }).join('');
          }).join('');

        // For local hotels, use the destination_id as location code
        const locationCode = $('#destination').val() || '';
        const card = `
                <div class="card shadow p-2">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="admin/uploads/${hotel.image ? hotel.image : 'assets/images/heros/image-not-available.jpg'}" class="card-img rounded-2 hotel-image" alt="No hotel image available">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body py-md-2 d-flex flex-column h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-1 package-button" data-hotel-data='${JSON.stringify(hotel)}' data-location-code="${locationCode}" data-package-id="${hotel.id}"  data-checkout="${checkOutDate}" data-everyday-travsaver-rate="${hotel.everyday_rate}"><a href="#">${hotel.package_title}</a></h4>
                                    <ul class="list-inline mb-0 z-index-2">
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-sm btn-round btn-light heart-btn" data-package-name="${hotel.package_title}" data-hotel-data='${JSON.stringify(hotel)}' title="Save Package for Later"><i class="fa-regular fa-fw fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <small><i class="bi bi-geo-alt me-2"></i>${hotel.city}, ${hotel.state}</small>
                                <ul class="nav nav-divider mt-3">
                                    ${amenitiesHTML}
                                </ul>
                                <ul class="list-group list-group-borderless h5 mb-0 mt-lg-3">
                                    <li class="list-group-item d-flex text-info p-0">
                                        <i class="bi bi-clock me-2"></i>${diffDate > 0 ? diffDate : hotel.nights} Nights
                                    </li>
                                    <li class="list-group-item d-flex text-info p-0 mt-lg-2">
                                        <i class="bi bi-geo-fill me-2"></i>${hotel?.name}
                                    </li>
                                </ul>
                                ${(() => {
                const price = urlParams.get('price');
                let displayPrice;
                
                if (price) {
                    // Use price from URL if available
                    const decodedPrice = atob(price);
                    displayPrice = decodedPrice;
                } else {
                    // Calculate price based on hotel data
                    const price = hotel.preview_rate * hotel.nights;
                    
                    if (hotel.nights === 2 && price < 150) {
                        displayPrice = '49';
                    } else if (hotel.nights === 3 && price < 225) {
                        displayPrice = '99';
                    } else if (hotel.nights === 4 && price < 300) {
                        displayPrice = '199';
                    } else {
                        displayPrice = '399';
                    }
                }
                
                const includedText = (() => {
                    switch (displayPrice) {
                        case '49':
                            return '2 Nights + $50 Dining Discount + $50 Hotel Card for use on next trip';
                        case '99':
                            return '3 Nights + $100 Dining Discount + $100 Hotel Card for use on next trip';
                        case '199':
                            return '4 Nights + $100 Dining Discount + $200 Condo Card for use on next trip';
                        case '399':
                            return '4 night All-Inclusive stays + $400 Condo Card for use on next trip';
                        default:
                            return '';
                    }
                })();

                return includedText ? `
                                    <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto price-card">
                                        <div class="d-flex align-items-center">
                                            <span class="mb-0 me-1">Included: ${includedText}</span>
                                            <h3 class="fw-bold text-dark mb-0 me-1" class="resort-preview-rate-included"></h3>
                                        </div>
                                    </div>` : '';
            })()}
                                <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto price-card">
                                    <div class="d-flex align-items-center">
                                        
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-sm-between align-items-center mt-1 price-card">
                                    <div class="d-flex align-items-center me-3">
                                    <span class="mb-0 me-1">Resort Preview Rate: </span>
                                        <h3 class="fw-bold text-dark mb-0 me-1 resort-preview-rate-main">$${(() => {
                const rawPrice = urlParams.get('price');
                if (!rawPrice) {
                    const price = hotel.preview_rate * hotel.nights;

                    let displayPrice;
                    if (hotel.nights === 2 && price < 150) {
                        displayPrice = 49;
                    } else if (hotel.nights === 3 && price < 225) {
                        displayPrice = 99;
                    } else if (hotel.nights === 4 && price < 300) {
                        displayPrice = 199;
                    } else {
                        displayPrice = 399;
                    }
                    return displayPrice;
                }

                try {
                    const decodedPrice = atob(rawPrice);
                    return decodedPrice;
                } catch (e) {
                    console.error('Error decoding price:', e);
                    const calculatedPrice = (hotel.price - 200) / diffDate;
                    return calculatedPrice >= 0 ? formatPrice(calculatedPrice) : '12';
                }
            })()}</h3>
                                    </div>
                                    <div class="mt-3 mt-sm-0">
                                        <button class="btn btn-lg btn-success mb-0 w-100 package-button" data-hotel-data='${JSON.stringify(hotel)}' data-package-id="${hotel.id}" data-location-code="${locationCode}" data-checkout="${checkOutDate}" data-everyday-travsaver-rate="${hotel?.everyday_rate}">Package Details <i class="bi bi-chevron-double-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        return card;
    },
    renderHotelCard: function (hotel, container, packageData = '', locationCode = '') {
        if (!locationCode && hotel.city && hotel.state) {
            const fullState = stateMap[hotel.state] || hotel.state;
            const cityState = `${hotel.city}, ${fullState}`;
            locationCode = destinationIdMap[cityState] || '';
        }
        const checkInDate = formatDate(hotel?.arrival || hotel?.possibleStays[0]?.checkIn);
        const checkOutDate = (hotel?.departure || hotel?.possibleStays[0]?.checkOut);
        const diffDate = calculateDateDifference(checkInDate, checkOutDate);

        // Fix: Add proper validation for packageData and include_perks
        let includePerks = [];
        if (packageData[0] && packageData[0].include_perks) {
            try {
                includePerks = JSON.parse(`[${packageData[0].include_perks}]`);
            } catch (e) {
                console.error('Error parsing include_perks:', e);
                includePerks = [];
            }
        }

        const amenitiesHTML = includePerks.map(perksArray => {
            return perksArray.map(a => {
              const amenityName = a.split('(')[0].trim();
              return `<li class="nav-item">${amenityName}</li>`;
            }).join('');
          }).join('');

        const stars = generateStars(hotel.starRating || 0);
        const packageTitle = packageData && packageData[0] ? packageData[0].package_title : hotel.package_title;
        const card = `
                <div class="card shadow p-2">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="${hotel.images ? hotel.images[0].url : 'assets/images/heros/image-not-available.jpg'}" class="card-img rounded-2 hotel-image" alt="No hotel image available">
                        </div>
                        
                        <div class="col-md-7">
                            <div class="card-body py-md-2 d-flex flex-column h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                            <ul class="list-inline mb-0">
                                                ${stars}
                                            </ul>

                                            <ul class="list-inline mb-0 z-index-2">
                                                <li class="list-inline-item">
                                                    <a href="#" class="btn btn-sm btn-round btn-light heart-btn" data-package-name="${packageTitle}" data-hotel-data='${JSON.stringify(hotel)}' title="Save Package for Later"><i class="fa-regular fa-fw fa-heart"></i></a>
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
                                <h4 class="card-title mb-1 package-button" data-hotel-data='${JSON.stringify(hotel)}' data-location-code="${locationCode}" data-package-id="${packageData && packageData[0] ? packageData[0].id : ''}"  data-checkout="${checkOutDate}" data-everyday-travsaver-rate1="${hotel.publicPrices[0].price}" data-package-name="${packageTitle}"><a href="#">${packageTitle}</a></h4>
                                <small><i class="bi bi-geo-alt me-2"></i>${hotel.city}, ${hotel.state}</small>
                                <ul class="nav nav-divider mt-3">${amenitiesHTML}</ul>
                                <ul class="list-group list-group-borderless h5 mb-0 mt-lg-3">
                                    <li class="list-group-item d-flex text-info p-0 hotel-nights">
                                        <i class="bi bi-clock me-2"></i>${diffDate > 0 ? diffDate : hotel.nights} Nights
                                    </li>
                                    <li class="list-group-item d-flex text-info p-0 mt-lg-2">
                                        <i class="bi bi-geo-fill me-2"></i>${hotel.displayName || hotel.name}
                                    </li>
                                </ul>
                                
                                ${(() => {
                const price = urlParams.get('price');
                let displayPrice;
                
                if (price) {
                    // Use price from URL if available
                    const decodedPrice = atob(price);
                    displayPrice = decodedPrice;
                } else {
                    // Calculate price based on package data
                    const price = packageData && packageData[0] ? (packageData[0].preview_rate * packageData[0].nights) : 0;
                    
                    if (packageData && packageData[0] && packageData[0].nights === 2 && price < 150) {
                        displayPrice = '49';
                    } else if (packageData && packageData[0] && packageData[0].nights === 3 && price < 225) {
                        displayPrice = '99';
                    } else if (packageData && packageData[0] && packageData[0].nights === 4 && price < 300) {
                        displayPrice = '199';
                    } else {
                        displayPrice = '399';
                    }
                }
                
                const includedText = (() => {
                    switch (displayPrice) {
                        case '49':
                            return '2 Nights + $50 Dining Discount + $50 Hotel Card for use on next trip';
                        case '99':
                            return '3 Nights + $100 Dining Discount + $100 Hotel Card for use on next trip';
                        case '199':
                            return '4 Nights + $100 Dining Discount + $200 Condo Card for use on next trip';
                        case '399':
                            return '4 night All-Inclusive stays + $400 Condo Card for use on next trip';
                        default:
                            return '';
                    }
                })();

                return includedText ? `
                                    <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto price-card">
                                        <div class="d-flex align-items-center">
                                            <span class="mb-0 me-1">Included: ${includedText}</span>
                                            <h3 class="fw-bold text-dark mb-0 me-1" class="resort-preview-rate-included"></h3>
                                        </div>
                                    </div>` : '';
            })()}
                                
                                <div class="d-sm-flex justify-content-sm-between align-items-center mt-3 mt-md-auto price-card">
                                    <div class="d-flex align-items-center">
                                       
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-sm-between align-items-center mt-1 price-card">
                                    <div class="d-flex align-items-center me-3">
                                     <span class="mb-0 me-1">Resort Preview Rate: </span>
                                        <h3 class="fw-bold text-dark mb-0 me-1 resort-preview-rate-main">$${(() => {
                const rawPrice = urlParams.get('price');
                if (!rawPrice) {
                    const price = packageData && packageData[0] ? (packageData[0].preview_rate * packageData[0].nights) : 0;
                    let displayPrice;
                    if (packageData && packageData[0] && packageData[0].nights === 2 && price < 150) {
                        displayPrice = 49;
                    } else if (packageData && packageData[0] && packageData[0].nights === 3 && price < 225) {
                        displayPrice = 99;
                    } else if (packageData && packageData[0] && packageData[0].nights === 4 && price < 300) {
                        displayPrice = 199;
                    } else {
                        displayPrice = 399;
                    }
                    return displayPrice;
                }

                try {
                    const decodedPrice = atob(rawPrice);
                    return decodedPrice;
                } catch (e) {
                    console.error('Error decoding price:', e);
                    const calculatedPrice = (hotel.price - 200) / diffDate;
                    return calculatedPrice >= 0 ? formatPrice(calculatedPrice) : '12';
                }
            })()}</h3>
                                    </div>
                                    <div class="mt-3 mt-sm-0">
                                        <button class="btn btn-lg btn-success mb-0 w-100 package-button" data-hotel-data='${JSON.stringify(hotel)}' data-package-id="${packageData && packageData[0] ? packageData[0].id : ''}" data-location-code="${locationCode}"  data-checkout="${checkOutDate}" data-everyday-travsaver-rate="${hotel.publicPrices[0].price}">Package Details <i class="bi bi-chevron-double-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        container.append(card);

    },

    showSkeletonLoaders: function (count = 3) {
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
    },

    hideSkeletonLoaders: function () {
        const container = $('#hotel-results');
        container.find('.skeleton-list-card').remove();
    }
};

packages.init();

// Heart button click handler
$(document).on('click', '.heart-btn', function (e) {
    e.preventDefault();
    e.stopPropagation();
    
    const hotelData = $(this).data('hotel-data');
    const hotelName = hotelData?.displayName || hotelData?.name || 'Hotel';
    const hotelLocation = `${hotelData?.city || ''}, ${hotelData?.state || ''}`;
    const hotelImage = hotelData?.images && hotelData.images.length > 0 ? hotelData.images[0].url : (hotelData?.image || 'assets/images/heros/image-not-available.jpg');
    
    // Check if already saved
    const isSaved = $(this).find('i').hasClass('fa-solid');
    
    if (isSaved) {
        // Remove from saved packages
        const heartIcon = $(this).find('i');
        heartIcon.removeClass('fa-solid text-danger').addClass('fa-regular');
        $(this).removeClass('btn-danger').addClass('btn-light');
        
        // Show removal message
        if (typeof successToaster !== 'undefined') {
            successToaster(`${hotelName} has been removed from your saved packages!`, 'Package Removed');
        } else {
            alert(`${hotelName} has been removed from your saved packages!`);
        }
    } else {
        // Show traveler info modal directly
        $('#package-name').val($(this).data('package-name'));
        $('#traveler-modal-hotel-image').attr('src', hotelImage);
        $('#traveler-modal-hotel-name').text(hotelName);
        $('#traveler-modal-hotel-location').text(hotelLocation);
        
        // Store hotel data for traveler info functionality
        $('#submitTravelerInfoBtn').data('hotel-data', hotelData);
        
        // Show the traveler info modal
        const travelerModal = new bootstrap.Modal(document.getElementById('travelerInfoModal'));
        travelerModal.show();
    }
});



// Submit traveler info button click handler
$(document).on('click', '#submitTravelerInfoBtn', function (e) {
    e.preventDefault();
    
    const hotelData = $(this).data('hotel-data');
    
    // Clear previous error states
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').hide();
    
    // Validate form fields using project's standard validation functions
    const isFirstNameValid = validateInput(
        $('#travelerFirstName'), 
        $('#travelerFirstName-error'), 
        'Please enter first name'
    );
    
    // Show/hide error element for first name
    if (!isFirstNameValid) {
        $('#travelerFirstName-error').show();
    } else {
        $('#travelerFirstName-error').hide();
    }
    
    const isLastNameValid = validateInput(
        $('#travelerLastName'), 
        $('#travelerLastName-error'), 
        'Please enter last name'
    );
    
    // Show/hide error element for last name
    if (!isLastNameValid) {
        $('#travelerLastName-error').show();
    } else {
        $('#travelerLastName-error').hide();
    }
    
    const isEmailValid = validateInput(
        $('#travelerEmail'), 
        $('#travelerEmail-error'), 
        'Please enter email address'
    );
    
    // Show/hide error element for email
    if (!isEmailValid) {
        $('#travelerEmail-error').show();
    } else {
        $('#travelerEmail-error').hide();
    }
    
    const isPhoneValid = validateInput(
        $('#travelerPhone'), 
        $('#travelerPhone-error'), 
        'Please enter phone number',
        { numeric: true, digitsBetween: [10, 15] }
    );
    
    // Show/hide error element for phone
    if (!isPhoneValid) {
        $('#travelerPhone-error').show();
    } else {
        $('#travelerPhone-error').hide();
    }
    
    const isPermissionValid = validateCheckobox(
        $('#permissionToContact'), 
        $('#permissionToContact-error'), 
        'You must agree to be contacted'
    );
    
    // If any validation fails, stop here
    if (!isFirstNameValid || !isLastNameValid || !isEmailValid || !isPhoneValid || !isPermissionValid) {
        return;
    }
    
    // Prepare form data for submission
    const formData = {
        packageName: $('#package-name').val().trim(),
        firstName: $('#travelerFirstName').val().trim(),
        lastName: $('#travelerLastName').val().trim(),
        email: $('#travelerEmail').val().trim(),
        phone: $('#travelerPhone').val().trim(),
        permissionToContact: $('#permissionToContact').is(':checked'),
        hotelData: hotelData
    };
    let frm = $(this);
    // Show loading state
    const submitBtn = $('#submitTravelerInfoBtn');
    const originalText = submitBtn.html();
    submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...');
    
    // Send data to server
    $.ajax({
        type: 'POST',
        url: 'save-package.php',
        data: formData, // remove the JSON.stringify() call
        contentType: 'application/x-www-form-urlencoded', // change the content type
        dataType: 'json',
        success: function(response) {
            // Restore button state
            submitBtn.prop('disabled', false).html(originalText);
            
            if (response.status === 'success') {
                const hotelName = hotelData?.displayName || hotelData?.name || 'Hotel';
                
                // Close the modal
                const travelerModal = bootstrap.Modal.getInstance(document.getElementById('travelerInfoModal'));
                travelerModal.hide();
                
                // Reset form
                $('#travelerInfoForm')[0].reset();
                
                // Show success message
                if (typeof successToaster !== 'undefined') {
                    successToaster(`${hotelName} package has been saved for later! We'll contact you soon.`, 'Package Saved');
                } else {
                    alert(`${hotelName} package has been saved for later! We'll contact you soon.`);
                }
                
                // Change the heart icon to filled to indicate it's saved
                const heartIcon = $(`.heart-btn[data-hotel-data='${JSON.stringify(hotelData)}'] i`);
                heartIcon.removeClass('fa-regular text-danger').addClass('fa-solid fa-fw fa-heart');
                heartIcon.parent().removeClass('btn-light').addClass('btn-light');
            } else {
                if (typeof errorToaster !== 'undefined') {
                    errorToaster(response.error || 'Failed to save package', 'Error');
                } else {
                    alert('Error: ' + (response.error || 'Failed to save package'));
                }
            }
        },
        error: function(xhr, status, error) {
            // Restore button state
            submitBtn.prop('disabled', false).html(originalText);
            
            if (typeof errorToaster !== 'undefined') {
                errorToaster('Failed to save package. Please try again.', 'Error');
            } else {
                alert('Failed to save package. Please try again.');
            }
        }
    });
});

// Real-time validation for traveler info form
$(document).on('input', '#travelerFirstName', function() {
    if ($(this).val().trim()) {
        $(this).removeClass('is-invalid');
        $('#travelerFirstName-error').hide();
    }
});

$(document).on('input', '#travelerLastName', function() {
    if ($(this).val().trim()) {
        $(this).removeClass('is-invalid');
        $('#travelerLastName-error').hide();
    }
});

$(document).on('input', '#travelerEmail', function() {
    if ($(this).val().trim()) {
        $(this).removeClass('is-invalid');
        $('#travelerEmail-error').hide();
    }
});

$(document).on('input', '#travelerPhone', function() {
    if ($(this).val().trim()) {
        $(this).removeClass('is-invalid');
        $('#travelerPhone-error').hide();
    }
});

$(document).on('change', '#permissionToContact', function() {
    if ($(this).is(':checked')) {
        $(this).removeClass('is-invalid');
        $('#permissionToContact-error').hide();
    }
});


$(document).on('click', '.package-button', function (e) {
    e.preventDefault();
    const hotelData = $(this).data('hotel-data');
    const hotelId = hotelData.hotelId;
    const hotelName = hotelData?.displayName;
    const hotelAddress = hotelData?.address;
    const hotelImage = hotelData ? (hotelData.images && hotelData.images.length > 0 ? hotelData.images[0].url : hotelData.image) : '';
    const packageId = $(this).data('package-id');
    const destinationId = $(this).data('location-code');
    const destinationName = $('#destination option:selected').text();
    const arrival = convertToYMD($('#package_arrival_date').val());
    const departure = $(this).data('checkout');
    const adults = $('.adults').text();
    const child = $('.child').text();
    const childAges = (child || '')
        .split(',')
        .map(age => parseInt(age))
        .filter(age => !isNaN(age) && age >= 0);
    const checkInDate = formatDate(hotelData?.arrival || hotelData?.possibleStays?.[0]?.checkIn);
    const checkOutDate = formatDate(hotelData?.departure || hotelData?.possibleStays?.[0]?.checkOut);
    const hotelNights = calculateDateDifference(checkInDate, checkOutDate) || hotelData.nights || 0;
    const resortPreviewPrice = urlParams.get('price') ? parseFloat(atob(urlParams.get('price'))) : parseFloat($(this).closest('.card').find('.resort-preview-rate-main').text().replace(/[$,]/g, '')).toFixed(2);
    console.log(resortPreviewPrice,"resortPreviewPrice");
    
    const everydayTravSaverPrice = $(this).data('everyday-travsaver-rate').toFixed(2);
    // const everydayTravSaverPrice = urlParams.get('price') ? '' : parseFloat($('#everyday-travsaver-rate').text().replace(/[$,]/g, '')).toFixed(2) * hotelNights;
    const locationCode = hotelData?.city + ', ' + hotelData?.state;

    localStorage.setItem('selectedPackageHotel', JSON.stringify({ hotelId, hotelName, hotelAddress, hotelImage, packageId, destinationId, destinationName, arrival, departure, adults, child, childAges, resortPreviewPrice, everydayTravSaverPrice, locationCode }));
    window.location.href = 'package-detail.php';
});
$('form').on('submit', function (event) {
    event.preventDefault();
    const isExperienceValid = validateSelect(
        $(this).find('.experience'),
        $(this).find('.experience-error'),
        'Please select a experience'
    );
    const isArrivalDateValid = validateInput(
        $(this).find('.package_arrival_date'),
        $(this).find('.package_arrival_date-error'),
        'Please select an arrival date.'
    );
    const isDestinationValid = validateSelect(
        $(this).find('.destinations'),
        $(this).find('.destinations-error'),
        'Please select a destination'
    );

    // Only proceed with API call if all validations pass
    if (isExperienceValid && isArrivalDateValid && isDestinationValid) {
        const destinationSelect = document.querySelector('select[name="destination"]');
        const destinationName = destinationSelect.options[destinationSelect.selectedIndex].text;
        let destination_id;
        destination_id = destinationIdMap[destinationName].toString();
        const rating = $('input[name="starRatings"]:checked').map(function () {
            return parseInt($(this).val());
        }).get();
        const arrivalDate = $('#package_arrival_date').val();
        const searchData = {
            experience: $('#experience').val(),
            destination_id: destination_id,
            destination_name: $('#destination option:selected').text(),
            checkIn: convertToYMD(arrivalDate),
            adults: parseInt($('.adults').text()) || 2,
            child: Array.from(document.querySelectorAll('input[name^="child_"]'))
                .map(child => child.value)
                .filter(age => !isNaN(parseInt(age)) && parseInt(age) >= 0)
                .join(','),
            starRatings: rating
        };
        Object.entries(searchData).forEach(([key, value]) => {
            $(`#${key}`).val(value);
        });

        packages.showSkeletonLoaders(4);
        packages.fetchPackages(searchData);
    }
});