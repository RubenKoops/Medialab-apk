<?php

include "includes.php";
	
$data=array();
$q=mysql_query("SELECT * FROM `Medialab_inventory` ORDER BY date DESC");
while ($row=mysql_fetch_object($q)){
	$data[]=$row;
	
	//maakt standaard afb als afb ontbreekt
	/*
	$id = $row->id;
	if(!file_exists("../recepten/".$id."_main.jpg")){
		echo "../recepten/".$id."_main.jpg bestaat niet <br>";
		copy("../img/no-image.jpg","../recepten/".$id."_main.jpg");
		}*/
	
}
echo json_encode($data);

foreach(glob("../recepten/*main.jpg") as $img){
	
		//echo $img.'<br>';
		//echo resize($img,"_thumb",300);
		}
	


function resize($img,$increment,$dst_width){

$new_name = str_replace(".jpg",$increment.".jpg",$img);
//new folder
list($width_orig, $height_orig) = getimagesize($img);
//ne size
$dst_height = ($dst_width/$width_orig)*$height_orig;
$im = imagecreatetruecolor($dst_width,$dst_height);
$image = imagecreatefromjpeg($img);
imagecopyresampled($im, $image, 0, 0, 0, 0, $dst_width, $dst_height, $width_orig, $height_orig);
//modive the name as u need
imagejpeg($im,$new_name);
//save memory
imagedestroy($im);
return "image saved as: ".$new_name;
}
?>