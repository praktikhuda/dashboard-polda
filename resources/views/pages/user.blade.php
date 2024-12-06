@extends('app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">User</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title align-middle">User
                    <button class="btn btn-outline-primary btn-sm ms-3" type="button" id="tambahUser">Tambah User</button>
                </h5>
                <div class="table-responsive">
                    <table id="myTableModal" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="templates-modal"></div>
@endsection
@section('js')
<script>
    function loadDataUser() {
        $.ajax({
            type: "GET",
            url: "{{ route('cariUser') }}",
            dataType: "json",
            success: function(response) {
                $("#myTableModal").DataTable({
                    destroy: true,
                    lengthMenu: [10, 25, 50, 100],
                    data: response,
                    processing: true,
                    columns: [{
                            title: "No",
                            width: "25px",
                            className: "text-center",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "username"
                        },
                        {
                            data: "email"
                        },
                        {
                            data: null,
                            className: "text-center",
                            render: function(data, type, row, meta) {
                                return `
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pen fs-5"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        <i class="fas fa-trash-alt fs-5"></i>
                                    </button>
                                `;
                            },
                        }
                    ]
                })
            }
        });
    }
    $(document).ready(function() {
        loadDataUser()

        $("#tambahUser").click(function() {
            $("#templates-modal").load("{{ route('modal-v4') }}", function() {
                $('#modalTable').modal('show');
            })
        })
    })
</script>
@endsection