<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Product_model');
        $request_method = $this->router->fetch_method();

        if(!in_array($request_method, array('detail', 'detailnew'))){
            $key = $this->input->get_request_header(AUTH_KEY);
            $this->InitializeUserSessiondata($key, TRUE);
        }
        //print_r($this->session->userdata); die;
    }

    public function index() {
        $this->load->view('list');
    }

    public function sell() {
        $data = array();
        $data['categoryList'] = $this->Product_model->getCategoryList();
        $this->load->view('sell', $data);
    }

    public function detail($item_id) {
        
        if(empty($item_id) || !is_numeric($item_id)){
            redirect(base_url());
        }
        $data['productDetail'] = $this->Product_model->get_product_detail($item_id);
        $data['productImages'] = $this->Product_model->get_product_images($item_id);
        
        $this->load->view('detail', $data);
    }
    
    public function detailnew($item_id) {
        
        if(empty($item_id) || !is_numeric($item_id)){
            redirect(base_url());
        }
        $data['productDetail'] = $this->Product_model->get_product_detail($item_id);
        $data['productImages'] = $this->Product_model->get_product_images($item_id);
        
        $this->load->view('detailnew', $data);
    }
    
}
