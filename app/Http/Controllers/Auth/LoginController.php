<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('guest')->except('logout');
    }

    public function maxAttempts()
    {
        //Lock out on 5th Login Attempt
        return 3;
    }

    public function decayMinutes()
    {
        //Lock for 5 minutes
        return 5;
    }


    public function getAsAdmin(){

        $return = [
            'title' => 'Login as Admin'
        ];

        return view('auth.login_as_admin', $return);
    }

    public function postAsAdmin(Request $request){

        $post = $request->all();

        $this->validate($request, [
            'user_email'    => 'required|email|exists:users,email',
            'email'         => 'required|email|exists:users,email',
            'password'      => 'required',
        ]);


        /**
         * Login as admin,
         *
         * if Login successfully,
         * >> logout user and login the user manually
         */

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {


            if (Auth::user()->hasRole(\USER_ROLE_ADMIN)){

                Auth::logout();

                $user = User::where('email', $post['user_email'])->first();
                Auth::loginUsingId($user->id, TRUE);

                return redirect()->intended($this->redirectPath());

            } else {
                /**
                 * If user is not an admin,
                 * >> logout and redirect back with error message
                 */

                Auth::logout();

                // Redirect
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'User is not an Admin');
            }
        }


         // Redirect
        return redirect()
            // To the previous page (probably the one generated by a `getRegister` method)
            ->back()
            // And with the input data (so that the form will get populated again)
            ->withInput();
    }

    public function setPassword(){




    }
}
