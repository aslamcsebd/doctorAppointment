<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Status change
    public function changeStatus(Request $request){
        $model = $request->model;
        $field = $request->field;
        $id = $request->id;
        $tab = $request->tab;

        $itemId = DB::table($model)->find($id);
        ($itemId->$field == true) ? $action=$itemId->$field = false : $action=$itemId->$field = true;     
        DB::table($model)->where('id', $id)->update([$field => $action]);
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // Delete
    public function itemDelete($model, $id, $tab){
        $itemId = DB::table($model)->find($id);
        if (Schema::hasColumn($model, $column='photo')){
            ($itemId->$column!=null) ? (file_exists($itemId->$column) ? unlink($itemId->$column) : '') : '';
        }
        DB::table($model)->where('id', $id)->delete();
        return back()->with('success', $model.' delete successfully')->withInput(['tab' => $tab]);
    }

    public function index()
    {
        return view('home');
    }
}
