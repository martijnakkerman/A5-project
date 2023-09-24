@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <p>User information:</p>
                        {{ Auth::user()->name }} <br>
                        {{ Auth::user()->email }} <br>
                        <a href="{{ route('user.edit')}}">Edit user information</a>

                        <p>Managed bands:</p>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
