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
                            SearchString: encodeURIComponent(inputVal)
                        },
                        dataType: 'json',
                        success: function (response) {
                            $('#suggestions-list').remove();
                            let suggestions = '';

                            if (response.locations && response.locations.length > 0) {
                                $.each(response.locations, function (index, value) {
                                    suggestions += `<li class="suggestion-item" value="${value.code}" longitude="${value.geoLocation.longitude}" latitude="${value.geoLocation.latitude}">${value.name}</li>`;
                                });
                            } else {
                                // Show fallback if no results
                                suggestions = `<li class="no-results">Sorry, we can't find the destination.</li>`;
                            }

                            $('#dest_loc').after(`<ul id="suggestions-list">${suggestions}</ul>`);

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
                        error: function () {
                            $('#loader').hide();
                            $('#suggestions-list').remove();
                            $('#dest_loc').after(`
                                    <ul id="suggestions-list">
                                        <li class="no-results">Sorry, we can't find the destination.</li>
                                    </ul>
                                `);
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
            const arrivalDate = formData.get('date_range').split(' to ')[0];
            const departureDate = formData.get('date_range').split(' to ')[1];
        
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
const departurePicker = $("#departureDate").flatpickr({
    dateFormat: "m/d/Y",
    clickOpens: false,
});

// Initialize Flatpickr for arrival with auto departure calculation
$("#arrivalDate").flatpickr({
    dateFormat: "m/d/Y",
    minDate: "today",
    onChange: function (selectedDates) {
        if (selectedDates.length && nights > 0) {
            const arrival = selectedDates[0];
            const departure = new Date(arrival);
            departure.setDate(arrival.getDate() + nights);
            departurePicker.setDate(departure);
        } else {
            console.warn("Nights not set or no arrival date selected");
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


