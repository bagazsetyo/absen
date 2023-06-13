@extends('layouts.master')

@section('title', 'Angkatan')

@section('content')
<div class="container-fluid">
    <div class="row pt-30">
        <div class="card">
            <div class="card-body">
            <button
                data-remote="{{ route('admin.angkatan.create') }}"
                data-title="Create Group"
                class="main-btn primary-btn btn-hover btn-sm mb-4"
                data-bs-toggle="modal"
                data-bs-target="#modal">
                Tambah Group
            </button>
    
                <table class="table" id="datatables">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tahun</th>
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
            {data: 'tahun', name: 'tahun'},
            {data: 'action', name: 'action'},
        ],
        responsive: true,
        autoWidth: false, 
    });

</script>
@endpush
