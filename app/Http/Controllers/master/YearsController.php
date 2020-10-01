<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Years;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class YearsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $Years =  Years::get();
            return DataTables::of($Years)
                ->addIndexColumn()
                ->addColumn('action', function ($Years) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('years_update','years_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('years_update')){
                        $btn .= '<a href="#" class="btn EditYear" id="'.$Years->id.'" data-toggle="modal" data-target="#editYearModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('years_delete')){
                        $btn .= '<a href="#" id="'.$Years->id.'" class="btn DeleteYear" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.years.view');
    }

    public function create(Request $request)
    {

    }

    public function Yearstore (Request $request){
        try{
            $Years = new Years;
            $Years->year = $request->year;
            $Years->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function Yearedit(Request $request){
        try {
            $Data['Years'] = Years::findorfail(request('year_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Question Type Not Found!']);
        }
    }

    public function YearUpdate (Request $request)
    {
        try {
            $Years = Years::findorfail($request->year_id);
            $Years->year = $request->year;
            $Years->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function YearDelete(Request $request){
        try {
            $Years = Years::findorfail($request->year_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
}
