<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Http\Requests;
use Redirect;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(){
    	$autor = Author::where('status',1)->get();
    	return view('author.index', compact('autor'));
    }

    public function create(){
    	return view('author.create');
    }

    public function store(Request $request){
      $rules = array(
          'name'         => 'required',
          'lastnamep'    => 'required',
          'status'       => 'required',
          );

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          return redirect('authors/create')->withErrors($validator)->withInput();
      }else{
        Author::create([
          'name'          => $request['name'],
          'lastnamep'     => $request['lastnamep'],
          'lastnamem'     => $request['lastnamem'],
          'phone_number'  => $request['phone_number'],
          'description'   => $request['description'],
          'status'        => $request['status']
        ]);

        return Redirect::to('/authors'); }
    }

    public function edit($id){
        $autor = Author::find($id);
        return view('author.edit', compact('autor'));
    }

    public function update(Request $request, $id){
      $autor = Author::find($id);
      $autor->fill($request->all());
      $autor->save();

      return Redirect::to('/authors');
    }

    public function destroy($id){
      $autor = Author::find($id);
      $autor->fill(['status' => 0]);
      $autor->save();

      return Redirect::to('/authors');
    }
}
