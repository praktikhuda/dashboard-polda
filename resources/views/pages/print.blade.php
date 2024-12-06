<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/libs/metrojs/release/MetroJs.Full/MetroJs.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- datatables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- DropZone JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <style>
        @media print {
            #download {
                display: none;
            }

            #kembali {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h5 class="card-title align-middle text-center fs-1" id="judul"></h5>
        <p id="deskripsi" class="text-center"></p>
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
        <div class="button-items">
            <button id="download" class="btn btn-primary">Download PDF</button>
            <button type="button" class="btn btn-danger" id="kembali">Kembali</button>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!--Data Table-->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- DataTables Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

    <!-- COBA -->

    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <!-- DropZone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get("id");
            loadTable();

            $("#download").click(function() {
                window.print()
            })

            $("#kembali").click(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('lihatTable-v1') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        window.location.href = response.redirect + "?id=" + id;
                    }
                });
            });

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
                $("#judul").text(data.judul)
                $("#deskripsi").text(data.deskripsi);
            }

            function parseColumns(data) {
                const parsedData = Array.isArray(data) ? data : JSON.parse(data || "[]");

                let tfoot = `<th class="text-end">No</th>`;

                parsedData.forEach((col) => {
                    if (col.type === 'number') {
                        tfoot += `<th class="text-end"></th>`;
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
                    type: col.type || 'text',
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
                    paging: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    lengthChange: false,
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
                        ...columns.map((col) => ({
                            ...col,
                            className: col.type === 'number' ? 'text-end' : 'text-start',
                        })),
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        const api = this.api();
                        const footerCells = $(this).find('tfoot th');

                        columns.forEach((column, index) => {
                            if (column.type === 'number') {
                                const total = api
                                    .column(index + 1, {
                                        page: 'current'
                                    })
                                    .data()
                                    .reduce((a, b) => a + (parseFloat(b) || 0), 0);
                                console.log(total);


                                $(footerCells[index + 1]).html(total);
                            } else {
                                $(footerCells[index + 1]).html('');
                            }
                        });
                    },
                });
            }
        });
    </script>
</body>

</html>