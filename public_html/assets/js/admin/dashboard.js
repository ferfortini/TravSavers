
let tableName = $("#packages").attr("id");
let packages = {
    init: function () {
        packages.list();
        packages.changeStatus();
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
                    const orderColumn = d.order && d.order.length > 0 ? d.order[0]["column"] : 0;
                    d.sortColumn = d.columns[orderColumn] ? d.columns[orderColumn]["name"] : 'id';
                    d.sortDirection = d.order && d.order.length > 0 ? d.order[0]["dir"] : 'desc';
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
                                <a class="text-primary view-package"
                                    href="#"
                                    data-id="${row.id}"
                                    data-title="${row.package_title}"
                                    data-description="${row.description}"
                                    data-experience="${row.experience_name}"
                                    data-experience-id="${row.experience_id}"
                                    data-experience-type="${row.experience_type_name}"
                                    data-experience-type-id="${row.experience_type_id}"
                                    data-preview-rate="${row.preview_rate}"
                                    data-everyday-rate="${row.everyday_rate}"
                                    data-nights="${row.nights}"
                                    data-additional-night-rate="${row.additional_night_rate}"
                                    data-additional-night-rate-id="${row.additional_night_rate_id}"
                                    data-hotel_display_threshold="${row.hotel_display_threshold}"
                                    data-include_perks='${JSON.stringify(row.include_perks)}'
                                    data-location='${row.location_id}'
                                    data-location-names='${row.location_names || ''}'
                                    data-optional-perks='${JSON.stringify(row.optional_perks)}'
                                    data-upgrade-cost='${JSON.stringify(row.upgrade_cost)}'
                                    data-use_hotel_api='${row.use_hotel_api}'
                                    data-hotel-id='${row.hotel_id}'
                                    data-hotel-name='${row.hotel_name || ''}'
                                    data-image='${row.image}'
                                    data-published-at='${row.published_at}'
                                    data-status='${row.status}'
                                    data-bs-toggle="modal"
                                    data-bs-target="#packageViewModal">
                                    <i class="bi bi-eye me-1"></i>
                                </a>
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
    }
}
packages.init();

