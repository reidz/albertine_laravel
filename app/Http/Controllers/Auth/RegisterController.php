<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email-reg' => 'required|string|email|max:100|unique:users,email',
            // 'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $password)
    {
        return User::create([
            'name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email-reg'],
            'password' => bcrypt($password),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $password = str_random(6);

        event(new Registered($user = $this->create($request->all(), $password)));

        $this->guard()->login($user);

        Mail::send(['text'=>'mail'], ['name'=>$user['name'].' '.$user['last_name'], 'password'=>$password], function($message) use ($user){
            $message->to($user['email'], 'To rickos89')->subject('Subject Test Nih');
            $message->from('rickos89.test@gmail.com', 'rickos89.test');
        });

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
