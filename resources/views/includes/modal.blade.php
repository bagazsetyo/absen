
<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Basic Modal</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>


<div class="modal fade text-left" id="danger" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel120">Apak anda yakin ingin menghapus data ini?
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    x
                </button>
            </div>
            <div class="modal-body">
                Data yang sudah dihapus tidak dapat dikembalikan.
                Tekan tombol "Hapus" untuk menghapus data.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="button" class="btn btn-danger ml-1 hapus-data"
                    data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Hapus</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // add spiner if data onload
        modal.find('.modal-body').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
        modal.find('.modal-body').load(button.data('remote'));
        modal.find('.modal-title').text(button.data('title'));

    })


    $('#danger').on('show.bs.modal',function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        url = button.data('remote')
    })
    $('.hapus-data').click(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log(csrfToken);
        $.ajax({
            url: url,
            type: 'delete',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function() {
                $('#tombol-hapus').text('Hapus Data');
            },
            success: (response) => {
                if (response) {
                    $('#danger').modal('hide');
                    
                    $('#datatables').DataTable().ajax.reload();
                    const toastElement = document.querySelector('.toast');
                    toastElement.classList.add('bg-success');
                    const toast = new bootstrap.Toast(toastElement);
                    const toastBodyElement = toastElement.querySelector('.toast-body').innerHTML =
                        response.message;
                    toast.show();
                }
            },
            error: function(response) {
                swal('Success', response.data, response.code)
            }
        })
    })
</script>
