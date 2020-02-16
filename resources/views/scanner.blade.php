@extends('layout.main')

@section('title', 'Attendee Scanner')

@section('style')
<style type="text/css"></style>
@endsection

@section('content')

<video id="camera"></video>

<b>Hasil scan : </b>
<span id="qrResult"></span>

@endsection

@section('script')
<script type="module">
  import QrScanner from "https://bookingevent.herokuapp.com//js/qr-scanner.min.js";
  QrScanner.WORKER_PATH = "https://bookingevent.herokuapp.com//js/qr-scanner-worker.min.js";

  const camera = document.getElementById('camera');
  const qrResult = document.getElementById('qrResult');
  const scanner = new QrScanner(camera, result => setResult(qrResult, result));
  scanner.start();
</script>
@endsection