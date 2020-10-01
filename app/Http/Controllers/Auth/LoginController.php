<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Token;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
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

    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function credentials(){
        if(is_numeric(request('email'))){
            return ['mobile_number'=>request('email'),'password'=>request('password')];
        }
        elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => request('email'), 'password'=>request('password')];
        }else{
            return "error";
            // return redirect()->back()
            //         ->withInput()
            //         ->withErrors([$this->username() => 'Give Valid Email/Phone Number']);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if(is_numeric(request('email'))){
            $user = User::where('mobile_number', $request->input('email'))->first();
        }
        elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->input('email'))->first();
        }

        if($this->credentials() != "error"){
            if (auth()->guard('web')->attempt($this->credentials())) {

                $new_session_id = Session::getId(); //get new session_id after user sign in

                if ($user->session_id != '') {
                    $last_session = Session::getHandler()->read($user->session_id);

                    if ($last_session) {
                        if (Session::getHandler()->destroy($user->session_id)) {
                        }
                    }
                }

                User::where('id', $user->id)->update(['session_id' => $new_session_id]);

                $user = auth()->guard('web')->user();

                if($user->user_type == "Student"){

                    //retrieveByCredentials
                    if ($user = app('auth')->getProvider()->retrieveByCredentials($this->credentials())) {

                        $token = Token::create([
                            'user_id' => $user->id
                        ]);

                        if($token->used == null){
                            Session::flush();
                            Auth::logout();
                        }

                        if ($token->sendCode()) {
                            Session::put("token_id", $token->id);
                            Session::put("user_id", $user->id);
                            Session::put("remember", $request->get('remember'));
                            return redirect()->route('showCodeForm');
                        }

                        $token->delete();// delete token because it can't be sent
                        return redirect('/login')
                            ->withInput()
                            ->withErrors([
                                $this->username() => Lang::get('auth.verificationfailed')
                            ]);
                    }

                    return redirect()->back()
                        ->withInput()
                        ->withErrors([
                            $this->username() => Lang::get('auth.failed')
                        ]);
                }else{
                    return redirect($this->redirectTo);
                }
            }
            return back()->withInput()->withErrors([$this->username() => Lang::get('auth.failed')]);
        }else{
            return redirect()->back()
                ->withInput()
                ->withErrors([$this->username() => 'Give Valid Email/Phone Number']);
        }
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function logout(Request $request)
    {
        $this->guard('guest')->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */

    public function showCodeForm(Request $request)
    {
        if (! $request->session()->has('token_id')) {
            return redirect("/login");
        }
        return view("auth.code");
    }

    /**
     * Store and verify user second factor.
     */
    public function storeCodeForm(Request $request)
    {
        // throttle for too many attempts
        if (! session()->has("token_id", "user_id")) {
            return redirect("login");
        }

        $token = Token::find(Session::get("token_id"));
        if (! $token ||
            ! $token->isValid() ||
            $request->code !== $token->code ||
            (int)Session::get("user_id") !== $token->user->id
        ) {
            return redirect("code")->withErrors(["Invalid token"]);
        }

        $token->used = true;
        $token->save();
        $this->guard()->login($token->user, Session::get('remember', false));

        session()->forget('token_id', 'user_id', 'remember');

        return redirect('home');
    }

}
