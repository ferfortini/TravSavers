function generateStars(rating) {
    const full = Math.floor(rating);
    const half = rating % 1 >= 0.5 ? 1 : 0;
    const empty = 5 - full - half;
    return `${'<li class="list-inline-item me-0 small"><i class="fa-solid fa-star text-warning"></i></li>'.repeat(full)}
${half ? '<li class="list-inline-item me-0 small"><i class="fa-solid fa-star-half-alt text-warning"></i></li>' : ''}
${'<li class="list-inline-item me-0 small"><i class="fa-regular fa-star text-warning"></i></li>'.repeat(empty)}`;
}

function formatDate(dateStr) {
    const d = new Date(dateStr);
    return `${(d.getMonth() + 1 < 10 ? '0' : '') + (d.getMonth() + 1)}/${(d.getDate() < 10 ? '0' : '') + d.getDate()}/${d.getFullYear()}`;
}

function formatPrice(price) {
    return price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function calculateDateDifference(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
}

function renderPagination(totalItems, currentPage, pageSize, callback) {
    const totalPages = Math.ceil(totalItems / pageSize);
    let paginationHTML = `
        <nav class="d-flex justify-content-center" aria-label="navigation">
            <ul class="pagination pagination-primary-soft d-inline-block d-md-flex rounded mb-0">`;

    // Show Previous button
    if (currentPage > 1) {
        paginationHTML += `<li class="page-item mb-0">
            <a class="page-link" href="#" tabindex="-1" data-page="${currentPage - 1}">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>`;
    }

    // Show page numbers
    let startPage, endPage;

    if (totalPages <= 5) {
        // If total pages are 5 or less, show all pages
        startPage = 1;
        endPage = totalPages;
    } else {
        // If current page is near the beginning
        if (currentPage <= 3) {
            startPage = 1;
            endPage = 5;
        }
        // If current page is near the end
        else if (currentPage + 2 >= totalPages) {
            startPage = totalPages - 4;
            endPage = totalPages;
        }
        // If current page is in the middle
        else {
            startPage = currentPage - 2;
            endPage = currentPage + 2;
        }

        // Add ellipsis if there are pages before the startPage
        if (startPage > 1) {
            paginationHTML += `<li class="page-item mb-0"><a class="page-link" href="#">..</a></li>`;
        }
    }

    // Show page numbers
    for (let i = startPage; i <= endPage; i++) {
        const isActive = i === currentPage;
        paginationHTML += `<li class="page-item mb-0 ${isActive ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`;
    }

    // Add ellipsis if there are pages after the endPage
    if (endPage < totalPages) {
        paginationHTML += `<li class="page-item mb-0"><a class="page-link" href="#">..</a></li>`;
    }

    // Show Next button
    if (currentPage < totalPages) {
        paginationHTML += `<li class="page-item mb-0">
            <a class="page-link" href="#" data-page="${currentPage + 1}">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>`;
    }

    paginationHTML += `</ul></nav>`;

    $('#hotel-results').append(paginationHTML);

    $('.page-link').on('click', function (e) {
        e.preventDefault();
        const newPage = parseInt($(this).data('page'));
        if (!isNaN(newPage)) {
            callback(newPage);
        }
    });
}

function showButtonLoader(id) {
    const loader = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    $(id).html(loader);
}

function hideButtonLoader(id) {
    $(id).find('.spinner-border').parent().remove();
}

function validateInput(inputEl, errorEl, message, options = {}) {
    const value = inputEl.val().trim();

    if (value === '') {
        errorEl.text(message);
        inputEl.addClass('is-invalid');
        return false;
    }

    if (options.numeric && !/^\d+$/.test(value)) {
        errorEl.text('The mobile number must be a number.');
        inputEl.addClass('is-invalid');
        return false;
    }

    if (options.digitsBetween) {
        const [min, max] = options.digitsBetween;
        if (value.length < min || value.length > max) {
            errorEl.text(`The mobile number must be between ${min} and ${max} digits.`);
            inputEl.addClass('is-invalid');
            return false;
        }
    }

    errorEl.text('');
    inputEl.removeClass('is-invalid');
    return true;
}


const validateCheckobox = (input, errorElement, errorMessage) => {
    if (input.is(':checked')) {
        errorElement.hide();
        return true;
    } else {
        errorElement.text(errorMessage).show();
        return false;
    }
};
// Utility function to validate select with Choices.js
function validateSelect(selectEl, errorEl, message) {
    const value = selectEl.val();
    const isEmpty = !value || value === '0' || value === '' || value === 'Select Destination';
    const wrapper = selectEl.closest('.choices');

    if (isEmpty) {
        errorEl.text(message).show();
        if (wrapper.length) wrapper.addClass('is-invalid');
    } else {
        errorEl.text('').hide();
        if (wrapper.length) wrapper.removeClass('is-invalid');
    }

    return !isEmpty;
}


function validateFile(inputEl, errorEl, message) {
    const file = inputEl.prop('files')[0];

    if (!file) {
        errorEl.text(message);
        inputEl.addClass('is-invalid');
        return false;
    }

    // Check file size
    const fileSize = file.size;
    if (fileSize > 2 * 1024 * 1024) {
        errorEl.text('File size exceeds 2MB');
        inputEl.addClass('is-invalid');
        return false;
    }

    // Check file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        errorEl.text('Only JPEG, PNG, and GIF files are allowed');
        inputEl.addClass('is-invalid');
        return false;
    }

    errorEl.text('');
    inputEl.removeClass('is-invalid');
    return true;
}


