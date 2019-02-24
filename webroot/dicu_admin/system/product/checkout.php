<?php
class Checkout{
	public function hasCart(){
	global $sys,$session;
		if(!$sys->notEmpty($session->data['cart'])){
			$sys->redirect(HTTP_SERVER);
		}
	}
	public function getCartTotal(){
	global $session;
		$total = 0.00;
		$quantity = 0;
		if(sizeof($session->data['cart'])){
			$cart = $session->data['cart'];
			foreach($cart as $item){
				$total += $item['netAmt'];
				$quantity += $item['qty'];
			}
		}
	return array('quantity' => $quantity, 'amount' => $total);
	}
	public function deleteCartItem($key){
	global $session;
		if(isset($session->data['cart'][$key])){
			//$session->data['cart_deleted'][] = $session->data['cart'][$key];
			unset($session->data['cart'][$key]);
		}
		if(sizeof($session->data['cart']) == 0){
			unset($session->data['cart']);
		}
	}
	
	public function placeExpressCheckout(){
	global $session, $request, $common, $sys, $encryption;
		$order_id = $session->data['order_id'];

		$max_amount = $order_info['total'];
		$max_amount = min($max_amount * 1.25, 10000);
		$max_amount = $common->priceFormat($max_amount);

		$data = array(
			'METHOD' => 'SetExpressCheckout',
			'MAXAMT' => $max_amount,
			'RETURNURL' => HTTP_SERVER.'checkout/paypal/',
			'CANCELURL' => HTTPS_SERVER . 'checkout/',
			'REQCONFIRMSHIPPING' => 0,
			'NOSHIPPING' => 1,
			'LOCALECODE' => 'EN',
			'LANDINGPAGE' => 'Login',
			'HDRIMG' => PP_EXPRESS_LOGO,
			'HDRBORDERCOLOR' => PP_EXPRESS_BORDER_COLOUR,
			'HDRBACKCOLOR' => PP_EXPRESS_HEADER_COLOUR,
			'PAYFLOWCOLOR' => PP_EXPRESS_PAGE_COLOUR,
			'CHANNELTYPE' => 'Merchant',
			'ALLOWNOTE' => PP_EXPRESS_ALLOW_NOTE,
		);

		$data = array_merge($data, $this->model_payment_pp_express->paymentRequestInfo());
		
		$result = $this->model_payment_pp_express->call($data);
		
		if(!isset($result['TOKEN'])) {
			$this->session->data['error'] = $result['L_LONGMESSAGE0'];
			if($this->config->get('pp_express_debug') == 0) {
				$this->log->write(serialize($result));
			}
			$this->redirect(HTTPS_SERVER . 'checkout/');	
		}

		$this->session->data['paypal']['token'] = $result['TOKEN'];
		
		if ($this->config->get('pp_express_test') == 1) {
			header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'].'&useraction=commit');
		} else {
			header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'].'&useraction=commit');
		}	
	}
	
