@extends('layout.main')

@section('title', 'Attendee Scanner')

@section('style')
<style type="text/css"></style>
@endsection

@section('content')
Kamera
<video id="camera"></video>

<b>Hasil scan : </b>
<span id="qrResult"></span>

@endsection

@section('script')
<script type="module">
  import QrScanner from "{{asset('/js/qr-scanner.min.js')}}";
  QrScanner.WORKER_PATH = "{{asset('/js/qr-scanner-worker.min.js')}}";

  const camera = document.getElementById('camera');
  const qrResult = document.getElementById('qrResult');
  const scanner = new QrScanner(camera, result => setResult(qrResult, result));
  scanner.start();
</script>
@endsection