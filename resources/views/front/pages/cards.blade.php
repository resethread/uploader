@extends('front.layouts.default')

@section('content')
    @foreach($videos as $video)
        <div class="col-md-3">
            <div class="card">
                <a href="#">
                    <div class="card-image">
                        <img class="img-responsive" src="http://material-design.storage.googleapis.com/publish/v_2/material_ext_publish/0Bx4BSt6jniD7TDlCYzRROE84YWM/materialdesign_introduction.png">
                    </div>

                    <div class="card-content">
                        <p>{{ $video->title }}</p>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@endsection