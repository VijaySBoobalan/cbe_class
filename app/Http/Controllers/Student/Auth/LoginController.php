<?php

namespace App\Http\Controllers\Student\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Token;
use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admin users for the application and
    | redirecting them to your admin dashboard.
    |
    */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * This trait has all the login throttling functionality.
     */
    use ThrottlesLogins;

    /**
     * Max login attempts allowed.
     */
    public $maxAttempts = 5;

    /**
     * Number of minutes to lock the login.
     */
    public $decayMinutes = 3;

    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:student')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.student_login',[
            'title' => 'Student Login',
            'loginRoute' => 'student.login',
            'forgotPasswordRoute' => 'student.password.request',
        ]);
    }


    function credentials(){
        if(is_numeric(request('email'))){
            return ['mobile_number'=>request('email'),'password'=>request('password')];
        }
        elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => request('email'), 'password'=>request('password')];
        }
    }

    /**
     * Login the admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'email' => 'required',
        ]);

        if(is_numeric(request('email'))){
            $user = User::where('mobile_number', $request->input('email'))->first();
        }elseif (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->input('email'))->first();
        }

        if ($user != "" && $user->user_type == "Student") {

            $StudentData = $user->StudentDetails;

            if(date('Y-m-d') > $user->StudentDetails->application_fee_date){
                $Student = Student::find($user->user_id);
                $Student->status = 0;
                $Student->save();
                $StudentData = $Student;
            }

            if($StudentData->status == 0){
                return view('application_fee_payment.stripe',compact('user'));
            }else{
                $token = Token::create([
                    'user_id' => $user->id
                ]);

                if ($token->sendCode($user)) {
                    Session::put("token_id", $token->id);
                    Session::put("user_id", $user->id);
                    Session::put("remember", $request->get('remember'));
                    return redirect()->route('showCodeForm');
                }

                $token->delete();// delete token because it can't be sent
                return redirect('student/login')
                    ->withInput()
                    ->withErrors([
                    Lang::get('auth.verificationfailed')
                ]);
            }
        }else{
            return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        Lang::get('auth.failed')
                    ]);
        }
    }

    /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logout(Request $request)
    {
        $Student = Student::find(auth()->user()->user_id);
        $Student->online_status = 0;
        $Student->save();

        $this->guard('student')->logout();

        return redirect()->route('student.login')
                ->with('warning','Student has been logged out!');
    }

    /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|exists:students|min:5|max:191',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    /**
     * Username used in ThrottlesLogins trait
     *
     * @return string
     */
    // public function username(){
    //     return 'email';
    // }


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
        // throttle for too many attempts
        if (! session()->has("token_id", "user_id")) {
            return redirect("student/login");
        }

        $token = Token::find(Session::get("token_id"));
        if (! $token ||
            ! $token->isValid() ||
            $request->code !== $token->code ||
            (int)Session::get("user_id") !== $token->user->id
        ) {
            return redirect("student/code")->withErrors(["Invalid token"]);
        }

        $token->used = true;
        $token->save();
        $this->guard()->login($token->user, Session::get('remember', false));

        session()->forget('token_id', 'user_id', 'remember');

        return redirect('student/home');
    }

}
