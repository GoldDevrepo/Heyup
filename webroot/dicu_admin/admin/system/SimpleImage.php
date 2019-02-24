<?php
/*
	Version: 1.3
	Modified Date: 30/06/2014
	Modified By: Ashwani
	Change Log: PNG transparent background fixes

	Version:	1.2
	Modified Date:	10/11/2013
	Modified By:	Ashwani
	Change Log: PNG transparent background fixes
	
*/
class SimpleImage { 
   var $image;
   var $image_type;
	 var $file_name;
   private $info;
 
   function load($filename) {
			$this->file_name = strtolower($filename);
			@$info = getimagesize($file);

			$this->info = array(
            	'width'  => $info[0],
            	'height' => $info[1],
            	'bits'   => $info['bits'],
            	'mime'   => $info['mime']
        	);
			
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_PNG, $compression=100, $permissions=null) {
 
      if( strpos($this->file_name,'.jpg') || strpos($this->file_name,'.jpeg')) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( strpos($this->file_name,'.gif') ) {
 
         imagegif($this->image,$filename);
      } elseif( strpos($this->file_name,'.png') ) {
 
         imagepng($this->image,$filename,9);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_PNG) {
 
      if( strpos($this->file_name,'.jpg') || strpos($this->file_name,'.jpeg') ) {
         imagejpeg($this->image);
      } elseif( strpos($this->file_name,'.gif') ) {
 
         imagegif($this->image);
      } elseif( strpos($this->file_name,'.png') ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
    $new_image = imagecreatetruecolor($width, $height);
	  //if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {		
	  if (strpos($this->file_name,'.png')) {		
			imagealphablending($new_image, false);
			imagesavealpha($new_image, true);
			$background = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
			imagecolortransparent($new_image, $background);
		} else {
			$background = imagecolorallocate($new_image, 255, 255, 255);
		}
	  imagefilledrectangle($new_image, 0, 0, $width, $height, $background);
	  
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
 
}
?>