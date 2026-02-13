localStorage.clear();
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    localStorage.clear();
});
let destination = {
    init: function () {
        destination.list();
        destination.validation();
        destination.packageValidation();
        destination.getDestinationByExperience();
    },
    list: function () {
        let debounceTimeout;
        $('#dest_loc').on('input', function () {
            let self = this;
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(function () {
                let inputVal = $(self).val().trim();
                if (inputVal.length >= 3) {
                    $('#loader').show();
                    $.ajax({
                        type: 'GET',
                        url: 'auto_suggestion_destination_api_call.php',
                        data: {
                            SearchString: inputVal
                        },
                        dataType: 'json',
                        success: function (response) {
                            $('#suggestions-list').remove();
                            let suggestions = '';

                            if (response.locations && response.locations.length > 0) {
                                $.each(response.locations, function (index, value) {
                                    // API returns latitude and longitude inverted, so swap them
                                    // API's "latitude" is actually longitude, and API's "longitude" is actually latitude
                                    const actualLatitude = value.geoLocation.longitude; // API's longitude is actual latitude
                                    const actualLongitude = value.geoLocation.latitude; // API's latitude is actual longitude
                                    suggestions += `<li class="suggestion-item" value="${value.code}" longitude="${actualLongitude}" latitude="${actualLatitude}">${value.name}</li>`;
                                });
                            } else {
                                // Show fallback if no results
                                suggestions = `<li class="no-results">Sorry, we can't find the destination.</li>`;
                            }

                            // Append to the column container for proper positioning
                            let $inputContainer = $('#dest_loc').closest('.form-icon-input');
                            let $colContainer = $inputContainer.closest('.col-md-6');
                            
                            // Ensure the column has relative positioning
                            $colContainer.css('position', 'relative');
                            
                            $('#suggestions-list').remove();
                            $colContainer.append(`<ul id="suggestions-list">${suggestions}</ul>`);
                            
                            // Calculate position relative to the input
                            let inputOffset = $inputContainer.position();
                            $('#suggestions-list').css({
                                'position': 'absolute',
                                'top': (inputOffset.top + $inputContainer.outerHeight() + 4) + 'px',
                                'left': inputOffset.left + 'px',
                                'width': $inputContainer.outerWidth() + 'px'
                            });

                            $('#suggestions-list').on('click', '.suggestion-item', function () {
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

                            $('#dest_loc').on('keyup', function () {
                                if ($(this).val() === '') {
                                    $('#suggestions-list').remove();
                                }
                            });

                            $('#loader').hide();
                        },
                        error: function (xhr, status, error) {
                            $('#loader').hide();
                            $('#suggestions-list').remove();
                            let errorMsg = 'Sorry, we can\'t find the destination.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMsg = xhr.responseJSON.error;
                            }
                            let $inputContainer = $('#dest_loc').closest('.form-icon-input');
                            let $colContainer = $inputContainer.closest('.col-md-6');
                            
                            // Ensure the column has relative positioning
                            $colContainer.css('position', 'relative');
                            
                            $colContainer.append(`<ul id="suggestions-list"><li class="no-results">${errorMsg}</li></ul>`);
                            
                            // Calculate position relative to the input
                            let inputOffset = $inputContainer.position();
                            $('#suggestions-list').css({
                                'position': 'absolute',
                                'top': (inputOffset.top + $inputContainer.outerHeight() + 4) + 'px',
                                'left': inputOffset.left + 'px',
                                'width': $inputContainer.outerWidth() + 'px'
                            });
                        }
                    });
                } else {
                    $('#suggestions-list').remove();
                }
            }, 500);
        });
    },

    validation: function () {
        $(document).on('submit', '#destintions-form', function (e) {
            e.preventDefault();
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

            if (!isDestinationsValid || !isDateRangeValid) {
                e.preventDefault();
                return;
            }

            const formData = new FormData(this);
            const childAges = Array.from(document.querySelectorAll('input[name^="child_"]')).map(child => child.value);
            const dateRange = formData.get('date_range');
            
            if (!dateRange || !dateRange.includes(' to ')) {
                e.preventDefault();
                return;
            }
            
            const arrivalDate = dateRange.split(' to ')[0];
            const departureDate = dateRange.split(' to ')[1];
            
            // Validate 3-night minimum stay
            const checkIn = new Date(convertToYMD(arrivalDate));
            const checkOut = new Date(convertToYMD(departureDate));
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays < 3) {
                const dateRangeInput = $(this).find('.destinations_date_range');
                const dateRangeError = $(this).find('.destinations_date_range-error');
                dateRangeError.text('Minimum stay is 3 nights. Please select a departure date at least 3 nights after arrival.');
                dateRangeInput.addClass('is-invalid');
                e.preventDefault();
                
                // Show toast notification
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Minimum stay is 3 nights. Please adjust your dates.', 'Notice');
                }
                return;
            }
        
            const filterData = {
                dest_loc: btoa(formData.get('dest_loc')),
                latitude: btoa(formData.get('latitude')),
                longitude: btoa(formData.get('longitude')),
                hotel_name: btoa(formData.get('hotel_name')),
                adults: btoa(document.querySelector('.adults').textContent),
                child: btoa(childAges.join(',')),
                arrival: btoa(convertToYMD(arrivalDate)),
                departure: btoa(convertToYMD(departureDate)),
                location_code: btoa(formData.get('location_code'))
            };
            
            if (filterData.dest_loc && filterData.arrival && filterData.departure) {
                const url = 'search-destinations.php';
                const queryParams = Object.keys(filterData).map(key => `${key}=${filterData[key]}`).join('&');
                window.location.href = `${url}?${queryParams}`;
            }

        }
        );
    },
    packageValidation: function () {
        $(document).on('submit', '#packages-form', function (e) {
            e.preventDefault();
            const isExperienceValid = validateSelect(
                $(this).find('.experience'),
                $(this).find('.experience-error'),
                'Please select a experience'
            );
            const isArrivalDateValid = validateInput(
                $(this).find('.arrivalDate'),
                $(this).find('.arrivalDate-error'),
                'Please select an arrival date.'
            );
            // const isDepartureDateValid = validateInput(
            //     $(this).find('.departureDate'),
            //     $(this).find('.departureDate-error'),
            //     'Please select an departure date.'
            // );
            const isDestinationValid = validateSelect(
                $(this).find('.destinations'),
                $(this).find('.destinations-error'),
                'Please select a destination'
            );
            if (!isExperienceValid || !isArrivalDateValid || !isDestinationValid) {
                e.preventDefault();
                return;
            }
            const formData = new FormData(this);
            const childAges = Array.from(document.querySelectorAll('input[name^="child_"]')).map(child => child.value);
            const destinationSelect = document.querySelector('select[name="destination"]');
            const destinationName = destinationSelect.options[destinationSelect.selectedIndex].text;
            const arrivalDate = formData.get('package_arrival_date');
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
            const filterData = {
                experience: btoa(formData.get('experience')),
                destination_id: btoa(destinationIdMap[destinationName]),
                destination_name: btoa(destinationName),
                adults: btoa(document.querySelector('.adults').textContent),
                child: childAges.join(','),
                checkIn: btoa(convertToYMD(arrivalDate)),
                checkOut: btoa(formData.get('package_departure_date')) || '',
                id: btoa(formData.get('destination'))
            };
            
            if (filterData.experience && filterData.checkIn) {
                const url = 'search-package.php';
                const queryParams = Object.keys(filterData).map(key => `${key}=${filterData[key]}`).join('&');
                window.location.href = `${url}?${queryParams}`;
            }
        }
        );
    },
    getDestinationByExperience: function () {
        $(document).on('change', '#experience', function (e) {
            e.preventDefault();
            const experience = $(this).val();
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

                        // Use Choices.js setChoices to update the dropdown options
                        if (destinationSelect && destinationSelect?.choicesInstance) { // Check if Choices.js is initialized using the common pattern
                            // Clear previous selections and options
                            destinationSelect.choicesInstance.clearStore();

                            if (newChoices.length > 0) {
                                destinationSelect.choicesInstance.setChoices(newChoices, 'value', 'label', true);
                            } else {
                                // Add a 'no data found' option if no destinations are returned
                                destinationSelect.choicesInstance.setChoices([{
                                    value: '',
                                    label: 'No destinations found',
                                    disabled: true // Make the option unselectable
                                }], 'value', 'label', true);
                            }

                        } else {
                            // Fallback to jQuery if Choices.js is not initialized
                            $(destinationSelect).empty();
                            if (parsed && parsed?.length > 0) {
                                $.each(parsed, function (index, value) {
                                    $(destinationSelect).append(`<option value="${value.id}">${value.city}, ${value.state}</option>`);
                                });
                            } else {
                                // Add a 'no data found' option for the jQuery fallback
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
        });
    }
}
destination.init();
let nights = 0;

// Package click: set nights and open modal
$('.openDateModal').on('click', function () {
    const price = $(this).data('price');
    nights = { 49: 2, 99: 3, 199: 4, 399: 5 }[price] || 0;
    $('#selectedPrice').val(price);
    $('#dateModal').modal('show');
});

// Initialize Flatpickr for departure (manually set later)
let departurePicker;

// Initialize Flatpickr for arrival with auto departure calculation
$("#arrivalDate").flatpickr({
    dateFormat: "m/d/Y",
    minDate: "today",
    onChange: function (selectedDates) {
        if (selectedDates.length) {
            const arrival = selectedDates[0];
            // Enforce 3-night minimum (3 nights = 4 days later)
            const minDeparture = new Date(arrival);
            minDeparture.setDate(arrival.getDate() + 3);
            
            // Initialize or update departure picker
            if (!departurePicker) {
                departurePicker = $("#departureDate").flatpickr({
                    dateFormat: "m/d/Y",
                    clickOpens: true,
                    minDate: minDeparture,
                    onChange: function (departureDates) {
                        if (departureDates.length) {
                            const arrivalInput = $("#arrivalDate");
                            const arrivalDate = arrivalInput[0]._flatpickr?.selectedDates[0];
                            
                            if (arrivalDate) {
                                const checkIn = arrivalDate;
                                const checkOut = departureDates[0];
                                const diffTime = Math.abs(checkOut - checkIn);
                                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                                
                                if (diffDays < 3) {
                                    // Calculate minimum checkout date (3 nights = 4 days later)
                                    const minCheckOut = new Date(checkIn);
                                    minCheckOut.setDate(checkIn.getDate() + 3);
                                    
                                    // Set to minimum date
                                    departurePicker.setDate(minCheckOut, false);
                                    
                                    // Show error
                                    const departureError = $('.departureDate-error');
                                    departureError.text('Minimum stay is 3 nights. Departure date must be at least 3 nights after arrival.');
                                    $('#departureDate').addClass('is-invalid');
                                    
                                    // Show toast notification
                                    if (typeof toastr !== 'undefined') {
                                        toastr.warning('Minimum stay is 3 nights. Departure date has been adjusted.', 'Notice');
                                    }
                                } else {
                                    // Clear error if valid
                                    $('.departureDate-error').text('');
                                    $('#departureDate').removeClass('is-invalid');
                                }
                            }
                        }
                    }
                });
            } else {
                // Update minimum date
                departurePicker.set("minDate", minDeparture);
            }
            
            // Auto-set departure date if nights is set, otherwise set to minimum
            if (nights > 0 && nights >= 3) {
                const calculatedDeparture = new Date(arrival);
                calculatedDeparture.setDate(arrival.getDate() + nights);
                departurePicker.setDate(calculatedDeparture);
            } else {
                // Set to minimum 3 nights
                departurePicker.setDate(minDeparture);
            }
            
            // Clear any validation errors
            $('.arrivalDate-error, .departureDate-error').text('');
            $('.arrivalDate, .departureDate').removeClass('is-invalid');
        } else {
            console.warn("No arrival date selected");
        }
    }
});

// Form submission with validation
$(document).on('submit', '#package-price-form', function (e) {
    e.preventDefault();
   
    const arrivalInput = $(this).find('.arrivalDate');
    const departureInput = $(this).find('.departureDate');

    const isArrivalValid = validateInput(arrivalInput, $(this).find('.arrivalDate-error'), 'Please select an arrival date');
    const isDepartureValid = validateInput(departureInput, $(this).find('.departureDate-error'), 'Please select a departure date.');

    if (!isArrivalValid || !isDepartureValid) {
        console.warn("Validation failed");
        return;
    }
    
    // Validate 3-night minimum stay
    const arrivalDate = arrivalInput.val();
    const departureDate = departureInput.val();
    
    if (arrivalDate && departureDate) {
        const checkIn = new Date(convertToYMD(arrivalDate));
        const checkOut = new Date(convertToYMD(departureDate));
        const diffTime = Math.abs(checkOut - checkIn);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays < 3) {
            const departureError = $(this).find('.departureDate-error');
            departureError.text('Minimum stay is 3 nights. Please select a departure date at least 3 nights after arrival.');
            departureInput.addClass('is-invalid');
            
            // Show toast notification
            if (typeof toastr !== 'undefined') {
                toastr.warning('Minimum stay is 3 nights. Please adjust your dates.', 'Notice');
            }
            return;
        }
    }
    
    const price = $('#selectedPrice').val();
    const filterData = {
        price: btoa(price),
        checkIn: btoa(convertToYMD(arrivalInput.val())),
        checkOut: btoa(convertToYMD(departureInput.val()))
    };

    if (filterData.checkIn && filterData.checkOut) {
        const url = 'search-package.php';
        const queryParams = Object.keys(filterData)
            .map(key => `${key}=${filterData[key]}`)
            .join('&');
        window.location.href = `${url}?${queryParams}`;
    }
});

// Reset form and validation when modal closes
$('#dateModal').on('hidden.bs.modal', function () {
    $('#package-price-form')[0].reset();

    // Clear flatpickr fields
    $("#arrivalDate")[0]._flatpickr?.clear();
    $("#departureDate")[0]._flatpickr?.clear();

    // Clear validation errors
    $('.arrivalDate-error, .departureDate-error').text('');
    $('.arrivalDate, .departureDate').removeClass('is-invalid');
});


