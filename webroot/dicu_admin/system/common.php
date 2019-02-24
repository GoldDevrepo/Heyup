<?php
class Common{
	public function dateLongFormat($strdate){
		return date(DATE_FORMAT_LONG,strtotime($strdate));
	}
	public function dateShortFormat($strdate){
		return date(DATE_FORMAT_SHORT,strtotime($strdate));
	}
	public function priceFormat($price){
		return number_format((float)$price, 2, '.','');
	}
	public function addNotice($type, $message){	// success | warning | attention
		global $session;
		$session->data['notice']['type'] = $type;
		$session->data['notice']['value'] = $message;
	}
	public function displayNotification(){
		global $session;
		if(isset($session->data['notice'])){
			echo '<div class="notification"><div class="'. $session->data['notice']['type'] .'">'.ucfirst($session->data['notice']['type']).': '. $session->data['notice']['value'] .'<img src="'. HTTP_SERVER .'images/close.png" /></div></div>';
			unset($session->data['notice']);
		}else{
			echo '<div class="notification"></div>';
		}
	}
	
	public function imageCache($dir='',$filename,$w,$h='auto'){
		$root_dir = HTTP_ROOT.$dir;
		$root_dir = str_replace('//','/',$root_dir);
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
	
	public function filter_keyword($keyword){
		$keyword = trim($keyword);
		$keyword = strtolower($keyword);
		$keyword = preg_replace("/[^A-Za-z0-9-_]/", "-", $keyword);
		return str_replace('--','-',$keyword);
	}
	
	public function uploadCampaignImage($img_name,$img_data){
		$img_data = str_replace('data:image/png;base64,', '', $img_data);
		$img_data = str_replace(' ', '+', $img_data);
		$data = base64_decode($img_data);
		$file = HTTP_ROOT_UPLOADS . $img_name;
		$success = file_put_contents($file, $data);
	}
}
?>
