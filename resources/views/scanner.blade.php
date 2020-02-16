@extends('layout.main')

@section('title', 'Attendee Scanner')

@section('style')
<style type="text/css">
  canvas {
    display: none;
  }
  hr {
    margin-top: 32px;
  }
  input[type="file"] {
    display: block;
    margin-bottom: 16px;
  }
  div {
    margin-bottom: 16px;
  }
</style>
@endsection

@section('content')

<h1>Scan from WebCam:</h1>
<div>
    <b>Device has camera: </b>
    <span id="cam-has-camera">false</span>
    <br>
    <video muted="" playsinline="" id="qr-video"></video>
</div>
<div>
    <select id="inversion-mode-select">
        <option value="original">Scan original (dark QR code on bright background)</option>
        <option value="invert">Scan with inverted colors (bright QR code on dark background)</option>
        <option value="both">Scan both</option>
    </select>
    <br>
</div>
<b>Detected QR code: </b>
<span id="cam-qr-result">None</span>
<br>
<b>Last detected at: </b>
<span id="cam-qr-result-timestamp"></span>
<hr>

<h1>Scan from File:</h1>
<input type="file" id="file-selector">
<b>Detected QR code: </b>
<span id="file-qr-result">None</span>

@endsection

@section('script')
<script type="module">
  import QrScanner from "../js/qr-scanner.min.js";
  QrScanner.WORKER_PATH = "../js/qr-scanner-worker.min.js";

  const video = document.getElementById('qr-video');
  const camHasCamera = document.getElementById('cam-has-camera');
  const camQrResult = document.getElementById('cam-qr-result');
  const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
  const fileSelector = document.getElementById('file-selector');
  const fileQrResult = document.getElementById('file-qr-result');

  function setResult(label, result) {
    label.textContent = result;
    camQrResultTimestamp.textContent = new Date().toString();
    label.style.color = 'teal';
    clearTimeout(label.highlightTimeout);
    label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
  }

  // ####### Web Cam Scanning #######

  QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

  const scanner = new QrScanner(video, result => setResult(camQrResult, result));
  scanner.start();

  document.getElementById('inversion-mode-select').addEventListener('change', event => {
    scanner.setInversionMode(event.target.value);
  });

  // ####### File Scanning #######

  fileSelector.addEventListener('change', event => {
    const file = fileSelector.files[0];
    if (!file) {
      return;
    }
    QrScanner.scanImage(file)
      .then(result => setResult(fileQrResult, result))
      .catch(e => setResult(fileQrResult, e || 'No QR code found.'));
  });
</script>
@endsection