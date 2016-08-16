<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    protected $fillable = ['name'];

    public function format(){
      return $this->has_many('Format');
    }
}
