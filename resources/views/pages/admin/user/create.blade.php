<div>
    <form method="post" id="create">
        @csrf
        <div class="form-group input-style-1">
            <label for="">Nama</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Tes">
        </div>
        <div class="form-group input-style-1">
            <label for="">NPM</label>
            <input type="text" name="npm" id="npm" class="form-control" placeholder="211322">
        </div>
        <div class="form-group input-style-1">
            <label for="">WA</label>
            <input type="text" name="wa" id="wa" class="form-control" placeholder="08123">
        </div>
        <div class="select-style-1 ">
            <label>Angkatan</label>
            <div class="select-position">
                <select class="angkatan" name="angkatan" required id="filterAngkatan">
                    <option value="">Pilih Angkatan</option>
                    @foreach ($angkatan as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="select-style-1 ">
            <label>Kelas</label>
            <div class="select-position">
                <select class="kelas" name="kelas" required id="filterKelas">
                    <option value="">Pilih Kelas</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button class="main-btn primary-btn btn-hover btn-sm" id="submit">Submit</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var filterAngkatan = $('#filterAngkatan');
        var filterKelas = $('#filterKelas');

        filterAngkatan.on('change', function() {
            $.ajax({
                url: "{{ route('admin.filter.kelas') }}",
                type: "POST",
                data: {
                    angkatan: $(this).val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    let filterKelas = $('#filterKelas');
                    filterKelas.empty();

                    filterKelas.append('<option value="">pilih</option>');
                    $.each(data, function(key, value) {
                        filterKelas.append('<option value="' + value.id + '">' +
                            value.nama +
                            '</option>');
                    });
                }
            })
        })
    });

    $('#create').submit(function(e) {
        e.preventDefault();
        var actionType = $('#submit').val();
        document.getElementById("submit").disabled = true;
        $('#submit').html('Creating..');
        let formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: '{{ route('admin.user.store') }}',
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
