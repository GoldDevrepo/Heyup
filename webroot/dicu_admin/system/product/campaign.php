<?php
class Campaign{
	public function keywordExists($keyword){
		global $db;
		$sql = "SELECT keyword FROM ". DB_PREFIX ."campaign WHERE keyword='". $db->escape($keyword) ."'";
		$rs = $db->query($sql);
		return ($rs->num_rows)?true:false;
	}
	public function getCampaignByKeyword($keyword){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."campaign WHERE keyword='". $db->escape($keyword) ."' AND status='1' ORDER BY campaign_id DESC LIMIT 0,1";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function addCampaign($data){
		global $db;
		$sql = "INSERT INTO ". DB_PREFIX ."campaign SET ref_seller_id='". (int)$data['ref_seller_id'] ."', title='". $db->escape($data['title']) ."', description='". $db->escape($data['description']) ."', tags='". $db->escape($data['tags']) ."', length='". (int)$data['length'] ."', keyword='". $db->escape($data['keyword']) ."', image_front='". $db->escape($data['image_front']) ."', image_back='". $db->escape($data['image_back']) ."', target_qty='". (int)$data['target_qty'] ."', selling_price='". (float)$data['selling_price'] ."', recommended_price='". (float)$data['recommended_price'] ."', profit_per_sale='". (float)$data['profit_per_sale'] ."', estimated_profit='". (float)$data['estimated_profit'] ."',date_expired='". $db->escape($data['date_expired']) ."', date_added=NOW(), date_modified=NOW(), status='". (int)$data['status'] ."'";
		$db->query($sql);
		return $db->getLastId();
	}
	public function addProduct($data){
		global $db;
		$sql = "INSERT INTO ". DB_PREFIX ."campaign_product SET ref_campaign_id='". (int)$data['ref_campaign_id'] ."', product_type='". $db->escape($data['product_type']) ."', product_data='". $db->escape($data['product_data']) ."'";
		$db->query($sql);
		return $db->getLastId();
	}
	public function getProductByCampaignId($campaign_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."campaign_product WHERE ref_campaign_id='". (int)$campaign_id ."' ORDER BY campaign_product_id DESC LIMIT 0,1";
		$rs = $db->query($sql);
		$data = array(
			'campaign_product_id' => $rs->row['campaign_product_id'],
			'ref_campaign_id' => $rs->row['ref_campaign_id'],
			'product_type' => $rs->row['product_type'],
			'product_data' => unserialize(base64_decode($rs->row['product_data']))
		);		
		return $data;
	}
	public function getCampaignById($campaign_id){
		global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."campaign WHERE campaign_id='". (int)$campaign_id ."'";
		$rs = $db->query($sql);
		return $rs->row;
	}
}
?>