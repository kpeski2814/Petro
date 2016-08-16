<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
      'name' , 'description' , 'status', 'user_id', 'type_id', 'path','tag_id','author_id','album_id','extension',
      'character','place','path','event_date','area_id','real_path','event_title'
    ];

    public function fileTags(){
      return $this->hasMany('App\FileTags');
    }

    public function users(){
      return $this->belongsTo('App\User' , 'user_id');
    }

    public function areas(){
      return $this->belongsTo('App\Area' , 'area_id');
    }

    public function authors(){
      return $this->belongsTo('App\Author','author_id');
    }

    public function albums(){
      return $this->belongsTo('App\Album','album_id');
    }

    public static function boot(){
      parent::boot();

      static::deleting(function($file){
          foreach ($file->fileTags as $filetag) {
              $filetag->delete();
          }
      });
    }

    public function getAlbumNameAttribute(){
      return $this->albums->name;
    }
}
