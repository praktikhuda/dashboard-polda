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
                                <img class="card-img-top img-fluid opacity-50" src="{{ asset('storage/uploads/${a.image}') }}" alt="Card image cap" style="object-fit: cover; height: 200px; float:center">
                                <div class="card-body">
                                    <h4 class="card-title">${a.judul}</h4>
                                    <p class="card-text text-muted font-size-13">${a.deskripsi}</p>
                                    <button type="button" class="btn btn-warning" id="editTable-${a.id}">Edit</button>
                                    <button type="button" class="btn btn-primary" id="lihatTable-${a.id}">Lihat</button>
                                    <button type="button" class="btn btn-danger" id="hapusTable-${a.id}">Hapus</button>
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
                            $(".modal-footer").append(`<button type="button" class="btn btn-warning" id="editFieldModal">Edit</button>`)
                            $("#addField").hide()
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
                                        $("#field-2").val(a.deskripsi)
                                        $("#gambarfieldHidden").val(a.image)
                                        $("#idfield").val(a.id)
                                        let dataJson = Array.isArray(a.data) ? a.data : JSON.parse(a.data);
                                        $.each(dataJson, function(j, b) {
                                            dataField += `
                                                <img id="imageShow" class="text-center pb-3" width="200px" src="{{ asset('storage/uploads/${a.image}') }}" alt="">
                                                <div class="form-group">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="field-3" class="form-label">Nama Kolom</label>
                                                                        <input type="text" class="form-control nama-kolom" id="field-3" placeholder="Nama Kolom" value="${b.title}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="field-3" class="form-label">Title Kolom</label>
                                                                        <input type="text" class="form-control title-kolom" id="field-4" placeholder="Title" value="${b.nama_col}">
                                                                    </div>
                                                                </div>
                                                               <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="field-4" class="form-label">Type</label>
                                                                        <select class="form-control type-kolom" id="field-5" name="state">
                                                                            <option value="text" ${b.type === 'text' ? 'selected' : ''}>Text</option>
                                                                            <option value="number" ${b.type === 'number' ? 'selected' : ''}>Number</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;

                                        })
                                        $("#dynamicForm").html(dataField)
                                        $("#gambarfield").change(function(e) {
                                            let file = e.target.files[0];
                                            if (file) {
                                                $('#imageShow').attr('src', URL.createObjectURL(file));
                                            }
                                        })
                                        $("#simpanField").hide()
                                    })
                                }
                            });
                            $('#modalTable').modal('show');
                        })
                    })
                    $("#templates-card").on("click", "#hapusTable-" + a.id, function() {
                        $.ajax({
                            type: "get",
                            url: "/hapus/" + a.id,
                            data: {
                                id: a.id
                            },
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
                            },
                            error: function(xhr) {
                                console.error("Terjadi error:", xhr.responseText);
                                alert("Terjadi kesalahan saat menghapus data.");
                            }
                        });
                    });

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
    })
</script>
@endsection