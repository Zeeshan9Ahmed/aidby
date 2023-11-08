<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;
use App\Models\Category;

Class IndexController extends Controller
{

	public function login(){

        return view('admin.login');
    }

    public function login_process(Request $request)
    {
        $controls=$request->all();
        $rules=array(
            'email'=>"required|exists:admins,email",
            "password"=>"required");
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $admin = Admin::where('email', $request->email)->first();
        // $admin = User::where('email', $request->email)->where('role','admin')->first();

        if (Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Incorrect email address or password']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $user  = User::where('type','user')->count();
        $service  = User::where('type','service')->count();
        $category  = Category::where('parent_id',null)->count();
        return view('admin.dashboard',["user" => $user, "category" => $category, "service" => $service]);
    }

}