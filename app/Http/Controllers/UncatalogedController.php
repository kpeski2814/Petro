<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Image;
use Redirect;

class UncatalogedController extends Controller
{
    public function index(){
      $img = Image::All();
      return view('uncataloged.index' , compact('img'));
    }

    public function create(){
      return view('uncataloged.create');
    }

    public function resize(Request $request){
      try {
        $files = $request->file('path');
        foreach ($files as $file) {
          $name      = $file->getClientOriginalName();
          $realpath  = $file->getRealPath();
          $thumbName = 'thumb_'.$file->getClientOriginalName();

          $img = \Image::make($realpath);
          $img->resize(intval(120), null, function($constraint) {
                 $constraint->aspectRatio();
            });

          $img->save(public_path('images'). '/'. $thumbName);
        }
      } catch (Exception $e) {
          return false;
      }

    }

    public function store(Request $request){

    }



    }
