<!DOCTYPE html>
<html>
<head>
    <title>QR Code Decoder</title>
    <script src="{{ asset('assets/js/qrcode-reader.js') }}"></script>
</head>
<body>
    <input type="file" accept="image/*" id="qr-input">
    <canvas id="canvas" style="display: none;"></canvas>
    <div id="result"></div>
    <div id="decoded-result"></div>

    <script>
        const qrInput = document.getElementById('qr-input');
        const canvas = document.getElementById('canvas');
        const resultDiv = document.getElementById('result');
        const decodedResultDiv = document.getElementById('decoded-result');

        qrInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
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
                        console.log(formattedDate);
                        decodedResultDiv.innerText = JSON.stringify(jsonData);
                    } else {
                        resultDiv.innerText = 'QR code not found';
                        decodedResultDiv.innerText = '';
                    }
                };
                image.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
