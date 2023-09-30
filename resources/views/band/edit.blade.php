@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if (is_null($band->id))
                        <div class="card-header h4">{{ __('Create a new band') }}</div>
                    @else
                        <div class="card-header h4">{{ __('Editing band: '.$band->name) }}</div>
                    @endif

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br>
                        @endif

                        @if (is_null($band->id))
                            <form enctype="multipart/form-data" action="{{ route('band.store', $band->id) }}" method="POST">

                        @else

                            <form enctype="multipart/form-data" action="{{ route('band.update', $band->id) }}" method="POST">
                            @method('PATCH')
                        @endif
                            @csrf
                            <div class="form-group">
                                <label for="name">Band name:</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ $band->name }}" />
                            </div> <br>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea rows="3" type="text" class="form-control" name="description"
                                       value="{{ $band->description }}"></textarea>
                            </div> <br>

                            <div class="form-group">
                                <label for="biography">Biography:</label>
                                <textarea rows="16" type="text" class="form-control" name="biography"
                                       value="{{ $band->biography }}"></textarea>
                            </div> <br>

                            <div class="js-embed-youtube-fields">
                                @if($band->embeds->count() > 0)
                                    @foreach($band->embeds as $embed)
                                        <div class="form-group">
                                            <label for="embed">Youtube URLs:</label>
                                            <textarea rows="1" type="text" class="form-control" name="youtube_url[]"
                                                      value="{{ $embed->youtube_url }}"></textarea>
                                            <a href="#" class="js-remove-embed-youtube">Remove</a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group">
                                        <label for="embed">Youtube URLs:</label>
                                        <textarea rows="1" type="text" class="form-control" name="youtube_url[]"></textarea>
                                        <a href="#" class="js-remove-embed-youtube btn btn-primary">Remove</a>
                                    </div>
                                @endif
                                <a href="#" class="btn btn-primary" id="js-add-url">Add</a>
                            </div>
                            <br><br>

                            <div class="form-group w-25">
                                <label for="text_color">Text color:</label>
                                <input type="color" class="form-control" name="text_color"
                                       value="{{ $band->text_color }}" />
                            </div>

                            <div class="form-group w-25">
                                <label for="background_color">Background color:</label>
                                <input type="color" class="form-control" name="background_color"
                                       value="{{ $band->background_color }}" />
                            </div> <br>

                            <div class="form-group">
                                <label for="image">Upload image:</label>
                                <input type="file" class="form-control" name="image" accept="image/x-png,image/jpeg"/> <br>
                                @if (!is_null($band->id))
                                    <image class="img-fluid img-thumbnail rounded mx-auto d-block w-50 h-50" alt="Responsive image"
                                           src="{{asset("storage/".$band->image_path)}}"></image>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success float-end">Save</button>
                            <a class="btn btn-primary" href="{{route('dashboard')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
