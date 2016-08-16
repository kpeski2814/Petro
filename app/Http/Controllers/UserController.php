<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\User;
use Redirect;
use Auth;

class UserController extends Controller
{
    public function index(){
      $user = User::All();
      return view('user.index', compact('user'));
    }

    public function create(){
      return view('user.create');
    }

    public function store(Request $request){
      $rules = array(
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
      );

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return redirect('users/create')->withErrors($validator)->withInput();
      }else{
          User::create([
              'name'     => $request['name'],
              'email'    => $request['email'],
              'password' => bcrypt($request['password']),
          ]);

      return Redirect::to('/users');   }
    }

    public function edit($id){
      $user = User::find($id);
      return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id){
      $user = User::find($id);
      $user->fill($request->all());
      $user->save();

      return Redirect::to('/users');
    }
}
