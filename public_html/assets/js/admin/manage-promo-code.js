
let perksTableId = $("#promo_codes").attr("id");
let promoCodes = {
    init: function () {
        promoCodes.list();
        promoCodes.changeStatus();
        promoCodes.edit();
        promoCodes.resetModal();
        promoCodes.delete();
    },
    list: function () {
        $("#promo_codes").DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'promo_codes';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($("#promo_codes").DataTable().page.info().page) + 1;
                    d.search = $("#promo_codes").DataTable().search();
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
                    name: "offer_code",
                    data: 'offer_code',
                },
                {
                    targets: 2,
                    name: "start_date",
                    data: 'start_date',
                },
                {
                    targets: 3,
                    name: "end_date",
                    data: 'end_date',
                },
                {
                    targets: 4,
                    name: "discount_type",
                    data: 'discount_type',
                    render: function (data, type, row) {
                        return data.replace("_", " ").split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
                    }
                },
                {
                    targets: 5,
                    name: "discount_value",
                    data: 'discount_value',
                },
                {
                    targets: 6,
                    name: "min_price",
                    data: 'min_price',
                    render: function (data, type, row) {
                        return `$${data}`;
                    }
                },
                {
                    targets: 7,
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
                    targets: 8,
                    name: "actions",
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                                <a class="text-primary edit-promo-code"
                                    href="#"
                                    data-id="${row.id}"
                                    data-offer_code="${row.offer_code}"
                                    data-start_date="${row.start_date}"
                                    data-end_date="${row.end_date}"
                                    data-discount_type="${row.discount_type}"
                                    data-discount_value="${row.discount_value}"
                                    data-min_price="${row.min_price}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPromoCode">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-promo-code" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
                            `;
                    }
                }
            ],
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
                table: perksTableId
            };
            changeRowStatus(url, postData, Text, perksTableId);
        });
    },
    edit: function () {
        $(document).on("click", ".edit-promo-code", function (e) {
            clearValidation('#addPromoCode');
            e.preventDefault();
            let id = $(this).attr("data-id");
            let offer_code = $(this).attr("data-offer_code");
            let start_date = $(this).attr("data-start_date");
            let end_date = $(this).attr("data-end_date");
            let discount_type = $(this).attr("data-discount_type");
            let discount_value = $(this).attr("data-discount_value");
            $('#edit-promo-code-id').val(id);
            $('#edit-offer-code').val(offer_code);
            $('#edit-start-date').val(start_date);
            $('#edit-end-date').val(end_date);
            updateChoice("edit-discount-type", discount_type);
            $('#edit-discount-value').val(discount_value);
            $('#edit-min-price').val(min_price);
        });
    },
    resetModal: function () {
        $('#addPromoCodeButton').on('click', function () {
            clearValidation('#addPromoCode');
            $('#promo_code_id, #offer_code, #start_date, #end_date, #discount_value').val('');

            const select = $('#discount_type')[0];
            if (select) {
                if (select.choicesInstance) {
                    select.choicesInstance.destroy();
                    select.choicesInstance = null;
                }
                select.value = "";
                select.choicesInstance = new Choices(select, {
                    removeItemButton: true,
                    shouldSort: false,
                    placeholder: true,
                    placeholderValue: 'Select',
                });
            }

            $('.modal-title').text("Add Promo Code");
            $('button[name="submitPromoCodeBtn"]').text("Add Promo Code");
        });
    },
    delete: function () {
        $(document).on("click", ".delete-promo-code", function (e) {
            let id = $(this).attr("rel");
            let table = 'promo_codes';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'promo_codes', 'Promo Code');
        });
    }
}
promoCodes.init();

$(document).on('click', '.edit-promo-code', function () {
    const self = $(this).closest('.edit-promo-code');

    // Set input values
    $('#promo_code_id').val(self.data('id'));
    $('#offer_code').val(self.data('offer_code'));
    $('#start_date').val(self.data('start_date'));
    $('#end_date').val(self.data('end_date'));
    updateChoice("discount_type", self.data('discount_type'));
    $('#discount_value').val(self.data('discount_value'));
    $('#min_price').val(self.data('min_price'));
    // Update modal content
    $('.modal-title').text("Edit Promo Code");
    $('button[name="submitPromoCodeBtn"]').text("Update Promo Code");
});


$('#addEditPromoCodeForm').on('submit', function (e) {
    const offerCodeValid = validateInput(
        $('#offer_code'),
        $('#offer_code-error'),
        'Please enter offer code'
    );

    const startDateValid = validateSelect(
        $('#start_date'),
        $('#start_date-error'),
        'Please select start date'
    );

    const endDateValid = validateSelect(
        $('#end_date'),
        $('#end_date-error'),
        'Please select end date'
    );

    const discountTypeValid = validateSelect(
        $('#discount_type'),
        $('#discount_type-error'),
        'Please select discount type'
    )

    const discountValueValid = validateInput(
        $('#discount_value'),
        $('#discount_value-error'),
        'Please select discount value'
    )

    const minPriceValid = validateInput(
        $('#min_price'),
        $('#min_price-error'),
        'Please enter minimum price'
    )

    if (offerCodeValid && startDateValid && endDateValid && discountTypeValid && discountValueValid && minPriceValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let btnName = btn.text();
        let url = 'services/promo_code_submit.php';
        var showLoader = 'Processing....';
        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-promo-code.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    // Restore button
                    btn.prop('disabled', false);
                    btn.html(btnName);
                }
            },
            error: function (err) { 
                handleError(err);
                // Restore button
                btn.prop('disabled', false);
                btn.html(btnName);
            },
        });
    } else {
        e.preventDefault();
    }
});
