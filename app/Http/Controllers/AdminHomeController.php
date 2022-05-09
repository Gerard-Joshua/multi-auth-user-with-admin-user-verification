<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Admins;
use App\User;
use Mail;
use Auth;

class AdminHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the admin application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if(Auth::guard('admin')->check()) {
            $users = User::orderBy('created_at','DESC')->get();
            return view('admin.admin_home',compact('users'));
        }else{
            return redirect('/admin/login');
        }
    }

    /**
     * Update user status.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update_user_status(Request $request,$id)
    {   
        try {
            $this->validate($request,[
                'user_status' => ['required'],
            ]);

            if(Auth::guard('admin')->check()) {
                $user = User::find($id);
                $user->user_status = $request->user_status;
                $user->save();

                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['status'] = $user->user_status;

                if(env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
                    Mail::send('email.user_status_notification', $data, function($message) use($data){
                        $message->to($data['email']);
                        $message->subject('User Account Status Notification');
                    });
                }

                return redirect('/admin/home')->with('status', 'User status updated !!!');
            }else{
                return redirect('/admin/login');
            }
        }catch(\Exception $e) {
            dd($e);
        }
    }
}
