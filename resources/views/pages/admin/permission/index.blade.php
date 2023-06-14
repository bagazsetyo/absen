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
                    <a href="{{ route('admin.permission.create') }}" class="main-btn primary-btn btn-hover btn-sm mb-4">
                        Tambah Permission
                    </a>

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
                    data: 'name',
                    name: 'name'
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
    </script>
@endpush
