@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Information') }}</div>

                <div class="card-body">
                        <p>Username: {{ Auth::user()->name }}</p>
                        <p>E-mail: {{ Auth::user()->email }}</p>
                        <a class="btn btn-primary" href="{{ route('user.edit')}}">Edit user information</a> <br><br>
                        <button class="btn btn-primary">Reset Password</button>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header">{{ __('Managed bands') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>Your bands</td>
                                    <td>Last changed</td>
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach(Auth::user()->bands as $band)
                                         <tr>
                                             <td>{{$band->name}}</td>
                                             <td>{{$band->updated_at}}</td>
                                             <td><a href="{{route('band.edit')}}">manage</a></td>
                                         </tr>
                                     @endforeach
                                </tbody>
                            </table>





                </div>
            </div>







        </div>
    </div>
</div>
@endsection
