
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