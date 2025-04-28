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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    protected function credentials(Request $request)
    {
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_no';

        return [
            $loginField => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    protected function authenticated(Request $request, $user)
    {

        if ($user->hasRole('superadmin')) {
            return redirect('/'); // Redirect to Superadmin dashboard
        }

        if ($user->hasRole('admin')) {
            return redirect('/admin'); // Redirect to admin dashboard
        }

        if ($user->hasRole('sales')) {
            return redirect('/sales'); // Redirect to sales dashboard
        }

        if ($user->hasRole('staff')) {
            return redirect('/staff'); // Redirect to sales dashboard
        }
        return redirect('/'); // Default fallback
    }
}
