<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Format;
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/login' , function(){
       return view('auth/login');
   });


Route::group(['middleware' => 'auth'], function () {
   Route::get('/navigate' , function(){
        Session::set('session_disk', '');
        return view('uncataloged/directory');
   });
   Route::post('/select/disk','PathController@selectDisk');
   Route::get('/home', 'HomeController@index');
   Route::get('/busquedas','BusquedaController@index');
   Route::get('/ajax-format' , function(){
    $type_id = Input::get('type_id');
    $format = Format::where('type_id','=',$type_id)->get();
    return Response::json($format);
  });

   Route::resource('authors' , 'AuthorController');
   Route::resource('areas' , 'AreaController');
   Route::resource('tags' , 'TagController');
   Route::resource('uncataloged','UncatalogedController');
   Route::resource('files','FileController');
   Route::get('uploads' , 'FileController@upload');
   Route::resource('albums' , 'AlbumController');
   Route::resource('users', 'UserController');
   Route::get('/details/{id}/view' , 'DetailController@index');
   Route::get('/download/{file}' , 'DetailController@downloadFile');
   Route::get('/cataloged' , 'CatalogedController@index');
   Route::post('/cataloged/create' , 'CatalogedController@create');
   Route::get('/cataloged/clean' , 'CatalogedController@clean');
   Route::get('/autocomplete/{query}' , 'SearchController@autocomplete');
   Route::get('/autocompleteCharacter/{query}' , 'SearchController@autocompleteC');
   Route::post('/tag/populate', 'TagController@populate');
   Route::get('/tag/csv', function(){
     return view('tag/populate');
   });
   Route::get('/read' , 'ReadController@read');

   Route::post('/read/catalog' , 'ReadController@catalog');
   Route::post('/delete/files' , 'CatalogedController@delete');
   Route::post('/search/cataloged/', 'CatalogedController@findby');
   Route::post('/image/resize' , 'UncatalogedController@resize');
   Route::get('/testing/path' , 'PathController@getRoute');

   Route::get('/directory/{ruta}/', 'PathController@newRoute');

   Route::post('directory/back', 'PathController@goingBack');
   Route::get('/videos/{id}/options','VideoController@show');

   Route::post('/videos/extension' , 'VideoController@change');
   Route::post('/videos/convert' , 'VideoController@ExtensionChange');
   Route::post('/videos/cut' , 'VideoController@cut');

   Route::post('/select/action', 'CatalogedController@selectAction');
    });
