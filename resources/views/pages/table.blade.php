@extends('app')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title align-middle">Table
                    <button class="btn btn-outline-primary btn-sm ms-3" type="button" id="tambahTable">Tambah Table</button>
                </h5>
                <div class="row" id="templates-card"></div>
            </div>
        </div>
    </div>
</div>
<div id="templates-modal"></div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $.ajax({
            type: "get",
            url: "{{ route('lihatTable') }}",
            success: function(response) {
                // console.log(response);
                let tampilan = "";
                $.each(response, function(i, a) {
                    tampilan += `
                        <div class="col-md-3 mt-4">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="{{ asset('assets/images/small/img-1.jpg') }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title">${a.judul}</h4>
                                    <p class="card-text text-muted font-size-13">${a.deskripsi}</p>
                                    <button type="button" class="btn btn-warning" id="editTable-${a.id}">Edit</button>
                                    <button type="button" class="btn btn-primary" id="lihatTable-${a.id}">Lihat</button>
                                    <button type="button" class="btn btn-danger" id="belumSiap">Hapus</button>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#templates-card").on("click", "#lihatTable-" + a.id, function() {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('lihatTable-v1') }}",
                            data: {
                                id: a.id
                            },
                            success: function(response) {
                                window.location.href = response.redirect + "?id=" + a.id;
                            }
                        });
                    })
                    // KLIK MODAL
                    $("#templates-card").on("click", "#editTable-" + a.id, function() {
                        $("#templates-modal").load("{{ route('modal-v2') }}", function() {
                            $.ajax({
                                type: "get",
                                url: "{{ route('cariTable') }}",
                                data: {
                                    id: a.id
                                },
                                success: function(response) {
                                    $.each(response, function(i, a) {
                                        let dataField = ""
                                        $("#field-1").val(a.judul)
                                        let dataJson = Array.isArray(a.data) ? a.data : JSON.parse(a.data);
                                        $.each(dataJson, function(j, b) {
                                            console.log(b.title);

                                            dataField += `
                                                <div id="form-group">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="field-3" class="form-label">Nama Kolom</label>
                                                                        <input type="text" class="form-control" id="field-3" placeholder="Nama Kolom" value="${b.title}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="field-3" class="form-label">Title Kolom</label>
                                                                        <input type="text" class="form-control" id="field-4" placeholder="Title">
                                                                    </div>
                                                                </div>
                                                                <span>
                                                                    <button type="button" class="btn btn-primary" id="tambahFiled"><li class="fas fa-plus"></li> Tambah</button>
                                                                    <button type="button" class="btn btn-danger" id="removeField"><li class="fas fa-trash"></li> Hapus</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;

                                        })
                                        $("#dynamicForm").html(dataField)
                                        $("#editField").show()
                                        $("#simpanField").hide()
                                    })
                                }
                            });
                            $('#modalTable').modal('show');
                        })
                    })
                })
                $("#templates-card").html(tampilan);
            }
        });

        $("#tambahTable").click(function() {
            $("#templates-modal").load("{{ route('modal-v2') }}", function() {
                $('#modalTable').modal('show');
            })
        })
        $("#templates-card").on("click", "#belumSiap", function() {

            $("#templates-modal").load("{{ route('modal') }}", function() {
                $('#BelumSiap').modal('show');
            });

        })
        $("#templates-card").on("click", "#tambahFiled", function() {

        })
    })
</script>
@endsection