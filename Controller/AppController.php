<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session', 'RequestHandler',
        'Auth' => array(
            'loginAction' => array('controller' => 'users', 'action' => 'register', 'admin' => true),
            //'loginAction' => array('controller' => 'users', 'action' => 'register'),
            // 'loginRedirect' => array('controller' => 'users', 'action' => 'index', 'admin' => true),
            // 'logoutRedirect' => array('controller' => 'users', 'action' => 'login', 'admin' => true),
            'authError' => 'You are not allowed',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email', 'password' => 'password')
                )
            )
        )
    );

    public function beforeFilter() {

        $this->Auth->allow('register',
                'login',
                'search',
                'update',
                'round_photo',
                'all_images', 
                'friend_request',
                'heyup_accept_chat',
                'my_friend',
                'chat_request',
                'notification_list',
                'send_message',
                'message_list',
                'view_profile',
                'block', 
                'like',
                'andpush',
                'count_viewer',
                'count_liker',
                'myprofile',
                'message_list_join',
                'g',
                'create_proposal',
                'get_proposals',
                'report_proposal',
                'report_user',
                'single_notification',
                'checkin',
                'delete_images',
                'get_more_data',
                'view_profile_details',
                'birthday_cron',
                'unfriend',
                'unlike',
                'test',
                'buy_credit',
                'delete_message',
                'delete_notification',
                'credit_list',
                'logout', 
                'mongo_message', 
                'mongo_message_list',
                'user_profile_pic',
                'delete_messages',
                'delete_account', 
                'upload_image',
                'iforgot', 
                'inactive_device_detect', 
                'bumped_into', 
                'ingore_bump', 
                'bumped_list',
                'check', 
                'message_list2',
                'message_list3', 
                'change_password',
                'get_session_list',
                'test_android', 
                'test_android_encounter',
                'test_ios',
                'logout_by_email');


        // if ($this->request->is('post')) {
        //     // Execute code only if client is an HTML (text/html)
        //     // response
        //     print_r('expression');
        // }
        // if ($this->request->is('ajax')) {
        //     //parent::beforeFilter();
        //     // Execute XML-only code
        //     //print_r('expression');
        //     //$this->RequestHandler->setContent('json', 'application/json');
        //     $this->RequestHandler->respondAs('json');
        // }
    }

    // public function beforeRender(){
        
    // }
    //upload image
    function _upload($file, $folder = null, $fileName = null) {
        App::import('Vendor', 'phpthumb', array('file' => 'phpthumb' . DS . 'phpthumb.class.php'));
        if (is_uploaded_file($file['tmp_name'])) {
            $ext = strtolower(array_pop(explode('.', $file['name'])));
            if ($ext == 'txt')
                $ext = 'jpg';
            if ($folder == null && $fileName == null) { // upload full image
                $fileName = time() . rand(1, 999) . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                    $uplodFile = WWW_ROOT . 'files' . DS . 'images' . DS . $fileName;
                    if (move_uploaded_file($file['tmp_name'], $uplodFile)) {
                        // $dest_small = WWW_ROOT . 'files' . DS . 'images' . DS . 'thumb' . DS . $fileName;
                        // $this->_resize($uplodFile, $dest_small);
                        return $fileName;
                    }
                }
            } elseif ($folder !== null && $fileName == null) { // upload image for message
                $fileName = time() . rand(1, 999) . '.' . $ext;
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                    $uplodFile = WWW_ROOT . 'files' . DS . $folder . DS . $fileName;
                    if (move_uploaded_file($file['tmp_name'], $uplodFile)) {
                        return $fileName;
                    }
                }
            } else { // upload round image
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                    $uplodFile = WWW_ROOT . 'files' . DS . 'images' . DS . $folder . DS . $fileName;
                    if (move_uploaded_file($file['tmp_name'], $uplodFile)) {
                        return $fileName;
                    }
                }
            }
        }
    }

    //image resize
    function _resize($src, $dest_small) {
        $phpThumb = new phpThumb();
        $phpThumb->resetObject();
        $capture_raw_data = false;
        $phpThumb->setSourceFilename($src);
        $phpThumb->setParameter('w', 208);
        $phpThumb->setParameter('h', 208);
        //$phpThumb->setParameter('zc', 1);
        $phpThumb->GenerateThumbnail();
        $phpThumb->RenderToFile($dest_small);
    }

    function _credit($data) {
        $this->loadModel('Transaction');
        $this->Transaction->create();
        $this->Transaction->save($data);
    }

    //user activity update
    function _latest_activity($id) {
        $this->loadModel('User');
        $now = date("Y-m-d H:i:s");
        $this->User->query("
        UPDATE users
          SET latest_activity = '$now'
          WHERE
            users.id = '$id'
      ");
    }

    function _is_friend($me, $other) {
        $this->loadModel('Friend');
        $is_validity = $this->Friend->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                //'Friend.is_accepted' => 1,
                'OR' => array(
                    array(
                        'Friend.userId1' => $me,
                        'Friend.userId2' => $other
                    ),
                    array(
                        'Friend.userId1' => $other,
                        'Friend.userId2' => $me
                    )
                )
            )
        ));
        return $is_validity;
    }

    function _is_blocked($me, $other) {
        $this->loadModel('Block');
        $is_validity = $this->Block->find('first', array(
            'conditions' => array(
                'OR' => array(
                    array(
                        'Block.userId1' => $me,
                        'Block.userId2' => $other
                    ),
                    array(
                        'Block.userId1' => $other,
                        'Block.userId2' => $me
                    )
                )
            )
        ));
        return $is_validity;
    }

    function _is_liked($me, $other) {
        $this->loadModel('Like');
        $is_validity = $this->Like->find('first', array(
            'conditions' => array(
                'Like.who' => $me,
                'Like.whom' => $other
            )
        ));
        return $is_validity;
    }

    function _activity($me, $other = null, $activity_type, $description = null) {
        $this->loadModel('Activity');
        $activity = array(
            'Activity' => array(
                'who' => $me,
                'whom' => $other,
                'activity_type' => $activity_type,
                'description' => $description
            )
        );
        $this->Activity->create();
        $this->Activity->save($activity);
    }

    function _viewed($follow_userId, $me_Id) {
        $this->loadModel('Follow');

        $follower = $this->Follow->Follower->findById($follow_userId);
        $me = $this->Follow->Me->findById($me_Id);
        $already_followed = $this->Follow->find('first', array(
            'conditions' => array(
                'Follow.userId1' => $follow_userId,
                'Follow.userId2' => $me_Id
            )
        ));

        if (empty($already_followed)) {
            $this->Follow->create();
            $this->Follow->save($this->request->data);
            //if($me['Me']['is_notify'] == 1){
            $notification = array(
                'Notification' => array(
                    'who' => $follow_userId,
                    'whom' => $me_Id,
                    'title' => $follower['Follower']['name'],
                    'body' => $follower['Follower']['name'] . ' viewed your profile.',
                    'notification_type' => 'view_profile',
                    'is_read' => 0
                )
            );
            $this->Notification->create();
            $this->Notification->save($notification);
            // }
            $this->_latest_activity($follow_userId);
        } else {
            return true;
        }
    }

    function _profile($user_id, $profiler) {
        $this->loadModel('User');
        $this->User->recursive = -1;
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $profiler),
            'fields' => array('User.id', 'User.name', 'User.gender', 'User.dob', 'User.lives_in', 'User.tagline', 'User.profile_img'),
                )
        );
        $this->loadModel('Block');
        $is_blocked = $this->Block->find('first', array(
            'conditions' => array(
                'Block.userId1' => $profiler,
                'Block.userId2' => $user_id
            )
                )
        );
        if (empty($is_blocked))
            return $user;
        else
            return array();
    }

    function _check_tokens($id) {
        $this->loadModel('DeviceToken');
        $devices = $this->DeviceToken->find('all', array(
            'fields' => array(
                'device_token',
                'stage',
                'device_type'
            ),
            'conditions' => array(
                'user_id' => $id
            )
        ));
        return $devices;
    }

    function _push($getMessage, $id, $f_id = null, $c_id = null, $m_f_id = null) {
        
        // send android push first
        //$this->_android_push($getMessage, $id, $f_id, $c_id, $m_f_id);

        $certificate_path_development = WWW_ROOT . 'files' . DS . 'push_certificate' . DS . 'heyup-prod.pem';
        $certificate_path_production = WWW_ROOT . 'files' . DS . 'push_certificate' . DS . 'heyup-prod.pem';
                           
        $certificate_heyup_path_development = WWW_ROOT . 'files' . DS . 'push_certificate' . DS . 'heyup-prod.pem';
        $certificate_heyup_path_production = WWW_ROOT . 'files' . DS . 'push_certificate' . DS . 'heyup-prod.pem';

        $this->loadModel('DeviceToken');
        $devices = $this->DeviceToken->find('all', array(
            'fields' => array(
                'device_token',
                'stage',
                'device_type'
            ),
            'conditions' => array(
                'user_id' => $id
            )
        ));

        // Put your private key's passphrase here:
        $passphrase = '1111';
        $passphrase = '1111'; // amit

        $push_url_development = 'ssl://gateway.sandbox.push.apple.com:2195';
        $push_url_production = 'ssl://gateway.push.apple.com:2195';
        $android_device_tokens = array();
        if (!empty($devices)) {
            foreach ($devices as $device) {
                $deviceToken = trim($device['DeviceToken']['device_token']);

                if ($device['DeviceToken']['device_type'] === 'ios') {

                    if (!empty($deviceToken)) {
                        if (!empty($f_id) && empty($m_f_id)) {
                            $body['aps'] = array(
                                'alert' => $getMessage,
                                'sound' => 'default',
                                'badge' => +1,
                                'F' => $f_id,
                                'C' => $c_id,
                            );
                        } elseif (!empty($m_f_id) && empty($f_id)) {
                            $body['aps'] = array(
                                'alert' => $getMessage,
                                'sound' => 'default',
                                'badge' => +1,
                                'MF' => $m_f_id,
                                'C' => $c_id
                            );
                        } else {
                            $body['aps'] = array(
                                'alert' => $getMessage,
                                'sound' => 'default',
                                'badge' => +1,
                            );
                        }
                    }
                    
                    if ($device['DeviceToken']['stage'] != 'production') {
                        $this->_apns($certificate_path_development, $passphrase, $push_url_development, $deviceToken, $body);
                    } elseif ($device['DeviceToken']['stage'] == 'production') {
                        $this->_apns($certificate_path_production, $passphrase, $push_url_production, $deviceToken, $body);
                    }
                } elseif ($device['DeviceToken']['device_type'] === 'android') {
                    array_push($android_device_tokens, $deviceToken);
                    if (count($android_device_tokens) > 0) {
                        $this->_agcm($deviceToken, 'AIzaSyDZLDjxeqz7i_vUv0ZZu8WfQjH5faIE6KE', $getMessage);
                    }
                }
            }
        }
        // commented out for android first approach
      //  if (count($android_device_tokens) > 0) {
            //$this->_agcm($android_device_tokens, 'AIzaSyBIB74xCLAT1veUkLkge9fd6c4J40QZ48o', $getMessage);
       //     if ($getMessage == "You've had a close encounter!") { // for new bump packet
       //     } else {
       //         $this->_agcm($android_device_tokens, 'AIzaSyDZLDjxeqz7i_vUv0ZZu8WfQjH5faIE6KE', $getMessage);
                // $this->_agcm($android_device_tokens, 'AIzaSyDhGUlpvGLAHtYKXteAAgtGKAAIRk-cSOE', $getMessage); // mukesh builts
       //     }
       // }
    }

    function _android_push($getMessage, $id, $f_id = null, $c_id = null, $m_f_id = null) { // android 
        $this->loadModel('DeviceToken');
        $devices = $this->DeviceToken->find('all', array(
            'fields' => array(
                'device_token',
                'stage',
                'device_type'
            ),
            'conditions' => array(
                'user_id' => $id
            )
        ));


        $android_device_tokens = array();
        if (!empty($devices)) {
            foreach ($devices as $device) {
                $deviceToken = trim($device['DeviceToken']['device_token']);

                if ($device['DeviceToken']['device_type'] === 'ios') {
                    
                } elseif ($device['DeviceToken']['device_type'] === 'android') {
                    array_push($android_device_tokens, $deviceToken);
                }
            }
        }
        if (count($android_device_tokens) > 0) {
            $this->_agcm($android_device_tokens, 'AIzaSyDZLDjxeqz7i_vUv0ZZu8WfQjH5faIE6KE', $getMessage);
        }
    }

    private function _apns($certificate_path, $passphrase, $push_url, $deviceToken, $body) {

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate_path);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server

        $fp = stream_socket_client($push_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit(0);
        // exit("Failed to connect: $err $errstr" . PHP_EOL);
        // echo 'Connected to APNS' . PHP_EOL;
        // Encode the payload as JSON

        $payload = json_encode($body);

        // Build the binary notification

        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server

        $result = fwrite($fp, $msg, strlen($msg));
        //if (!$result) echo 'Message not delivered' . PHP_EOL;
        //else echo 'Message successfully delivered' . PHP_EOL;
        // Close the connection to the server
        fclose($fp);
    }

    public function _agcm($registrationIds, $API_ACCESS_KEY, $getMessage) {


        //define( 'API_ACCESS_KEY', 'AIzaSyBIB74xCLAT1veUkLkge9fd6c4J40QZ48o' );

        /* if(isset($_GET['inx'])){ echo "<pre>-----";print_r($_GET);exit;
          $registrationIds = array('APA91bGpPp0jh86Ku7x6hvVeaxvLRTxYpTCWyoCBK3buDvPCkw8kqgZbvzWRYjc2PVKVzvyPqtYI9x0xcHhjpRrEtwEU9W9m3j19GIkFaPos0aHbGsG5RjvDwgKMlIUIExzznx7ex_S0');
          $API_ACCESS_KEY = 'AIzaSyDZLDjxeqz7i_vUv0ZZu8WfQjH5faIE6KE';
          $getMessage = 'hello';
          } */

        //$registrationIds = array( $_GET['id'] );
        
        /*
            $fields = array
                (
                'registration_ids' => $registrationIds,
                'data' => $msg
            );

            $headers = array
                (
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
            );

            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' =>
                    'Authorization: key=' . $API_ACCESS_KEY . "\r\n" .
                    'Content-Type: application/json',
                    'content' => json_encode($fields)
            ));

            $context = stream_context_create($options);

            $result = file_get_contents('https://android.googleapis.com/gcm/send', false, $context);
        */

        $msg = array
        (
            'message' => $getMessage,
            'sound' => 1
        );
        
        $this->_agcm_curl($registrationIds, $msg);

    }

    public function _agcm_curl($registatoin_ids, $message) {
        $GOOGLE_API_KEY = "AIzaSyDZLDjxeqz7i_vUv0ZZu8WfQjH5faIE6KE";

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_id' => $registatoin_ids,
            'data' => $message,
            'to' => $registatoin_ids
        );

        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }



    public function age_cal($dob) {
        $this->loadModel('User');
        if (!empty($dob)) {
            $age = $this->User->query("SELECT
                (
                    DATE_FORMAT(NOW(), '%Y')- DATE_FORMAT('$dob','%Y')
                -(DATE_FORMAT(NOW(), '00-%m-%d')< DATE_FORMAT('$dob', '00-%m-%d')
                    )
                )AS age");
            return $age;
        } else {
            $age[0][0]['age'] = 0;
            return $age;
        }
    }

}
