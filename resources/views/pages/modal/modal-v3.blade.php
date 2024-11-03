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
                <div id="dynamicForm"></div>
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
    });
</script>