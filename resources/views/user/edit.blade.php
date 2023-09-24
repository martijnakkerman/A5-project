@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit user information') }}</div>

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

                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @method('PATCH')
                            @csrf

                            <div class="form-group">
                                <label for="name">name:</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ $user->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="email">e-mail:</label>
                                <input type="text" class="form-control" name="email"
                                       value="{{ $user->email }}" />
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-primary" href="{{route('home')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
