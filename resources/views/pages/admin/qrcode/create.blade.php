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
    <form action="{{ route('admin.qrcode.store') }}" method="post">
        @csrf
        <div class="container-fluid">
            <div class="pt-30">
                <div class="card">
                    <div class="card-body">
                        <div id="drop-area">
                            <h3>Drag and Drop QR Code Image Here<br>or Click to Select File</h3>
                            <input type="file" accept="image/*" id="qr-input" style="display: none;">
                        </div>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <div id="result"></div>
                        <div id="decoded-result"></div>

                        <div class="form pt-30">
                            <div class="input-style-1">
                                <label>Name</label>
                                <input type="text" placeholder="Nama" name="nama" required />
                            </div>
                            <div class="input-style-1">
                                <label>Minggu</label>
                                <input type="text" placeholder="Nama" name="minggu" value="14" />
                            </div>
                            <div class="input-style-1">
                                <label>Libur</label>
                                <input type="text" placeholder="libur" name="libur" value="" />
                                <span class="text-muted">gunakan (,) untuk membuat multiple minggu libur</span>
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
                                <textarea name="jsonData" class="jsonData" id="" style="display: none;" required></textarea>
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
        const dropArea = document.getElementById('drop-area');
        const qrInput = document.getElementById('qr-input');
        const canvas = document.getElementById('canvas');
        const resultDiv = document.getElementById('result');
        const decodedResultDiv = document.getElementById('decoded-result');

        let totalPertemuan = 14;
        let satuMinggu = 7;
        let libur = [];

        let qrcodeData = "";

        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        let jsonData = [];

        let datatables = $('#datatables').DataTable({
            data: jsonData,
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
            minimumInputLength: 1,
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
            minimumInputLength: 1,
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
            minimumInputLength: 1,
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

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('highlight');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('highlight');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('highlight');
            const file = event.dataTransfer.files[0];
            readQRCodeImage(file);
        });

        dropArea.addEventListener('click', () => {
            qrInput.click();
        });

        qrInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            readQRCodeImage(file);
        });

        function readQRCodeImage(file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const image = new Image();
                image.onload = function() {
                    canvas.width = image.width;
                    canvas.height = image.height;
                    const context = canvas.getContext('2d');
                    context.drawImage(image, 0, 0, image.width, image.height);
                    const imageData = context.getImageData(0, 0, image.width, image.height);
                    const code = jsQR(imageData.data, image.width, image.height);
                    if (code) {
                        resultDiv.innerText = code.data;
                        const cleanedData = code.data.replace("{", "").replace("}", "");
                        const decodedResult = atob(cleanedData);

                        // Convert to JSON
                        const jsonData = {};
                        const pairs = decodedResult.split('|');
                        pairs.forEach(pair => {
                            const [key, value] = pair.split(':');
                            jsonData[key] = value;
                        });

                        const input = jsonData.date;
                        const splittedArray = input.match(/.{1,2}/g);
                        const formattedDate = {
                            year: `${splittedArray[0]}${splittedArray[1]}`,
                            month: splittedArray[2],
                            day: splittedArray[3],
                            hour: splittedArray[4],
                            minute: splittedArray[5],
                            second: splittedArray[6]
                        };
                        decodedResultDiv.innerText = JSON.stringify(jsonData);
                        qrcodeData = jsonData;
                        tableList(jsonData);
                    } else {
                        resultDiv.innerText = 'QR code not found';
                        decodedResultDiv.innerText = '';
                    }
                };
                image.src = event.target.result;
            };

            reader.readAsDataURL(file);
        }

        function tableList(data) {
            const dateString = data.date;
            const dateArray = [
                parseInt(dateString.substring(0, 4)),
                parseInt(dateString.substring(4, 6)),
                parseInt(dateString.substring(6, 8)),
                parseInt(dateString.substring(8, 10)),
                parseInt(dateString.substring(10, 12)),
                parseInt(dateString.substring(12, 14))
            ];
            let date = new Date(...dateArray);
            date.setMonth(date.getMonth() - 1);

            let selisih = data.meetingTo * 7;
            date.setDate(date.getDate() - selisih);

            let teachingId = parseInt(data.teachingId) - parseInt(data.meetingTo);
            teachingId += 1;

            // counter minggu 
            let minggu = 0;

            let dataPertemuan = [];
            for (i = 1; i <= totalPertemuan; i++) {

                let dateEveryWeek = new Date(date);
                dateEveryWeek.setDate(dateEveryWeek.getDate() + (satuMinggu * i));

                if (libur.length > 0) {
                    if (libur.includes(i)) {
                        continue;
                    }
                }

                let thisYear = dateEveryWeek.getFullYear();
                let thisMonth = String(dateEveryWeek.getMonth() + 1).padStart(2, '0');
                let thisDate = String(dateEveryWeek.getDate()).padStart(2, '0');
                let thisHour = String(dateEveryWeek.getHours()).padStart(2, '0');
                let thisMinute = String(dateEveryWeek.getMinutes()).padStart(2, '0');
                let thisSecond = String(dateEveryWeek.getSeconds()).padStart(2, '0');

                let fullDate = `${thisYear}${thisMonth}${thisDate}${thisHour}${thisMinute}${thisSecond}`;

                let thisTeachingId = teachingId++;
                let uniqueCode = `teachingId:${thisTeachingId}|periodId:${data.periodId}|date:${fullDate}|meetingTo:${i}`;
                let uniqueCodeBase64 = btoa(uniqueCode);

                // increament minggu 
                minggu++

                let mainData = {
                    teachingId: thisTeachingId,
                    periodId: data.periodId,
                    date: fullDate,
                    meetingTo: minggu,
                    tahun: thisYear,
                    bulan: thisMonth,
                    tanggal: thisDate,
                    jam: thisHour,
                    menit: thisMinute,
                    detik: thisSecond,
                    uniqueCode: uniqueCodeBase64,
                    minggu_ke: minggu
                };

                dataPertemuan.push(mainData);
            }
            jsonData = [];
            jsonData.push(...dataPertemuan);
            $('.jsonData').val(JSON.stringify(jsonData));

            datatables.clear().rows.add(jsonData).draw();
        }

        // on change libur dan masuk berap minggu
        $('input[name="minggu"]').on('change', function() {
            totalPertemuan = $(this).val();

            if (libur.length > 0) {
                let newLibur = [];
                for (let i = 0; i <= libur.length; i++) {
                    if (libur[i] < totalPertemuan) {
                        newLibur.push(libur[i]);
                    }
                }
                libur = newLibur;
                let valueLibur = libur.join(',');
                $('input[name="libur"]').val(valueLibur);
            }

            if (qrcodeData) {
                tableList(qrcodeData);
            }
        });

        $('input[name="libur"]').on('change', function() {
            var listLibur = $(this).val();
            libur = [];
            libur = listLibur.split(',');

            // loop dengan for
            for (let i = 0; i < libur.length; i++) {
                if (libur[i] > totalPertemuan) {
                    alert('Libur tidak boleh lebih dari total pertemuan');
                    libur = [];
                    break;
                }
                libur[i] = parseInt(libur[i]);
            }

            // group jika ada yang sama 
            libur = libur.filter((item, index) => libur.indexOf(item) === index);
            // join kembali
            libur.sort(function(a, b) {
                return a - b
            });
            let valueLibur = libur.join(',');
            $(this).val(valueLibur);

            if (libur.length > 0) {
                totalPertemuan = parseInt(libur.length) + parseInt(totalPertemuan);
                $('input[name="minggu"]').val(totalPertemuan);
            }

            if (qrcodeData) {

                tableList(qrcodeData);
            }
        });
    </script>
@endpush
