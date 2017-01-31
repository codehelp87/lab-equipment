<?php

namespace LabEquipment\Http\Controllers\Auth;

use Auth;
use Hash;
use LabEquipment\User;
use Symfony\Component\HttpFoundation\Request;
use LabEquipment\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $user = User::findOneByEmail($request->email);

        if (!is_null($user)) {
            if (Hash::check($request->password, $user->getAuthPassword())) {
                $user = User::where('status', 1)
                ->where('email', $request->get('email'))
                ->first();

                if (count($user) > 0) {
                    Auth::login($user);
                    return redirect() ->route('dashboard');
                }
            }
        } 

        return redirect()
            ->route('load_login')
            ->with('message', 'Invalid Username/Password')
            ->withInput();
    }
}
