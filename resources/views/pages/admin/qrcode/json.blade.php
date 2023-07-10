@extends('layouts.master')

@section('title', 'Generate Qr code')

@push('after-style')
    <script src="{{ asset('assets/js/qrcode-reader.js') }}"></script>

    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            width: 100%;
            height: 150px;
            padding: 25px;
            text-align: center;
            margin: 0 auto;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #drop-area.highlight {
            background-color: #f5f5f5;
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('admin.qrcode.store.json') }}" method="post">
        @csrf
        <div class="container-fluid">
            <div class="pt-30">
                <div class="card">
                    <div class="card-body">
                        <div class="form pt-30">
                            <div class="input-style-3 ">
                                <label>Data</label>
                                <textarea id="dataSemester" required rows="7"></textarea>
                            </div>
                            <div class="input-style-1">
                                <label>Name</label>
                                <input type="text" placeholder="Nama" name="nama" required />
                            </div>
                            <div class="input-style-1">
                                <label>Periode Id</label>
                                <input type="text" placeholder="Nama" id="periodeId" required />
                            </div>
                            <div class="select-style-1 ">
                                <label>Angkatan</label>
                                <div class="select-position">
                                    <select class="angkatan" name="angkatan" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-style-1 ">
                                <label>Kelas</label>
                                <div class="select-position">
                                    <select class="kelas" name="kelas" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-style-1 ">
                                <label>Matkul</label>
                                <div class="select-position">
                                    <select class="matkul" name="matkul" required>
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="select-style-1 ">
                                <textarea name="dataQrCode" class="dataQrCode" id="" style="display: none;" required></textarea>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table dt-responsive nowrap" id="datatables" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Meeting To</th>
                                        <th>Teaching Id</th>
                                        <th>Periode Id</th>
                                        <th>Date</th>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Date</th>
                                        <th>Hour</th>
                                        <th>Minutes</th>
                                        <th>Second</th>
                                        <th>Unique Code</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="">
                            <button class="main-btn primary-btn btn-hover btn-sm mb-4" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('after-script')
    <script>
        const dataSemester = $('#dataSemester');
        const periodeId = $('#periodeId');
        const dataQrCode = $('.dataQrCode');
        
        dataSemester.on('change', function(e){
            generateData();
        })
        periodeId.on('change', function(e){
            generateData();
        })

        function generateData()
        {
            var value = dataSemester.val().trim();
            var jsonData = JSON.parse(value);

            let periodeIdValue = periodeId.val().trim();

            let data = [];

            for (i = 0; i < jsonData.length; i++) {
                let thisData = jsonData[i];
                let thisDate = thisData.tgljadwal.split('-').join('') + thisData.waktuselesai.split(':').join('');
                // check if date = 14 length 
                if (thisDate.length < 14) {
                    thisDate = thisDate + '00';
                }
                let dataUniqueCode = "teachingId:" + thisData.idjadwal + "|periodId:"+periodeIdValue+"|date:" + thisDate + "|meetingTo:" + thisData.pertemuanke;
                let uniqueCodeBase64 = btoa(dataUniqueCode);
                let thisUniqueCode = "{" + uniqueCodeBase64 + "}";


                let mainData = {
                    teachingId: thisData.idjadwal,
                    periodId: periodeIdValue, 
                    date: thisDate,
                    meetingTo: thisData.pertemuanke,
                    tahun: thisData.tgljadwal.split('-')[0],
                    bulan: thisData.tgljadwal.split('-')[1],
                    tanggal: thisData.tgljadwal.split('-')[2],
                    jam: thisData.waktuselesai.split(':')[0],
                    menit: thisData.waktuselesai.split(':')[1],
                    detik: '00',
                    uniqueCode: thisUniqueCode,
                    minggu_ke: thisData.pertemuanke
                };

                data.push(mainData);
            }

            datatables.clear().draw();
            datatables.rows.add(data).draw();
            $('.dataQrCode').val(JSON.stringify(data));
        }



        let totalPertemuan = 14;
        let satuMinggu = 7;
        let libur = [];

        let qrcodeData = "";

        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        let datatables = $('#datatables').DataTable({
            data: dataQrCode.val() ? dataQrCode.val() : [],
            responsive: true,
            autoWidth: false,
            columns: [{
                    data: 'meetingTo'
                },
                {
                    data: 'teachingId'
                },
                {
                    data: 'periodId'
                },
                {
                    data: 'date'
                },
                {
                    data: 'tahun'
                },
                {
                    data: 'bulan',
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            const index = parseInt(data) - 1;
                            return namaBulan[index] || '';
                        }
                        return data;
                    }
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'jam'
                },
                {
                    data: 'menit',
                    visible: false
                },
                {
                    data: 'detik',
                    visible: false
                },
                {
                    data: 'uniqueCode',
                    visible: false
                },
            ]
        });

        let angkatan = $('.angkatan').select2({
            placeholder: 'Pilih Angkatan',
            ajax: {
                url: '{{ route('admin.filter.select.angkatan') }}',
                dataType: 'json',
            },
            afterSelect: function(data) {
                kelas.val(null).trigger('change');
                matkul.val(null).trigger('change');
            }
        });
        let kelas = $('.kelas').select2({
            placeholder: 'Pilih Kelas',
            ajax: {
                url: '{{ route('admin.filter.select.kelas') }}',
                data: function (params) {
                    return {
                        angkatan: $('.angkatan').val(),
                        term: params.term // Jika Anda ingin mengirim juga nilai pencarian (term)
                    };
                }
            },
            afterSelect: function(data) {
                matkul.val(null).trigger('change');
            }
        });
        let matkul = $('.matkul').select2({
            placeholder: 'Pilih Matkul',
            ajax: {
                url: '{{ route('admin.filter.select.matkul') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        kelas: $('.kelas').val(),
                        term: params.term // Jika Anda ingin mengirim juga nilai pencarian (term)
                    };
                }
            }
        });
    </script>
@endpush
