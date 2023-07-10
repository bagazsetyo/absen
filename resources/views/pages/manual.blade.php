@extends('layouts.manual')

@section('title', 'Generate QR Code')

@section('content')

<div class="card-style mb-30">
    <h1>Generate manual QR code</h1>
    <div class="input-style-1">
      <label>Data</label>
      <input id="data" required>
    </div>
    <div class="input-style-1">
      <label>Teaching Id</label>
      <input id="teachingId" required>
    </div>
    <div class="input-style-1">
      <label>Period Id</label>
      <input id="periodId" required>
    </div>
    <div class="input-style-1">
      <label>Date</label>
      <input id="date" required>
      <span class="text-sm text-muted">Format YYYY-MM-DD-HH-II-SS (*tidak menggunakan tanda "-". contoh 2023-12-30-10-40-20 => 20231230104020)</span>
    </div>
    <div class="input-style-1">
      <label>Meeting To</label>
      <input id="meetingTo" required>
    </div>
    <div class="input-style-1">
      <label>Output</label>
      <input type="url" id="output" disabled>
    </div>
    <button type="button" id="generateQRCode" class="main-btn primary-btn btn-hover">
        Generate QR Code
    </button>
    <div id="qrcode-container" class="mt-4">
      <div id="qrcode" class="qrcode "></div>
    </div>
  
    <!-- end input -->
  </div>
@endsection

@push('after-script')
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let data = $('#data');
        let teachingId = $('#teachingId');
        let periodId = $('#periodId');
        let date = $('#date');
        let meetingTo = $('#meetingTo');
        let output = $('#output');
        let button = $('#generateQRCode');
        let kurungKurawal = $('#kurungKurawal');

        data.on('change', function(e){
            let value = e.target.value;
            
            // decode base64 string
            let decodedString = atob(value);
            // if not valid base64 string 
            if (decodedString == '') {
                alert('Invalid base64 string');
                return;
            }

            // split | to array
            let splitted = decodedString.split('|');
            splitted.forEach(function(item){
                let splittedItem = item.split(':');
                let input = $('#' + splittedItem[0]);
                input.val(splittedItem[1]);
            });

            generateDataQrcode();

        });

        $(document).on('change', '#teachingId, #periodId, #date, #meetingTo, #kurungKurawal', function(e){
            generateDataQrcode();
        });

        button.on('click', function(e){
            generateQRCode();
        });

        function generateDataQrcode()
        {
            let teachingIdValue = teachingId.val();
            let periodIdValue = periodId.val();
            let dateValue = date.val();
            let meetingToValue = meetingTo.val();

            let data = 'teachingId:' + teachingIdValue + '|periodId:' + periodIdValue + '|date:' + dateValue + '|meetingTo:' + meetingToValue;

            let encodedString = btoa(data);
            encodedString = '{' + encodedString + '}';
            output.val(encodedString);
        }

        function generateQRCode() {
          let website = output.val();
          if (website) {
            let qrcodeContainer = document.getElementById("qrcode");
            qrcodeContainer.innerHTML = "";
            new QRCode(qrcodeContainer, website);
            document.getElementById("qrcode-container").style.display = "block";
          } else {
            alert("Please enter a valid URL");
          }
        }
    } );
</script>
@endpush