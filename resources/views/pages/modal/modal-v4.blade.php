 <div class="modal fade" id="modalTable" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title align-self-center"
                     id="judulModal">New message</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                     aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-1" class="form-label">Nama Lengkap</label>
                                     <input type="text" class="form-control" id="field-1" placeholder="Nama Lengkap">
                                     <div class="invalid-feedback">Please provide a valid Nama Lengkap.</div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-2" class="form-label">Username</label>
                                     <input type="text" class="form-control" id="field-2" placeholder="Username">
                                     <div class="invalid-feedback">Please provide a valid Username.</div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-3" class="form-label">Email</label>
                                     <input type="email" class="form-control" id="field-3" placeholder="Email">
                                     <div class="invalid-feedback">Please provide a valid Email.</div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="mb-3">
                                     <label for="field-4" class="form-label">Password</label>
                                     <input type="password" class="form-control" id="field-4" placeholder="Password">
                                     <div class="invalid-feedback">Please provide a valid Password.</div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="simpanField">Simpan</button>
                 <button type="button" class="btn btn-warning" id="ubahField">Edit</button>
             </div>
         </div>
     </div>
 </div>
 <input type="hidden" id="idUser">
 <script>
     function validasi() {
         let isValid = true;

         const fields = [{
                 id: "field-1",
                 name: "Nama Lengkap"
             },
             {
                 id: "field-2",
                 name: "Username"
             },
             {
                 id: "field-3",
                 name: "Email"
             }
         ];

         fields.forEach(field => {
             const input = document.getElementById(field.id);
             const feedback = input.nextElementSibling;

             if (!input.value.trim()) {
                 input.classList.add("is-invalid");
                 if (feedback) {
                     feedback.textContent = `Please provide a valid ${field.name}.`;
                 }
                 isValid = false;
             } else {
                 input.classList.remove("is-invalid");
             }
         });

         const passwordInput = document.getElementById("field-4");
         if (passwordInput.value.trim()) {
             passwordInput.classList.remove("is-invalid");
         }

         return isValid;
     }


     $(document).ready(function() {

         $("#simpanField").click(function() {
             const passwordInput = document.getElementById("field-4");
             const feedback = passwordInput.nextElementSibling;
             let isValid = true

             if (!passwordInput.value.trim()) {
                 passwordInput.classList.add("is-invalid");
                 if (feedback) {
                     feedback.textContent = "Please provide a valid password.";
                 }
                 isValid = false;
             } else {
                 passwordInput.classList.remove("is-invalid");
                 if (feedback) {
                     feedback.textContent = "";
                 }
             }

             if (validasi() && isValid) {
                 $.ajax({
                     type: "POST",
                     url: "{{ route('tambahUser') }}",
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
             }
         })
         $("#ubahField").click(function() {
             if (validasi()) {
                 const data = {
                     _token: $('meta[name="csrf-token"]').attr('content'),
                     id: $("#idUser").val(),
                     name: $("#field-1").val(),
                     username: $("#field-2").val(),
                     email: $("#field-3").val()
                 };

                 const password = $("#field-4").val().trim();
                 if (password) {
                     data.password = password;
                 }

                 $.ajax({
                     type: "POST",
                     url: "{{ route('ubahUser') }}",
                     data: data,
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
             }
         })
     })
 </script>