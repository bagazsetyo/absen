<div>
    <form method="post" id="formData">
        @csrf
        @method('PUT')
        <div class="form-group input-style-1">
            <label for="group">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ $data->nama }}" class="form-control" placeholder="A/B/C/D/K">
        </div>
        <div class="select-style-1">
            <label for="filterAngkatan">Angktan:</label>
            <div class="select-position">
                <select id="filterAngkatan" name="id_angkatan">
                    <option value="">pilih</option>
                    @foreach ($angkatan as $a)
                        <option value="{{ $a->id }}" @selected($a->id == $data->id_angkatan)>{{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>
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
            type:'POST',
            url: '{{ route('admin.kelas.update', $data->id) }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response) {
                    $('#datatables').DataTable().ajax.reload();
                    document.getElementById("submit").disabled = false;
                    $('#submit').html('Create');

                    const toastElement = document.querySelector('.toast');
                    toastElement.classList.add('bg-success');
                    const toast = new bootstrap.Toast(toastElement);
                    const toastBodyElement = toastElement.querySelector('.toast-body').innerHTML = response.message;
                    toast.show();

                }
            },
            error: function(response){
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
                const toastBodyElement = toastElement.querySelector('.toast-body').innerHTML = message;
                toast.show();
            }
        });
    });
</script>
