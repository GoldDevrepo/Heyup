<?php
class Sys{
	public function isPost($var){
	global $request;
		if((isset($request->post[$var]) && !empty($request->post[$var])) || @$request->post[$var] === '0'){
			return true;
		}else{
			return false;
		}
	}
	public function isGet($var){
	global $request;
		if((isset($request->get[$var]) && !empty($request->get[$var])) || @$request->get[$var] === '0'){
			return true;
		}else{
			return false;
		}
	}
	public function notEmpty(&$var){
		return ((isset($var) && !empty($var)) || $var === '0')?true:false;
	}
	public function redirect($url){
		header('Location: '. $url);
		die;
	}
	public function getForwardedIp(){
	global $request;
	$forwarded_ip = '';
		if (!empty($request->server['HTTP_X_FORWARDED_FOR'])) {
			$forwarded_ip = $request->server['HTTP_X_FORWARDED_FOR'];
		} elseif(!empty($request->server['HTTP_CLIENT_IP'])) {
			$forwarded_ip = $request->server['HTTP_CLIENT_IP'];
		} else {
			$forwarded_ip = '';
		}
	return $forwarded_ip;
	}
	public function getUserAgent(){
	global $request;
		return ((isset($request->server['HTTP_USER_AGENT']))?$request->server['HTTP_USER_AGENT']:'');
	}
	public function getIp(){
	global $request;
		return $request->server['REMOTE_ADDR'];
	}
	public function thumbImage($url, $width = 150, $height = true){
		if(empty($url)){ $url = HTTP_IMAGES.'no-image.jpg'; }
		$filename = md5($url.$width.$height).'.jpg';
		$filepath = HTTP_ROOT_CACHE . $filename;
		$img = '';
		if(!file_exists($filepath)){
			$image = ImageCreateFromString(file_get_contents($url));
			$height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
			$output = ImageCreateTrueColor($width, $height);
			ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
			ImageJPEG($output,$filepath,80);
		}
		$img = HTTP_CACHE . $filename;
		return $img;
	}
}
?>
