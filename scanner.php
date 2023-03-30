<?php
session_start();
include_once "header.php";
// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="ZXing for JS">

  <title>Admin Page</title>

  <!-- <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic"> -->
  <!-- <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://unpkg.com/normalize.css@8.0.0/normalize.css"> -->
  <!-- <link rel="stylesheet" rel="preload" as="style" onload="this.rel='stylesheet';this.onload=null" href="https://unpkg.com/milligram@1.3.0/dist/milligram.min.css">/ -->
   <style>* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  background-color: #f5f5f5;
}

.wrapper {
  display: flex;
  justify-content: center;
  height: 100vh;
}

.container {
  background-color: #fff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  padding: 2em;
  width: 400px;
  height: 450px;
}

.button {
  display: inline-block;
  border: none;
  background-color: #007bff;
  color: #fff;
  padding: 0.5em 1em;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
  margin-right: 1em;
  margin-bottom: 1em;
}

.button:hover {
  background-color: #0069d9;
}

select {
  font-size: 1em;
  padding: 0.5em;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-left: 1em;
  margin-bottom: 1em;
}

label {
  display: block;
  margin-bottom: 0.5em;
}

pre {
  font-size: 1.2em;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 1em;
  overflow-x: auto;
  margin-top: 1em;
}

  pre#result {
    font-size: 1.2em;
    line-height: 1.5;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 1em;
    overflow-x: auto;
    margin-top: 1em;
    margin-bottom: 1em;
    background-color: #fff;
  }
  #result:empty {
  display: none;
}
</style>
</head>

<body>

  <main class="wrapper" style="padding-top:2em">

    <section class="container" id="demo-content">
      <div>
        <a class="button" id="startButton">Start</a>
        <a class="button" id="resetButton">Reset</a>
      </div>

      <div>
        <video id="video" width="340" height="200" style="border: 1px solid gray"></video>
      </div>

      <div id="sourceSelectPanel" style="display:none">
        <label for="sourceSelect">Change video source:</label>
        <select id="sourceSelect" style="max-width:400px">
        </select>
      </div>

      <div style="display: table">
        <label for="decoding-style"> Decoding Style:</label>
        <select id="decoding-style" size="1">
          <option value="once">Decode once</option>
          <option value="continuously">Decode continuously</option>
        </select>
      </div>
	  <input type="file" id="input-file" accept="image/*">
<button onclick="decodeQRCode()">Decode</button>


	
    </section>
	<div id="result-container" style="display: inline-block; margin-left: 2em;">
      <h3>Result</h3>
	  <div>
        <pre id="result" style="background-color: #f0f0f0; padding: 1em;"></pre>
      </div>
    </div>
  </main>

  <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
  <script type="text/javascript">
    function decodeOnce(codeReader, selectedDeviceId) {
      codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
        console.log(result)
		document.getElementById('result').innerHTML = `<p>${result.text}</p>`;
      }).catch((err) => {
        console.error(err)
        document.getElementById('result').textContent = err
      })
    }

    function decodeContinuously(codeReader, selectedDeviceId) {
      codeReader.decodeFromInputVideoDeviceContinuously(selectedDeviceId, 'video', (result, err) => {
        if (result) {
          // properly decoded qr code
          console.log('Found QR code!', result)
          document.getElementById('result').textContent = result.text
        }

        if (err) {
          // As long as this error belongs into one of the following categories
          // the code reader is going to continue as excepted. Any other error
          // will stop the decoding loop.
          //
          // Excepted Exceptions:
          //
          //  - NotFoundException
          //  - ChecksumException
          //  - FormatException

          if (err instanceof ZXing.NotFoundException) {
            console.log('No QR code found.')
          }

          if (err instanceof ZXing.ChecksumException) {
            console.log('A code was found, but it\'s read value was not valid.')
          }

          if (err instanceof ZXing.FormatException) {
            console.log('A code was found, but it was in a invalid format.')
          }
        }
      })
    }
    window.addEventListener('load', function () {
      let selectedDeviceId;
      const codeReader = new ZXing.BrowserQRCodeReader()
      console.log('ZXing code reader initialized')

      codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
          const sourceSelect = document.getElementById('sourceSelect')
          selectedDeviceId = videoInputDevices[0].deviceId
          if (videoInputDevices.length >= 1) {
            videoInputDevices.forEach((element) => {
              const sourceOption = document.createElement('option')
              sourceOption.text = element.label
              sourceOption.value = element.deviceId
              sourceSelect.appendChild(sourceOption)
            })

            sourceSelect.onchange = () => {
              selectedDeviceId = sourceSelect.value;
            };

            const sourceSelectPanel = document.getElementById('sourceSelectPanel')
            sourceSelectPanel.style.display = 'block'
          }

		  
          document.getElementById('startButton').addEventListener('click', () => {

            const decodingStyle = document.getElementById('decoding-style').value;

            if (decodingStyle == "once") {
              decodeOnce(codeReader, selectedDeviceId);
            } else {
              decodeContinuously(codeReader, selectedDeviceId);
            }

            console.log(`Started decode from camera with id ${selectedDeviceId}`)
          })

          document.getElementById('resetButton').addEventListener('click', () => {
            codeReader.reset()
            document.getElementById('result').textContent = '';
            console.log('Reset.')
          })

        })
        .catch((err) => {
          console.error(err)
        })
    })
    
    function decodeQRCode() {
  const selectedFile = document.getElementById('input-file').files[0];
  if (!selectedFile) {
    alert('Please select a file to decode.');
    return;
  }

  const reader = new FileReader();
  reader.onload = () => {
    const img = new Image();
    img.onload = () => {
      const codeReader = new ZXing.BrowserQRCodeReader();
      const canvas = document.createElement('canvas');
      canvas.width = img.width;
      canvas.height = img.height;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(img, 0, 0, img.width, img.height);
      const imageData = ctx.getImageData(0, 0, img.width, img.height);
      codeReader.decodeFromImage(imageData).then(result => {
        console.log(result);
        document.getElementById('result').innerHTML = `<p>${result.text}</p>`;
      }).catch(err => {
        console.error(err);
        document.getElementById('result').textContent = err;
      });
    };
    img.src = reader.result;
  };
  reader.readAsDataURL(selectedFile);
}


  </script>

</body>

</html>