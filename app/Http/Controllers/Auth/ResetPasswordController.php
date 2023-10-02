<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function passwordReset(){

        return view("auth.passwords.change");

    }

    public function passwordChange(Request $request){

        $request->validate([
            'password_old'=>'required|string',
            'password_new'=>'required|string|min:8|confirmed',
            'password_new_confirmation'=>'required|string|min:8',
        ]);

        $user = Auth()->user();
        if (Hash::check($request->password_old, $user->password)) {
            $user->password = Hash::make($request->password_new);
            $user->save();
            return redirect('/dashboard')->with('success', 'Successfully updated password.');
        } else {
            return redirect()->back()->with('error', 'The old password you filled in is incorrect.');
        }
    }
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset Requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

//    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
}
