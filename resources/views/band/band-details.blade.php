@extends('layouts.app')

@section('content')
    <div id="colors" style="background-color: {{$band->background_color}}; color: {{$band->text_color}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-center m-3" id="title">
                       <h1 class="fw-bold"> {{$band->name}} </h1>
                    </div>

                    <div id="image">
                        <image class="img-fluid img-thumbnail rounded mx-auto d-block" style="height: 500px; width: auto;" alt="Responsive image"
                               src="{{asset("storage/".$band->image_path)}}"></image>
                    </div>

                    <div id="description" class="m-3">
                        <p>{{$band->description}}</p>
                    </div>

                    <div id="biography">
                        <h3 class="fw-bold m-4 d-flex justify-content-center">Biography</h3>
                        <p>{{$band->biography}}</p>
                    </div>


                    <div id="embeds" class="d-flex justify-content-start align-items-center m-3" style="overflow: auto;">
                             @foreach($band->embeds as $embed)
                                 <div class="m-3">
                                     {!!$embed->embed_url!!}
                                 </div>
                             @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
