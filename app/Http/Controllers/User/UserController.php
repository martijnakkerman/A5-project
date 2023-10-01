<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userEdit()
    {
        $user = Auth::user();
        return view('user.edit', ['user'  => $user]);
    }

    public function userUpdate(Request $request, User $user){

            $request->validate([
                'name'=>'required',
                'email'=>'required|email',
            ]);

            $user->update($request->all());
            return redirect('/user/edit')
                ->with('success', 'User information updated');

    }
}
