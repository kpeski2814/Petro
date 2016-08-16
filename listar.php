<?php
$directorio = opendir("C:\\Users\Developer\Pictures"); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (is_dir($archivo))//verificamos si es o no un directorio
    {
        echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
    }
    else
    {
        echo "[".$archivo . "]";
		echo "<img src=".$archivo . " width=100 height=100></img> <br />";
		
    }
}

$ruta_video='24214219.avi'; 
?>
<!-- <embed src="<php echo $ruta_video; ?>" width="100" height="150" autostart="true" loop="true" /> </embed> -->



