<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function passwordReset(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6|required_with:conform_password|same:conform_password',
        ]);

        DB::beginTransaction();
        try{
            $User = User::find(auth()->user()->id);
            $User->is_password_changed = 1;
            $User->password = Hash::make($request->password);
            $User->save();
            DB::commit();
            return back()->with('success','Password Successfully Changed');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error','Password Does not Changed');
        }
    }
}
