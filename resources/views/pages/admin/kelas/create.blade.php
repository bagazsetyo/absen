<div>
    <form method="post" id="formData">
        @csrf
        <div class="form-group input-style-1">
            <label for="group">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="A/B/C/D/K">
        </div>
        <div class="mt-3">
            <button class="main-btn primary-btn btn-hover btn-sm" id="submit">Submit</button>
        </div>
    </form>
</div>
<script>

    $('#formData').submit(function(e) {
        e.preventDefault();
        var actionType = $('#submit').val();
        document.getElementById("submit").disabled = true;
        $('#submit').html('Creating..');
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.kelas.store') }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response) {
                    this.reset();
                    $('#datatables').DataTable().ajax.reload();
                    document.getElementById("submit").disabled = false;
                    $('#submit').html('Create');

                    const toastElement = document.querySelector('.toast');
                    toastElement.classList.add('bg-success');
                    const toast = new bootstrap.Toast(toastElement);
                    const toastBodyElement = toastElement.querySelector('.toast-body').innerHTML =
                        response.message;
                    toast.show();
                }
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                let message = '';
                $.each(errors, function(key, value) {
                    message += value + '<br>';
                });

                document.getElementById("submit").disabled = false;
                $('#submit').html('Create');
                const toastElement = document.querySelector('.toast');
                toastElement.classList.add('bg-success');
                const toast = new bootstrap.Toast(toastElement);
                const toastBodyElement = toastElement.querySelector('.toast-body').innerHTML =
                    message;
                toast.show();
            }
        });
    });
</script>
