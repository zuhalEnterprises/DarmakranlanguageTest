<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller {
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
	protected $redirectTo = '/dashboard';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'guest' )->except( 'logout' );
	}

	public function username() {
		return 'username';
	}


	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function showLoginForm()
    {
		if ( view()->exists( 'auth.authenticate' ) ) {
			return view( 'auth.authenticate' );
		}
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
		return view( 'admin.auth.login' );
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
	    $user->update([
	        'last_login'=> Carbon::now(),
	        'last_ip'=>$request->ip()
        ]);

//		if($user->isAdmin() || $user->isMember()) {
//			return redirect('/dashboard');
//		}

		if(!$user->isAdmin() || !$user->isMember()) {
            return back()->withErrors(['', 'شما مجوز لازم برای دسترسی به این بخش را ندارید.']);
		}

		//dd(session('url.intended'));
        return redirect(session('url.intended') ?? '/profile');


//		return back()->withErrors(['', 'شما مجوز لازم برای دسترسی به این بخش را ندارید.']);
	}

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $redirectUrl = '/login';

        // check previous url
        $referrerUrl = url()->previous();
        if (strpos($referrerUrl, 'admin-panel') !== false) {
            $redirectUrl = $referrerUrl;
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ])->redirectTo($redirectUrl);
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->active == 1 && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'));
                    //->withErrors(['active' => 'You must be active to login.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
