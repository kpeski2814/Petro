<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
    	'name','type','description','status'
    ];

    public function fileTag(){
      return $this->hasMany('App\FileTags');
    }

    public function getStatusAttribute($value){
       if($value == 1){
         $estado = "activo";
       }
       return  ucwords($estado);
    }

    public function getTypeAttribute($value){
      if($value == 1){
        $type = "Etiqueta";
      }else {
        $type = "Personaje";
      }
      return $type;
    }
}
