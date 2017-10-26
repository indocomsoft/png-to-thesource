<?php

include_once("GDIndexedColorConverter.php");

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $imgType = exif_imagetype($image);
	if($imgType != IMAGETYPE_PNG){
		die("File uploaded is not png");
	}
}

if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	die("Error in uploading");
}

$image = imagecreatefrompng($target_file);

$converter = new GDIndexedColorConverter();

$palette = array(
		array(0x00,0x00,0x00),
		array(0xFF,0xFF,0xFF),
		array(0x4B,0xAE,0x79),
		array(0x3E,0x50,0xB4),
		array(0xFE,0x97,0x00),
		array(0xE8,0x1D,0x62),
		array(0xA9,0x00,0xFE),
		array(0xFD,0x42,0x35),
		array(0xFE,0xEA,0x3A),
		array(0x20,0x95,0xF2),
		array(0x78,0x54,0x47)
);

$new_image = $converter->convertToIndexedColor($image, $palette, 0.8);

imagepng($new_image, 'output.png', 0);

list($width, $height) = getimagesize('output.png');
echo('
function c(code){
    if (code === 0){
        return blank_bb;
    } else if (code === 1){
        return black_bb;
    } else if (code === 2){
        return green(black_bb);
    } else if (code === 3){
        return indigo(black_bb);
    } else if (code === 4){
        return orange(black_bb);
    } else if (code === 5){
        return pink(black_bb);
    } else if (code === 6){
        return purple(black_bb);
    } else if (code === 7){
        return red(black_bb);
    } else if (code === 8){
        return yellow(black_bb);
    } else if (code === 9){
        return blue(black_bb);
    } else {
        return brown(black_bb);
    }
}

function julius_2d_contest_0(){
return ');


for($i=0;$i<$height;$i++){
	if($i<($height-1))echo("stack_frac(1/".($height-$i).",quarter_turn_left(");
	else echo "quarter_turn_left(";
	for($j=0;$j<$width;$j++){
		$current=imagecolorat($new_image,$j,$i);
		switch($current){
			case 0x000000:
			$code=1;
			break;
			
			case 0xFFFFFF:
			$code=0;
			break;
			
			case 0x4BAE79:
			$code=2;
			break;
			
			case 0x3E50B4:
			$code=3;
			break;
			
			case 0xFE9700:
			$code=4;
			break;
			
			case 0xE81D62:
			$code=5;
			break;
			
			case 0xA900FE:
			$code=6;
			break;
			
			case 0xFD4235:
			$code=7;
			break;
			
			case 0xFEEA3A:
			$code=8;
			break;
			
			case 0x2095F2:
			$code=9;
			break;
			
			case 0x785447:
			$code=10;
			break;
		}
		if($j<($width-1))echo "stack_frac(1/".($width-$j).",c(".$code."),";
		else echo "c(".$code.")";
	}
	for($j=0;$j<($width-1);$j++)echo ")";
	echo ")";
	if($i<($height-1))echo ",\n";
}
for($i=0;$i<($height-1);$i++)echo ")";
echo ";}";