<?php
class Seller{
	public function haveAccess(){
	global $sys;
		if(!$this->checkSellerLogin()){
			$sys->redirect(HTTP_SERVER . 'account/logout/');
		}
	}
	public function checkSellerLogin(){
	global $sys, $session, $seller;
	$logged = false;
		if($sys->notEmpty($session->data['seller'])){
			$acc = $session->data['seller'];
			$data = array(
				'email'		=>	$acc['email'],
				'password'=>	$acc['password']
			);
			$logged = $this->sellerExist($data);
		}
		return $logged;
	}
	
	public function sellerExist($data){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."seller WHERE email='". $db->escape($data['email']) ."' AND password='". $db->escape($data['password']) ."' AND status='1'";
		$rs = $db->query($sql);
		return ($rs->num_rows)?true:false;
	}
	public function sellerEmailExist($email){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."seller WHERE email='". $db->escape($email) ."'";
		$rs = $db->query($sql);
		return ($rs->num_rows)?true:false;
	}
	public function getSeller($data){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."seller WHERE email='". $db->escape($data['email']) ."' AND password='". $db->escape($data['password']) ."' ORDER BY seller_id ASC LIMIT 0,1";
		$rs = $db->query($sql);
		return $rs->row;
	}
	public function addSeller($data){
	global $db;
		$sql = "INSERT INTO ". DB_PREFIX ."seller SET email='". $db->escape($data['email']) ."', password='". $db->escape($data['password']) ."', status='1', date_added=NOW(), date_modified=NOW()";
		$db->query($sql);
		return $db->getLastId();
	}
}
?>