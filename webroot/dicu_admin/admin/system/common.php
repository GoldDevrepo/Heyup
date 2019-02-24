<?php
class Common{
	public function checkAdminLogin(){
		global $session;
		if(isset($session->data['admin'])){
			return true;
		}else{
			return false;
		}
	}
	public function adminAccess(){
	global $sys,$request;
		if(!$this->checkAdminLogin()){
			if(isset($request->server['HTTP_HOST']) && !empty($request->server['HTTP_HOST']) && isset($request->server['REQUEST_URI']) && !empty($request->server['REQUEST_URI'])){
				$logout_url = $request->server['HTTP_HOST'].'/'.$request->server['REQUEST_URI'];
				$logout_url = str_replace('//','/',$logout_url);
				$logout_url = 'http://'.$logout_url;
			}
			$sys->redirect(HTTP_ADMIN.'?redirect='.urlencode($logout_url));
		}
	}
	public function addAlert($type, $message){
		global $session;
		$session->data['alert']['type'] = $type;
		$session->data['alert']['message'] = $message;
	}
	public function dateLongFormat($strdate){
		return date(DATE_FORMAT_LONG,strtotime($strdate));
	}
	public function dateShortFormat($strdate){
		return date(DATE_FORMAT_SHORT,strtotime($strdate));
	}
	public function priceFormat($price){
		return number_format((float)$price, 2, '.','');
	}
	public function displayAlert(){
		global $session;
		$str = '';
		if(isset($session->data['alert'])){
			$str = '<div class="alert alert-'. $session->data['alert']['type'] .'"><i class="fa fa-exclamation-circle"></i> '. $session->data['alert']['message'] .'<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
			unset($session->data['alert']);
		}
		return $str;
	}
	public function breadcrumb($breadcrumbs = array()) {
		$str = '<ul class="breadcrumb">';
		if(sizeof($breadcrumbs)){
			foreach($breadcrumbs as $breadcrumb){
				$str .= '<li><a href="'. $breadcrumb['href'] .'">'. $breadcrumb['text'] .'</a></li>';
			}
		}
		$str .= '</ul>';
		return $str;
	}
	public function pageUrl($page,$return=false){
		$url = HTTP_ADMIN.$page.'.php';
		if($return){
			return $url;
		}else{
			echo $url;
		}
	}
	public function checkImageType($var){
	global $request;
		$type = $request->files[$var]['type'];
		if($type == 'image/gif' || $type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/pjpeg' || $type == 'image/bmp' || $type == 'image/png'){
			return true;
		}else{
			return false;
		}
	}
	public function checkFontType($var){
	global $request;
		$type = $request->files[$var]['type'];
		if($type == 'application/octet-stream'){
			return true;
		}else{
			return false;
		}
	}
	public function uploadImage($val,$dir=''){
	global $request;
		if(isset($request->files[$val]['name']) && !empty($request->files[$val]['name']) && $request->files[$val]['error']==0){
			$image = $request->files[$val]['name'];
			$image = time().preg_replace("/[^A-Za-z0-9-._]/", "", $image );
			$dir = HTTP_ROOT.$dir.'/';
			$dir = str_replace('//','/',$dir);
			if(!is_dir($dir)){
				mkdir($dir, 0777, true);
			}
			copy($request->files[$val]['tmp_name'],$dir.$image);
			return $image;
		}
	}
	public function deleteImage($file,$dir=''){
		$dir = HTTP_ROOT.$dir.'/'.$file;
		$dir = str_replace('//','/',$dir);
		if(file_exists($dir)){
			@unlink($dir);
		}
	}
	public function imageCache($dir='',$filename,$w,$h='auto'){
		$root_dir = WEB_ROOT.$dir;
		$root_dir = str_replace('//','/',$root_dir);
echo $root_dir.$filename;

		if(!empty($filename) && file_exists($root_dir.$filename)){
			$SimpleImage = new SimpleImage();
			$filename_new = $w.'x'.$h.'_'.$filename;
			if(!file_exists(HTTP_ROOT_CACHE.$filename_new)){
				$SimpleImage->load($root_dir.$filename);
				if($h=='auto'){
					$SimpleImage->resizeToWidth($w);
				}else{
					$SimpleImage->resize($w,$h);
				}
				$SimpleImage->save(HTTP_ROOT_CACHE.$filename_new);
				echo '<img class="cached" width="'. $w .'" height="'.$h.'" src="'. HTTP_CACHE.$filename_new .'" />';
			}
			else{
				echo '<img class="cached" width="'. $w .'" height="'.$h.'" src="'. HTTP_CACHE.$filename_new .'" />';
			}
		}else{
			echo '<img class="cached" width="'. $w .'" height="'.$h.'"  src="'. HTTP_IMAGES.'no-image.jpg" />';
		}
	}
}
?>
