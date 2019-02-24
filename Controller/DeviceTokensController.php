<?php
App::uses('AppController', 'Controller');
/**
 * DeviceTokens Controller
 *
 * @property DeviceToken $DeviceToken
 * @property PaginatorComponent $Paginator
 */
class DeviceTokensController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	//////////////////////////////////////////////////////////////////////////////
	//  		A cron job to detect invalid devicetoken and delete it 			//
	//////////////////////////////////////////////////////////////////////////////

	public function inactive_device_detect(){
		$this->autoRender = false;
		//$SERVER ='feedback.sandbox.push.apple.com:2196';
		//Put your private key's passphrase here:

		$passphrase = 'mamun';

    	//$certificate_path =  WWW_ROOT.'files'.DS.'push_certificate'. DS .'ck.pem';
        $certificate_path_production = WWW_ROOT . 'files' . DS . 'push_certificate' . DS . 'ck_production.pem';

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate_path_production);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client('ssl://feedback.sandbox.push.apple.com:2196', $err, 
			$errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

		if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);

		echo 'Connected to APNS' . PHP_EOL;

		$tuples = stream_get_contents($fp);

		fclose($fp);

		if ($tuples === false) {
			echo 'Failed to download device tokens' . PHP_EOL;
		}

		print_r($tuples);

		if ($tuples !== false) {
			$tupleCount = strlen($tuples) / 38;
			echo "Downloaded $tupleCount device tokens" . PHP_EOL;

			for ($i = 0; $i < $tupleCount; $i++){
				$offset = $i * 38;

				// Each tuple is 38 bytes. The first 4 bytes contain a UNIX
				// timestamp that indicates when the APNS determined that the
				// application no longer exists on the device.

				$timestamp = substr($tuples, $offset, 4);
				$timestamp = hexdec(bin2hex($timestamp));

				// The next 2 bytes contain the length of the device token.
				// Currently, this is always 32.

				$length = substr($tuples, $offset + 4, 2);
				$length = hexdec(bin2hex($length));

				// The remaining 32 bytes contain the device token. We convert
				// it to a 64-character hexadecimal string.

				$token = substr($tuples, $offset + 6, 32);
				$token = bin2hex($token);

				print_r($token);

				 echo 'Timestamp: ' . $timestamp . ', Token: ' . $token . PHP_EOL;

				$device_token_obj = $this->DeviceToken->findByDeviceToken($token);
				if(!empty($device_token_obj)){
					$this->DeviceToken->id = $device_token_obj['DeviceToken']['id'];
					$this->DeviceToken->delete();
				}
			}
		}
	}


}
