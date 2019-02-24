<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    //login for app
    public function login() {
        //print_r(AuthComponent::password($this->request->data['User']['password'])); exit;
        $this->autoLayout = false;
        header('Content-Type: application/json');
        if ($this->request->is('post')) {

            $password = AuthComponent::password($this->request->data['User']['password']); //hashing
            //overwrite password if request is 
            if (isset($this->request->data['User']['account_type'])) { // check facebook login, amit
                if ($this->request->data['User']['account_type'] == "1" || $this->request->data['User']['account_type'] == "2" || $this->request->data['User']['user_type'] == "2") {
                    $pass_info = $this->User->find('first', array(
                        'conditions' => array('User.email' => $this->request->data['User']['email'])
                            )
                    );
                    if (!empty($pass_info)) {
                        $password = $pass_info['User']['password'];
                    }
                }
            }

            $is_present = $this->User->find('first', array(
                'conditions' => array('User.email' => $this->request->data['User']['email'], 'User.password' => $password)
                    )
            );

            if (!empty($is_present)) {
                // call device token function 
                $this->_deviceToken($is_present['User']['id'], $this->request->data['DeviceToken']['device_token'], $this->request->data['DeviceToken']['device_type'], $this->request->data['DeviceToken']['stage']);
                
                /*
                // disable only for development
                if (!empty($this->request->data['User']['lat']) && !empty($this->request->data['User']['lng'])) {
                    //insert data for bumps
                    App::import('Controller', 'bumps');
                    $bumps_con = new BumpsController();
                    $bumps_users = $bumps_con->bumped_into($is_present['User']['id'], $this->request->data['User']['location']);
                }
                */

                //$user = $this->User->findById($this->User->id);
                $this->User->id = $is_present['User']['id'];
                $this->User->saveField('is_login', 1);
                $is_present['User']['is_login'] = 1;
                $this->set(compact('is_present'));
            } else {
                die(json_encode(array('success' => false, 'msg' => 'Email or Password incorrect, please try again.')));
            }
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
            exit;
        }
    }
	
	 //change password email added 20-06-2016
    public function change_password() {
        header('Content-Type: application/json');
        $this->autoRender = false;
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            $user = $this->User->findByEmail($this->request->data['User']['email'], array('User.id', 'User.email', 'User.password'));
            if (!empty($user)) {
                $oldPassword = AuthComponent::password($this->request->data['User']['old_password']);
                if ($user['User']['password'] == $oldPassword) {
                    $newPassword = $this->request->data['User']['new_password'];
                    $data = array(
                        'id' => $user['User']['id'],
                        'password' => AuthComponent::password($newPassword)
                    );
                    $this->User->save($data);
                    die(json_encode(array('success' => true, 'msg' => 'Succeed to change password')));
                    
                } else 
                    die(json_encode(array('success' => false, 'msg' => 'Wrong old password')));
                
            } else
                die(json_encode(array('success' => false, 'msg' => 'Email address not found.')));
        }
    }

    public function logout($user_id) {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->User->id = $user_id;
        $this->User->saveField('is_login', 0);
        die(json_encode(array('success' => true, 'msg' => 'Successfully logged out.')));
    }

    public function myprofile($me) {
        $this->autoLayout = false;
        header('Content-Type: application/json');
        $this->User->recursive = -1;
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $me)
                )
        );
        // $name_array = explode(' ', $user['User']['name']);
        //     if(!empty($name_array[1]))
        //         $user['User']['name'] = $name_array[0] .' '. strtoupper($name_array[1]{0});
        $age = $this->age_cal($user['User']['dob']);
        unset($user['User']['dob'], $user['User']['password']);
        $user['User']['age'] = $age[0][0]['age'];
        if (!empty($user))
            $this->set(compact('user'));
    }

    //sign up for app
    public function register() {
        $this->autoLayout = false;
        header('Content-Type: application/json');
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            $is_present = $this->User->findByEmail($this->request->data['User']['email'], 'User.email');
            if (empty($is_present)) {
                $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                $this->request->data['User']['is_login'] = 1;
                $image_upload_user = $this->_upload($this->request->data['Picture']['imagex']);
                /*if (!empty($image_upload_user)) {
                    $this->loadModel('Picture');
                    $this->_upload($this->request->data['Picture']['round_image'], 'round_images', $image_upload_user);
                    $data['Picture']['image'] = $image_upload_user;
                    //$data['Picture']['user_id'] = $user_obj['User']['id'];
                    $this->Picture->create();
                    $this->Picture->save($data);
                    $this->request->data['User']['profile_img'] = $data['Picture']['image'];
                }*/
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    if (!empty($image_upload_user)) {
                        $this->loadModel('Picture');
                        $this->_upload($this->request->data['Picture']['round_image'], 'round_images', $image_upload_user);
                        $data['Picture']['image'] = $image_upload_user;
                        $data['Picture']['user_id'] = $this->User->id;
                        $this->Picture->create();
                        $this->Picture->save($data);
                        $this->request->data['User']['profile_img'] = $data['Picture']['image'];
                    }
                    // call device token function 
                    $device_type = $this->request->data['DeviceToken']['device_type'];
                    $this->_deviceToken($this->User->id, $this->request->data['DeviceToken']['device_token'], $device_type, $this->request->data['DeviceToken']['stage']);
                    $user = $this->User->findById($this->User->id);
                    $user = $user['User'];
                    
                    // Add 10 credits
                    $Transaction = array();
                    $Transaction['user_id'] = $this->User->id;
                    if ($device_type == 'ios') {
                        $Transaction['itunes_product'] = 'com.dicu.app.10credits';
                    } else {
                        $Transaction['android_product'] = 'com.dicu.app.10credits';
                    }
                    $Transaction['amount'] = 0;
                    $Transaction['description'] = '10 Credits Points';
                    //$Transaction['time_stamp'] = date('Y-m-d H:i:s');
                    $Transaction['credit'] = 10;
                    $this->_credit(compact('Transaction'));
                    
                    // Send Welcome Email
                    $body = '<br/><br/>Hi there,<br/><br/>'
                    . 'I\'d like to thank you for joining the Did I See U Real Time Dating App…. the app that is powered by real life interactions! '
                    . 'As a thank you for joining our online dating community, I have credited your account with 10 Free Credits.<br/><br/>'
                    . 'Go out and see the people around you and never miss a dating opportunity again!<br/><br/>'
                    . 'The app that gives you a second chance to make a first impression.<br/><br/>'
                    . 'Good Luck! Best regards, <br/>The Did I See U Team!<br/><br/><a href="www.didiseeu.com"><img width="150" src="http://didiseeu.com/resources/images/did-see-u-logo.png" title="DidISeeU.com" alt="DidISeeU.com"></a>';
            
                    $Email = new CakeEmail();
                    $Email->from(array('support@didiseeu.com' => 'DidISeeU.com'));
                    $Email->to($this->request->data['User']['email']);
                    $Email->subject('Welcome to DID I SEE U!');
                    $Email->emailFormat('html');
                    $sent_email = $Email->send($body);
                    
                    $this->set(compact('user', 'sent_email', 'device_type'));                
                    //die(json_encode(array('success' => true, 'user' => $user['User']))); 
                }
            } else {
                die(json_encode(array('success' => false, 'msg' => 'This email is already in use, please try another.')));
            }
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid request')));
        }
    }
    
    private function _deviceToken($id, $device_token, $device_type, $stage) {
        if (!empty($device_token)) {
            $this->loadModel('DeviceToken');
            $device_check = $this->DeviceToken->findByDeviceToken($device_token, array('id'));
            if (!empty($device_check)) {
                $this->DeviceToken->id = $device_check['DeviceToken']['id'];
                $this->DeviceToken->save(array('DeviceToken' => array(
                        'user_id' => $id,
                        'device_token' => $device_token,
                        'device_type' => $device_type,
                        'stage' => $stage,
                )));
            } else {
                $this->DeviceToken->create();
                $this->DeviceToken->save(array('DeviceToken' => array(
                        'user_id' => $id,
                        'device_token' => $device_token,
                        'device_type' => $device_type,
                        'stage' => $stage,
                )));
            }
        }
    }

    public function delete_account($user_id = null) {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->loadModel('Friend');
        $this->loadModel('Like');
        $this->loadModel('Notification');
        $this->loadModel('Follow');
        $this->loadModel('Block');
        $this->loadModel('MongoMessage');
        $this->loadModel('Activity');
        $this->loadModel('Chat');

        $this->User->delete($user_id);

        $this->Friend->deleteAll(array('OR' => array('Friend.userId1' => $user_id, 'Friend.userId2' => $user_id)));
        $this->Like->deleteAll(array('OR' => array('Like.who' => $user_id, 'Like.whom' => $user_id)));
        $this->Notification->deleteAll(array('OR' => array('Notification.who' => $user_id, 'Notification.whom' => $user_id)));
        $this->Follow->deleteAll(array('OR' => array('Follow.userId1' => $user_id, 'Follow.userId2' => $user_id)));
        $this->Block->deleteAll(array('OR' => array('Block.userId1' => $user_id, 'Block.userId2' => $user_id)));
        $this->Activity->deleteAll(array('OR' => array('Activity.who' => $user_id, 'Activity.whom' => $user_id)));
        $this->Chat->deleteAll(array('OR' => array('Chat.sender' => $user_id, 'Chat.receiver' => $user_id)));
        $db = $this->MongoMessage->getDataSource();
        //var_dump($user_id);
        $db->delete($this->MongoMessage, array('$or' => array(
                array("sender" => $user_id),
                array('receiver' => $user_id),
        )));
        die(json_encode(array('success' => true, 'msg' => ' Successfully deleted account.')));
    }

    public function update() {
        $this->autoLayout = false;
        header('Content-Type: application/json');
        $this->User->recursive = 0;
        $this->loadModel('Picture');
        if (($this->request->is('post') || $this->request->is('put'))) {
            $user_obj = $this->User->findById($this->request->data['User']['id']);
            if (!empty($user_obj)) {
                if (empty($this->request->data['User']['password'])) {
                    unset($this->request->data['User']['password']);
                } else {
                    $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                }
                $this->loadModel('DeviceToken');
                if (!empty($this->request->data['DeviceToken']['device_token'])) {
                    $this->_deviceToken($this->request->data['User']['id'], $this->request->data['DeviceToken']['device_token'], $this->request->data['DeviceToken']['device_type'], $this->request->data['DeviceToken']['stage']);
                }
                $image_upload_user = $this->_upload($this->request->data['Picture']['imagex']);

                if (!empty($image_upload_user)) {
                    $this->_upload($this->request->data['Picture']['round_image'], 'round_images', $image_upload_user);
                    $data['Picture']['image'] = $image_upload_user;
                    $data['Picture']['user_id'] = $user_obj['User']['id'];
                    $this->Picture->create();
                    $this->Picture->save($data);
                    $this->request->data['User']['profile_img'] = $data['Picture']['image'];
                }
                $this->request->data['User']['latest_activity'] = date('Y-m-d H:i:s');
                $this->User->id = $user_obj['User']['id'];
                if ($this->User->save($this->request->data, false)) {
                    if (!empty($this->request->data['User']['location'])) {
                        //insert data for bumps
                        App::import('Controller', 'bumps');
                        $bumps_con = new BumpsController();
                        $bumps_users = $bumps_con->bumped_into($this->request->data['User']['id'], $this->request->data['User']['location']);
                    }
                    $userInfo = am($user_obj['User'], $this->request->data['User']);
                    $dob = empty($user_obj['User']['dob']) ? $this->request->data['User']['dob'] : $user_obj['User']['dob'];
                    $age = $this->age_cal($dob);
                    //unset($data_user['User']['dob']);
                    $userInfo = am($userInfo, $age[0][0]);
                    unset($userInfo['password']);
                    $this->set(compact('userInfo'));
                    //die(json_encode(array('success' => true, 'User' => $userInfo)));
                }
            } else
                die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
        } else
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request')));
    }

    public function round_photo($user_id, $image_name) {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->User->recursive = 0;
        $user_obj = $this->User->findById($user_id);
        if (!empty($user_obj)) {
            $image_upload_user = $this->_upload($this->request->data['Picture']['imagex'], 'round_images', $image_name);
            if (!empty($image_upload_user)) {
                $data['Picture']['image'] = $image_upload_user;
            }
            if ($user_obj['User']['profile_img'] != $image_name) {
                $this->User->id = $user_obj['User']['id'];
                $data['User']['profile_img'] = $image_name;
                $this->User->save($data, false);
            }
            die(json_encode(array('success' => true)));
        } else
            die(json_encode(array('success' => false, 'msg' => 'Invalid User')));
    }

    public function report_user() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        //$this->Proposal->recursive = -1;
        $this->loadModel('ReportUser');
        $this->ReportUser->recursive = -1;
        if ($this->request->is('post')) {
            $exist_report = $this->ReportUser->find('first', array(
                'conditions' => array('ReportUser.user_id' => $this->request->data['ReportUser']['user_id'])
            ));
            if ($exist_report) {
                die(json_encode(array('success' => false, 'msg' => 'You already have a report.')));
            } else {
                $this->ReportUser->create();
                if ($this->ReportUser->save($this->request->data)) {
                    $report_user = $this->ReportUser->findById($this->ReportUser->id);
                    $report_user = $report_user['ReportUser'];
                    $success = true;
                    die(json_encode(compact('report_user', 'success')));
                } else {
                    die(json_encode(array('success' => false, 'msg' => 'Unavailable to create report.')));
                }
            }
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
        }
    }

    public function search($user_id, $lat, $lng, $radius, $timeline = null) {
        $this->autoLayout = false;
        header('Content-Type: application/json');
        $me = $this->User->findById($user_id);
        $condition_string = array();

        $condition_string = "is_login = '1' AND name IS NOT NULL AND name!='' ";

        if ($me['User']['search_type'] == 'male') {
            if (!empty($timeline))
                $condition_string = "gender = 'male' AND name IS NOT NULL AND name!='' ";
            else
                $condition_string = $condition_string . " AND gender = 'male'";
        } else if ($me['User']['search_type'] == 'female') {
            if (!empty($timeline))
                $condition_string = "gender = 'female' AND name IS NOT NULL AND name!='' ";
            else
                $condition_string = $condition_string . " AND gender = 'female'";
        } else {
            if (!empty($timeline))
                $condition_string = " name IS NOT NULL AND name!='' ";
            else
                $condition_string = $condition_string . "";
        }

        $distance_unit = 3959.0 * 5280;
        $radius = $radius * 5280;

        if (!empty($timeline)) {
            $this->loadModel('Transaction');
            $this->loadModel('Checkin');
            $this->Transaction->recursive = -1;
            $credit_info = $this->Transaction->findByUserId($user_id);

            /*            if(!empty($credit_info)){     
              $remaining_credit = $this->Transaction->query("SELECT SUM(credit) FROM transactions WHERE user_id = ".$user_id."");
              if($remaining_credit[0][0]['SUM(credit)'] >= 4 ){
              $new_credit_info = array(
              'Transaction' => array(
              'user_id' => $credit_info['Transaction']['user_id'],
              'itunes_product' => $credit_info['Transaction']['itunes_product'],
              'itunes_price' => $credit_info['Transaction']['itunes_price'],
              'android_product' => $credit_info['Transaction']['android_product'],
              'android_price' => $credit_info['Transaction']['android_price'],
              'credit' => -4,
              'amount' => $credit_info['Transaction']['amount'],
              'description' => $credit_info['Transaction']['description'],
              'time_stamp' => $credit_info['Transaction']['time_stamp']
              )
              );
              $this->_credit($new_credit_info);
              } else
              die(json_encode(array('success' => false, 'error_type' => 'credit', 'msg' => 'Not enough credit, Please purchase credit.')));
              } else
              die(json_encode(array('success' => false, 'error_type' => 'credit', 'msg' => 'Please purchase credit.'))); */

            $places = $this->Checkin->find('all', array(
                'recursive' => 0,
                'fields' => array(
                    '(ACOS(
                        SIN(\'' . $lat . '\' * PI() / 180)* SIN(Checkin.lat * PI() / 180)+ 
                        COS(\'' . $lat . '\' * PI() / 180)* COS(Checkin.lat * PI() / 180)* COS(
                        (\'' . $lng . '\' * PI() / 180)-(Checkin.lng * PI() / 180))
                        ) *   ' . $distance_unit . ') AS distance',
                    'Checkin.id', 'Checkin.lat', 'Checkin.lng', 'User.id', 'User.name', 'User.dob', 'User.gender', 'User.profile_img', 'User.lat', 'User.lng', 'User.about_me', 'User.role'
                ), //in mile
                'conditions' => array(
                    'Checkin.id NOT IN (SELECT userId1 FROM blocks WHERE userId2 = \'' . $user_id . '\' ) ',
                    '(  ' . $distance_unit . ' * ACOS(
                        SIN(\'' . $lat . '\' * PI() / 180)* SIN(Checkin.lat * PI() / 180)+ COS(\'' . $lat . '\' * PI() / 180)* COS(Checkin.lat * PI() / 180)* COS(
                        (\'' . $lng . '\' * PI() / 180)-(Checkin.lng * PI() / 180)
                        ))) <=  ' => $radius, $condition_string, 'Checkin.id <>' => $user_id, 'Checkin.timeline' => $timeline, 'User.status' => '1'
                ),
                'order' => array('distance' => 'ASC'),
                'group' => array('Checkin.id')
            ));
        } else {
            $places = $this->User->find('all', array(
                'recursive' => -1,
                'fields' => array(
                    '(ACOS(
                        SIN(\'' . $lat . '\' * PI() / 180)* SIN(User.lat * PI() / 180)+ 
                        COS(\'' . $lat . '\' * PI() / 180)* COS(User.lat * PI() / 180)* COS(
                        (\'' . $lng . '\' * PI() / 180)-(User.lng * PI() / 180))
                        ) *   ' . $distance_unit . ') AS distance',
                    'User.id', 'User.name', 'User.dob', 'User.gender', 'User.profile_img', 'User.lat', 'User.lng', 'User.about_me', 'User.role'
                ),
                'conditions' => array(
                    'User.id NOT IN (SELECT userId1 FROM blocks WHERE userId2 = \'' . $user_id . '\' ) ',
                    '(  ' . $distance_unit . ' * ACOS(
                        SIN(\'' . $lat . '\' * PI() / 180)* SIN(User.lat * PI() / 180)+ COS(\'' . $lat . '\' * PI() / 180)* COS(User.lat * PI() / 180)* COS(
                        (\'' . $lng . '\' * PI() / 180)-(User.lng * PI() / 180)
                        ))) <=  ' => $radius, $condition_string, 'User.id <>' => $user_id, 'User.status' => '1'
                ),
                'order' => array('distance' => 'ASC'),
                'group' => array('User.id')
            ));

        }
        foreach ($places as $key => $place) {
//            if(empty($place['User']['name'])){
//                unset($places[$key]);
//            }
            if($me['User']['role']=="escort" && $place['User']['role']!="escort_friendly"){
                unset($places[$key]);
                continue;
            }
            if($me['User']['role']=="" && $place['User']['role']=="escort"){
                unset($places[$key]);
                continue;
            }
            empty($place['User']['name']) ? $places[$key]['User']['name'] = 'Anonymous' : $places[$key]['User']['name'] = trim($place['User']['name']);
            $age = $this->age_cal($place['User']['dob']);
            unset($places[$key]['User']['dob'], $places[$key]['User']['password']);
            $places[$key]['User']['age'] = $age[0][0]['age'];
        }
        $this->set(compact('places'));
    }

    public function view_profile_details($me, $other, $offset = null, $limit = null, $download_time = null) {
        $this->layout = false;
        header('Content-Type: application/json');
        $this->_latest_activity($me);
        $this->loadModel('Chat');
        $chat = $this->Chat->find('first', array(
            'conditions' => array(
                'OR' => array(
                    array(
                        'Chat.sender' => $me,
                        'Chat.receiver' => $other
                    ),
                    array(
                        'Chat.sender' => $other,
                        'Chat.receiver' => $me
                    )
                )
            )
        ));
        if ($me === $other)
            $other = $me;
        $data_user = $this->_get_more_data($other, $download_time);
        $activity_list = $this->_get_activity($me, $other, $offset, $limit, $download_time);
        $count_viewer = $this->_count_viewer($other, $download_time);
        $count_liker = $this->_count_liker($other, $download_time);
        $count_friend = $this->_count_friend($other, $download_time);
        $friend = $this->_is_friend($me, $other);
        $is_blocked = $this->_is_blocked($me, $other);
        $is_liked = $this->_is_liked($me, $other);
        //print_r($activity_list);
        $this->set(compact('me', 'chat', 'data_user', 'count_viewer', 'count_liker', 'count_friend', 'activity_list', 'friend', 'is_blocked', 'is_liked'));
    }

    private function _get_more_data($user_id, $download_time = null) {
        //$this->layout = false;
        $conditions = array();
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
//            $conditions = array('is_deleted' => 0);
        }
        //print_r($download_time); 
        $conditions = am($conditions, array('modified >=' => $download_time, 'User.id' => $user_id));

        $data_user = $this->User->find('first', array(
            'recursive' => -1,
            'conditions' => $conditions,
            'fields' => array(
                'name',
                'gender',
                'lives_in',
                'tagline',
                'hair_color',
                'about_me',
                'modified',
                'profile_img',
                'dob',
                'relationship',
                'ethnicity',
                'looking_for',
                'height_ft',
                'height_inch')
        ));
        $age = $this->age_cal($data_user['User']['dob']);
        unset($data_user['User']['dob']);
        $data_user = am($data_user['User'], $age[0][0]);
        //print_r($data_user); exit(0);
        return $data_user;
    }

    private function _get_activity($me = null, $user_id = null, $offset = null, $limit = null, $download_time = null) {
        $this->loadModel('Activity');
        $conditions = array();
        //$this->Activity->recursive = -1;
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
//            $conditions = array('is_deleted' => 0);
        }
        if ($me != $user_id) {
            $conditions = array('Activity.activity_type <>' => 'like_profile');
        }
        $conditions = am($conditions, array('Activity.modified >=' => $download_time, 'Activity.who' => $user_id,
            'OR' => array(array(
                    'Activity.activity_type' => 'checkin',
                    'Activity.description <>' => NULL
                ),
                array('Activity.activity_type' => 'like_profile')
            )
        ));

        if (empty($limit))
            $limit = 10;
        if (empty($offset))
            $offset = 0;
        $activity_list = $this->Activity->find('all', array(
            'recursive' => 1,
            'conditions' => $conditions,
            'offset' => $offset,
            'limit' => $limit
        ));
        return $activity_list;
    }

    private function _count_viewer($user_id, $download_time = null) {
        $this->loadModel('Follow');
        $this->Follow->recursive = -1;
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
        }
        $viewer_count = $this->Follow->find('count', array(
            'conditions' => array('Follow.userId2' => $user_id, 'modified >=' => $download_time)
        ));
        return $viewer_count;
    }

    private function _count_liker($user_id, $download_time = null) {
        $this->loadModel('Like');
        $this->Like->recursive = -1;
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
        }
        $liker_count = $this->Like->find('count', array(
            'conditions' => array('Like.whom' => $user_id, 'modified >=' => $download_time)
        ));
        return $liker_count;
    }

    private function _count_friend($user_id, $download_time = null) {
        $this->loadModel('Friend');
        $this->request->data = date("Y-m-d H:i:s");
        if (!empty($download_time)) {
            $download_time = date("Y-m-d H:i:s", $download_time);
        } else {
            $download_time = "1970-01-01 00:00:00";
        }
        $friends = $this->Friend->find('count', array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                        "(User.id = Friend.userId1 OR User.id = Friend.userId2) AND User.id <> '$user_id' "
                    )
                )
            ),
            'conditions' => array(
                'OR' => array(
                    'Friend.userId1' => $user_id,
                    'Friend.userId2' => $user_id
                ),
                array(
                    'Friend.is_accepted' => 1,
                    'Friend.modified >=' => $download_time
                )
            ),
                // 'order' => array('Friend.created' => 'desc'), 
                // 'fields' => array('User.*'),
        ));
        return $friends;
    }

    // a cron job runs at 12am to fetch birthday of all users and make an entry in notification table
    public function birthday_cron() {
        $this->autoRender = false;
        $this->loadModel('Notification');
        //$now = date("Y-m-d");
        $birthday_users = $this->User->find('all', array(
            'recursive' => -1,
            'conditions' => "DATE_FORMAT(dob,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')"
        ));
        //print_r($birthday_users);
        foreach ($birthday_users as $key => $user) {
            //print_r($user['User']['id']);    
            $data['Notification']['who'] = $user['User']['id'];
            $data['Notification']['notification_type'] = 'birthday';
            $data['Notification']['title'] = $user['User']['name'];
            $whose = ($user['User']['gender'] === 'male') ? 'his' : 'her';
            $data['Notification']['body'] = "It's " . $user['User']['name'] . "'s Birthday Today! Visit " . $whose . ' profile';
            $this->Notification->create();
            $this->Notification->save($data);
            //$this->_notify_friends($user['User']['id'], $user['User']['name']); not notifying friends for birthday
        }
    }

    private function _notify_friends($user_id, $user_name) {
        $this->loadModel('Friend');
        $friends = $this->Friend->find('all', array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                        "(User.id = Friend.userId1 OR User.id = Friend.userId2) AND User.id <> '$user_id' "
                    )
                )
            ),
            'conditions' => array(
                'OR' => array(
                    'Friend.userId1' => $user_id,
                    'Friend.userId2' => $user_id
                ),
                array(
                    'Friend.is_accepted' => 1,
                )
            ),
            // 'order' => array('Friend.created' => 'desc'), 
            'fields' => array('User.id', 'User.is_notify'),
        ));
        //print_r($friends);
        foreach ($friends as $key => $friend) {
            if ($friend['User']['is_notify'] == 1) {
                $this->_push("It's " . $user_name . "'s Birthday Today!", $friend['User']['id']);
            }
        }
    }

    public function test_android($user_id) {
        $user = $this->User->findById($user_id, array('User.id', 'User.email', 'User.name'));
        if ($user) {
            $tokens = $this->_check_tokens($user_id);
            var_dump($user_id);
            var_dump($tokens);
            //die();
            if (count($tokens) > 0) {
                echo "<br />Sent Push: Devices " . count($tokens) . "<br />";
                $this->_push("You've had a close encounter!", $user_id);
            }
            die();
        }
    }
    
    public function get_session_list() {
        $this->autoLayout = false;
        header('Content-Type: application/json');
        
        if ($this->request->is('post')) {
            $userId = $this->request->data['User']['user_id'];
            
            if ($userId > 0) {            
                $sessionId = 'sessions.logout'.$userId;
                $sessionInfo = $SESSION[$sessionId];

                die(json_encode(array('success' => true, 'msg' => 'OK', '$sessionInfo' => $sessionInfo)));
            }
        }
        die(json_encode(array('success' => true, 'msg' => 'Wrong user info')));
    }
    
    public function test_ios() {
        $email = 'michellecafferty@hotmail.co.uk';
        $password = 'EVtcprdg';
        $this->autoLayout = false;
        header('Content-Type: application/json');
        $cyperPw = AuthComponent::password($password); //hashing
        $is_present = $this->User->find('first', array(
            'conditions' => array('User.email' => $email, 'User.password' => $cyperPw)
                )
        );      
        $user = $this->User->findByEmail($email, array('User.email', 'User.password'));
        $currentPw = $user['User']['password'];
        die(json_encode(array('present' => $is_present, 
            'is_present' => $is_present,
            'current' => $currentPw, 
            'origin' => $cyperPw)));
    }

    public function test_android_encounter($user_id, $with_id) {
        $user = $this->User->findById($user_id, array('User.id', 'User.email', 'User.name'));
        if ($user) {
            $tokens = $this->_check_tokens($user_id);
            var_dump($user_id);
            var_dump($tokens);
            //die();
            if (count($tokens) > 0) {
                echo "<br />Sent Push: Devices " . count($tokens) . "<br />";
                $bump_array = array();
                $bump_array["me_id"] = $user_id;
                $bump_array["message"] = "You've had a close encounter!";
                $bump_array["with"] = $with_id;
                // for andrid new push only bump format of JSON
                $this->_android_push(json_encode($bump_array), $user_id);
            }
            die();
        }
    }

    public function test() {
        $this->autoRender = false;
        //$this->_push("test push", 640);
        //$this->_agcm($android_device_tokens, 'AIzaSyBIB74xCLAT1veUkLkge9fd6c4J40QZ48o', $getMessage);
        if ($this->request->is('post')) {
            //var_dump($this->request->data);
            if ($this->request->data['selected']) {
                foreach ($this->request->data['selected'] as $user_id) {

                    $user = $this->User->findById($user_id, array('User.id', 'User.email', 'User.name'));
                    if ($user) {

                        if (isset($user['User']['email'])) {

                            $body = 'Hi ' . $user['User']['name'] . ','
                                    . '<br/><br/>'
                                    . 'We would like to thank you for downloading the Did I See U dating app. We want everyone to enjoy using the app but we have a few rules to ensure it is a safe and enjoyable experience for everyone.<br/>
We do our best to ensure uses are genuine, which is why we ask all of our users to upload a clear profile picture of themselves. This is to ensure other users know who they are communicating with, or should they have a Close Encounter alert, they know who to look for.<br/>

Failure to do this will unfortunately result in suspension or termination of your account, in order to keep our users safe.<br/>

We would again like to thank you for using the Did I See U app.'
                                    . '<br/><br/>Best regards, <br/> The DID I SEE U Team<br/><br/><a href="www.didiseeu.com"><img width="150" src="http://didiseeu.com/wp-content/uploads/2015/03/GetInline.aspx_.png" title="DidISeeU.com" alt="DidISeeU.com"></a>';

                            if (isset($this->request->data['push_message_email'])) {
                                $body = $this->request->data['push_message_email'];
                                if ($body != "") {
                                    $body = str_replace("%user%", $user['User']['name'], $body);
                                    $body .= '<br/><br/>Best regards, <br/> The DID I SEE U Team<br/><br/><a href="www.didiseeu.com"><img width="150" src="http://didiseeu.com/wp-content/uploads/2015/03/GetInline.aspx_.png" title="DidISeeU.com" alt="DidISeeU.com"></a>';
                                    $Email = new CakeEmail();
                                    $Email->from(array('support@didiseeu.com' => 'DidISeeU.com'));
                                    $Email->to($user['User']['email']);
                                    $Email->subject('DID I SEE U!');
                                    $Email->emailFormat('html');

                                    if ($Email->send($body)) {
                                        echo "<br />Sent Email<br />";
                                        echo $body;
                                    }
                                }
                            }
                        }
                    }

                    $tokens = $this->_check_tokens($user_id);
                    var_dump($user_id);
                    var_dump($tokens);
                    if ($tokens) {
                        if (isset($this->request->data['push_message'])) {
                            echo "<br />Sent Push: Devices " . count($tokens) . "<br />";
                            $this->_push($this->request->data['push_message'], $user_id);
                        }
                    }
                } // foreach end 
            }
        }
    }

    public function user_profile_pic($user_id) {
        $this->autoRender = false;
        header('Content-Type: image/jpeg');
        $user_profile_pic = $this->User->findById($user_id, 'User.profile_img');
        $file = 'http://' . env('SERVER_NAME') . '/files/images/' . $user_profile_pic['User']['profile_img'];
        //print_r($file);
        readfile($file);
    }

    public function g() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $relationship = array('Single', 'Married', "It's complicated");
        //$looking_for = array('Love', 'Friendship', 'Fun', 'Flirt');
        $looking_for = array('Love', 'Friendship', 'Fun', 'Networking', 'You Tell Me');
        $ethnicity = array('British', 'Irish', 'White and Black Caribbean',
            'White and Black African', 'White and Asian', 'Indian', 'Pakistani',
            'Bangladeshi', 'Caribbean', 'African', 'Chinese', 'Other');
        $contact_us = 'Didiseeu@gmail.com';
        die(json_encode(array('success' => true, 'relationship' => $relationship,
            'looking_for' => $looking_for, 'ethnicity' => $ethnicity, 'contact_us' => $contact_us)));
    }

    //forgot password email
    public function iforgot() {
        header('Content-Type: application/json');
        $this->autoRender = false;
        /*        App::import('Vendor', 'ses', array('file' => 'ses' . DS . 'ses.php'));
          $ses = new SimpleEmailService('AKIAJULLR4UQDRFARJ5A', 'nDwpsXh+UN77ivTYUgDvzo1crHdXlFi+zqhepRwZ'); */
        $this->User->recursive = -1;
        if ($this->request->is('post')) {
            $user = $this->User->findByEmail($this->request->data['User']['email'], array('User.id', 'User.email', 'User.name'));
            if (!empty($user)) {
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                $password = substr(str_shuffle($chars), 0, 8);          #Here 8(last params) is length
                $data = array(
                    'id' => $user['User']['id'],
                    'password' => AuthComponent::password($password)
                );
                $this->User->save($data);
                /*                $m = new SimpleEmailServiceMessage();
                  $m->addTo($this->request->data['User']['email']);
                  // $m->setFrom('justin@appinstitute.co.uk');

                  $m->setFrom('support@heyup.co');
                  $m->setSubject('HeyUp! Authentication Request'); */
                $body = 'Hi ' . $user['User']['name'] . ',<br/><br/> Your password is: <b> ' . $password . ' </b><br/><br/>Thanks, <br/><br/> The HeyUp Team<br/><br/><a href="www.heyup.co"><img width="150" src="http://www.heyup.co/resources/images/heyup_logo.png" title="HeyUp.co" alt="HeyUp.co"></a>';

                $Email = new CakeEmail();
                $Email->from(array('support@heyup.co' => 'Heyup.co'));
                $Email->to($this->request->data['User']['email']);
                $Email->subject('HeyUp! Authentication Request');
                $Email->emailFormat('html');
//$Email->send($body);
                if ($Email->send($body))
                    die(json_encode(array('success' => true, 'msg' => 'New password has been sent to your email. Thanks.')));
                /*
                  $plainTextBody = '';

                  $m->setMessageFromString($plainTextBody,$body);
                  //$ses->sendEmail($m);
                  try{
                  if($ses->sendEmail($m)) die(json_encode(array('success' => true, 'msg' => 'New password has been sent to your email. Thanks.')));
                  } catch(Exception $e){

                  } */
            } else
                die(json_encode(array('success' => false, 'msg' => 'Email address not found.')));
        }
    }

}