	public function placePayflowOrder($cardInfo){
	global $session, $request, $common, $sys, $encryption;
		$order_id = $session->data['order_id'];
		$order_info = $this->getOrder($order_id);
		$postFields  = 'USER=' . urlencode(PP_PRO_PF_USER);
		$postFields .= '&VENDOR=' . urlencode(PP_PRO_PF_VENDOR);
		$postFields .= '&PARTNER=' . urlencode(PP_PRO_PF_PARTNER);
		$postFields .= '&PWD=' . urlencode(PP_PRO_PF_PASSWORD);
		$postFields .= '&TENDER=C';
		$postFields .= '&TRXTYPE=S';
		$postFields .= '&AMT=' . $order_info['total'];
		$postFields .= '&CURRENCY=USD';
		$postFields .= '&NAME=' . urlencode($cardInfo['cc_name']);
		$postFields .= '&STREET=' . urlencode($order_info['billing_address']);
		$postFields .= '&CITY=' . urlencode($order_info['billing_city']);
		$postFields .= '&STATE=' . urlencode($order_info['billing_state']);
		$postFields .= '&COUNTRY=' . urlencode($order_info['billing_country']);
		$postFields .= '&ZIP=' . urlencode(str_replace(' ', '', $order_info['billing_zipcode']));
		$postFields .= '&CLIENTIP=' . urlencode($request->server['REMOTE_ADDR']);
		$postFields .= '&EMAIL=' . urlencode($order_info['email']);
		$postFields .= '&ACCT=' . urlencode(str_replace(' ', '', $cardInfo['cc_number']));
		$postFields .= '&EXPDATE=' . urlencode($cardInfo['cc_mm'] . substr($cardInfo['cc_yyyy'], - 2, 2));
		$postFields .= '&CVV2=' . urlencode($cardInfo['cc_cvv']);
		$postFields .= '&BUTTONSOURCE=' . urlencode('OpenCart_Cart_PFP');
		
		if (!PP_PRO_PF_TEST) {
			$curl = curl_init('https://payflowpro.paypal.com');
		} else {
			$curl = curl_init('https://pilot-payflowpro.paypal.com');
		}

		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-VPS-REQUEST-ID: ' . md5($order_id . mt_rand())));

		$response = curl_exec($curl);

		curl_close($curl);

		if (!$response) {
			$common->addNotice('attention', 'DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
			$sys->redirect(HTTP_SERVER . 'checkout/');
		}

		$response_info = array();

		parse_str($response, $response_info);
		
		$message = '';
		foreach($response_info as $key=>$val){
			$message .= $key . ' = ' . $val . "\n";		
		}
		
		$cardData = array(
			'ref_order_id'		=>	$order_id,
			'amount'					=>	$order_info['total'],
			'trans_type'			=>	1,				//charge
			'status'					=>	0,				// by default failed
			'cc_name'					=>	$cardInfo['cc_name'],
			'cc_number'				=>	$encryption->encrypt($cardInfo['cc_number']),
			'cc_mm'						=>	$cardInfo['cc_mm'],
			'cc_yyyy'					=>	$cardInfo['cc_yyyy'],
			'cc_cvv'					=>	$cardInfo['cc_cvv'],
			'comments'				=>	$message
			
		);

		if ($response_info['RESULT'] == '0') {
			$cardData['status']	= 1;	// success
			$this->updateSoldQty($order_id);
			$this->saveCard($cardData);
			$this->updateOrderStatus($order_id,1,1);	// valid and confirmed
			$this->sendOrderReceipt($order_info);
			$common->addNotice('success', 'Order has been successfully placed!');
			$sys->redirect(HTTP_SERVER . 'checkout/thankyou/');
			
		} else {
			switch ($response_info['RESULT']) {
				case '1':
				case '26':
					$warning = 'Warning: Payment module configuration error. Please verify the login credentials.';
					break;
				case '7':
					$warning = 'Warning: A match of the Payment Address City, State, and Postal Code failed. Please try again.';
					break;
				case '12':
					$warning = 'Warning: This transaction has been declined. Please try again.';
					break;
				case '23':
				case '24':
					$warning = 'Warning: The provided credit card information is invalid. Please try again.';
					break;
				default:
					$warning = 'Warning: A general problem has occurred with the transaction. Please try again.';
				break;
			}
			$this->saveCard($cardData);	
			$common->addNotice('warning', $warning);
			$sys->redirect(HTTP_SERVER . 'checkout/');
		}
	}
	
	public function sendOrderReceipt($order_info){
	global $session,$encryption;
	
		$order_id_enc = $encryption->encrypt($order_info['order_id']);
		
		$mail_content = file_get_contents(HTTP_SERVER . 'mail/order_receipt/?refid='.$order_id_enc);
	
		$subject = WEBSITE_NAME .' - Order Receipt '. $order_id;
		$to = $order_info['email'];
		$from = SALES_EMAIL;
		$sender = WEBSITE_NAME;
	
		$mail = new Mail();		
		$mail->setTo($to);
		$mail->setFrom($from);
		$mail->setSender($sender);
		$mail->setSubject(html_entity_decode($subject));
		$mail->setHtml($mail_content);
		$mail->send();

		//unset($session->data['order']);
		//unset($session->data['cart']);
	}
	
	public function addOrder($data){
	global $db;
		$sql = "INSERT INTO ". DB_PREFIX ."order SET email='". $db->escape($data['email']) ."',shipping_name='". $db->escape($data['shipping_name']) ."',shipping_address='". $db->escape($data['shipping_address']) ."',shipping_city='". $db->escape($data['shipping_city']) ."',shipping_state='". $db->escape($data['shipping_state']) ."',shipping_zipcode='". $db->escape($data['shipping_zipcode']) ."',shipping_country='". $db->escape($data['shipping_country']) ."',billing_name='". $db->escape($data['billing_name']) ."',billing_address='". $db->escape($data['billing_address']) ."',billing_city='". $db->escape($data['billing_city']) ."',billing_state='". $db->escape($data['billing_state']) ."',billing_zipcode='". $db->escape($data['billing_zipcode']) ."',billing_country='". $db->escape($data['billing_country']) ."',payment_method='". $db->escape($data['payment_method']) ."',quantity='". (int)$data['quantity'] ."',total='". (float)$data['total'] ."',ip='". $db->escape($data['ip']) ."',forwarded_ip='". $db->escape($data['forwarded_ip']) ."',user_agent='". $db->escape($data['user_agent']) ."',date_added=NOW(),date_modified=NOW(),order_status=0, payment_status=0";
		
		/*
				order_status => 1=valid | 0 = temp
				payment_status => 1=confirmed | 0=pending | 2=failed
		
		*/
		
		$db->query($sql);
		$order_id = $db->getLastId();
		
		foreach($data['products'] as $product){
			$sql = "INSERT INTO ". DB_PREFIX ."order_product SET ref_order_id='". (int)$order_id ."',ref_campaign_id='". (int)$product['ref_campaign_id'] ."',qty='". (int)$product['qty'] ."',price='". (float)$product['price'] ."'";
			$db->query($sql);
		}
		
		return $order_id;
	}
	
	public function getOrder($order_id){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."order WHERE order_id='". (int)$order_id ."'";
		$rs = $db->query($sql);
	return $rs->row;
	}
	public function getOrderProduct($order_id){
	global $db;
		$sql = "SELECT * FROM ". DB_PREFIX ."order_product WHERE ref_order_id='". (int)$order_id ."'";
		$rs = $db->query($sql);
	return $rs->rows;
	}
	
	public function updateOrderStatus($order_id,$order_status,$payment_status){
	global $db;
		$sql = "UPDATE ". DB_PREFIX ."order SET order_status='". (int)$order_status ."', payment_status='". (int)$payment_status ."' WHERE order_id='". (int)$order_id ."'";
		$db->query($sql);
	}
	
	public function saveCard($data){
	global $db;
		$sql = "INSERT INTO ". DB_PREFIX ."transaction_cc SET ref_order_id='". (int)$data['ref_order_id'] ."', amount='". (int)$data['amount'] ."', trans_type='". (int)$data['trans_type'] ."', status='". (int)$data['status'] ."',cc_name='". $db->escape($data['cc_name']) ."',cc_number='". $db->escape($data['cc_number']) ."',cc_mm='". $db->escape($data['cc_mm']) ."',cc_yyyy='". $db->escape($data['cc_yyyy']) ."',cc_cvv='". $db->escape($data['cc_cvv']) ."',comments='". $db->escape($data['comments']) ."', date_added=NOW(),date_modified=NOW()";
		$db->query($sql);
		/*
		trans_type		=>	1=charge, 2=refund
		status 				=>	1=success, 0=failed
		*/
	}
	public function updateSoldQty($order_id){
	global $db;
	$products = $this->getOrderProduct($order_id);
	foreach($products as $product){
		$sql = "UPDATE ". DB_PREFIX ."campaign SET sold_qty=(sold_qty + ". (int)$product['qty'] .") WHERE campaign_id='". $product['ref_campaign_id'] ."'";
		$db->query($sql);
	}
	}
}
?>