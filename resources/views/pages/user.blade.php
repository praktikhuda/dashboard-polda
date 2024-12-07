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
                    processing: true,
                    lengthMenu: [10, 25, 50, 100],
                    data: response,
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
                                    <a type="button" href="javascript:void(0);" class="btn btn-warning ubahUser">
                                        <i class="fas fa-pen fs-5"></i>
                                    </a>
                                    <a type="button" href="javascript:void(0);" class="btn btn-danger hapusUser">
                                        <i class="fas fa-trash-alt fs-5"></i>
                                    </a>
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
                $("#simpanField").show()
                $("#ubahField").hide()
                $("#judulModal").text("Tambah User")
                $('#modalTable').modal('show');
            })
        })

        $("#myTableModal").on("click", ".ubahUser", function() {
            let data = $("#myTableModal").DataTable().row($(this).closest("tr")).data();
            $("#templates-modal").load("{{ route('modal-v4') }}", function() {
                $("#simpanField").hide()
                $("#ubahField").show()
                $("#judulModal").text(data.name)
                $('#modalTable').modal('show');

                $("#modalTable").attr("data-action", "edit");

                $("#idUser").val(data.id)
                $("#field-1").val(data.name);
                $("#field-2").val(data.username);
                $("#field-3").val(data.email);
            })
        })

        $("#myTableModal").on("click", ".hapusUser", function() {
            let data = $("#myTableModal").DataTable().row($(this).closest("tr")).data();
            $.ajax({
                type: "GET",
                url: "/hapusUser/" + data.id,
                success: function(data) {
                    if (data.status === "berhasil") {
                        $("#templates-toast").load("{{ route('toast-v1') }}", function(response, status, xhr) {
                            if (status === "success") {
                                $("#pesantoast").text(data.toast);
                                $('#liveToast').toast('show');
                            } else {
                                console.error("Gagal memuat konten: " + xhr.status + " " + xhr.statusText);
                            }
                        });
                    } else {
                        alert("Gagal menghapus data: " + data.toast);
                    }
                    loadDataUser()
                },
                error: function(xhr) {
                    console.error("Terjadi error:", xhr.responseText);
                    alert("Terjadi kesalahan saat menghapus data.");
                }
            });
        })
    })
</script>
@endsection