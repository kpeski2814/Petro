<?php


require_once(app_path().'/phpfile_manager/class.phpmyfileeditor.php');

//Base Directory which will be used to scan files/folders to be editable
//$config['dir']['base'] = 'C:\Users\Developer\Pictures';
if(isset($new_disk)){
$config['dir']['base']  = $new_disk;
Session::put('session' , $config['dir']['base']);
$session = Session::get('session');
}
else {
  if (isset($session)) {
  $config['dir']['base'] = $session;
  }
  else {
    $new_disk = '';
    $config['dir']['base'] = '';
  }

}

//$config['access']['user'] = 'admin';//This will be used to create .htpasswd file
//$config['access']['pass'] = 'admin';//This will be used to create .htpasswd file


//Get File, Directory to be scanned
$file = filter_input(INPUT_GET,'file',FILTER_SANITIZE_STRING);
$dir = filter_input(INPUT_GET,'dir',FILTER_SANITIZE_STRING);
$remove = filter_input(INPUT_GET,'remove',FILTER_VALIDATE_INT);
$newfile = filter_input(INPUT_POST,'newfile',FILTER_SANITIZE_STRING);
$submitfile = filter_input(INPUT_POST,'submitfile',FILTER_SANITIZE_STRING);
$submitdir = filter_input(INPUT_POST,'submitdir',FILTER_SANITIZE_STRING);

//FileContents is submitted by form which will have contents to update the file
$fileContents = filter_input(INPUT_POST,'filecontents',FILTER_UNSAFE_RAW);

$errMsg = $errClass = '';

//Check for .. in Directory name
//This is to prevent users adding that in directory name and getting list of parent directories above directory listed in config
$listDir = explode('/',str_replace('\\','/',$dir));
$listFile = explode('/',str_replace('\\','/',$file));

if(in_array('..',$listDir) || in_array('..',$listFile)){
	exit('.. not allowed in the path');
}

try{
	//Start using My PHP File Editor class
	$fileEditor = new PhpMyFileEditor($config);
}catch(DirNotFoundException $e){
	$errMsg = $e->getMessage();
}

if($newfile != ''){
	try{
		if($submitfile != ''){
			$fileEditor->createNewFile(($dir=='')?$newfile:$dir.'/'.$newfile);
			$errMsg = 'File was created!';
		}elseif($submitdir != ''){
			$fileEditor->createNewDirectory(($dir=='')?$newfile:$dir.'/'.$newfile);
			$errMsg = 'Directory was created!';
		}
		$errClass = 'success';
		$file = $dir.'/'.$newfile;//Change $file so this file can be edited right away
		//Redirect users while setting new file and directory name set in URL so users can start editing it right away
		//Just setting $file to new value won't work because edit form uses INPUT_GET for $file and with new file submission, that is not set in URL
		header('Location: '.$fileEditor->getLink($_SERVER['SCRIPT_NAME'],array('file'=>($dir=='')?$newfile:$dir.'/'.$newfile,'dir'=>$dir)));
		exit;
	}catch(AlreadyExistsException $e){
		$errMsg = $e->getMessage();
		$errClass = 'error';
	}
}

//If File to be edited was set and File contents were submitted via form then update that file
if($fileContents != ''){
	try{
		$fileEditor->updateFile($file,$fileContents);
		$errMsg = 'File was updated!';
		$errClass = 'success';
	}catch(FileExistsException $e){
		$errMsg = $e->getMessage();
		$errClass = 'error';
	}
}

//Remove directory/file
if($remove == 1){
	$toRemove = ($file == '')?$dir:$file;
	if($fileEditor->removeDirFile($toRemove)){
		$errMsg = 'Removal Sucessful!';
		$errClass = 'success';
		header('Location: '.$fileEditor->getLink($_SERVER['SCRIPT_NAME'],array('dir'=>(dirname($toRemove) == '.'?'':dirname($toRemove)))));
		exit;
	}else{
		$errMsg = 'Some error occured!';
		$errClass = 'error';
	}
}

//Get left nav based on directory selected by user
//At first, it will use base directory
$leftNav = (isset($fileEditor) && is_object($fileEditor))?$fileEditor->getLeftNav($dir):'';
?>
<!DOCTYPE html>

@extends('layouts.app')

@section('content')
  <html lang="en">
  <head>
    {!!Html::script('js/vue.js')!!}
  	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

  </head>


  <body style="margin:0;">

    <div class="container">

				<div class="page-header">
         <p>
           <?php $real_name = substr(strrchr($new_disk, "\\"), 1);?>
           <h3>Directorio actual     {{ $new_disk }}</h3>
         </p>
				</div>


            @if(Session::has('status'))
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <p><strong>Al parecer tenemos un problema...</strong> </p>
                <ul>
                  <li>{{ Session::get('status') }}</li>
                </ul>
              </div>
            @endif

	    <div class="row" style="background-color: #FFFFFF;color: #000000;">
	     <div class="black column">

         <button class="ui primary button left floated" id="button-going-back">
           <i class="chevron circle left icon"></i>
           Retroceder
         </button>
         <br>
         <br>
         {!! Form::open(['action'=>'PathController@goingBack', 'id'=>'form-going-back']) !!}
         {!! Form::close() !!}

         <div class="ui blue small message">
            Selecciona al menos un archivo para catalogar.
         </div>

	      {{ Form::open(['action'=>'ReadController@catalog', 'method'=>'POST']) }}

					 <input type="submit" class="ui secondary button right floated" name="name" value="Catalogar">
					 <br>
					 <br>
           <h3>Seleccionar Todo :  <input type="checkbox" id="select_all"/></h3>
						<?php echo $leftNav;?>
	         <input type="text" name="path" value="images" hidden="">

	      {{ Form::close() }}

	     </div>
	   </div>


  </div>
  </body>
  </html>

  <script>

  $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});

	$('.ui.dropdown').dropdown();

  $('#button-going-back').click(function(){
    $('#form-going-back').submit();
  });

	$('#btn-select-disk').click(function(){
	$("#select-disk-form").submit();
	});

  $('.left.demo.sidebar').first().sidebar('attach events', '.toggle.button');
  $('.toggle.button').removeClass('disabled');
  </script>
@endsection
