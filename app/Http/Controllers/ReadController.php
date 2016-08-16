<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Author;
use App\Type;
use App\Album;
use Storage;
use App\File;
use Redirect;
use Session;
use App\Area;

class ReadController extends Controller
{
  public function read(){

     $directory = 'imagenes';
     $info = [];
     $files = \File::files('imagenes');
   
     foreach ($files as $file) {
          $info[] = pathinfo($file);
     }
     $img = File::where('status',1)->count();

     if($img > 0){
       $archivos = File::where('status', 1)->select('name')->get();
       for ($i=0; $i < count($archivos) ; $i++) {
          $arch = array($archivos);
       }
       return view('uncataloged.read', compact(['info','archivos']));
     }else{
       return view('uncataloged.read', compact('info'));
     }
 
     //return view('uncataloged.read', compact(['info','img']));
  }
  public function catalog(Request $request){
      $check  = $request->input('check');
      if($check = '' || $check == null){
        $new_disk = Session::get('session');
        Session::flash('status','Por favor Selecciona un Archivo para catalogar');
        return view('uncataloged.navigate')->with('new_disk', $new_disk);
       
      }else{
      $check  = $request->input('check');
      $path   = $request->input('path');
      $author = Author::All();
      $type   = Type::All();
      $album  = Album::All();
      $area   = Area::All();
      
      return view('cataloged.create', compact(['check','author','type','album','route','area']))->with('path',$path);
    }
  }

}
