<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** Login form */
    public function loginForm()
    {
        if(Auth::check()){
            if(auth()->user()->type == 'user'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect()->intended('user/complete-profile');
                }
                return redirect()->intended('user');
            }
        }
        return view('auth.login');    
    }

    /** Login */
    public function login(Request $request)
    {
        $request->validate([
            'email'             =>  'required|email|exists:users,email',
            'password'          =>  'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->get('remember'))) {
            if(auth()->user()->type == 'user'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect('user/complete-profile')->with('success', 'Please complete your profile.');
                }
                return redirect('user')->with('success', 'User login successfully.');
            } else if(auth()->user()->type == 'service'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect('service/complete-profile')->with('success', 'Please complete your profile.');
                }
                return redirect('service')->with('success', 'User login successfully.');
            }
        }
        return back()->with('error', 'Invalid credentials.');
    }

    public function socialLogin(Request $request)
    {
        $user = User::where('social_token', $request->social_token)->first();

        if(!empty($user)){
            if (Auth::loginUsingId($user->id)) {
                if(auth()->user()->type == 'user'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('user/complete-profile')->with('success', 'Please complete your profile.');
                    }
                    return redirect('user')->with('success', 'User login successfully.');
                } else if(auth()->user()->type == 'service'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('service/complete-profile')->with('success', 'Please complete your profile.');
                    }
                    return redirect('service')->with('success', 'User login successfully.');
                }
            }
        }else{

            
            $full_name = $request->full_name;
            $explod_full_name = explode(' ', $full_name);
            
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
        
            $customers_create = $stripe->customers->create([
                'email' => $request->email
            ]);
            
            $user = new User;
            $user->first_name = isset($explod_full_name[0]) ? $explod_full_name[0] : null;
            $user->last_name = isset($explod_full_name[1]) ? $explod_full_name[1] : null;
            $user->email = $request->email;
            $user->social_type = $request->social_type;
            $user->social_token = $request->social_token;
            $user->type = $request->user_type;
            $user->is_verified = '1';
            $user->is_social = '1';
            $user->expires_at = now()->addMonth();
            $user->customer_id = $customers_create->id;
            $user->save();
            if (Auth::loginUsingId($user->id)) {
                if(auth()->user()->type == 'user'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('user/complete-profile')->with('success', 'Please complete your profile.');
                    }
                    return redirect('user')->with('success', 'User login successfully.');
                } else if(auth()->user()->type == 'service'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('service/complete-profile')->with('success', 'Please complete your profile.');
                    }
                    return redirect('service')->with('success', 'User login successfully.');
                }
            }
        }
    }

    /** Per sign up form */
    public function preSignUpForm()
    {
        if(Auth::check()){
            if(auth()->user()->type == 'user'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect('user/complete-profile');
                }
                return redirect('user');
            } else{
                if(auth()->user()->type == 'service'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('service/complete-profile');
                    }
                    return redirect('service');
                }
            }
        }
        return view('auth.pre-sign-up');    
    }

    /** Sign up form */
    public function signUpForm($type)
    {
        if(Auth::check()){
            if(auth()->user()->type == 'user'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect('user/complete-profile');
                }
                return redirect('user');
            } else{
                if(auth()->user()->type == 'service'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('service/complete-profile');
                    }
                    return redirect('service');
                }
            }
        } else{
            if(!empty($type)){
                return view('auth.sign-up', compact('type'));    
            } else{
                return redirect('pre-sign-up')->with('error', 'Please select role.');
            }
        }
    }

    /** Sign up */
    public function signUp(Request $request)
    {
        $request->validate([
            'email'             =>  'required|unique:users|email|max:255',
            'password'          =>  'required|min:8', 
            'confirm_password'  =>  'required|same:password|min:8',
            'type'              =>  'required|in:user,service'
        ]);
        
        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
        
        $customers_create = $stripe->customers->create([
            'email' => $request->email
        ]);
        
        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->verified_code = 123456; // mt_rand(100000,900000);
        $user->type = $request->type;
        $user->customer_id = $customers_create->id;
        $user->expires_at = now()->addMonth();
        if($user->save()){
            session()->put('user_id', $user->id);
            return redirect('auth/verify')->with('success', 'Sign up successfully please verify your email.');
        } else{
            return back()->with('error', 'Something went wrong.');
        }
    }

    /** Verify form */
    public function verifyForm()
    {
        if(Auth::check()){
            if(auth()->user()->type == 'user'){
                if(auth()->user()->is_profile_complete == '0'){
                    return redirect('user/complete-profile');
                }
                return redirect('user');
            } else{
                if(auth()->user()->type == 'service'){
                    if(auth()->user()->is_profile_complete == '0'){
                        return redirect('service/complete-profile');
                    }
                    return redirect('service');
                }
            }
        } else{
            if(!empty(session()->get('user_id'))){
                return view('auth.verify');    
            } else{
                return back()->with('error', 'Something went wrong.');
            }
        }
    }

    /** Verify */
    public function verify(Request $request)
    {        
        $request->validate([
            'digit_1'        =>  'required|min:1', 
            'digit_2'        =>  'required|min:1', 
            'digit_3'        =>  'required|min:1', 
            'digit_4'        =>  'required|min:1', 
            'digit_5'        =>  'required|min:1', 
            'digit_6'        =>  'required|min:1', 
        ]);

        $userId = session()->get('user_id');
        $verifiedCode = $request->digit_1.$request->digit_2.$request->digit_3.$request->digit_4.$request->digit_5.$request->digit_6;
        $userExists = User::whereId($userId)->where('verified_code', $verifiedCode)->exists();

        if($userExists){
            $updateUser = User::whereId($userId)->where('verified_code', $verifiedCode)->update(['is_verified' => '1', 'verified_code' => null]);
            if($updateUser){  
                session()->forget('user_id');                
                if (Auth::loginUsingId($userId)) {
                    if(auth()->user()->type == 'user'){
                        return redirect('user/complete-profile')->with('success', 'Please complete your profile.');
                    } else if(auth()->user()->type == 'service'){
                        return redirect('service/complete-profile')->with('success', 'Please complete your profile.');
                    }
                }
            }
            else{
                return back()->with('error', 'Something went wrong.');
            }
        }
        else{
            return back()->with('error', 'Invalid Otp.');
        }
    }

    /** Logout */
    public function logout()
    {
        Auth::logout();
        return back()->with('success', 'User logout successfully.');  
    }
}
