<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;

  use App\Http\Requests;
  use Session;
  use Redirect;

  class PathController extends Controller
  {
      public function selectDisk(Request $request){

        $disk = $request->input('disk');
        if ($disk == null || $disk == "") {
          Session::flash('status','Debes de seleccionar una unidad');
          return Redirect::to('/navigate');
        } else {
          $route_disk = strtoupper($disk).':\\';
          if (!\File::exists($route_disk)) {
            Session::flash('status','La unidad que ha seleccionado no existe, por favor seleccione otra.');
            return Redirect::to('/navigate');
          }else {
            Session::put('session_disk' , $route_disk);
            $directories = \File::directories($route_disk);
            if (count($directories)>0) {
             return view('uncataloged.directory', compact('directories'));
            }
          }
      }
        //return view('uncataloged.directory', compact('new_disk'))->with('route_disk', $route_disk);
        //return view('uncataloged.directory')->with('new_disk', $new_disk);
      }

      public function newRoute($ruta){
          $session_disk = Session::get('session_disk');
          $route_disk = $session_disk.'\\'.$ruta;
          Session::put('session_disk',$route_disk);

          if (\File::isDirectory($route_disk))
            {
                $directories = \File::directories($route_disk);

                if (count($directories)>0) {
                  return view('uncataloged.directory', compact('directories'));
                }

                $files = \File::files($route_disk);
                if(count($files)>0){
                  return view('uncataloged.navigate')->with('new_disk', $route_disk);
                }
            }

      }

      public function goingBack(){
          $last_session = Session::get('session_disk');

          $ultimo = substr(strrchr($last_session, "\\"), 0);

          $posicionsubcadena = strpos ($last_session, $ultimo);

          $dominio = substr ($last_session,0, ($posicionsubcadena));

          Session::put('session_disk', $dominio);

          if (\File::isDirectory($dominio))
            {
                $directories = \File::directories($dominio);

                if (count($directories)>0) {
                  return view('uncataloged.directory', compact('directories'));
                }

                $files = \File::files($dominio);
                if(count($files)>0){
                  return view('uncataloged.navigate')->with('new_disk', $dominio);
                }
            }

      }

  }
