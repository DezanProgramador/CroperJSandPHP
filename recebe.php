<?
	print_r($_FILES);
	print_r($_POST);
	$base64string = $_POST['img64'];



	$data = $base64string;
	
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
	

	while (true) {
		$origem = uniqid(rand(), true);
		if (!file_exists(sys_get_temp_dir() . $origem)) break;
	}
	$destino = $origem.".jpg";

	file_put_contents($origem, $data);
	
	function png2jpg($originalFile, $outputFile, $quality) {
		$image = imagecreatefrompng($originalFile);
		$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		//imagealphablending($bg, TRUE)

		imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
		imagedestroy($image);		

		imagejpeg($bg, $outputFile, $quality);
		unlink($originalFile);
	}


	
	png2jpg($origem, $destino, 70);
	
	
?>