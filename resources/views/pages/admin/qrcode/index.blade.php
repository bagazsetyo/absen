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
                    @if(Helper::isAdmin())
                    <a href="{{ route('admin.qrcode.create') }}" class="main-btn primary-btn btn-hover btn-sm mb-4">
                        Tambah Qrcode
                    </a>
                    @endif

                    <div class="row">
                        <div class="select-style-1 col-6 col-lg-3">
                            <label for="filterKelas">Kelas:</label>
                            <div class="select-position">
                                <select id="filterKelas">
                                    <option value="">Semua</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="select-style-1 col-6 col-lg-3">
                            <label for="filterAngkatan">Filter Angkatan:</label>
                            <div class="select-position">
                                <select id="filterAngkatan">
                                    <option value="">Semua</option>
                                    @foreach ($angkatan as $a)
                                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="select-style-1 col-6 col-lg-3">
                            <label for="filterMatkul">Filter Matkul:</label>
                            <div class="select-position">
                                <select id="filterMatkul">
                                    <option value="">Semua</option>
                                    @foreach ($matkul as $m)
                                        <option value="{{ $m->id }}">
                                            {{ Helper::getHariByDate($m->jadwal) . '-' . date('H:i', strtotime($m->jam_mulai)) . '-' . $m->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-style-1 col-6 col-lg-3">
                            <label for="filterHari">Date</label>
                            <input type="date" name="filterHari" id="filterHari">
                        </div>
                    </div>
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
        var filterKelas = $('#filterKelas');
        var filterAngkatan = $('#filterAngkatan');
        var filterMatkul = $('#filterMatkul');
        var filterHari = $('#filterHari');

        filterKelas.on('change', function() {
            table.draw();
        });

        filterAngkatan.on('change', function() {
            table.draw();
        });

        filterMatkul.on('change', function() {
            table.draw();
        });

        filterHari.on('change', function() {
            table.draw();
        });

        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url()->current() }}",
                data: function(d) {
                    d.filterKelas = filterKelas.val();
                    d.filterAngkatan = filterAngkatan.val();
                    d.filterMatkul = filterMatkul.val();
                    d.filterHari = filterHari.val();
                }
            },
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
                    visible: '{{ Helper::isAdmin() }}'
                },
            ],
            responsive: true,
            autoWidth: false,
            initComplete: function() {
                // Tampilkan jumlah data terfilter
                var api = this.api();
                var keluaran = api.column(4, {
                    search: 'applied'
                }).data().length;
                var total = api.column(4).data().length;

                $(api.column(4).footer()).html('Keluaran (' + keluaran + ' dari ' + total + ' data)');
            }
        });
        $(document).on('click', '.delete', function() {
            dataId = $(this).attr('id');
            console.log(dataId)
            $('#konfirmasi-modal').modal('show');
        });
    </script>
@endpush
