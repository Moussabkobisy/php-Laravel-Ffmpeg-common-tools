@extends('app')
@section('content')

    <div class="container">

            <div class="row pt-5">
                <h1>Video Tool</h1>
            </div>
        <div class="row">
            <h2>Separate tool</h2>
        </div>


    <div class="row">
        <div class="col-6">
            <form action="/extract" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <label for="video" class="col-md-4 col-form-label ">Choose Video :</label>

                    <input type="file" class="form-control-file" id="video" name="video">
                    @error('video')
                    <strong>{{ $message }}</strong>

                    @enderror
                </div>
                <div class="row pt-4">

                    <button class="btn btn-primary">Go</button>
                </div>
            </form>
            <div class="row pt-5">
                <a href="/" class="btn btn-danger btn-sm">back</a>
            </div>
        </div>
        <div class="col-6">
            <div class="row pt-5 loader" id="loader1" style="display: none">
                <span class="pr-3">Separating Video</span>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @if(isset($video))
                <h1>Here is your Audio</h1>
                <audio controls>
                    <source src="/storage/{{$audio}}" type="audio/mp3">
                </audio>
                <h1>Here is your video</h1>
                <video controls style="max-width: 200px">
                    <source src="/storage/{{$video}}" type="video/mp4">
                </video>
        @endif
        </div>
    </div>






    </div>

@endsection