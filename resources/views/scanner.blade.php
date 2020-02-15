@extends('layout.main')

@section('title', 'Attendee Scanner')

@section('style')
@endsection

@section('content')
<video id="attendeeScanner"></video>
@endsection

@section('script')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
  let scanner = new Instascan.Scanner({
    video: document.getElementById('attendeeScanner')
  });

  scanner.addListener('scan', function(content){
    alert(content);
  });

  Instascan.Camera.getCameras().then(cameras => {
    if(cameras.length > 0){
      scanner.start(cameras[0]);
    }else{
      console.error('Please enable camera!');
    }
  });
</script>
@endsection