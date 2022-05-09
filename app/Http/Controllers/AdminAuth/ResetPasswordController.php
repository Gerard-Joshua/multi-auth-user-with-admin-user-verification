<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Admins; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token) { 
        return view('admin.auth.passwords.reset', ['token' => $token]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
  
        $updatePassword = DB::table('admin_password_resets')
                                ->where([
                                    'email' => $request->email, 
                                    'token' => $request->token
                                ])
                                ->first();
  
        if(!$updatePassword){
            return back()->withInput()->withErrors(['reset_error' => 'Invalid token!']);
        }
  
        $user = Admins::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
        DB::table('admin_password_resets')->where(['email'=> $request->email])->delete();
  
        return redirect('/admin/login')->with('message', 'Your password has been changed!');
    }
}
