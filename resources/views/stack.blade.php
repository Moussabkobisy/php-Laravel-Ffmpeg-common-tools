@extends('app')
@section('content')

    <div class="container">

            <div class="row pt-5">
                <h1>Video Tool</h1>
            </div>
        <div class="row">
            <h2>Stack Tool</h2>
        </div>


    <div class="row">
        <div class="col-6">
            <form action="/stack" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">

                    <div class="pt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="orientation" id="gridRadios1" value="h" checked>
                            <label class="form-check-label" for="gridRadios1">
                                Horizontal Stack
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="orientation" id="gridRadios2" value="v">
                            <label class="form-check-label" for="gridRadios2">
                                Vertical Stack
                            </label>
                        </div>
                    </div>
                    @error('orientation')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>


                <div class="row">
                    <label for="video1" class="col-md-4 col-form-label ">First Video :</label>

                    <input type="file" class="form-control-file" id="video1" name="video1">
                    @error('video1')
                    <strong>{{ $message }}</strong>

                    @enderror
                </div>
                <div class="row">
                    <label for="video2" class="col-md-4 col-form-label ">Second Video :</label>

                    <input type="file" class="form-control-file" id="video2" name="video2">
                    @error('video2')
                    <strong>{{ $message }}</strong>

                    @enderror
                </div>
                <div class="row pt-4">

                    <button class="btn btn-primary">Stack</button>
                </div>
            </form>
            <div class="row pt-5">
                <a href="/" class="btn btn-danger btn-sm">back</a>
            </div>
        </div>
        <div class="col-6">
            <div class="row pt-5 loader" id="loader1" style="display: none">
                <span class="pr-3">Merging Videos</span>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @if(isset($stackName))
                <h1>Here is your stacked video</h1>
                <video width="600"  controls>
                    <source src="/storage/{{$stackName}}" type="video/mp4">
                    <source src="/storage/{{$stackName}}" type="video/ogg">
                    <source src="/storage/{{$stackName}}" type="video/webm">
                    Sorry - Your browser does not support the HTML5 video tag.
                </video>
            <div class="row">

                <a  class="btn btn-primary" href="/storage/{{$stackName}}">download</a>
            </div>

        @endif
        </div>
    </div>






    </div>

@endsection