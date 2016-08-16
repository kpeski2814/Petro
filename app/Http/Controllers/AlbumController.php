<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    public function index(){
      $album = Album::where('status', 1)->get();//selecccioname todos los campos de la tabla status
      return view('album.index',compact('album'));
    }

    public function create(){
      return view('album.create');
    }

    public function store(Request $request){
      $rules = array(
          'name'         => 'required|unique:albums',
          'status'       => 'required',
          );

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          return redirect('albums/create')->withErrors($validator)->withInput();
      }else{
         Album::create([
            'name'        => $request['name'],
            'description' => $request['description'],
            'status'      => $request['status']
         ]);

         return Redirect::to('/albums');
      }
    }

    public function edit($id){
      $album = Album::find($id);
      return view('album.edit' , compact('album'));
    }

    public function update(Request $request , $id){
      $album = Album::find($id);
      $album->fill($request->all());
      $album->save();

      return Redirect::to('/albums');
    }

    public function destroy($id){
      $album = Album::find($id);
      $album->fill(['status'=>0]);
      $album->save();

      return Redirect::to('/albums');
    }

}

