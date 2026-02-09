let perksTableId = $("#perks").attr("id");
let perkValues = {
    init: function () {
        perkValues.list();
        perkValues.edit();
        perkValues.delete();
    },

    list: function () {
        $('#perkValues').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'perk_values';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($('#perkValues').DataTable().page.info().page) + 1;
                    d.search = $('#perkValues').DataTable().search();
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
                    name: "category",
                    data: 'category',
                    render: function (data, type, row) {
                        return data.replace("_", " ").split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
                    }
                },
                {
                    targets: 2,
                    name: "value",
                    data: 'value',
                    render: function (data, type, row) {
                        if (!isNaN(parseFloat(data))) {
                            return `$${(data)}`;
                        } else {
                            return data;
                        }
                    }
                },
                {
                    targets: 3,
                    name: "actions",
                    data: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                                <a class="text-primary edit-perk-values"
                                    href="#"
                                    data-id="${row?.id}"
                                    data-category="${row?.category}"
                                    data-type="${row?.type}"
                                    data-value="${row?.value}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPerkValues">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-perk-values" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
                            `;
                    }
                }
            ]
        });
    },

    edit: function () {
        $(document).on("click", ".edit-perk-values", function (e) {
            clearValidation('#editPerkValues');
            e.preventDefault();
            let id = $(this).attr("data-id");
            let category = $(this).attr("data-category");
            let type = $(this).attr("data-type");
            let value = $(this).attr("data-value");
            $('#perk_values_id').val(id);
            $('#edit-perk-values-value').val(value);
            $('#editValue').val(value);
            updateChoice("editCategory", category);
            updateChoice("editType", type);
        });
    },
    delete: function () {
        $(document).on("click", ".delete-perk-values", function (e) {
            let id = $(this).attr("rel");
            let table = 'perk_values';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'perk_values', 'Perk Value');
        });
    }
}
perkValues.init();

let perks = {
    init: function () {
        perks.list();
        perks.changeStatus();
        perks.delete();
    },
    list: function () {
        $('#perks').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: 'server.php',
                type: 'GET',
                data: function (d) {
                    d.table = 'perks';
                    d.size = d.length;
                    d.columns = d.columns.filter(col => col.data !== 'actions');
                    d.sortColumn = d.columns[d.order[0]["column"]]["name"];
                    d.sortDirection = d.order[0]["dir"];
                    d.page = parseInt($('#perks').DataTable().page.info().page) + 1;
                    d.search = $('#perks').DataTable().search();
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
                    name: "plus_set",
                    data: 'plus_set',
                    orderable: false,
                },
                {
                    targets: 2,
                    name: "plus_type",
                    data: 'plus_type',
                    orderable: false,
                },
                {
                    targets: 3,
                    name: "description",
                    data: 'description',
                },
                {
                    targets: 4,
                    name: "increment",
                    data: 'increment',
                    orderable: false,
                },
                {
                    targets: 5,
                    name: "included",
                    data: 'included',
                    orderable: false,
                    render: function (data, type, row) {
                        return row.included === 1 ? 'Yes' : 'No';
                    }
                },
                {
                    targets: 6,
                    name: "cost",
                    data: 'cost',
                    orderable: false,
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
                                <a class="text-primary edit-perk"
                                    href="#"
                                    data-id="${row.id}"
                                    data-description="${row.description}"
                                    data-plus_set="${row.plus_set_id}"
                                    data-plus_type="${row.plus_type_id}"
                                    data-increment="${row.increment_id}"
                                    data-included="${row.included}"
                                    data-cost="${row.cost_id}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPerk">
                                    <i class="bi bi-pencil-square me-1"></i>
                                </a>
                                <a class="text-primary delete-perk" href="#" rel="${row.id}"><i class="bi bi-trash text-danger"></i></a>
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
    delete: function () {
        $(document).on("click", ".delete-perk", function (e) {
            let id = $(this).attr("rel");
            let table = 'perks';
            let url = 'delete.php';
            deleteRowData(url, id, table, 'perks', 'Perk');
        });
    }
}
perks.init();
$(document).on('click', '.edit-perk', function () {
    const self = $(this).closest('.edit-perk');

    // Set input values
    $('#perk_id').val(self.data('id'));
    $('#description').val(self.data('description'));

    // Extract dataset values
    const plusSet = self.data('plus_set') ?? '';
    const plusType = self.data('plus_type') ?? '';
    const increment = self.data('increment') ?? '';
    const included = self.data('included') ?? '';
    const cost = self.data('cost') ?? '';

    // Update each select with new values
    updateChoice("plusSet", plusSet);
    updateChoice("plusType", plusType);
    updateChoice("increment", increment);
    updateChoice("included", included);
    updateChoice("cost", cost);

    // Update modal content
    $('.modal-title').text("Edit Perk");
    $('button[name="submitPerkBtn"]').text("Update Perk");
});

// Reset modal for "Add Perk"
$('#addPerk').on('hidden.bs.modal', function () {
    clearValidation('#addEditPerkForm');
    const form = $('#addEditPerkForm');
    form[0].reset();
    $('#perk_id').val("");
    $('.modal-title').text("Create New Perk");
    $('button[name="submitPerkBtn"]').text("Create Perk");

    const selectIds = ["plusSet", "plusType", "increment", "included", "cost"];
    selectIds.forEach(id => {
        const select = document.getElementById(id);

        if (select) {
            // Destroy existing Choices instance
            if (select.choicesInstance) {
                select.choicesInstance.destroy();
                select.choicesInstance = null;
            }

            // Remove any selected value manually
            select.value = "";

            // Remove any previously added Choices container (backup in case destroy didn't fully clean up)
            const nextSibling = select.nextElementSibling;
            if (nextSibling && nextSibling.classList.contains('choices')) {
                nextSibling.remove();
            }

            // Re-initialize Choices
            select.choicesInstance = new Choices(select, {
                removeItemButton: true,
                shouldSort: false,
                placeholder: true,
                placeholderValue: 'Select',
            });
        }
    });
});

$('#addEditPerkValues').on('submit', function (e) {
    e.preventDefault();
    const categoryValid = validateSelect(
        $('#category'),
        $('#category-error'),
        'Please select a category'
    );
    const typeValid = validateSelect(
        $('#type'),
        $('#type-error'),
        'Please select a type'
    );
    const valueValid = validateInput(
        $('#value'),
        $('#value-error'),
        'Please enter a value'
    );
    
    if (categoryValid && typeValid && valueValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let btnName = btn.text();
        let url = 'services/perk_value_submit.php';
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
                        window.location.href = 'manage-perks.php';
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

$('#editPerkValuesForm').on('submit', function (e) {
    e.preventDefault();
    const categoryValid = validateSelect(
        $('#editCategory'),
        $('#editCategory-error'),
        'Please select a category'
    );
    const typeValid = validateSelect(
        $('#editType'),
        $('#editType-error'),
        'Please select a type'
    );
    const valueValid = validateInput(
        $('#editValue'),
        $('#editValue-error'),
        'Please enter a value'
    );
    
    if (categoryValid && typeValid && valueValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/perk_values_submit.php';
        var showLoader = 'Processing....';
        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);
        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-perks.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    // Restore button
                    btn.prop('disabled', false);
                    btn.html(btnName);
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
    } else {
        e.preventDefault();
    }
});

$('#addEditPerkForm').on('submit', function (e) {
    e.preventDefault();
    const descriptionValid = validateInput(
        $('#description'),
        $('#description-error'),
        'Please enter description'
    );

    const plusSetValid = validateSelect(
        $('#plusSet'),
        $('#plusSet-error'),
        'Please select plus set'
    );

    const plusTypeValid = validateSelect(
        $('#plusType'),
        $('#plusType-error'),
        'Please select plus type'
    );

    const incrementValid = validateSelect(
        $('#increment'),
        $('#increment-error'),
        'Please select increment'
    )

    const includedValid = validateSelect(
        $('#included'),
        $('#included-error'),
        'Please select included'
    )

    const costValid = validateSelect(
        $('#cost'),
        $('#cost-error'),
        'Please select cost'
    )
    if (descriptionValid && plusTypeValid && plusSetValid && incrementValid && includedValid && costValid) {
        let frm = $(this);
        let btn = frm.find('button[type="submit"]');
        let cancelBtn = $("#cancelBtn");
        let btnName = btn.text();
        let url = 'services/perks_submit.php';
        var showLoader = 'Processing....';
        // Show button loader
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + showLoader);
        cancelBtn.prop("disabled", true);
        $.ajax({
            type: "POST",
            url: url,
            data: frm.serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    successToaster(res.message);
                    setTimeout(function () {
                        window.location.href = 'manage-perks.php';
                    }, 1000);
                } else {
                    errorToaster(res.message);
                    // Restore button
                    btn.prop('disabled', false);
                    btn.html(btnName);
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
    } else {
        e.preventDefault();
    }
});
