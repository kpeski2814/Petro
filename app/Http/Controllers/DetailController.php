<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Http\Requests;
use FFMpeg\FFMpeg;
use App\Author;
use App\fileTags;

class DetailController extends Controller
{
    public function index($id){
      $detail = File::where('id',$id)->get();
      $tags   = FileTags::with('tags')->where('file_id', $detail[0]->id)->select('tag_id')->get();
      //dd($detail[0]->name, $detail[0]->real_path);
      if (\File::exists(public_path('images').'/'.$detail[0]->name)) {
        $image = \Image::make($detail[0]->real_path);
        $width = $image->width();
        $height = $image->height();
        $size  = $image->filesize()/1024;
        $real_size = round($size,0);
        $dimension = $width.'x'.$height;
        $data = array( $real_size, $dimension);
        //dd($data[0]);
        return view('cataloged.images.index', compact(['detail','tags']))->with('data',$data);
      } else {
        $img = \Image::make($detail[0]->real_path);
        $width  = $img->width();
        $height = $img->height();
        $size   = $img->filesize()/1024;
        $real_size = round($size,0);
        $dimension = $width.'x'.$height;
        $data = array( $real_size, $dimension);

        $img->resize(600,400);
        $img->save(public_path('images'). '/'. $detail[0]->name);

        return view('cataloged.images.index', compact(['detail','tags']))->with('data',$data);
      }
    }
    
    public function downloadFile($file){
      $pathtoFile = public_path().'//images/'.$file;
      return response()->download($pathtoFile);
    }
}
