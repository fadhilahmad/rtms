<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
    logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username () 
    {
        return 'username';
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
   
        if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'],'u_status' => 1)))
        {
            if (auth()->user()->u_type == 1 OR auth()->user()->u_type == 2 )  //CASE ADMIN
            {
                return redirect()->route('admin.dashboard');
            }
            
            elseif(  auth()->user()->u_type == 5  ) //CASE DEPARTMENT
            {
                return redirect()->route('department.home');
            }
            
            elseif(auth()->user()->u_type == 3 OR auth()->user()->u_type == 4 ) //CASE Designer and tailor
            {
                return redirect()->route('job_list');
            }
            
            elseif(auth()->user()->u_type == 6 OR auth()->user()->u_type == 7 OR auth()->user()->u_type == 8 OR auth()->user()->u_type == 9) //CASE CUSTOMER 
            {
                return redirect()->route('customer.home');
            }
                                    
        }
        elseif(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'],'u_status' => 2)))
        {
           return redirect()->route('login')
                   ->with('error','Waiting for admin approval');
        }
        elseif(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'],'u_status' => 0)))
        {
           return redirect()->route('login')
                   ->with('error','Please contact admin');
        }
        else{
           return redirect()->route('login')
                   ->with('error','wrong password');

        }
          
    }
    
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
}
