<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'formats';

    protected $fillable = [
      'name' , 'type_id'
    ];

    public function type(){
      return $this->belongs_to('Type');
    }
}
