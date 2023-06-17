@extends('layouts.master')

@section('title', 'Kelas')

@section('content')
<div class="container-fluid">
    <div class="row pt-30">
        <div class="card">
            <div class="card-body">
            <button
                data-remote="{{ route('admin.kelas.create') }}"
                data-title="Create Kelas"
                class="main-btn primary-btn btn-hover btn-sm mb-4"
                data-bs-toggle="modal"
                data-bs-target="#modal">
                Tambah Kelas
            </button>
    
                <table class="table dt-responsive nowrap" id="datatables" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script>

    $('#datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url()->current() }}",
        columns: [
            {data: 'id', name: 'id', searchable: false, orderable: false, visible: false},
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'nama', name: 'nama'},
            {data: 'action', name: 'action', width: '200px', maxWidth: '200px', searchable: false, orderable: false,},
        ],
        responsive: true,
        autoWidth: false, 
    });

</script>
@endpush