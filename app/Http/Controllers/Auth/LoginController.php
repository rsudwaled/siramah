<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where('username', $request->email)
            ->orWhere('email', $request->email)->first();
        if (isset($user)) {
            if (empty($user->email_verified_at)) {
                return view('vendor.adminlte.auth.verify', compact(['request', 'user']));
            }
        } else {
            return redirect()->route('login')->withErrors('Username / Email Tidak Ditemukan');
        }
        if (auth()->attempt(array($fieldType => $input['email'], 'password' => $input['password']))) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->withErrors('Username / Email dan Password Salah');
        }
    }
}
