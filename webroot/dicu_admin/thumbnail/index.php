<?php
	require_once('../admin/system/startup.php');
	
	if($sys->isGet('width')){
		$width = $request->get['width'];
	}else{
		$width = 150;
	}
	
	if($sys->isGet('height')){
		$height = $request->get['height'];
	}else{
		$height = true;
	}
	
	if($sys->isGet('url')){
		$url = $request->get['url'];
	}else{
		$url = HTTP_IMAGES.'no-image.jpg';
	}
	
	$filename = HTTP_ROOT_CACHE . md5($url.$width.$height).'.jpg';

	if(file_exists($filename)){
		echo 'exists';
		die;
	}else{
		$image = ImageCreateFromString(file_get_contents($url));
		$height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
		$output = ImageCreateTrueColor($width, $height);
		ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
		ImageJPEG($output,$filename,80);
	}
	//header('Content-type: image/jpeg');
?>