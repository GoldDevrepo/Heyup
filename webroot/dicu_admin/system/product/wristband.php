<?php
class Wristband{
	public function getStyle($style_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_style WHERE status='1' AND style_id='". (int)$style_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function getStyles(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_style WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getSize($size_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_size WHERE status='1' AND size_id='". (int)$size_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function getSizes(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_size WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getType($type_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_type WHERE status='1' AND type_id='". (int)$type_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function getTypes(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_type WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getColor($color_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_color WHERE status='1' AND color_id='". (int)$color_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function getColors(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_color WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getFonts(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_font WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getFontColors(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_text_color WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getCliparts(){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."wb_clipart WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
}
?>