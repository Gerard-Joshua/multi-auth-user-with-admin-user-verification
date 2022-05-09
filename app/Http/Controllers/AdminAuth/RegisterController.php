<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admins;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * redirects admin to registration form.
     *
     * @var string
     */
    public function showRegistrationForm() {
        return view('admin.auth.register');
    }

    /**
     * create admin account and redirects to admin home.
     *
     * @var string
     */
    public function register(Request $request) {
        try {

            $this->validate($request,[
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $admin = Admins::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if($admin->id) {
                return redirect()->route('admin.home');
            }else{
                return redirect()->route('admin.login');
            }

        }catch(\Exception $e) {
            dd($e);
        }
    }
}
