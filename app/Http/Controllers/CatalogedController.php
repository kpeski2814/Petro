<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Tag;
use App\Author;
use App\Album;
use App\Area;
use App\Http\Requests;
use App\FileTags;
use Redirect;
use Session;
use Illuminate\Support\Facades\Validator;
use FFMpeg\FFMpeg;

class CatalogedController extends Controller
{
    public function index(){
      $author = Author::where('status', 1)->get();
      $album  = Album::where('status',1)->get();
      $area   = Area::where('status',1)->get();
      return view('cataloged.index' , compact(['author','album','area']));
    }

    public function clean(){
         $directory_thumbs = public_path('thumb');
         $success   = \File::cleanDirectory($directory_thumbs);

         $directory_images = public_path('images');
         $success   = \File::cleanDirectory($directory_images);

         $directory_videos = public_path('videos');
         $success   = \File::cleanDirectory($directory_videos);

         $directory_cuts   = public_path('cuts');
         $success   = \File::cleanDirectory($directory_cuts);

         if ($success == true) {
           Session::flash('status', 'Archivos temporales eliminados Correctamente');
           return Redirect::to('home');
         }
    }

    public function create(Request $request){
          $check = $request->input('check');
          $tag = Tag::All();
          $author = Author::All();

          return view('cataloged.create', compact(['check','tag','author']));
    }

    public function selectAction(Request $request){
          $action = $request->input('action-value');

          if ($action == 'delete') {
            $checked = $request->input('catalog');

            foreach($checked as $check){
              $id = File::where('name', $check)->select('id')->first();
              $file = File::find($id->id);
              $file::destroy($id->id);
              Session::flash('success','Los archivos fueron eliminados');
            }

            return Redirect::to('/cataloged');

          } elseif($action == 'download') {
            $checked = $request->input('catalog');

            foreach($checked as $check){
              $path = File::where('name',$check)->select('real_path')->first();
              $img = \Image::make($path->real_path);
              $img->save(public_path('download'). '/'. $check);
            }

            $files = \File::files('download');
            \Zipper::make(public_path('download/download.zip'))->add($files);
            return response()->download(public_path('download/download.zip'));
          }

    }
    public function delete(Request $request){
          $checked = $request->input('catalog');

          foreach($checked as $check){
            $id = File::where('name', $check)->select('id')->first();
            $file = File::find($id->id);
            $file::destroy($id->id);
            Session::flash('success','El archivo '.$file->name.' fue eliminado');
          }

          return Redirect::to('/cataloged');
    }

    public function findby(Request $request){
          $author      = $request->input('author');
          $album       = $request->input('album');
          $radio       = $request->input('optradio');
          $date_start  = $request->input('event_start');
          $time_start  = strtotime($date_start);
          $day_start   = date('d',$time_start);
          $date_end    = $request->input('event_end');
          $time_end    = strtotime($date_end);
          $day_end     = date('d',$time_end);
          $character   = $request->input('character');
          $place       = $request->input('place');
          $tag         = $request->input('tag');
          $area        = $request->input('area');
          $title       = $request->input('title');

          //dd($author,$album, $radio,$date_end, $character , $place , $tag, $title);
          if($author == null && $album == null && $radio == null && $date_start == "" && $date_end == "" && $character == "" && $place == "" && $tag == "" && $area == "" && $title ==""){
              Session::flash('status','Por favor Selecciona al menos una opcion');
              return Redirect::to('/cataloged');
          }else{

            $image = File::where('status',1)->select('real_path','extension')->get();
            foreach ($image as $path) {
              $thumbName = substr(strrchr($path->real_path, "\\"), 1);
            if( $path->extension == 'jpg' || $path->extension == 'png' ){
              $img = \Image::make($path->real_path);
              $img->backup();
              /** para thumb **/
              $img->resize(150,150);
              $img->save(public_path('thumb'). '/'. $thumbName);
            }else{
              $extension = explode('.' , $thumbName);
              $name = $extension[0].'.jpg';
              //dd($name);
              $ffmpeg = FFMpeg::create();
              $video = $ffmpeg->open($path->real_path);
              $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(10));
              $frame->save(public_path('thumb'). '/' .$name );
            }
          }

          if($date_start && $date_end){
            $result = File::where('status', 1)->where(\DB::raw('DAY(event_date)'), '>=', $day_start)
                                                 ->where(\DB::raw('DAY(event_date)'), '<=' ,$day_end)->get();
          }

          if($radio == 'img'){
            $result = File::where('status',1)->where('type_id', 1)->get();
          }elseif($radio == 'vid'){
            $result = File::where('status',1)->where('type_id', 2)->get();
          }
            //filtros individuales
          if($author != null || $author != ''){
            $result = File::where('status',1)->where('author_id', $author)->get();
          }
          if ($album != null || $album != '') {
            $result = File::where('status',1)->where('album_id', $album)->get();
          }
          if ($place != null || $place != '') {
            $result = File::where('status',1)->where('place',$place)->get();
          }
          if($area != null || $area != ''){
            $result = File::where('status', 1)->where('area_id',$area)->get();
          }
          if ($character) {
            $personajes = explode(',',$character);
            $result = array();
            foreach ($personajes as $persona) {
              $get_id   = Tag::where('name',trim($persona))->where('type','=','0')->select('id')->first();
              if($get_id == null){
                Session::flash('status', 'Al parecer estas intentado buscar un personaje que no existe.');
                return Redirect::to('/cataloged');
              }
              $result[] = FileTags::with('files')->where('tag_id',$get_id->id)->get();
            }
        }
        if ($tag) {
          $etiquetas = explode(',',$tag);
          $result = array();
          foreach ($etiquetas as $etiqueta) {
            $get_id   = Tag::where('name',trim($etiqueta))->where('type','=','1')->select('id')->first();
            if($get_id == null){
              Session::flash('status', 'Al parecer estas intentado buscar una etiqueta que no existe.');
              return Redirect::to('/cataloged');
            }
            $result[] = FileTags::with('files')->where('tag_id',$get_id->id)->get();
          }
      }
      if($title != "" || $title != null){
        $result = File::where('status',1)->where('event_title', $title)->get();
      }
      //filtros compuestos
     if ($album != null && $author !=null) {
       $result = File::where('status',1)->where('album_id', $album)
                                        ->where('author_id', $author)->get();
     }
     if ($place != null  && $author != null){
       $result = File::where('status',1)->where('place',$place)
                                           ->where('author_id', $author)->get();
     }
     if ($place != null && $album != null) {
       $result = File::where('status',1)->where('place',$place)
                                           ->where('album_id', $album)->get();
     }
     if ($place != null && $title != "") {
       $result = File::where('status',1)->where('place',$place)
                                        ->where('event_title', $title)->get();
     }
     if ($title != "" && $album != null) {
       $result = File::where('status',1)->where('event_title',$title)
                                        ->where('album_id', $album)->get();
     }
     if ($title != "" && $author != null) {
       $result = File::where('status',1)->where('event_title', $title)
                                        ->where('author_id',$author)->get();
     }

         return view('cataloged.view', compact('result'));
      }

    }


}
