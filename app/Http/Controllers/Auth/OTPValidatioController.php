<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class OTPValidatioController extends Controller
{

    use AuthenticatesUsers;

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
        $this->middleware('web')->except('logout');
    }

    public function showCodeForm(Request $request)
    {
        if (! $request->session()->has('token_id')) {
            return redirect("student/login");
        }
        return view("auth.code");
    }

    /**
     * Store and verify user second factor.
     */
    public function storeCodeForm(Request $request)
    {
        $id = $request->session()->get('user_id');
        $user = User::find($id);
        $Student = Student::find($user->user_id);
        $Student->online_status = 1;
        $Student->save();
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
            return redirect("code")
            ->withErrors([
                $this->username() => Lang::get('auth.inavalidcode')
            ]);
        }

        $token->used = true;
        $token->save();

        $this->guard()->login($token->user, Session::get('remember', false));

        session()->forget('token_id', 'user_id', 'remember');

        $new_session_id = Session::getId(); //get new session_id after user sign in

        if ($user->session_id != '') {
            $last_session = Session::getHandler()->read($user->session_id);

            if ($last_session) {
                if (Session::getHandler()->destroy($user->session_id)) {
                }
            }
        }
        User::where('id', $user->id)->update(['session_id' => $new_session_id]);

        return redirect('home');
    }
}