// View Package Handler (same as in manage-package.js)
$(document).on('click', '.view-package', function () {
    const self = $(this);
    const modal = $('#packageViewModal');
    
    // Basic Information
    modal.find('#view-package-title').text(self.data('title') || 'N/A');
    modal.find('#view-package-description').text(self.data('description') || 'N/A');
    
    // Published Date
    const publishedAt = self.data('published-at');
    modal.find('#view-published-at').text(publishedAt ? new Date(publishedAt).toLocaleDateString() : 'N/A');
    
    // Status
    const status = parseInt(self.data('status'));
    const statusBadge = modal.find('#view-status-badge');
    if (status === 1) {
        statusBadge.text('Active').removeClass('bg-danger').addClass('bg-success');
    } else {
        statusBadge.text('Inactive').removeClass('bg-success').addClass('bg-danger');
    }
    
    // Experience
    modal.find('#view-experience').text(self.data('experience') || 'N/A');
    modal.find('#view-experience-type').text(self.data('experience-type') || 'N/A');
    
    // Rates
    modal.find('#view-preview-rate').text('$' + (self.data('preview-rate') || '0'));
    modal.find('#view-everyday-rate').text('$' + (self.data('everyday-rate') || '0'));
    modal.find('#view-nights').text(self.data('nights') || '0');
    modal.find('#view-additional-night-rate').text(self.data('additional-night-rate') || 'N/A');
    
    // Hotel API Settings
    const useHotelApi = self.data('use_hotel_api');
    modal.find('#view-use-hotel-api').text(useHotelApi || 'N/A');
    
    if (useHotelApi === 'Yes') {
        modal.find('#view-hotel-display-threshold-wrapper').show();
        modal.find('#view-hotel-name-wrapper').hide();
        modal.find('#view-hotel-display-threshold').text(self.data('hotel_display_threshold') || 'N/A');
    } else {
        modal.find('#view-hotel-display-threshold-wrapper').hide();
        modal.find('#view-hotel-name-wrapper').show();
        modal.find('#view-hotel-name').text(self.data('hotel-name') || 'N/A');
    }
    
    // Location
    const locationNames = self.data('location-names');
    const locationId = self.data('location');
    if (locationNames) {
        modal.find('#view-location').text(locationNames);
    } else if (locationId) {
        modal.find('#view-location').text('Location ID: ' + locationId);
    } else {
        modal.find('#view-location').text('N/A');
    }
    
    // Image
    const imageUrl = self.data('image');
    const imageContainer = modal.find('#view-package-image-container');
    imageContainer.empty();
    
    if (imageUrl) {
        let fullImageUrl = imageUrl;
        if (imageUrl && !imageUrl.includes('/') && !imageUrl.includes('\\')) {
            fullImageUrl = '/admin/uploads/' + imageUrl;
        }
        const img = $('<img>', {
            src: fullImageUrl,
            class: 'img-fluid rounded',
            style: 'max-height: 150px; max-width: 100%;',
            alt: 'Package Image'
        });
        imageContainer.append(img);
    } else {
        imageContainer.append('<span class="text-muted">No image available</span>');
    }
    
    // Include Perks
    let includePerks = self.data('include_perks');
    const includePerksContainer = modal.find('#view-include-perks');
    includePerksContainer.empty();
    
    if (includePerks) {
        if (typeof includePerks === 'string') {
            try {
                includePerks = JSON.parse(includePerks);
            } catch (e) {
                includePerks = includePerks.split(',').map(p => p.trim());
            }
        }
        
        if (Array.isArray(includePerks) && includePerks.length > 0) {
            const perksList = $('<ul>', { class: 'list-unstyled mb-0' });
            includePerks.forEach(perk => {
                if (perk) {
                    perksList.append($('<li>', { class: 'mb-1' }).html('<i class="bi bi-check-circle text-success me-2"></i>' + perk));
                }
            });
            includePerksContainer.append(perksList);
        } else {
            includePerksContainer.append('<span class="text-muted">No perks included</span>');
        }
    } else {
        includePerksContainer.append('<span class="text-muted">No perks included</span>');
    }
    
    // Optional Perks
    let optionalPerks = self.data('optional-perks');
    let upgradeCost = self.data('upgrade-cost');
    const optionalPerksContainer = modal.find('#view-optional-perks');
    optionalPerksContainer.empty();
    
    if (optionalPerks) {
        if (typeof optionalPerks === 'string') {
            try {
                optionalPerks = JSON.parse(optionalPerks);
            } catch (e) {
                optionalPerks = optionalPerks.split(',').map(p => p.trim());
            }
        }
        
        if (typeof upgradeCost === 'string') {
            try {
                upgradeCost = JSON.parse(upgradeCost);
            } catch (e) {
                upgradeCost = upgradeCost.split(',').map(c => c.trim());
            }
        }
        
        if (Array.isArray(optionalPerks) && optionalPerks.length > 0) {
            const perksTable = $('<table>', { class: 'table table-sm table-bordered' });
            perksTable.append($('<thead>').append($('<tr>').append(
                $('<th>').text('Perk'),
                $('<th>').text('Upgrade Cost')
            )));
            const tbody = $('<tbody>');
            optionalPerks.forEach((perk, index) => {
                const cost = (Array.isArray(upgradeCost) && upgradeCost[index]) ? '$' + upgradeCost[index] : 'N/A';
                tbody.append($('<tr>').append(
                    $('<td>').text(perk || 'N/A'),
                    $('<td>').text(cost)
                ));
            });
            perksTable.append(tbody);
            optionalPerksContainer.append(perksTable);
        } else {
            optionalPerksContainer.append('<span class="text-muted">No optional perks</span>');
        }
    } else {
        optionalPerksContainer.append('<span class="text-muted">No optional perks</span>');
    }
    
    // Show the modal
    modal.modal('show');
});