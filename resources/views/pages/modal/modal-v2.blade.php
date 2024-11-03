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
                         </div>
                     </div>
                 </div>
                 <div id="dynamicForm"></div>
                 <button id="addField" type="button" class="btn btn-primary">Tambah Input</button>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanField">Simpan</button>
                 <button type="button" class="btn btn-warning" id="editField">Edit</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         $("#editField").hide()
         $('#addField').click(function() {
             $('#dynamicForm').append(`
                <div id="form-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field-3" class="form-label">Nama Kolom</label>
                                        <input type="text" class="form-control" id="field-3" placeholder="Nama Kolom">
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
             $('#dynamicForm #form-group').each(function() {
                 let namaCol = $(this).find('#field-3').val();
                 let title = $(this).find('#field-4').val();

                 if (namaCol && title) {
                     data.push({
                         nama_col: namaCol,
                         title: title
                     });
                 }
             });

             let jsonData = {
                 judul: judul,
                 deskripsi: deskripsi,
                 data: data
             };
             console.log(jsonData);

             $.ajax({
                 type: "POST",
                 url: "{{ route('tambahTable') }}",
                 data: {
                     _token: "{{ csrf_token() }}",
                     jsonData: jsonData
                 },
                 success: function(response) {
                     console.log(response);
                     $('#modalTable').modal('show');
                 }
             });
         });
     });
 </script>