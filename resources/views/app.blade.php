<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard Data Inventaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
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
</head>

<body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('componens.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('componens.sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- end page title -->
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            @include('componens.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

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

    @yield('js')

    <script>
        $(document).ready(function() {
            // $("#username").text();
            $("#logout").click(function(event) {
                event.preventDefault();
                $.ajax({
                    type: "post",
                    url: "{{ route('auth.logout') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Sertakan CSRF token
                    },
                    success: function(response) {
                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        console.log("Terjadi kesalahan saat logout:", xhr.responseText);
                    }
                });
            });
            $("#datatable").DataTable();
            // Tambah field input baru saat tombol "Tambah Input" diklik
            $('#addField').click(function() {
                $('#dynamicForm').append(`
                <div class="form-group">
                    <input type="text" name="inputField[]" placeholder="Masukkan data" />
                    <button class="removeField">Hapus</button>
                </div>
                `);
            });

            // Hapus field input saat tombol "Hapus" diklik
            $('#dynamicForm').on('click', '.removeField', function() {
                $(this).parent('.form-group').remove();
            });
        });

        function loadData() {
            $.ajax({
                type: "GET",
                url: "{{ route('lihatTable') }}",
                success: function(response) {
                    let tampilan = "";
                    $.each(response, function(i, a) {
                        tampilan += `
                    <div class="col-md-3 mt-4">
                        <div class="card">
                            <img class="card-img-top img-fluid opacity-50" src="{{ asset('storage/uploads/${a.image}') }}" alt="Card image cap" style="object-fit: cover; height: 200px; float:center">
                            <div class="card-body">
                                <h4 class="card-title">${a.judul}</h4>
                                <p class="card-text text-muted font-size-13">${a.deskripsi}</p>
                                <button type="button" class="btn btn-warning editTable" data-id="${a.id}">Edit</button>
                                <button type="button" class="btn btn-primary lihatTable" data-id="${a.id}">Lihat</button>
                                <button type="button" class="btn btn-danger hapusTable" data-id="${a.id}">Hapus</button>
                            </div>
                        </div>
                    </div>
                `;
                    });
                    $("#templates-card").html(tampilan);
                }
            });
        }


                function loadTable() {
            $.ajax({
                type: "GET",
                url: "{{ route('cariTable') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    $.each(response, function(i, a) {
                        $("#judul").text(a.judul).append(`<button class="btn btn-outline-primary btn-sm ms-3" type="button" id="tambahTable">Tambah Table</button>`);
                        $("#deskripsi").text(a.deskripsi);

                        let dataJson = Array.isArray(a.data) ? a.data : JSON.parse(a.data);
                        let name_col = [];
                        let data__ = [];

                        $.each(dataJson, function(j, b) {
                            name_col.push({
                                title: b.title,
                                data: b.nama_col
                            });
                        });

                        $.ajax({
                            type: "get",
                            url: "{{ route('cariTable__') }}",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                $.each(response, function(k, c) {
                                    let dataJson = Array.isArray(c.data) ? c.data : JSON.parse(c.data);
                                    $.each(dataJson, function(l, d) {
                                        data__.push(d);
                                    });
                                });

                                $("#myTableModal").DataTable({
                                    destroy: true,
                                    lengthMenu: [4],
                                    pageLength: 4,
                                    data: data__,
                                    processing: true,
                                    columns: [{
                                            title: "No",
                                            width: "25px",
                                            className: "text-center",
                                            render: function(data, type, row, meta) {
                                                return meta.row + meta.settings._iDisplayStart + 1;
                                            }
                                        },
                                        ...name_col
                                    ],
                                })
                            }
                        });
                    });
                }

            });
        }
    </script>

</body>

</html>