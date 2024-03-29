<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest.admin')->except('logout');
    }

    /**
     * redirects admin to login form.
     *
     * @var string
     */
    public function showLoginForm() {
        
        if(Auth::guard('admin')->check()) {
            return redirect('admin/home');
        }else{
            return view('admin.auth.login');
        }
    }

    /**
     * login admin account and redirects to admin home.
     *
     * @var string
     */
    public function login(Request $request) {

        try {

            $this->validate($request,[
                'email' => 'required',
                'password' => 'required',
            ]);

            $credentials = ['email' => $request->email , 'password' => $request->password];
            if(Auth::guard('admin')->attempt($credentials)){ 
                return redirect('admin/home');
            }else{
               return redirect()->back()->withInput()->withErrors(['login_error' => 'These credentials do not match our records.',]);
            }

        }catch(\Exception $e) {
            dd($e);
        }
    }

    public function logout(Request $request) {

        try {
            if(Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
                return redirect('/admin/login');
            }else{
                return redirect('/admin/login');
            }
        }catch(\Exception $e) {
            dd($e);
        }
    }
}
