<?php

class PhpMyFileEditor {
	/**
	 * Base directory which will be used to scan for files/folders to be able to edit files
	 */
	private $dirBase = '.';
	/**
	 * Access user which will be used to create .htpasswd file
	 */
	private $accessUser = '.';
	/**
	 * Access pass which will be used to create .htpasswd file
	 */
	private $accessPass = '.';

	/**
	 * Set Base Directory which will be used to list files and directories in left navigation
	 *
	 * @param 	String 	$dirBase	Base Directory to scan for in this class
	 */
	public function __construct($config){
		if(!is_dir($config['dir']['base'])){
			throw new DirNotFoundException("Base directory: '".$config['dir']['base']."' not found");
		}
		$this->dirBase = $config['dir']['base'];

	}
	/**
	 * Setup server for File Editor
	 * This includes creating .htaccess and .htpasswd files if not already exists
	 */
	public function getFileDirList($dir = '',$arrExclude=array()){
		$dir = ($dir == '')?$this->dirBase:$this->dirBase.'/'.$dir;
		$arrExclude = array_merge(array('.','..'),$arrExclude);
		$listDir = array_diff(scandir($dir), $arrExclude);
		return $listDir;
	}
	/**
	 * Generate Left navigation for File Editor
	 *
	 * @param string 	$dir 			Directory name to scan, this is needed when clicking on left nav and its a directory type so we need sub-folders and files listed there
	 * @param string 	$url 			URL to use in File and directory links when creating <ul> list
	 * @param array 	$arrExclude		Files/Directories to exclude from the list
	 * @return array 	String including <ul> tag with list of all directories
	 */
	public function getLeftNav($dir='',$url=null,$arrExclude=array()){
		//If URL not set then take current URL
		$url = '/navigate';
		$url .= strpos($url,'?')?'&':'?';
    //dd($url);
		//Get File/Dir list in supplied folder
		$list = $this->getFileDirList($dir,$arrExclude);

    foreach ($list as $file) {
      //dd($list[2]);
      $extension = explode('.' , $file);

      if (is_file($this->dirBase.'\\'.$file) && ($extension[1] == 'jpg' || $extension[1] == 'png')) {
        $thumbName  =  md5($extension[0]).'-'.$file;
        $realpath   =  $this->dirBase.'/'.$file;
        $img = \Image::make($realpath);
        $img->backup();
        /** para thumb **/
        $img->resize(150,150);
        $img->save(public_path('thumb'). '/'. $thumbName);

      }elseif (is_file($this->dirBase.'\\'.$file) && ($extension[1] == 'mp4' || $extension[1] == 'avi')) {
        $realpath = 	$this->dirBase.'/'.$file;
        $name   = $extension[0].'.jpg';
				$ffmpeg = FFMpeg\FFMpeg::create();
        $video  = $ffmpeg->open($realpath);
        $video
              ->filters()
              ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
              ->synchronize();
        $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))->save(public_path('thumb'). '/' .$name );
        //$video->save(new FFMpeg\Format\Video\X264(), public_path('videos'). '/'. $file);
        //$frame->save(public_path('videos'). '/' .$name );

      }


    }
		//Generate a <ul> List of all files/folders
		$str = '<div class="container">';

		//If directory is set then use it to go back to parent directory
		if($dir != ''){
			$str .= '<div class="panel panel-default"><div class="panel-body"><a href="'.$this->getLink($url,array('dir'=>(dirname($dir)=='.'?'':dirname($dir)))).'">Parent</a>';
		}
		foreach($list as $key=>$file){
			$ext = explode('.' , $file);
			//dd($ext[1]);
			$f = ($dir!='')?$dir.'/'.$file:$file;
			$options = (is_file($this->dirBase.'/'.$f))?array('file'=>$f,'dir'=>$dir):array('dir'=>$f);
			$str .= '<center><div class="col-md-3"><div class="panel panel-default">
      <div class="panel-body"><a class="ui black label">'.$f.'</a><br><br>'.
						(is_file($this->dirBase.'/'.$f) && ($ext[1] == 'jpg' || $ext[1] == 'png')?
            '   <img src="/thumb/'.md5($ext[0]).'-'.$file.'" width="120px" alt="" /><br><br>'.
            '   <a href="/download/'.$file.'" class="mini ui disabled secondary button">Descargar</a><br>'.
            ' <input type="checkbox" v-model="checkedNames" name="check[]" value="'.$f.'">':'').
            (is_file($this->dirBase.'/'.$f) && ($ext[1]  == 'mp4' || $ext[1]  == 'avi')?
            '   <img src="/thumb/'.$ext[0].'.jpg" width="120px" alt="" /><br><br>'.
            ' <input type="checkbox" name="check[]" value="'.$f.'">':'').
					'</div></div></div></center>';
		}
		$str .= '</div>';
		return $str;
	}

	/**
	 * Create a link by joining the given URL and the parameters given as the second argument.
	 * Arguments :  $url - The base url.
	 *                $params - An array containing all the parameters and their values.
	 *                $use_existing_arguments - Use the parameters that are present in the current page
	 * Return : The new url.
	 * Example :
	 *            getLink("http://www.google.com/search",array("q"=>"binny","hello"=>"world","results"=>10));
	 *                    will return
	 *            http://www.google.com/search?q=binny&amp;hello=world&amp;results=10
	 */
	function getLink($url,$params=array(),$use_existing_arguments=false) {
	    if($use_existing_arguments) $params = $params + $_GET;
	    if(!$params) return $url;
	    $link = $url;
	    if(strpos($link,'?') === false) $link .= '?'; //If there is no '?' add one at the end
	    elseif(!preg_match('/(\?|\&(amp;)?)$/',$link)) $link .= '&amp;'; //If there is no '&' at the END, add one.

	    $params_arr = array();
	    foreach($params as $key=>$value) {
	        if(gettype($value) == 'array') { //Handle array data properly
	            foreach($value as $val) {
	                $params_arr[] = $key . '[]=' . urlencode($val);
	            }
	        } else {
	            $params_arr[] = $key . '=' . urlencode($value);
	        }
	    }
	    $link .= implode('&',$params_arr);

	    return $link;
	}
	/**
	 * Create new file
	 * If file already exists then throw an exception
	 * If not then attempt to create file and return file_put_contents() return value
	 *
	 * @param 	String 	$fileName 	Name of the file (including directory name) to be created
	 * @return 	String 	Number of bytes written if success; false otherwise
	 */
	public function createNewFile($fileName){
		$file = $this->dirBase.'/'.$fileName;
		if(file_exists($file)){
			throw new FileExistsException($file.' already exists');
		}
		return file_put_contents($file,'');
	}
	/**
	 * Create new directory
	 * If directory already exists then throw an exception
	 * If not then attempt to create file and return file_put_contents() return value
	 *
	 * @param 	String 	$fileName 	Name of the file (including directory name) to be created
	 * @return 	String 	Number of bytes written if success; false otherwise
	 */
	public function createNewDirectory($dirName){
		$dir = $this->dirBase.'/'.$dirName;
		if(is_dir($dirName)){
			throw new AlreadyExistsException($dirName.' already exists');
		}
		return mkdir($dir,0777,true);
	}
	/**
	 * Update file with new content
	 * If file does NOT exist then trow an exception
	 *
	 * @param 	String 	$fileName 	Name of the file (including directory name) to be update
	 * @param 	String 	$content 	New content to be udpated
	 * @return 	String 	Number of bytes written if success; false otherwise
	 */
	public function updateFile($fileName,$content){
		$file = $this->dirBase.'/'.$fileName;
		if(!file_exists($file)){
			throw new FileNotExistsException('File '.$file.' does NOT exist');
		}
		return file_put_contents($file,$content);
	}
	/**
	 * Remove a file
	 * If file does NOT exist then trow an exception
	 *
	 * @param 	String 	$fileName 	Name of the file (including directory name) to be update
	 * @return 	String 	True on success; false otherwise
	 */
	public function removeDirFile($name){
		$str = $this->dirBase.'/'.$name;
		if(is_file($str)){
			return unlink($str);
		}elseif(is_dir($str)){
			return $this->delTree($str);
		}
		return false;
	}

	/**
	 * Recursively Delete directory
	 */
	private function delTree($dir) {
   		$files = array_diff(scandir($dir), array('.','..'));
    	foreach ($files as $file) {
      		(is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
    	}
    	return rmdir($dir);
  	}
}

/**
 * Custom Directory Not Found Exception Class
 */
class DirNotFoundException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 101, Exception $previous = null) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
/**
 * Custom File Exists Exception Class
 */
class AlreadyExistsException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 101, Exception $previous = null) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
/**
 * Custom File NOT Exists Exception Class
 */
class FileNotExistsException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 101, Exception $previous = null) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
