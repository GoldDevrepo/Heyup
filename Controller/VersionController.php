<?php

App::uses('AppController', 'Controller');

class VersionController extends AppController {

    public function check() {
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

        header('Content-Type: application/json');
        if ($this->request->is('post')) {
//            $this->request->data['Version']['code'];
            $is_present = $this->Version->find('first', array(
                'conditions' => array(
                    'Version.device_id' => $this->request->data['Version']['device_id'],
                    'Version.discontinued' => '0')
                    )
            );
            $results = array('success' => false, 'msg' => 'Version Info Not Found.');
            if ($is_present) {
                $results = array('success' => true, 'msg' => 'Version Info.', 'info' => $is_present['Version']);
            }
            die(json_encode($results));
        } else
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
    }

}
