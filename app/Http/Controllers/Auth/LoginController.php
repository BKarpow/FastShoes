<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\UserOrderController;

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

    /**
     * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            dd($e);
            return redirect('/login');
        }        // only allow people with @company.com to login
        if(explode("@", $user->email)[1] !== 'gmail.com') {
            return redirect()->to($this->redirectTo);
        }        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();        if($existingUser){
            // log them in
            /**
             * Save user ordered amd phone
             */
            UserOrderController::saveOrdered();
            if (empty( $existingUser->phone ) ) {
                $existingUser->phone = $_COOKIE["my_phone"] ?? '';
                $existingUser->save();
            }
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            UserOrderController::saveOrdered();
            auth()->login($newUser, true);
        }
        return redirect()->to($this->redirectTo);
    }


}
