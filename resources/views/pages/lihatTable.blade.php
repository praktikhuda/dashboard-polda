@extends('app')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title align-middle" id="judul"></h5>
                <p id="deskripsi"></p>
                <div class="table-responsive" id="cetakPdf">
                    <div id="pdfTitle" style="display: none;">Judul Tabel</div>
                    <table id="myTableModal" class="table table-bordered" style="width: 100%">
                        <thead>
                            <tr></tr>
                        </thead>
                        <tbody></tbody>
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
        const id = urlParams.get('id');

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
        $("#judul").on("click", "#tambahTable", function() {
            $.ajax({
                type: "GET",
                url: "{{ route('lihatTable__') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#templates-modal").load(response.redirect, function() {
                        console.log(response);

                        $.each(response.data, function(i, a) {
                            console.log(a.judul);

                            $("h5#modalTable").text(a.judul)
                            let dataJson = Array.isArray(a.data) ? a.data : JSON.parse(a.data);
                            $.each(dataJson, function(j, b) {
                                $('#dynamicForm').append(`
                                    <div id="form-group">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="field-3" class="form-label">${b.title}</label>
                                                            <input type="text" class="form-control" id="field-${j}" data-nama_col="${b.nama_col}" placeholder="${b.title}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            })
                        })
                        $("#simpanField").click(function() {
                            let dataForm = [{}];

                            $('#dynamicForm input').each(function() {
                                let nama_col = $(this).data("nama_col");
                                let value = $(this).val();
                                dataForm[0][nama_col] = value;
                            });
                            let dataJson = {
                                id_table: id,
                                data: dataForm
                            }
                            $.ajax({
                                type: "POST",
                                url: "{{ route('addTable__') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    dataJson: dataJson
                                },
                                success: function(response) {
                                    console.log(response);
                                }
                            });
                            console.log(dataForm);
                        })

                        $('#modalTable').modal('show');
                    });
                }
            });
        })

        document.getElementById('download').addEventListener('click', () => {
            const element = document.getElementById('cetakPdf');

            const filterElement = document.querySelector('.dataTables_filter');
            const infoElement = document.querySelector('.dataTables_info');
            const paginateElement = document.querySelector('.dataTables_paginate');
            const lengthElement = document.querySelector('.dataTables_length');
            const pdfTitleElement = document.getElementById('pdfTitle');

            const originalDisplayFilter = filterElement ? filterElement.style.display : 'block';
            const originalDisplayInfo = infoElement ? infoElement.style.display : 'block';
            const originalDisplayPaginate = paginateElement ? paginateElement.style.display : 'block';
            const originalDisplayLength = lengthElement ? lengthElement.style.display : 'block';
            const originalPdfTitleDisplay = pdfTitleElement ? pdfTitleElement.style.display : 'none';

            if (filterElement) filterElement.style.display = 'none';
            if (infoElement) infoElement.style.display = 'none';
            if (paginateElement) paginateElement.style.display = 'none';
            if (lengthElement) lengthElement.style.display = 'none';

            if (pdfTitleElement) pdfTitleElement.style.display = 'block';

            const opt = {
                margin: 1,
                filename: 'table.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };

            html2pdf().from(element).set(opt).save().then(() => {
                if (filterElement) filterElement.style.display = originalDisplayFilter;
                if (infoElement) infoElement.style.display = originalDisplayInfo;
                if (paginateElement) paginateElement.style.display = originalDisplayPaginate;
                if (lengthElement) lengthElement.style.display = originalDisplayLength;
                if (pdfTitleElement) pdfTitleElement.style.display = originalPdfTitleDisplay;
            });
        });

    })
</script>
@endsection