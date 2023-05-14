<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() 
    {
        return view("auth.login");

    }

    public function success(LoginRequest $request) 
    {
        // Intentar iniciar sesion
        $datosUsuario = $request->validated();
        

        if (Auth::attempt($datosUsuario)) {
            $request->session()->regenerate();
            // dd($request->session()->all());
            return redirect(route('home'))->with('success', 'Sesión iniciada.');
        }

        throw ValidationException::withMessages([
                    'name' => ['El usuario o la contraseña son incorrectos.']
                ]);    }

    public function register() 
    {
        return view("auth.register");
    }
    


}
