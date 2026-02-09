let tableName = $("#packages").attr("id");
let packages = {
    init: function () {
        packages.list();
        packages.changeStatus();
        packages.delete();
    },

    list: function () {
        $('#packages').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'packages';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($('#packages').DataTable().page.info().page) + 1;
                    d.search = $('#packages').DataTable().search();
                },
            },
            columnDefs: [
                {
                    targets: 0,
                    name: "id",
                    data: 'id',
                    orderable: true,
                    render: function (_data, _type, _full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    targets: 1,
                    name: "published_at",
                    data: 'published_at',
                },
                {
                    targets: 2,
                    name: "package_title",
                    data: 'package_title',
                },
                {
                    targets: 3,
                    name: "description",
                    data: 'description',
                },
                {
                    targets: 4,
                    name: "experience",
                    data: 'experience_name',
                    orderable: false,
                },
                {
                    targets: 5,
                    name: "experience_type",
                    data: 'experience_type_name',
                    orderable: false,
                },
                {
                    targets: 6,
                    name: "nights",
                    data: 'nights',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 7,
                    name: "preview_rate",
                    data: 'preview_rate',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return `$${data}`;
                    }
                },
                {
                    targets: 8,
                    name: "everyday_rate",
                    data: 'everyday_rate',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return `$${data}`;
                    }
                },
                {
                    targets: 9,
                    name: "status",
                    data: 'status',
                    render: function (data, type, row) {
                        return `
                                <div class="form-check form-switch text-center">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked-${row.id}" rel="${row.id}" ${row.status == 1 ? 'checked' : ''}>
                                </div>
                            `;
                    }
                },
                {
                    targets: 10,
                    name: "actions",
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                                <a class="text-primary package"
                                    href="#"
                                    data-id="${row.id}"
                                    data-title="${row.package_title}"
                                    data-description="${row.description}"
                                    data-experience="${row.experience_id}"
                                    data-experience-type="${row.experience_type_id}"
                                    data-preview-rate="${row.preview_rate}"
                                    data-everyday-rate="${row.everyday_rate}"
                                    data-nights="${row.nights}"
                                    data-additional-night-rate="${row.additional_night_rate_id}"
                                    data-hotel_display_threshold="${row.hotel_display_threshold}"
                                    data-include_perks='${JSON.stringify(row.include_perks)}'
                                    data-location='${row.location_id}'
                                    data-optional-perks='${JSON.stringify(row.optional_perks)}'
                                    data-upgrade-cost='${JSON.stringify(row.upgrade_cost)}'
                                    data-use_hotel_api='${row.use_hotel_api}'
                                    data-hotel-id='${row.hotel_id}'
                                    data-image='${row.image}'
                                    data-bs-toggle="modal"
                                    data-bs-target="#customValueModal">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-package" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
                            `;
                    }
                }
            ]
        });
    },

    changeStatus: function () {
        $(document).on("click", ".form-check-input", function (e) {
            e.preventDefault();
            let status = $(this).is(':checked') ? 1 : 0;
            let id = $(this).attr("rel");
            if (status == 0) {
                var Text = "You want to deactivate?";
            } else {
                var Text = "You want to activate?";
            }
            let url = "update-status.php";
            let postData = {
                id: id,
                status: status,
                table: tableName
            };
            changeRowStatus(url, postData, Text, tableName);
        });
    },
    delete: function () {
        $(document).on("click", ".delete-package", function (e) {
            let id = $(this).attr("rel");
            let table = 'packages';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'packages', 'Package');
        });
    }
}
packages.init();


$(document).on('submit', '#addEditPackageForm', function (e) {
    e.preventDefault();
    const useHotelApi = $(this).find('[name="use_hotel_api"]').val();
    
    const isPackageTitleValid = validateInput(
        $(this).find('.packageTitle'),
        $(this).find('.packageTitle-error'),
        'Please enter a package title'
    );

    const isDescriptionValid = validateInput(
        $(this).find('.description'),
        $(this).find('.description-error'),
        'Please enter a description'
    );

    const existingImageUrl = $(this).find('.existingImage').val();
    const imageInput = $(this).find('.featuredImage');
    const isImageInputEmpty = !imageInput.val();

    const isImageValid = (existingImageUrl || !isImageInputEmpty)
        ? true
        : validateFile(
            imageInput,
            $(this).find('.featuredImage-error'),
            'Please choose a featured image'
        );

    const isUseHotelApiValid = validateSelect(
        $(this).find('[name="use_hotel_api"]'),
        $(this).find('#use_hotel_api-error'),
        'Please select a use hotel api'
    );

    // Declare validation variables at the beginning
    let isHotelDisplayThresholdValid = true;
    let isLocationValid = true;
    let isHotelNameValid = true;

    if (useHotelApi === 'Yes') {
        isHotelDisplayThresholdValid = validateInput(
            $(this).find('.hotelDisplayThreshold'),
            $(this).find('.hotelDisplayThreshold-error'),
            'Please enter a hotel display threshold'
        );

        isLocationValid = validateSelect(
            $(this).find('.location'),
            $(this).find('.location-error'),
            'Please select a location'
        );
    } else {
        isHotelNameValid = validateSelect(
            $(this).find('.hotelName'),
            $(this).find('.hotelName-error'),
            'Please enter a hotel name'
        );
    }

    const isExperienceValid = validateSelect(
        $(this).find('.experience'),
        $(this).find('.experience-error'),
        'Please select a experience'
    );

    const isExperienceTypeValid = validateSelect(
        $(this).find('.experienceType'),
        $(this).find('.experienceType-error'),
        'Please select a experience type'
    );

    const isPreviewRateValid = validateInput(
        $(this).find('.previewRate'),
        $(this).find('.previewRate-error'),
        'Please enter a preview rate'
    );

    const iseveryDayRateValid = validateInput(
        $(this).find('.everyDayRate'),
        $(this).find('.everyDayRate-error'),
        'Please enter a every day rate'
    );

    const isNightsValid = validateInput(
        $(this).find('.nights'),
        $(this).find('.nights-error'),
        'Please enter a nights'
    );

    const isAdditionalNightRateValid = validateSelect(
        $(this).find('.additionalNightRate'),
        $(this).find('.additionalNightRate-error'),
        'Please select a additional night rate'
    );

    const isIncludePerksValid = validateSelect(
        $(this).find('.includePerks'),
        $(this).find('.includePerks-error'),
        'Please select a include perks'
    );
    if (!isPackageTitleValid || !isDescriptionValid || !isExperienceValid ||
        !isExperienceTypeValid || !isPreviewRateValid || !isIncludePerksValid ||
        !isAdditionalNightRateValid || !isNightsValid || !iseveryDayRateValid ||
        !isLocationValid || !isUseHotelApiValid || !isHotelNameValid ||
        !isHotelDisplayThresholdValid || !isImageValid) e.preventDefault();
    else {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/package_submit.php';
        var showLoader = 'Processing....';
        
        // Create FormData object to handle file uploads
        let formData = new FormData(frm[0]);
        
        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);
        
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-packages.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    showButtonLoader(btn, btnName, false);
                    cancelBtn.prop("disabled", false);
                }
            },
            error: function (err) {
                handleError(err);
                // Restore button
                btn.prop('disabled', false);
                btn.html(btnName);
                cancelBtn.prop("disabled", false);
            },
        });
    }
});


$(document).ready(function () {
    $('#edit_use_hotel_api').on('change', function () {
        var selected = $(this).val();
        if (selected === 'No') {
            $('#edit-hotel-selector-wrapper').show();
            $('#edit-hotel-display-rule').hide();
            $('#edit-location-selector-wrapper').hide();
        } else if (selected === 'Yes') {
            $('#edit-hotel-selector-wrapper').hide();
            $('#edit-hotel-display-rule').show();
            $('#edit-location-selector-wrapper').show();
        }
    });

    $('#add-input').click(function () {
        $('#input-container').append(`
            <div class="row mb-2 input-row">
                <div class="col-md-8 mb-3">
                    <input type="text" class="form-control" name="optionalPerks[]" placeholder="">
                </div>
                <div class="col-md-2 mb-3">
                    <input type="number" class="form-control" name="upgradeCost[]" placeholder="">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-sm btn-danger remove-input">
                        <i class="bi bi-plus me-2"></i>Remove
                    </button>
                </div>
            </div>
        `);
    });

    $('#input-container').on('click', '.remove-input', function () {
        $(this).closest('.input-row').remove();
    });
});


$(document).on('click', '.package', function () {
    const modal = $('#customValueModal');
    const self = $(this);
    $('#package_id').val(self.data('id'));
    const useHotelApi = $(this).attr('data-use_hotel_api');

    if (useHotelApi == 'No') {
        $('#edit-hotel-selector-wrapper').show();
        $('#edit-hotel-display-rule').hide();
        $('#edit-location-selector-wrapper').hide();
    } else if (useHotelApi === 'Yes') {
        $('#edit-hotel-selector-wrapper').hide();
        $('#edit-hotel-display-rule').show();
        $('#edit-location-selector-wrapper').show();
    }

    // Set values for the modal inputs
    modal.find('#packageTitle').val($(this).data('title'));
    modal.find('#description').val($(this).data('description'));
    modal.find('#experience').val($(this).data('experience')).trigger('change');
    modal.find('#experience_type').val($(this).data('experience_type')).trigger('change');

    modal.find('#nights').val($(this).data('nights'));
    modal.find('#previewRate').val($(this).data('preview-rate'));
    modal.find('#everyDayRate').val($(this).data('everyday-rate'));

    // Show existing image if present
    const imageUrl = $(this).data('image');
    const previewContainer = modal.find('#featuredImagePreview');
    previewContainer.empty(); // Clear old preview

    if (imageUrl) {
        // Construct full path from filename if it's just a filename
        let fullImageUrl = imageUrl;
        if (imageUrl && !imageUrl.includes('/') && !imageUrl.includes('\\')) {
            fullImageUrl = '/admin/uploads/' + imageUrl;
        }
        
        // Display existing image
        const img = $('<img>', {
            src: fullImageUrl,
            class: 'img-fluid',
            style: 'height: 100px;',
        });
        previewContainer.append(img);
        modal.find('.existingImage').val(imageUrl); // Store image URL in hidden field
    }

    // Image upload preview logic
    modal.find('#featuredImage').off('change').on('change', function () {
        const input = this;
        previewContainer.empty(); // Clear previous preview
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = $('<img>', {
                    src: e.target.result,
                    class: 'img-fluid',
                    style: 'height: 100px;',
                });
                previewContainer.append(img);
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Set additional night rate
    modal.find('#additionalNightRate').val($(this).data('additional-night-rate')).trigger('change');

    // Set other fields
    modal.find('#location').val($(this).data('location')).trigger('change');
    modal.find('#use_hotel_api').val($(this).data('use_hotel_api')).trigger('change');
    // modal.find('#hotel_name').val($(this).data('hotel_id'));
    modal.find('#hotelDisplayThreshold').val($(this).data('hotel_display_threshold'));
    modal.find('#includePerks').val($(this).data('include_perks')).trigger('change');
    modal.find('#optionalPerks').val($(this).data('optional-perks'));

    // Set package ID in modal
    modal.attr('data-package-id', $(this).data('id'));

    // Get location data and ensure it's a valid array
    // let locations = $(this).data('location');
    // if (Array.isArray(locations)) {
    //     // You can now safely use locations as an array
    //     locations.forEach(loc => {
    //         console.log('Selected location:', loc);
    //     });
    // }

    let includePerks = $(this).data('include_perks');
    if (typeof includePerks === 'string') {
        try {
            includePerks = JSON.parse(includePerks);
        } catch (e) {
            console.error('Failed to parse includePerks:', e);
            includePerks = [];
        }
    }
    if (useHotelApi == 'No') {
        updateChoice("editHotelName", $(this).data('hotel-id'));
    }

    updateChoice("editLocation",  $(this).data('location'));
    updateChoice("editIncludePerks", includePerks);
    updateChoice("editAdditionalNightRate", $(this).data('additional-night-rate'));
    updateChoice("editExpeirience", $(this).data('experience'));
    updateChoice("editExperienceType", $(this).data('experience-type'));
    updateChoice("edit_use_hotel_api", $(this).data('use_hotel_api'));


    function createPerkRow(perk = '', cost = '') {
        return $(`
        <div class="row mb-2 input-row">
          <div class="col-md-10 mb-3">
            <input type="text" class="form-control" name="optionalPerks[]" value="${perk.toString()}" placeholder="">
          </div>
          <div class="col-md-2 mb-3">
            <input type="number" class="form-control" name="upgradeCost[]" value="${cost.toString()}" placeholder="">
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-sm btn-danger remove-input">
              <i class="bi bi-x me-2"></i>Remove
            </button>
          </div>
        </div>
      `);
    }
    let upgradeCost = $(this).data('upgrade-cost');
    let optionalPerks = $(this).data('optional-perks');

    if (typeof optionalPerks === 'string') {
        try {
            optionalPerks = JSON.parse(optionalPerks);
            if (typeof optionalPerks === 'string') {
                optionalPerks = JSON.parse(optionalPerks);
            }
        } catch (e) {
            console.error('JSON parsing failed:', e);
            optionalPerks = [];
        }
    }

    if (typeof upgradeCost === 'string') {
        try {
            upgradeCost = JSON.parse(upgradeCost);
            if (typeof upgradeCost === 'string') {
                upgradeCost = JSON.parse(upgradeCost);
            }
        } catch (e) {
            console.error('JSON parsing failed:', e);
            upgradeCost = [];
        }
    }

    // Populate modal fields

    const container = modal.find('#input-container');
    container.empty();

    if (Array.isArray(optionalPerks) && Array.isArray(upgradeCost)) {
        optionalPerks.forEach((perk, index) => {
            const cost = upgradeCost[index] || '';
            const row = createPerkRow(perk, cost);
            container.append(row);
        });
    } else {
        console.warn('Perks or cost not in array format');
    }

    // Show the modal
    modal.modal('show');
    $('#addMoreBtn').on('click', function () {
        const newRow = createPerkRow();
        container.append(newRow);
    });

    // Remove row
    $(document).on('click', '.remove-input', function () {
        $(this).closest('.input-row').remove();
    });

});

$(document).on('change', '#featuredImage', function () {
    const input = this;
    const previewContainer = $('#featuredImagePreview');
    previewContainer.empty(); // Clear old preview

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = $('<img>', {
                src: e.target.result,
                class: 'img-fluid',
                css: { height: '100px' }
            });
            previewContainer.append(img);
        };

        reader.readAsDataURL(input.files[0]);
    }
});
