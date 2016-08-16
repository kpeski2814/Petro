<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Http\Requests;
use Redirect;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index(){
    	$area = Area::where('status',1)->get();
    	return view('area.index', compact('area'));
    }

    public function create(){
    	return view('area.create');
    }

    public function store(Request $request){
        $rules = array(
            'name' => 'required|unique:areas',
            'status' => 'required',
            );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('areas/create')->withErrors($validator)->withInput();
        } else {
           Area::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'status' => $request['status'],
            'abbrev' => $request['abbrev']
            ]);

            return Redirect::to('areas');
        }

    }

    public function edit($id){
    	$area = Area::find($id);
    	return view('area.edit' , compact('area'));
    }

    public function update(Request $request, $id){
        $area = Area::find($id);
        $area->fill($request->all());
        $area->save();

        return Redirect::to('areas');
    }

    public function destroy($id){
        $area = Area::find($id);
        $area->fill(['status'=>'0']);
        $area->save();

        return Redirect::to('areas');
    }
}
