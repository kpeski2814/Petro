<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Session;

class TagController extends Controller
{
    public function index(){
    	$tags = Tag::where('status',1)->orderBy('name')->paginate(10);
      //dd($tag);
    	return view('tag.index' , compact('tags'));
    }

    public function create(){
    	return view('tag.create');
    }

    public function populate(Request $request){
      $tipo       = $_FILES['csv']['type'];
  		$tamanio    = $_FILES['csv']['size'];
  		$archivotmp = $_FILES['csv']['tmp_name'];

      $lineas = file($archivotmp);
      $i = 0;

      foreach ($lineas as $line_num => $linea) {

				$datos      = explode(";", $linea);
				$name_tag   = trim($datos[0]);
        $bd_tag     = utf8_encode($name_tag);
        $tag_exists = Tag::where('name',$bd_tag)->first();
        //dd($bd_tag);
        if (!$tag_exists) {
          $data = new Tag;
          $data->name = $bd_tag;
          $data->type = 1;
          $data->status = 1;
          $data->save();
          $i++;
      }
    }
    return Redirect::to('/tags');
  }

    public function store(Request $request){
      $tag_name = $request->input('name');
      $tag_exists = Tag::where('name',$tag_name)->first();

      $rules = array(
          'name'         => 'required',
          'type'         => 'required',
          'status'       => 'required',
          );

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          return redirect('tags/create')->withErrors($validator)->withInput();
      }else{
        if ($tag_exists) {
          Session::flash('status','El tag ingresado ya existe.');
          return Redirect::to('/tags/create');
        }else {
          Tag::create([
              'name'        => $request['name'],
              'description' => $request['description'],
              'type'        => $request['type'],
              'status'      => $request['status']
              ]);

              return Redirect::to('/tags');
            }
         }
    }

    public function edit($id){
    	$tag = Tag::find($id);
    	return view('tag.edit', compact('tag'));
    }

    public function update(Request $request, $id){
      $tag = Tag::find($id);
      $tag->fill($request->all());
      $tag->save();

      return Redirect::to('/tags');
    }

    public function destroy($id){
      $tag = Tag::find($id);
      $tag->fill(['status'=>0]);
      $tag->save();

      return Redirect::to('/tags');
    }
}
