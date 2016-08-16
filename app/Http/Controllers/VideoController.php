<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Http\Requests;
use FFMpeg\FFMpeg;
use Session;

class VideoController extends Controller
{
    public function show($id){
       $videos = File::where('status', 1)->where('type_id', 2)->where('id', $id)->get();
       //dd($videos[0]->name);

       if (\File::exists(public_path('videos').'/'.$videos[0]->name)) {
          $ffmpeg = \FFMpeg\FFProbe::create();
          $duration = $ffmpeg->format($videos[0]->real_path)->get('duration');

         return view('cataloged.videos.index', compact('videos'));
       }else {
         $ffmpeg = \FFMpeg\FFMpeg::create();
         $video  = $ffmpeg->open($videos[0]->real_path);
         $video->save(new \FFMpeg\Format\Video\X264(), public_path('videos'). '/'. $videos[0]->name);

         return view('cataloged.videos.index', compact('videos'));
       }

    }

    public function change(Request $request){
       $id      = $request->input('id');
       $videos  = File::where('status', 1)->where('type_id', 2)->where('id', $id)->get();
      return view('cataloged.videos.extension', compact('videos'));
    }

    public function ExtensionChange(Request $request){
      $extension     = $request->input('extension');
      $new_extension = $request->input('new_extension');
      $id          = $request->input('id');
      $videos  = File::where('status', 1)->where('type_id', 2)->where('id', $id)->get();
      $ultimo = substr(strrchr($videos[0]->name, "."), 0);
      $posicionsubcadena = strpos ($videos[0]->name, $ultimo);
      $video_name = substr ($videos[0]->name,0, ($posicionsubcadena));

      if ($new_extension == 'a') {
        $formato = 'avi';
        $new_name = $video_name.'.'.$formato;
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $video  = $ffmpeg->open($videos[0]->real_path);
        $video->save(new \FFMpeg\Format\Video\X264(), public_path('videos'). '/'. $new_name);
      }elseif ($new_extension == 'b') {
        $formato = 'wmv';
        $new_name = $video_name.'.'.$formato;
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $video  = $ffmpeg->open($videos[0]->real_path);
        $video->save(new \FFMpeg\Format\Video\WMV(), public_path('videos'). '/'. $new_name);
      }elseif ($new_extension == 'c') {
        $formato = 'webm';
        $new_name = $video_name.'.'.$formato;
        $ffmpeg = \FFMpeg\FFMpeg::create();
        $video  = $ffmpeg->open($videos[0]->real_path);
        $video->save(new \FFMpeg\Format\Video\WebM(), public_path('videos'). '/'. $new_name);
      //dd($extension,$id, $new_extension, $formato, $video_name, $new_name);
    }
        $pathtoFile = public_path('videos'). '/'. $new_name;
        return response()->download($pathtoFile);
}

    public function cut(Request $request){
      $id    = $request->input('id');
      $desde = $request->input('desde');
      $hasta = $request->input('hasta');
      $final = $hasta - $desde;
      $videos  = File::where('status', 1)->where('type_id', 2)->where('id', $id)->get();
      $cut_name = substr(md5(rand()), 0, 7).'-'.$videos[0]->name;
      //dd($cut_name);
      $ffmpeg = \FFMpeg\FFMpeg::create();
      $video  = $ffmpeg->open($videos[0]->real_path);
      $video->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($hasta), \FFMpeg\Coordinate\TimeCode::fromSeconds($final));
      $video->save(new \FFMpeg\Format\Video\X264(), public_path('cuts'). '/'. $cut_name);

      $pathtoFile = public_path('cuts'). '/'. $cut_name;
      return response()->download($pathtoFile);
      //dd($id, $desde, $hasta);
    }

}
