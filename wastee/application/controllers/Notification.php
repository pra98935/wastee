<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Notification_model');
        $request_method = $this->router->fetch_method();

        $key = $this->input->get_request_header(AUTH_KEY);
        $this->InitializeUserSessiondata($key, TRUE);

        //print_r($this->session->userdata); die;
    }

    public function index_get() {
        $this->isAllowedUser(array(USER_TYPE));
        $this->load->view($this->layout, $this->data);
    }

    public function get_notification_list() {
        $user_id = $this->user_id;
        if (!$user_id)
            return;
        $result = array();
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $result = $this->Notification_model->user_notifications($user_id);

        if (is_array($result['results']) AND count($result) > 0) {
            foreach ($result['results'] as $key => $value) {
                
                if ($value['notification_type_id'] == 1) {
                    
                    $message = str_replace(array('{{product_name}}'), array($value['product_title']), $value['notification_text']);
                    $product_url = ' <a href="' . base_url('product/detail/' . $value['product_id']) . '">' . $message . '</a>';
                    $result['results'][$key]['notification_text'] = $product_url;
                }

                if ($value['notification_type_id'] == 2) {
                    
                    $message = str_replace(array('{{user_name}}','{{product_name}}'), array($value['full_name'], $value['product_title']), $value['notification_text']);
                    $product_url = ' <a href="' . base_url('product/detail/' . $value['product_id']) . '">' . $message . '</a>';
                    $result['results'][$key]['notification_text'] = $product_url;
                }
            }
        }

        $this->api_response_arry['data'] = $result;
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name'] = "get_notification";
        $this->api_response_arry['message'] = '';
        $this->api_response_arry['error'] = '';
        $this->api_response();
    }

    public function update_notification_count_post() {
        $notifycount = $this->Notification_model->get_single_row('COUNT(notification_id) AS readcount', NOTIFICATION, array('is_read' => '0', 'receiver_user_id' => $this->user_id));

        $this->session->set_userdata('notification_count', $notifycount['readcount']);

        $this->api_response_arry['data'] = array('notification_count' => $notifycount['readcount']);
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name'] = "update_notification_count";
        $this->api_response_arry['message'] = '';
        $this->api_response_arry['error'] = '';
        $this->api_response();
    }

}

/* End of file leaderboard.php */
/* Location: ./application/controllers/leaderboard.php */