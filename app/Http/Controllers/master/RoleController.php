<?php

namespace App\Http\Controllers\master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Env;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:roles_view|roles_create|roles_update|roles_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:roles_create', ['only' => ['create','store']]);
        $this->middleware('permission:roles_update', ['only' => ['edit','update']]);
        $this->middleware('permission:roles_delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!auth()->user()->can('roles_view')) {
        //     abort(403, 'Unauthorized action.');
        // }
        if (request()->ajax()) {
            if(auth()->user()->hasRole('super_admin')){
                $Roles =  Role::get();
            }else{
                $Roles = Role::where('is_default',0)->get();
            }
            return DataTables::of($Roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '';
                    if(auth()->user()->hasPermissionTo('roles_update')){
                        $action .= '<a href="' . action('master\RoleController@edit', [$row->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '."edit".'</a>';
                    }
                    if (auth()->user()->hasPermissionTo('roles_delete')) {
                        $action .= '&nbsp
                            <button data-href="' . action('master\RoleController@destroy', [$row->id]) . '" class="btn btn-xs btn-danger delete_role_button"><i class="glyphicon glyphicon-trash"></i> '."delete".'</button>';
                    }

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.roles.view');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Data['Permissions'] = Permission::get()->groupBy('description_name');
        return view('master.roles.add',$Data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        DB::beginTransaction();
        try{
            $role = Role::create(['name' => $request->input('name')]);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            };
            DB::commit();
            return redirect('master/roles')->with('success','Role Created Successfully');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error','Role Cannot be Created')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return view('roles.show',compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $Permissions = Permission::pluck('description','description_name')->unique();
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->join('permissions','permissions.id','role_has_permissions.permission_id')->pluck('name')->toArray();
        return view('master.roles.edit',compact('role','permission','Permissions','rolePermissions'));
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
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        try{
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $permissions = $request->input('permissions');

            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            };
            DB::commit();
            return redirect('master/roles')->with('success','Role Updated Successfully');
        }catch (Exception $e){
            DB::rollBack();
            return back()->with('error',['Role Cannot be Updated'])->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
