$(document).ready(function() {
    $('#apply-coupon').click(function() {
        const $button = $(this);
        const couponCode = $('#coupon-code').val();
        
        if (!couponCode || couponCode.trim() === '') {
            errorToaster('Please enter a coupon code');
            $('#coupon-code').addClass('is-invalid');
            return;
        }
        
        // Disable button and show loading state
        $button.prop('disabled', true).text('Applying...');
        
        $('#coupon-code').removeClass('is-invalid');
        $.ajax({
            url: 'check-coupon.php',
            type: 'POST',
            dataType: 'json',
            data: { coupon_code: couponCode, cart_total: $('#cart-total').val() },
            success: function(response) {
                if (response.success) {
                    $button.text('Applied').prop('disabled', true);
                    $('#coupon-discount').html(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="h6 fw-light mb-0">Discount Code:</span>
                            <span class="fs-5 text-success">-$${response.discount}</span>
                        </li>
                        <hr class="m-0">
                    `);
                    if (response.discount_type === 'percent') {
                        const total = $('#cart-total').val() - (response.discount / 100);
                        $('#total').text(`$` + total);
                    } else {
                        const total = $('#cart-total').val() - response.discount;
                        $('#total').text(`$` + total);
                    }
                    $('#coupon-discount').slideDown();
                    successToaster(response.message);
                } else {
                    // Reset button state on error
                    $button.prop('disabled', false).text('Apply');
                    errorToaster(response.message);
                }
            },
            error: function() {
                // Reset button state on AJAX error
                $button.prop('disabled', false).text('Apply');
                errorToaster('An error occurred while applying the coupon');
            }
        });
    });

    $('#remove-coupon').click(function() {
        $('#coupon-code').val('');
        $(this).hide();
        $('#coupon-discount').slideUp();
        $('#coupon-discount-value').html('');
        const originalTotal = $('#cart-total').val();
        $('#total').text(`$` + originalTotal);
        $('#apply-coupon').prop('disabled', false).text('Apply');
    });

    $('#coupon-code').on('input keyup paste', function() {
        const closeBtn = $('#remove-coupon');
        const inputValue = $(this).val().trim();
        
        if (inputValue.length > 0) {
            closeBtn.show();
        } else {
            closeBtn.hide();
        }
    });

    $('#coupon-code').on('focus blur', function() {
        const closeBtn = $('#remove-coupon');
        const inputValue = $(this).val().trim();
        
        if (inputValue.length > 0) {
            closeBtn.show();
        } else {
            closeBtn.hide();
        }
    });

    // Add validation on input to remove invalid state
    $('#coupon-code').on('input', function() {
        $(this).removeClass('is-invalid');
    });

    const initialValue = $('#coupon-code').val().trim();
    if (initialValue.length > 0) {
        $('#remove-coupon').show();
    }
});
                
                