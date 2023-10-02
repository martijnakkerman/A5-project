@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4">{{ __('User Information') }}</div>

                <div class="card-body">
                        <p>Username: {{ Auth::user()->name }}</p>
                        <p>E-mail: {{ Auth::user()->email }}</p>
                        <a class="btn btn-primary" href="{{ route('user.edit')}}">Edit user information</a> <br><br>
                        <a class="btn btn-primary" href="{{ route('user.password-reset')}}">Change password</a>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header h4">{{ __('Your Bands') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <a href ="{{route('band.create')}}" class="btn btn-primary">Create new band</a>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>Band</td>
                                    <td>Last changed</td>
                                    <td id="edit_delete"></td>
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach(Auth::user()->bands as $band)
                                         <tr>
                                             <td>{{$band->name}}</td>
                                             <td>{{$band->updated_at}}</td>

                                             <td>
                                                 <div class="d-flex">
                                                     <a class="btn btn-primary bi-pencil" href="{{route('band.edit',$band->id)}}"></a>
                                                     <form action="{{ route('band.destroy', $band->id) }}" method="post">
                                                         @csrf
                                                         @method('DELETE')
                                                        <button type="submit" class="btn btn-danger bi-trash ms-1" data-toggle="tooltip" title='Delete'></button>
                                                     </form>
                                                 </div>
                                             </td>
                                         </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
