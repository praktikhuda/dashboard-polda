<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | Amezia - Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <style>
        .full-height {
            height: 100vh;
        }
    </style>

</head>

<body data-topbar="dark">

    <div class="container full-height d-flex align-items-center justify-content-center">
        <div class="col-lg-4">
            <div class="card rounded">
                <div class="card-body text-center m-3">
                    <h1 class="">Login</h1>
                    <p class="card-title-desc">Hey, Enter your details to get sign in to your accoount</p>
                    <form id="myform">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12 mb-3">
                                <input class="form-control invalid-border" type="text" id="name" name="username" placeholder="Username or Email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-12">
                                <input class="form-control" type="password" id="subject2" name="passowrd" placeholder="Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 px-4" id="singin">Sing In</button>
                    </form>
                    <!-- end form -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div id="templates-modal"></div>

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

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#myform").submit(function(event) {
                event.preventDefault();
                let username = $("#name").val();
                let password = $("#subject2").val();
                let errors = [];

                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                function showError(inputId, message) {
                    $("#" + inputId).addClass("is-invalid").after(`
                        <div class="invalid-feedback text-start">
                            ${message}
                        </div>
                    `);
                }

                if (!username) {
                    showError("name", "username tidak boleh kosong.");
                    errors.push("username tidak boleh kosong.");
                }
                if (!password) {
                    showError("subject2", "Password tidak boleh kosong.");
                    errors.push("Password tidak boleh kosong.");
                }

                let data = {
                    username: username,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
                $.ajax({
                    type: "POST",
                    url: "{{ route('auth.authenticate') }}",
                    data: data,
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.replace(response.redirect)
                        } else {
                            $("#templates-modal").load("{{ route('modal') }}", function() {
                                $('#warningModal').modal('show');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log("Terjadi kesalahan:", xhr.responseText);
                    }
                });
            })

            $("#belumSiap").click(function() {
                $("#templates-modal").load("{{ route('modal') }}", function() {
                    $('#BelumSiap').modal('show');
                });
            })
        })
    </script>

</body>

</html>