<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Type;
use App\Tag;
use App\Http\Requests;
use Auth;
use Redirect;
use Session;
use App\FileTags;
use Illuminate\Support\Facades\Validator;
use Response;

class FileController extends Controller
{
    public function index(){
      $file = File::All();
      return view('file.index' , compact('file'));
    }

    public function upload(){
        $type = Type::All();
        return view('file.upload' , compact('type'));
    }

    public function create(){
      return view('uncataloged.create');
    }

    public function store(Request $request){
        $name      = $request->input('name');
        $tag       = $request->input('tag');
        $path      = $request->input('path');
        $session   = $request->session()->get('session');
        $count     = count($name);

        $rules = array(
            'event_title' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

          foreach($name as $names){
             $extension = substr(strrchr($names, "."), 1);
             $ultimo = substr(strrchr($names, "."), 0);
             $posicionsubcadena = strpos ($names, $ultimo);
             $video_name = substr ($names,0, ($posicionsubcadena));
             $video_thumb = $path.'\\'.$video_name.'.jpg';
             //dd($video_thumb);
             $route     = $path."\\".$names;
             $real_path = $session.'\\'.$names;

             $archive   = File::where('name','=',$names)->where('real_path', $real_path)->first();

             if ($archive) {

               if($archive->type_id == 1){
                       $archive->fill([
                         'name'        => $names,
                         'description' => $request['description'],
                         'user_id'     => Auth::user()->id,
                         'status'      => '1',
                         'path'        => $route,
                         'real_path'   => $real_path,
                         'extension'   => $extension,
                         'event_title' => $request['event_title'],
                         'event_date'  => $request['event_date'],
                         'place'       => $request['place'],
                         'album_id'    => $request['album'],
                         'type_id'     => 1,
                         'author_id'   => $request['author'],
                       ]);
                       $archive->save();
                   }else {
                     $archive->fill([
                       'name'        => $names,
                       'description' => $request['description'],
                       'user_id'     => Auth::user()->id,
                       'status'      => '1',
                       'path'        => $video_thumb,
                       'real_path'   => $real_path,
                       'extension'   => $extension,
                       'event_title' => $request['event_title'],
                       'event_date'  => $request['event_date'],
                       'place'       => $request['place'],
                       'album_id'    => $request['album'],
                       'type_id'     => 2,
                       'author_id'   => $request['author'],
                     ]);
                     $archive->save();
               }

             } else {

             if ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
               $creates = File::create([
                   'name'        => $names,
                   'description' => $request['description'],
                   'user_id'     => Auth::user()->id,
                   'status'      => '1',
                   'path'        => $route,
                   'real_path'   => $real_path,
                   'extension'   => $extension,
                   'event_title' => $request['event_title'],
                   'event_date'  => $request['event_date'],
                   'place'       => $request['place'],
                   'album_id'    => $request['album'],
                   'area_id'     => $request['area'],
                   'type_id'     => 1,
                   'author_id'   => $request['author'],
               ]);
             } else {
              $creates = File::create([
                   'name'        => $names,
                   'description' => $request['description'],
                   'user_id'     => Auth::user()->id,
                   'status'      => '1',
                   'path'        => $video_thumb,
                   'real_path'   => $real_path,
                   'extension'   => $extension,
                   'event_title' => $request['event_title'],
                   'event_date'  => $request['event_date'],
                   'place'       => $request['place'],
                   'album_id'    => $request['album'],
                   'area_id'     => $request['area'],
                   'type_id'     => 2,
                   'author_id'   => $request['author'],
               ]);
             }

         }

           foreach ($tag as $tags) {
             if ($tags != '') {
               $tag_id = Tag::where('name',$tags)->select('id')->get();
               $file   = File::where('name','=',$names)->select('id')->get();
               //dd($file[0]['id']);
               var_dump($file[0]['id']);
               //var_dump($tag_id[0]['id']);
               FileTags::create([
                  'file_id'   => $file[0]['id'],
                  'tag_id'    => $tag_id[0]['id'],
               ]);
             }
           }
          }

          Session::forget('session_disk');
          Session::flash('status', $count.' Archivos Catalogadas Correctamente');
          return Redirect::to('home');

        }



    }
