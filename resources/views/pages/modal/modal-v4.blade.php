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
                                     <label for="field-3" class="form-label">Nama Lengkap</label>
                                     <input type="text" class="form-control" id="field-1" placeholder="Nama Lengkap">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-3" class="form-label">Username</label>
                                     <input type="text" class="form-control" id="field-2" placeholder="Username">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-3" class="form-label">Email</label>
                                     <input type="email" class="form-control" id="field-3" placeholder="Email">
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="mb-3">
                                 <label for="field-3" class="form-label">Password</label>
                                 <input type="password" class="form-control" id="field-4" placeholder="Password">
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanField">Simpan</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         $("#simpanField").click(function() {
             $.ajax({
                 type: "POST",
                 url: "{{ route('tambahTable') }}",
                 data: {
                     _token: $('meta[name="csrf-token"]').attr('content'),
                     name: $("#field-1").val(),
                     username: $("#field-2").val(),
                     email: $("#field-3").val(),
                     password: $("#field-4").val()
                 },
                 success: function(data) {
                     $("#templates-toast").load("{{ route('toast-v1') }}", function(response, status, xhr) {
                         if (status == "success") {
                             $("#pesantoast").text(data.toast);
                             $('#liveToast').toast('show');
                         } else {
                             console.error("Gagal memuat konten: " + xhr.status + " " + xhr.statusText);
                         }
                     });
                     loadDataUser()
                     $('#modalTable').modal('hide');
                 },
                 error: function(xhr) {
                     console.error("Terjadi error: " + xhr.responseText);
                 }
             });
             loadDataUser()
         })
     })
 </script>