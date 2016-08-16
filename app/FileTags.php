<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileTags extends Model
{
    protected $table = 'file_tag';

    protected $fillable = [
        'file_id' , 'tag_id'
    ];

    public function tags(){
      return $this->belongsTo('App\Tag' , 'tag_id');
    }

    public function files(){
      return $this->belongsTo('App\File', 'file_id');
    }
}
