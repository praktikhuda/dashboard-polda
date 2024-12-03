@extends('app')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card" id="card">
            <div class="card-body">
                <h5 class="card-title align-middle" id="judul"></h5>
                <p id="deskripsi" class=""></p>
                <div class="table-responsive" id="cetakPdf">
                    <table id="myTableModal" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr></tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button id="download" class="btn btn-primary">Download PDF</button>
            </div>
        </div>
    </div>
</div>
<div id="templates-modal"></div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get("id");
        loadTable();

        function loadTable() {
            $.ajax({
                type: "GET",
                url: "{{ route('cariTable') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    if (!response || response.length === 0) {
                        console.error("Data tidak ditemukan.");
                        return;
                    }

                    const tableData = response[0];
                    renderHeader(tableData);
                    const columns = parseColumns(tableData.data);
                    fetchTableData(columns);
                },
                error: function(xhr) {
                    console.error("Gagal memuat data:", xhr.responseText);
                },
            });
        }

        function renderHeader(data) {
            $("#judul")
                .text(data.judul)
                .append(
                    `<button class="btn btn-outline-primary btn-sm ms-3" type="button" id="tambahTable">Tambah Table</button>`
                );
            $("#deskripsi").text(data.deskripsi);
        }

        function parseColumns(data) {
            const parsedData = Array.isArray(data) ? data : JSON.parse(data || "[]");

            let tfoot = `<th class="text-end">No</th>`;

            parsedData.forEach((col) => {
                if (col.type === 'number') {
                    tfoot += `<th class="text-end">100 <p id="jumlahTotal"></p></th>`;
                } else {
                    tfoot += `<th class="text-end"></th>`;
                }
            });

            const tfootElement = $("#myTableModal tfoot");
            tfootElement.empty();
            tfootElement.append(`<tr>${tfoot}</tr>`);

            return parsedData.map((col) => ({
                title: col.title,
                data: col.nama_col,
            }));
        }


        function fetchTableData(columns) {
            $.ajax({
                type: "GET",
                url: "{{ route('cariTable__') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response.length);
                    
                    if (!response || response.length === 0) {
                        console.error("Data tabel kosong.");
                        return;
                    }

                    const tableData = response.flatMap((item) =>
                        Array.isArray(item.data) ? item.data : JSON.parse(item.data || "[]")
                    );
                    renderTable(columns, tableData);
                },
                error: function(xhr) {
                    console.error("Gagal memuat data tabel:", xhr.responseText);
                },
            });
        }

        function renderTable(columns, data) {
            $("#myTableModal").DataTable({
                destroy: true,
                lengthMenu: [10, 25, 50, 100],
                data: data,
                processing: true,
                columns: [{
                        title: "No",
                        width: "25px",
                        className: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    ...columns,
                ],
            });
        }

        $("#judul").on("click", "#tambahTable", function() {
            $.ajax({
                type: "GET",
                url: "{{ route('lihatTable__') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    if (!response.redirect) {
                        console.error("Redirect URL tidak ditemukan.");
                        return;
                    }

                    $("#templates-modal").load(response.redirect, function() {
                        renderModalForm(response.data);
                        $("#modalTable").modal("show");
                    });
                },
                error: function(xhr) {
                    console.error("Gagal memuat form:", xhr.responseText);
                },
            });
        });

        function renderModalForm(data) {
            $("#dynamicForm").empty();
            data.forEach((item, i) => {
                $("h5#modalTable").text(item.judul);
                const fields = Array.isArray(item.data) ?
                    item.data :
                    JSON.parse(item.data || "[]");

                fields.forEach((field, j) => {
                    $("#dynamicForm").append(`
                    <div id="form-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="field-${j}" class="form-label">${field.title}</label>
                                            <input type="${field.type == 'number' ? 'number' : 'text'}" class="form-control" id="field-${j}" data-nama_col="${field.nama_col}" placeholder="${field.title}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                });
            });

            $("#simpanField").off("click").on("click", function() {
                saveFormData();
            });
        }

        function saveFormData() {
            const formData = [{}];

            $("#dynamicForm input").each(function() {
                const colName = $(this).data("nama_col");
                const value = $(this).val();
                formData[0][colName] = value;
            });

            const payload = {
                id_table: id,
                data: formData,
            };

            $.ajax({
                type: "POST",
                url: "{{ route('addTable__') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    dataJson: payload,
                },
                success: function(response) {
                    $("#modalTable").modal("hide");
                    loadTable();
                    console.log("Data berhasil disimpan:", response);
                },
                error: function(xhr) {
                    console.error("Gagal menyimpan data:", xhr.responseText);
                },
            });
        }
    });
</script>
@endsection