function updateChoice(id, values) {
    if (!id || values == null) return;

    const select = document.getElementById(id);
    if (!select) {
        console.warn(`Element with ID '${id}' not found.`);
        return;
    }

    let valArr = [];

    try {
        if (typeof values === 'string') {
            // Try to parse as JSON first
            try {
                const parsed = JSON.parse(values);
                valArr = Array.isArray(parsed) ? parsed : [parsed];
            } catch (jsonError) {
                // If JSON parsing fails, treat the string as a single value
                valArr = [values];
            }
        } else {
            valArr = Array.isArray(values) ? values : [values];
        }
    } catch (e) {
        handleError(e);
        return; // Exit early if there's an error
    }

    // Normalize to string and remove empty/null
    valArr = valArr.map(v => v != null ? v.toString() : '').filter(Boolean);

    const instance = select.choicesInstance || Choices.getInstanceById?.(select.id);

    if (instance) {
        valArr.forEach(val => instance.setChoiceByValue(val));
    } else {
        select.choicesInstance = new Choices(select, {
            removeItemButton: true,
            shouldSort: false,
        });
        valArr.forEach(val => select.choicesInstance.setChoiceByValue(val));
    }
}


window.changeRowStatus = function (url, postData, confirmationText, tableId) {
    Swal.fire({
        allowOutsideClick: false,
        title: "Are you sure?",
        text: confirmationText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Want  to !",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: postData,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,

                        }).then(() => {
                            setTimeout(function () {
                                $(`#${tableId}`).DataTable().ajax.reload();
                            }, 1000);
                        });
                    }
                },
                error: function (err) {
                    handleError(err);
                    window.location.href = response.redirectUrl;
                },
            });
        }
    });
}
// Toastr Option
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "showDuration": "1500",
    "hideDuration": "1500",
    "timeOut": "5000",
    "toastClass": "toastr",
    "extendedTimeOut": "5000"
};

window.successToaster = function (message, title = '') {
    toastr.remove();
    toastr.options.closeButton = true;
    toastr.success(message, title, { timeOut: 5000 });
}
window.errorToaster = function (message, title = 'Error') {
    toastr.remove();
    toastr.options.closeButton = true;
    toastr.error(message, title, { timeOut: 5000 });
}

window.handleError = function (errorResponse) {
    if (errorResponse.responseText) {
        var errors = JSON.parse(errorResponse.responseText);
        if (errorResponse.status === 422 || errorResponse.status === 429) {
            if (errors.errors) {
                $('.error-help-block').show();
                for (var field in errors.errors) {
                    $('#' + field + '-error').html(errors.errors[field]);
                    $('#' + field + '-error').parent('.form-group').removeClass('has-success').addClass('has-error');
                }
            } else {
                errorToaster(errors.error.message);
            }
        } else {
            if (errors.message) {
                errorToaster(errors.message);
            } else {
                errorToaster(errors.error.message);
            }
            return false;
        }
    } else if (errorResponse.status === 0) {
        errorToaster(internetConnectionError);
    } else {
        errorToaster(errorResponse.statusText);
    }
}

window.deleteRowData = function (url, id, table, tableId, title = "") {
    let messageTitle = title || 'Data';

    Swal.fire({
        allowOutsideClick: false,
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: { id: id, table: table },
                success: function (data) {
                    if (data.status === 'success') {
                        Swal.fire({
                            allowOutsideClick: false,
                            title: "Deleted!",
                            text: messageTitle + " has been deleted.",
                            icon: "success",
                        }).then(() => {
                            const tableElement = $(`#${tableId}`);
                            if ($.fn.DataTable.isDataTable(tableElement)) {
                                tableElement.DataTable().ajax.reload();
                            } else {
                                location.reload();
                            }
                        });
                    } else {
                        errorToaster(data.message);
                    }
                },
                error: function (err) {
                    handleError(err);
                    const tableElement = $(`#${tableId}`);
                    if ($.fn.DataTable.isDataTable(tableElement)) {
                        tableElement.DataTable().ajax.reload();
                    } else {
                        location.reload(); // fallback on error
                    }
                },
            });
        }
    });
}


function clearValidation(modalSelector) {
    const modal = $(modalSelector);

    // Remove 'is-invalid' class from all inputs/selects
    modal.find('.is-invalid').removeClass('is-invalid');

    // Clear error text from all invalid-feedback elements
    modal.find('.invalid-feedback').text('');
}

function convertToYMD(dateStr) {
    const [month, day, year] = dateStr.split('/');
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
}

