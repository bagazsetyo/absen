@extends('layouts.master')

@section('title', 'Permission')

@section('content')
    <div class="container-fluid">
        <div class="row pt-30">
            @if (session('success'))
                <div class="alert-box success-alert p-0">
                    <div class="alert">
                        <h4 class="alert-heading">Success</h4>
                        <p class="text-medium">
                            {!! session('success') !!}
                        </p>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.qrcode.create') }}" class="main-btn primary-btn btn-hover btn-sm mb-4">
                        Tambah Qrcode
                    </a>

                    <table class="table dt-responsive nowrap" id="datatables" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Pertemuan Ke</th>
                                <th>Kelas</th>
                                <th>Angkatan</th>
                                <th>Matkul</th>
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
            columns: [{
                    data: 'id',
                    name: 'id',
                    searchable: false,
                    orderable: false,
                    visible: false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'meetingTo',
                    name: 'meetingTo'
                },
                {
                    data: 'kelas.nama',
                    name: 'kelas.nama'
                },
                {
                    data: 'angkatan.nama',
                    name: 'angkatan.nama'
                },
                {
                    data: 'matkul.nama',
                    name: 'matkul.nama'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '200px',
                    maxWidth: '200px',
                    searchable: false,
                    orderable: false,
                },
            ],
            responsive: true,
            autoWidth: false,
        });
        $(document).on('click', '.delete', function () {
            dataId = $(this).attr('id');
            console.log(dataId)
            $('#konfirmasi-modal').modal('show');
        });

    </script>
@endpush
