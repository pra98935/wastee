<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Setting_model');
        $request_method = $this->router->fetch_method();

        //if(!in_array($request_method, array('userprofile'))){
            $key = $this->input->get_request_header(AUTH_KEY);
            $this->InitializeUserSessiondata($key, FALSE);
        //}
        //print_r($this->session->userdata); die;
    }

    public function myprofile() {
        $user_guid = $this->session->userdata('user_guid');
        $data['profileDetail'] = $this->Setting_model->get_profile_detail($user_guid);
	$this->load->view('myprofile', $data);
    }
    
    public function userprofile($user_guid) {
        if(empty($user_guid)){
            redirect('');
        }
        $data['profileDetail'] = $this->Setting_model->get_profile_detail($user_guid);
        //print_r($this->session->userdata); die;
        if($user_guid == $this->session->userdata('user_guid')){
            $this->load->view('myprofile', $data);
        } else {
            $this->load->view('profile', $data);
        }
	
    }


}
