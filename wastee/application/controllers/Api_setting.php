<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Setting extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Setting_model');
        $request_method = $this->router->fetch_method();
        
        if(!in_array($request_method, array('get_follows_n_follower'))){
            $key = $this->input->get_request_header(AUTH_KEY);
            $this->InitializeUserSessiondata($key, TRUE);
        }
        //print_r($this->session->userdata); die;
        $post = file_get_contents("php://input");
        $_POST = (array) json_decode($post);
    }
    
    function create_search_tag(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('search_tag', 'search agent', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "create_search_tag";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                
                $searchTag = array();
                if($this->session->userdata('search_tag')){
                    $searchTag = json_decode($this->session->userdata('search_tag'));
                }
                
                array_push($searchTag, trim($this->input->post('search_tag')));
                
                $upd_data = array(
                    'search_tag' => json_encode($searchTag),
                    'updated_by' => $this->user_id,
                    'updated_date' => format_date('today', 'Y-m-d H:i:s')
                );
                
                $this->db->update(USER, $upd_data, array('user_id'=>$this->session->userdata('user_id')));
                
                $this->session->set_userdata('search_tag', json_encode($searchTag));
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('SearchTag' => $searchTag);
                $this->api_response_arry['service_name'] = "create_search_tag";
                $this->api_response_arry['message'] = 'Search agent added successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "create_search_tag";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    function remove_search_tag(){
        
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('search_tag', 'search agent', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "remove_search_tag";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                
                $searchTag = array();
                if($this->session->userdata('search_tag')){
                    $searchTag = json_decode($this->session->userdata('search_tag'));
                }
                
                unset($searchTag[$this->input->post('search_tag')]);
                $searchTag = array_values($searchTag);
                
                $upd_data = array(
                    'search_tag' => json_encode($searchTag),
                    'updated_by' => $this->user_id,
                    'updated_date' => format_date('today', 'Y-m-d H:i:s')
                );
                
                $this->db->update(USER, $upd_data, array('user_id'=>$this->session->userdata('user_id')));
                
                $this->session->set_userdata('search_tag', json_encode($searchTag));
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('SearchTag' => $searchTag);
                $this->api_response_arry['service_name'] = "remove_search_tag";
                $this->api_response_arry['message'] = 'Search agent removed successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "remove_search_tag";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }

     function set_follow_status() {

        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('following_id', 'following user', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "set_follow_status";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                
                $is_follow = '1';
                $message = 'Follow successfully.';
                if(trim($this->input->post('is_follow')) == '1'){
                    $is_follow = '0';
                    $message = 'Unfollow successfully.';
                }

                $follow_data[] = array(
                    'following_id' => trim($this->input->post('following_id')),
                    'follower_id' => $this->session->userdata('user_id'),
                    'is_follow' => $is_follow,
                    'date_modified' => format_date('today', 'Y-m-d H:i:s')
                );
                //print_r($sell_data); die;
                
                $item_id = $this->Setting_model->set_follow_status($follow_data);
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('is_follow' => $is_follow);
                $this->api_response_arry['service_name'] = "set_follow_status";
                $this->api_response_arry['message'] = $message;
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "set_follow_status";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    public function get_follows_n_follower(){
        
        if(!$this->input->post('user_guid')){
            $this->api_response_arry['data']          = array();
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name']  = "get_follows_n_follower";
            $this->api_response_arry['message']       = 'Invaid input data.';
            $this->api_response_arry['error']         = 'Invaid input data.';
            $this->api_response();
        }
        
        $result  = array();
        
        $user_guid = $this->input->post('user_guid');
        $userData = $this->Setting_model->get_profile_detail($user_guid);
        
        if(!empty($userData)){
            $follows  = $this->Setting_model->get_follows_list($userData['user_id']);
            $followers  = $this->Setting_model->get_follower_list($userData['user_id']);
            $result = array('follows'=> $follows, 'followers' => $followers);
        }
        
        $this->api_response_arry['data']          = $result;
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name']  = "get_news_list";
        $this->api_response_arry['message']       = '';
        $this->api_response_arry['error']         = '';
        $this->api_response();
    }
}
