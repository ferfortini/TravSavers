const storage = localStorage;
const guestFormData = JSON.parse(storage.getItem('guestFormData'));
const hotelData = JSON.parse(storage.getItem('selectedHotel'));
const packageHotelData = JSON.parse(storage.getItem('selectedPackageHotel'));
const cookieValue = document.cookie.match(/userId=([^;]*)/);
const userId = cookieValue ? cookieValue[1] : '';

if (hotelData?.everydayTravSaverPrice) {
    $('#everydayRate').show();
} else {
    $('#everydayRate').remove();
}

const { fname, lname, email, mobile, zip, booking_type } = guestFormData;

$('#guest').text(`${fname} ${lname}`);
$('#email').text(email);
$('#mobile').text(mobile);
const zipCode = guestFormData.zip;

const hotel = hotelData || packageHotelData;
if (hotel) {

    $('#hotel-name').text(hotel.hotelName);
    $('#image').attr('src', hotel.hotelImage || 'default.jpg');
    $('#hotel-address').text(hotel.hotelAddress);
    $('#check-in').text(formatDate(hotel.checkInDate || hotel.arrival));
    $('#check-out').text(formatDate(hotel.checkOutDate || hotel.departure));
    if (hotel.everydayTravSaverPrice) {
        $('#every-day-rate').text(`$${hotel.everydayTravSaverPrice}`);
        $('#every-day-rate-main').text(`$${hotel.everydayTravSaverPrice}`);
    }
    $('#preview-rate').text(`$${hotel.resortPreviewPrice}`);
    $('#preview-rate-main').text(`$${hotel.resortPreviewPrice}`);

    initRoomTypes(hotel);
}

$.ajax({
    type: "GET",
    url: "http://api.zippopotam.us/us/" + zipCode,
    success: function (data) {
        $('#location').text(data.places[0]['place name'] + ', ' + data.places[0]['state abbreviation'] + ' ' + data['post code']);
    }
});

function initRoomTypes(hotelData) {
    const formData = {
        hotelId: hotelData?.hotelId,
        packageId: guestFormData?.package_id,
        sessionKey: {
            value: userId,
            expireDate: "2025-05-16T17:49:43.4803216Z",
            isInvalid: false
        },
        marginator: {
            percentage: 0,
            commission: 0
        },
        currency: "USD",
        lifeType: "none"
    };

    $.ajax({
        type: 'POST',
        url: 'hotel_booking_summary_api_call.php',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        beforeSend: () => showButtonLoader('#room-type'),
        success: function (data) {
            const taxAmount = parseFloat(data?.bookingCard?.bookingPrice?.totalTaxes) || 0;
            $('#tax').text('$' + taxAmount.toFixed(2));
            
            // Initialize radio button event handlers
            $('input[name="selectedRate"]').on('change', function () {
                const selectedRate = $(this).val();
                const everydayTravSaverPrice = parseFloat($('#every-day-rate-main').text().replace(/[$,]/g, ''));
                const previewPrice = parseFloat($('#preview-rate-main').text().replace(/[$,]/g, ''));

                let total = 0;
                if (selectedRate === 'everyday') {
                    total = everydayTravSaverPrice + taxAmount;
                } else if (selectedRate === 'preview') {
                    total = previewPrice + taxAmount;
                }

                $('#total').text('$' + total.toFixed(2));
                $('#total-payment').text('$' + total.toFixed(2));
                $('#cart-total').val(total.toFixed(2));
            });
            
            // Set initial total based on default selection (everyday rate)
            const everydayTravSaverPrice = parseFloat($('#every-day-rate-main').text().replace(/[$,]/g, ''));
            const initialTotal = everydayTravSaverPrice + taxAmount;
            $('#total').text('$' + initialTotal.toFixed(2));
            $('#total-payment').text('$' + initialTotal.toFixed(2));
            $('#cart-total').val(initialTotal.toFixed(2));
        },
        error: handleError
    });
}

// Ensure radio buttons are properly initialized when page loads
$(document).ready(function() {
    // Set default selection if none is selected
    if (!$('input[name="selectedRate"]:checked').length) {
        $('#everyDayRateRadio').prop('checked', true);
    }
    
    // Make entire rate option clickable
    $('.rate-option').on('click', function(e) {
        // Don't trigger if clicking on the radio button itself
        if (!$(e.target).is('input[type="radio"]')) {
            $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
        }
    });
    
    // Add visual feedback for radio button selection
    $('input[name="selectedRate"]').on('change', function() {
        // Remove active class from all rate sections
        $('.rate-option').removeClass('border-primary bg-light');
        
        // Add active class to selected rate section
        const selectedRate = $(this).val();
        if (selectedRate === 'everyday') {
            $('#everyday-rate-option').addClass('border-primary bg-light');
        } else if (selectedRate === 'preview') {
            $('#preview-rate-option').addClass('border-primary bg-light');
        }
    });
    
    // Trigger initial selection
    $('#everyDayRateRadio').trigger('change');
});

let payment = {
    init: function () {
        payment.bookNow();
    },
    bookNow: function () {
        $(document).on("submit", "#payment-form", function (e) {
            e.preventDefault();


            const jsonData = {
                PackageId: formData.find((item) => item.name === 'selected_package_id').value,
                Rooms: [
                    {
                        RateKey: formData.find((item) => item.name === 'selected_rate_key').value,
                        Guests: [
                            {
                                GivenName: formData.find((item) => item.name === 'fname').value,
                                SurName: formData.find((item) => item.name === 'lname').value,
                                Phone: formData.find((item) => item.name === 'mobile').value,
                                Email: formData.find((item) => item.name === 'email').value,
                                IsMainGuest: true,
                                Residence: "US",
                                Age: 30
                            }
                        ],
                        Card: {
                            AddressLine: "aa",
                            AddressLine2: null,
                            CVV: "123",
                            CardNumber: "4111111111111111",
                            CardType: 1,
                            City: "bb",
                            State: "AL",
                            Country: "US",
                            ExpireDate: "102024",
                            HolderName: "aa",
                            Phone: "123",
                            ZipCode: formData.find((item) => item.name === 'zip').value
                        }
                    }
                ]
            };

            // $.ajax({
            //     type: 'POST',
            //     url: 'reservation_api_call.php',
            //     data: JSON.stringify(jsonData),
            //     contentType: 'application/json',
            //     headers: {
            //         'Authorization': 'Bearer ' + token
            //     },
            //     processData: false,
            //     dataType: 'json',
            //     beforeSend: function () {
            //         showButtonLoader(btn, showLoader, true);
            //     },
            //     success: function (response) {
            //         console.log(response);
            //         if (response.success) {
            //             setTimeout(function () {
            //                 window.location.href = 'booking-confirmation.php'
            //             }, 1000);
            //         } else {
            //             showButtonLoader(btn, btnName, false);
            //         }
            //     },
            //     error: function (err) {
            //         showButtonLoader(btn, btnName, false);
            //     },
            // });

        });
    }
}
payment.init();

// Clear localStorage data when leaving the payment page
// window.onbeforeunload = function () {
//     localStorage.removeItem('guestFormData');
// };