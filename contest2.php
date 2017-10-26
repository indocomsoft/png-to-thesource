<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');


include_once("GDIndexedColorConverter.php");

function convertcolour($current){
	switch($current){
		case 0x000000:
		$code="b";
		break;
		
		case 0xFFFFFF:
		$code="a";
		break;
		
		case 0x4BAE79:
		$code="c";
		break;
		
		case 0x3E50B4:
		$code="d";
		break;
		
		case 0xFE9700:
		$code="e";
		break;
		
		case 0xE81D62:
		$code="f";
		break;
		
		case 0xA900FE:
		$code="g";
		break;
		
		case 0xFD4235:
		$code="h";
		break;
		
		case 0xFEEA3A:
		$code="i";
		break;
		
		case 0x2095F2:
		$code="j";
		break;
		
		case 0x785447:
		$code="k";
		break;
	}
	return $code;
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	die("Error in uploading");
}

if(!($image = imagecreatefrompng($target_file))){
	die("Image uploaded is not in png format.<br /><a href=\"javascript:window.history.back();\">Go back</a>");
}

if(!is_numeric($_POST["strength"])){
	die("Dithering strength is not a number.<br /><a href=\"javascript:window.history.back();\">Go back</a>");
}

if($_POST["strength"] > 1.0 || $_POST["strength"] < 0.0){
	die("Invalid dithering strength entered. Please enter a number between 0 and 1.<br /><a href=\"javascript:window.history.back();\">Go back</a>");
}

$converter = new GDIndexedColorConverter();

$palette = array(
		array(0x00,0x00,0x00),		//black
		array(0xFF,0xFF,0xFF),		//white
		array(0x4B,0xAE,0x79),		//green
		array(0x3E,0x50,0xB4),		//indigo
		array(0xFE,0x97,0x00),		//orange
		array(0xE8,0x1D,0x62),		//pink
		array(0xA9,0x00,0xFE),		//purple
		array(0xFD,0x42,0x35),		//red
		array(0xFE,0xEA,0x3A),		//yellow
		array(0x20,0x95,0xF2),	//blue
		array(0x78,0x54,0x47)		//brown
);

$new_image = $converter->convertToIndexedColor($image, $palette, $_POST["strength"]);

$output_file = 'output'.basename($_FILES["fileToUpload"]["name"]).'.png';

imagepng($new_image, $output_file, 0);

list($width, $height) = getimagesize($output_file);
$output = '<textarea style="height:100%; width:100%;">
function draw_pic(){
	var a = blank_bb;
	var b = black_bb;
	var c = green(black_bb);
	var d = indigo(black_bb);
	var e = orange(black_bb);
	var f = pink(black_bb);
	var g = purple(black_bb);
	var h = red(black_bb);
	var i = yellow(black_bb);
	var j = blue(black_bb);
	var k = brown(black_bb);
	var l = stack_frac;
	var m = quarter_turn_left;
	return ';
$count=1;
$close_count=0;
$block=0;

for($i=0;$i<$height;$i++){
	if($i<($height-1))$output = $output."l(1/".($height-$i).",m(";
	else $output = $output."m(";
	$close_count=0;
	for($j=0;$j<$width;$j++){
		if($j<($width-1)){
			if(imagecolorat($new_image,$j,$i) == imagecolorat($new_image,$j+1,$i)){
				if($count==1){
					$ccurrent=imagecolorat($new_image,$j,$i);
					$count++;
				} else {
					$count++;
				}
			} else {
				$output = $output."l(".$count."/".($width-$j+$count-1).",".convertcolour(imagecolorat($new_image,$j,$i)).",";
				$block++;
				$close_count++;
				$count=1;
			}
		} else {
			if($count==1){
				$output = $output."".convertcolour(imagecolorat($new_image,$j,$i))."";
				$block++;
			} else {
				$output = $output."".convertcolour($ccurrent)."";
				$block++;
				$count=1;
			}
		}
	}
	for($j=1;$j<=$close_count;$j++)$output = $output.")";
	$output = $output.")";
	if($i<($height-1))$output = $output.",";
}
for($i=0;$i<($height-1);$i++)$output = $output.")";
$output = $output.";}\n</textarea>";

echo '<table border=0 height="100%" width="100%"><tr style="white-space:nowrap;"><td style="align:top;">'."No of blocks = ".$block."</td><td width=\"100%\" rowspan=\"2\">".$output."</td></tr><tr style=\"height:100%;vertical-align:top;\"><td><b>Preview:</b><br /><img src=\"".$output_file."\" width=\"256\" height=\"256\" style=\"border: 1px solid black; image-rendering: -moz-crisp-edges; image-rendering: -o-crisp-edges; image-rendering: -webkit-optimize-contrast;\" /><br />Run this on the interpreter:<br /><textarea>show(draw_pic());</textarea><br /><br /><a href=\"javascript:window.history.back();\">Go back</a></td></tr></table>";