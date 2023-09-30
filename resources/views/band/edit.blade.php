@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if (is_null($band->id))
                        <div class="card-header h4">{{ __('Create a new band') }}</div>
                    @else
                        <div class="card-header">{{ __('Update your band'.$band->name) }}</div>
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
                                <form action="{{ route('band.store', $band->id) }}" method="POST">

                        @else

                            <form action="{{ route('band.update', $band->id) }}" method="POST">
                            @method('PATCH')
                        @endif
                            @csrf
                            <div class="form-group">
                                <label for="name">Band name:</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ $band->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea rows="3" type="text" class="form-control" name="description"
                                       value="{{ $band->description }}"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="biography">Biography:</label>
                                <textarea rows="16" type="text" class="form-control" name="biography"
                                       value="{{ $band->biography }}"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image_path">Upload image:</label>
                                <input type="file" class="form-control" name="image_path"
                                       value="{{ $band->image_path }}" />
                            </div>

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

                            <button type="submit" class="btn btn-success float-end">Save</button>
                            <a class="btn btn-primary" href="{{route('dashboard')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
