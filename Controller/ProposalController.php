<?php

App::uses('AppController', 'Controller');
//App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class ProposalController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public function create_proposal() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->Proposal->recursive = -1;
        $this->loadModel('Proposal');

        if ($this->request->is('post')) {
            //$exist_proposal = $this->Proposal->findByUserId($this->request->data['Proposal']['user_id']);
            $exist_proposal = $this->Proposal->find('first', array(
                'conditions' => array('Proposal.status' => 1, 'Proposal.user_id' => $this->request->data['Proposal']['user_id'])
            ));
            if ($exist_proposal) {
                $timediff = strtotime(date('Y-m-d H:i:s')) - strtotime($exist_proposal['Proposal']['created']);
                if ($timediff > 86400) {
                    $this->request->data['Proposal']['status'] = 0;
                    $this->request->data['Proposal']['id'] = $exist_proposal['Proposal']['id'];
                    $this->request->data['Proposal']['modified'] = date('Y-m-d H:i:s');
                    if (!$this->Proposal->save($this->request->data, false)) {
                        die(json_encode(array('success' => false, 'msg' => 'Not available to update the status.')));
                    }
                } else {
                    $success = true;
                    die(json_encode(array('success' => false, 'msg' => 'You already have an active proposal.')));
                }
            }

            $this->Proposal->create();
            $this->request->data['Proposal']['status'] = 1;
            $this->request->data['Proposal']['created'] = date('Y-m-d H:i:s');
            if ($this->Proposal->save($this->request->data)) {
                $proposal = $this->Proposal->findById($this->Proposal->id);
                $proposal = $proposal['Proposal'];
                $success = true;
                die(json_encode(compact('proposal', 'success')));
            }
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
        }
    }


    public function get_proposals() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        $this->loadModel('Users');

        if ($this->request->is('post')) {
            $proposals = $this->Proposal->find('all', array(
                'recursive' => -1,
                'conditions' => array('Proposal.status' => 1)
            ));
            $response['proposals'] = array();
            foreach ($proposals as $key => $proposal) {
                $timediff = strtotime(date('Y-m-d H:i:s')) - strtotime($proposal['Proposal']['created']);
                if ($timediff > 86400) {
                    continue;
                }
                $userinfo = $this->Users->findById($proposal['Proposal']['user_id']);
                $proposal['Proposal']['userinfo'] = $userinfo['Users'];

                $response['proposals'][]=$proposal['Proposal'];
            }
            $response['success'] = true;
            die(json_encode($response));
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
        }
    }

    public function report_proposal() {
        $this->autoRender = false;
        header('Content-Type: application/json');
        //$this->Proposal->recursive = -1;
        $this->loadModel('ReportProposal');
        $this->ReportProposal->recursive = -1;
        if ($this->request->is('post')) {
            $exist_report = $this->ReportProposal->find('first', array(
                'conditions' => array('ReportProposal.proposal_id' => $this->request->data['ReportProposal']['proposal_id'], 'ReportProposal.user_id' => $this->request->data['ReportProposal']['user_id'])
            ));
            if ($exist_report) {
                die(json_encode(array('success' => false, 'msg' => 'You already have a report.')));
            } else {
                //print_r("Report does not exist");
                $this->ReportProposal->create();
                if ($this->ReportProposal->save($this->request->data)) {
                    $report_proposal = $this->ReportProposal->findById($this->ReportProposal->id);
                    $report_proposal = $report_proposal['ReportProposal'];
                    $success = true;
                    die(json_encode(compact('report_proposal', 'success')));
                } else {
                    die(json_encode(array('success' => false, 'msg' => 'Unavailable to create report.')));
                }
            }
            //$proposal = $this->Proposal->findById($this->request->data['Proposal']['proposal_id']);
        } else {
            die(json_encode(array('success' => false, 'msg' => 'Invalid Request.')));
        }
    }

}
