@extends('layouts.frontLayout.doctorLayout.design')
@section('styles')
{{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}
<style>
    .text-danger {
        color: red;
    }

    #patient_video {
        border-radius: 10px;
        -moz-box-shadow:    0px 0px 5px 6px #ccc;
        -webkit-box-shadow: 0px 0px 5px 6px #ccc;
        box-shadow:         0px 0px 5px 6px #ccc;

    }

    #my_video {
        border-radius: 10px;
        -moz-box-shadow:    0px 0px 5px 6px #ccc;
        -webkit-box-shadow: 0px 0px 5px 6px #ccc;
        box-shadow:         0px 0px 5px 6px #ccc;
        position: relative;
        width: 200px;
        height: 100px;
        bottom: 0px;
        right: 0px;
        margin: 10px;
    }
</style>
@endsection

@section('content')

<!-- /navbar -->
<div class="wrapper">
   <div class="container">
       <div class="row">
           <div class="span3">
               @include('layouts.frontLayout.doctorLayout.sidebar')
           </div>
           <!--/.span3-->
           <div class="span9">
            <div class="content">

                <div class="module">
                    <div class="module-head">
                        <h3>Video Conference</h3>
                    </div>
                    <div class="module-body">
                        <div id="conference">

                        </div>
                        <div>
                            <button class="btn btn-success">Start Session</button>
                        </div>

                    </video>
                </div>



            </div><!--/.content-->
               <!--/.content-->
           </div>
           <!--/.span9-->
       </div>
   </div>
   <!--/.container-->
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">


// var video = document.getElementById('my_video');
// if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//     navigator.mediaDevices.getUserMedia({video: true, audio: true}).then(function(stream){
//         video.srcObject = stream;
//         video.play();
//     }).catch(function(e) {
//         console.log("Unable to fetch Strea,")
//     })
// }

</script>
@endsection
