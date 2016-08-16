<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use App\Format;
use App\Http\Requests;

class BusquedaController extends Controller
{
    //
    public function index(){
        $type = Type::All();
        return view('busqueda' , compact('type') );
    }

}
