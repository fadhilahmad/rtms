<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterAgent extends Controller
{
    use RegistersUsers;
    
    protected $redirectTo = '/login';
    protected $table = 'user';
    //
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function PageRegisterAgent() 
    {
        return view('register_agent');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:user'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    protected function create(array $data)
    {
        return User::create([
            'u_fullname' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'username' => $data['username'],
            'email' => $data['email'],
            'u_type' => '6',
            'u_status' => '2',
            'password' => Hash::make($data['password']),
        ]);
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return redirect($this->redirectPath())->with('message', 'Your message');
    }
}
