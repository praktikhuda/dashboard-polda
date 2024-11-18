 <div class="modal fade" id="modalTable" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title align-self-center"
                     id="modalTable">New message</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                     aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-3" class="form-label">Judul Table</label>
                                     <input type="text" class="form-control" id="field-1" placeholder="Judul">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-3" class="form-label">Deskripsi Table</label>
                                     <input type="text" class="form-control" id="field-2" placeholder="Deksripsi">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <label for="field-3" class="form-label">Image Table</label>
                                 <div class="input-group mb-3">
                                     <input type="file" class="form-control" id="gambarfield" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                                     <input type="hidden" class="form-control" id="gambarfieldHidden" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                                     <input type="hidden" class="form-control" id="idfield">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div id="dynamicForm"></div>
                 <button id="addField" type="button" class="btn btn-primary">Tambah Input</button>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanField">Simpan</button>

             </div>
         </div>
     </div>
 </div>
 <div id="templates-toast"></div>
 <script>
     $(document).ready(function() {
         $("#imageShow").hide()
         $('#addField').click(function() {
             $('#dynamicForm').append(`
                <div id="form-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field-3" class="form-label">Nama Kolom</label>
                                        <input type="text" class="form-control nama-kolom" id="field-3" placeholder="Nama Kolom">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field-4" class="form-label">Title Kolom</label>
                                        <input type="text" class="form-control title-kolom" id="field-4" placeholder="Title">
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field-4" class="form-label">Type</label>
                                        <select class="form-control type-select" id="field-5" name="state">  
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                        </select>
                                    </div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-danger" id="removeField"><i class="fas fa-trash"></i> Hapus</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
         });

         $('#dynamicForm').on('click', '#removeField', function() {
             $(this).closest('#form-group').remove();
         });

         $("#simpanField").click(function(e) {
             e.preventDefault();

             let judul = $('#field-1').val();
             let deskripsi = $('#field-2').val();

             let data = [];
             $('#dynamicForm').find('.form-group').each(function() {
                 let namaCol = $(this).find('.nama-kolom').val();
                 let title = $(this).find('.title-kolom').val();
                 let type = $(this).find('.type-select').val();

                 if (namaCol && title && type) {
                     data.push({
                         nama_col: namaCol,
                         title: title,
                         type: type
                     });
                 }
             });

             let formData = new FormData();
             formData.append('_token', "{{ csrf_token() }}");
             formData.append('judul', judul);
             formData.append('deskripsi', deskripsi);

             let gambar = $("#gambarfield")[0].files[0];
             if (gambar) {
                 formData.append('image', gambar);
             }
             formData.append('data', JSON.stringify(data));

             $.ajax({
                 type: "POST",
                 url: "{{ route('tambahTable') }}",
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function(data) {
                     $("#templates-toast").load("{{ route('toast-v1') }}", function(response, status, xhr) {
                         if (status == "success") {
                             $("#pesantoast").text(data.toast);
                             $('#liveToast').toast('show');
                         } else {
                             console.error("Gagal memuat konten: " + xhr.status + " " + xhr.statusText);
                         }
                     });

                     $('#modalTable').modal('hide');
                 },
                 error: function(xhr) {
                     console.error("Terjadi error: " + xhr.responseText);
                 }
             });
         });

     });
     $("#templates-modal").on("click", "#editFieldModal", function(e) {
         e.preventDefault();

         console.log("Mengirim data untuk diedit...");

         let judul = $('#field-1').val();
         let deskripsi = $('#field-2').val();
         let id = $('#idfield').val();

         let data = [];
         $('#dynamicForm').find('.form-group').each(function() {
             let namaCol = $(this).find('.nama-kolom').val();
             let title = $(this).find('.title-kolom').val();
             let type = $(this).find('.type-kolom').val();

             if (namaCol && title) {
                 data.push({
                     nama_col: namaCol,
                     title: title,
                     type: type
                 });
             }
         });

         if (!judul || !deskripsi || data.length === 0 || !id) {
             alert("Harap isi semua field yang diperlukan.");
             return;
         }

         let gambar = $("#gambarfield")[0].files[0];

         let gambarNull = gambar ? gambar : $("#gambarfieldHidden").val();

         let formData = new FormData();
         formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
         formData.append('judul', judul);
         formData.append('deskripsi', deskripsi);
         formData.append('image', gambarNull);
         formData.append('data', JSON.stringify(data));

         $.ajax({
             type: "POST",
             url: "/edit/" + id,
             data: formData,
             processData: false,
             contentType: false,
             success: function(data) {
                 $("#templates-toast").load("{{ route('toast-v1') }}", function(response, status, xhr) {
                     if (status == "success") {
                         $("#pesantoast").text(data.toast);
                         $('#liveToast').toast('show');
                     } else {
                         console.error("Gagal memuat konten: " + xhr.status + " " + xhr.statusText);
                     }
                 });

                 $('#modalTable').modal('hide');
             },
             error: function(xhr) {
                 console.error("Error:", xhr.responseText);
             }
         });

     });
 </script>