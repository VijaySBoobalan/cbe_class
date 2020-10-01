<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Institution;
use App\User;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::where('is_default',0)->get();
        if (request()->ajax()) {
            $Institutions =  Institution::get();
            return DataTables::of($Institutions)
                ->addIndexColumn()
                ->addColumn('action',
                    '<a href="#" class="btn EditInstitution" id="{{ $id }}" data-toggle="modal" data-target="#editInstitutionModal">
                        <i class="fa fa-pencil text-aqua"></i>
                    </a>
                    <a href="#" id="{{ $id }}" class="btn DeleteInstitution" data-toggle="modal" data-target="#InstitudeDeleteModel">
                        <i class="fa fa-trash-o" style="color:red;"></i>
                    </a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('institution.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $Data['Institution'] = Institution::findorfail($request->institution_id);
            $Data['User'] = User::where('email',$Data['Institution']->email)->first();
            $Data['Roles'] = DB::table('model_has_roles')->where('model_id',$Data['User']->id)->pluck('role_id')->toArray();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'institution_name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'phone_number_1' => ['required', 'numeric',' digits_between:10,11', 'unique:users,mobile_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        DB::beginTransaction();
        try{
            $Institution = new Institution;
            $Institution->institution_name = $request->institution_name;
            $Institution->institution_address = $request->institution_address;
            $Institution->user_name = $request->user_name;
            $Institution->phone_number_1 = $request->phone_number_1;
            $Institution->phone_number_2 = $request->phone_number_2;
            $Institution->email = $request->email;
            $Institution->password = Hash::make($request->password);

            $Institution->save();

            $roles = $request->roles;

            $User = User::create([
                'name' => $Institution->institution_name,
                'email' => $Institution->email,
                'password' => $Institution->password,
                'user_id' => $Institution->id,
                'user_type' => 'Admin',
                'mobile_number' => $Institution->phone_number_1,
            ]);

            $User->assignRole($roles);
            DB::commit();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            DB::rollBack();
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateInstitution(Request $request)
    {
        $UserInstitution = User::where([['user_id', $request->institution_id],['user_type','Admin']])->first();
        $this->validate($request, [
            'institution_name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'phone_number_1' => ['required', 'numeric', 'min:10','unique:users,mobile_number,'.$UserInstitution->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$UserInstitution->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);
        DB::beginTransaction();
        try{
            $Institution = Institution::find($request->institution_id);
            $Institution->institution_name = $request->institution_name;
            $Institution->institution_address = $request->institution_address;
            $Institution->user_name = $request->user_name;
            $Institution->phone_number_1 = $request->phone_number_1;
            $Institution->phone_number_2 = $request->phone_number_2;
            $Institution->email = $request->email;
            if(!empty(request('password'))){
                $Institution->password = Hash::make($request->password);
            }
            $Institution->save();

            $UserInstitution = User::where([['user_id', $Institution->id],['user_type','Admin']])->first();

            $roles = $request->roles;

            $User = User::find($UserInstitution->id);
            $User->name = $Institution->institution_name;
            $User->email = $Institution->email;
            $User->password = $Institution->password;
            $User->user_id = $Institution->id;
            $User->user_type = 'Admin';
            $User->mobile_number = $Institution->phone_number_1;
            $User->save();

            $User->assignRole($roles);
            DB::commit();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            DB::rollBack();
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function DeleteInstitution(Request $request)
    {
        try {
            $Data['Institution'] = Institution::findorfail($request->institution_id);
            $Data['User'] = User::where('email',$Data['Institution']->email)->delete();
            $Data['Institution']->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
