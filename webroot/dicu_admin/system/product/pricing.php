<?php
class Pricing{
	public function getQuantityPrice(){
		global $db;
		$sql = "SELECT quantity_id as id, qty_value as val, profit as p FROM ". DB_PREFIX ."wb_quantityprice WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getWristbandPrice(){
		global $db;
		$sql = "SELECT style_id as sid, size_id as zid, type_id as tid, qty_id as qid, price as p FROM ". DB_PREFIX ."wb_qtypricerel";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getQuantityOthers(){
		global $db;
		$sql = "SELECT quantity_id as id, qty_value as val FROM ". DB_PREFIX ."wb_quantity WHERE status='1' ORDER BY sort_order ASC";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	public function getOthersPrice(){
		global $db;
		$sql = "SELECT style_id as sid, size_id as zid, type_id as tid, qty_id as qid, front_msg_extra as fme , internal_msg as im, internal_msg_extra as ime, back_msg as bm, back_msg_extra as bme, logo as l FROM ". DB_PREFIX ."wb_qtypriceotherrel";
		$rs = $db->query($sql);
		return $rs->rows;
	}
	
}
?>