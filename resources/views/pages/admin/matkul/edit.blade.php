<div>
    <form method="post" id="formData">
        @csrf
        @method('PUT')
        <div class="form-group input-style-1">
            <label for="group">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ $data->nama }}" class="form-control" placeholder="Teknik Informatika">
        </div>
        <div class="form-group input-style-1">
            <label for="kode">Kode</label>
            <input type="text" name="kode" id="kode" value="{{ $data->kode }}" class="form-control" placeholder="TI">
        </div>
        <div class="select-style-1">
            <label for="filterAngkatan">Angktan:</label>
            <div class="select-position">
                <select id="filterAngkatan" name="id_angkatan">
                    <option value="">pilih</option>
                    @foreach ($angkatan as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="select-style-1">
            <label for="filterKelas">Kelas:</label>
            <div class="select-position">
                <select id="filterKelas" name="id_kelas">
                    <option value="">pilih</option>
                </select>
            </div>
        </div>
        <div class="input-style-1">
            <label for="group">Jadwal</label>
            <input type="date" name="jadwal" value="{{ $data->jadwal }}">
        </div>
        <div class="input-style-1">
            <label for="start-time">Jam Mulai:</label>
            <input type="time" id="start-time" name="jam_mulai" value="{{ $data->jam_mulai }}" data-toggle="datepicker">
        </div>
        <div class="input-style-1">
            <label for="end-time">Jam Selesai:</label>
            <input type="time" id="end-time" name="jam_selesai" value="{{ $data->jam_selesai }}" data-toggle="datepicker">
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
            url: '{{ route('admin.matkul.update', $data->id) }}',
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
