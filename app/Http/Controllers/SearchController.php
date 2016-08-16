<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests;

class SearchController extends Controller
{
    public function search()
    {
      return view('home');
    }

    public function autocomplete($query)
    {
      
        $search = "%$query%";
        $data = Tag::where("name","LIKE",$search)->where('type',1)->get();
        return response()->json($data);

    }

    public function autocompleteC($query)
    {
        $search = "%$query%";
        $data = Tag::where("name","LIKE",$search)->where('type',0)->get();
        return response()->json($data);
    }
}
