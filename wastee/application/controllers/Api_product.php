<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_Product extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Product_model');
        $request_method = $this->router->fetch_method();
        
        if(!in_array($request_method, array('get_product_list', 'get_review_list'))){
            $key = $this->input->get_request_header(AUTH_KEY);
            $this->InitializeUserSessiondata($key, TRUE);
        }
        //print_r($this->session->userdata); die;
        $post = file_get_contents("php://input");
        $_POST = (array) json_decode($post);
    }

    function create_item() {

        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('title', 'product name', 'required|trim');
            $this->form_validation->set_rules('description', 'product description', 'required|trim');
            $this->form_validation->set_rules('category_id', 'product category', 'required|trim');
            $this->form_validation->set_rules('currency', 'currency', 'required|trim');
            $this->form_validation->set_rules('price', 'product price', 'required|numeric|trim');
            $this->form_validation->set_rules('location', 'address', 'required|trim');
            $this->form_validation->set_rules('location_lat', 'address', 'required|trim');
            $this->form_validation->set_rules('location_long', 'address', 'required|trim');
            //$this->form_validation->set_rules('cover_image', 'featured image', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "create_item";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                $item_images = $this->input->post('item_images');
                if (count($item_images) == 0) {
                    $message = 'Please select atleast one image.';
                    $this->api_response_arry['response_code'] = 500;
                    $this->api_response_arry['service_name'] = "create_item";
                    $this->api_response_arry['error'] = $message;
                    $this->api_response_arry['global_error'] = $message;
                    $this->api_response();
                }

                $title = trim($this->input->post('title'));
                
                $sell_data = array(
                    'title' => $title,
                    'description' => trim($this->input->post('description')),
                    'category_id' => trim($this->input->post('category_id')),
                    'currency' => trim($this->input->post('currency')),
                    'price' => trim($this->input->post('price')),
                    'location' => trim($this->input->post('location')),
                    'location_lat' => trim($this->input->post('location_lat')),
                    'location_long' => trim($this->input->post('location_long')),
                    'cover_image' => trim($this->input->post('cover_image')),
                    'user_id' => $this->user_id,
                    'status_id' => 2,
                    'created_date' => format_date('today', 'Y-m-d H:i:s')
                );
                //print_r($sell_data); die;
                
                $item_id = $this->Product_model->create_item($sell_data);
                
                if(isset($item_id) && $item_id) {
                    $item_images = $this->input->post('item_images');
                    if(!empty($item_images)){
                        $imageData = array();
                        foreach($item_images as $image){
                            if(!isset($cover_image)){
                                $cover_image = $image->file_name;
                            }
                            $imageData[] = array(
                                'entity_id' => $item_id,
                                'entity_type' => ENTITY_TYPE_PRODUCT,
                                'media_type' => 'Image',
                                'media_name' => $image->file_name,
                            );
                        }
                        //echo '<pre>'; print_r($imageData);
                        //echo $cover_image; die;
                        $this->Product_model->insert_item_images($item_id, $imageData);
                        
                        if(isset($cover_image)){
                            //$cover_image = $image->file_name;
                            $this->db->update(ITEM, array('cover_image'=>$cover_image), array('item_id'=>$item_id));
                        }
                    }
                }
                
                // Now Set Notifications
                
                $this->load->model(array('Setting_model', 'Notification_model'));
                
                // Search Agent Notification
                $searchTags = $this->Product_model->get_all_table_data("search_tag, user_id", USER, array("status"=> '1', 'search_tag!='=>'', 'user_id!='=>$this->user_id)) ;
                
                if(!empty($searchTags)){
                    foreach($searchTags as $stag){
                        if($stag['search_tag']){
                            $tags = json_decode($stag['search_tag']);
                            
                            $tag_notify = false;
                            foreach($tags as $tag){
                                if (strpos($title, $tag) !== false) {
                                    $tag_notify = true;
                                }
                            }
                            if($tag_notify){
                                $this->Notification_model->add_notification(1, $stag['user_id'], $item_id, $this->user_id);
                            }
                        }
                    }
                }
                
                // Follower User Notification
                $followerList = $this->Setting_model->get_follower_list($this->user_id);
                
                if(!empty($followerList)){
                    foreach($followerList as $follower){
                        $this->Notification_model->add_notification(2, $follower['user_id'], $item_id, $this->user_id);
                    }
                }
                $this->api_response_arry['data'] = array('item_id' => $item_id);
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['service_name'] = "create_item";
                $this->api_response_arry['message'] = 'Item has been submitted successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "create_item";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }

    function do_upload() {
        //print_r($_FILES);
        $field_name = key($_FILES);
        $dir = ROOT_PATH_UPLOADS; // upload/
        $subdir = ROOT_PATH_UPLOADS.'product/'; // upload/logo/
        $thumb_dir = $subdir.'thumb/';
        
        $temp_file = $_FILES[$field_name]['tmp_name'];
        $ext = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);
        $vals = @getimagesize($temp_file);
        $width = $vals[0];
        $height = $vals[1];

        $this->api_response_arry['service_name'] = 'do_upload';
        $this->api_response_arry['message'] = '';
        $this->api_response_arry['error'] = '';

        $file_size = $_FILES[$field_name]['size'];

        if ($file_size > 8*1024*1024) {
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['error'] = "File size should be less than 5MB.";
            $this->api_response();
        }

        $this->check_folder_exist($dir, $subdir);

        $this->check_folder_exist($subdir, $thumb_dir);

        $file_name = time()."_".rand(0,999) . "." . $ext;

        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['max_size'] = '204800';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';
        $config['upload_path'] = $subdir;
        //$config['file_name'] = time() . $_FILES[$field_name]['name'];
        $config['file_name'] = $file_name;
        
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            $msg = $this->upload->display_errors();
            $this->api_response_arry['response_code'] = 500;
            //$this->api_response_arry['error']       = strip_tags($this->upload->display_errors());
            $this->api_response_arry['error'] = $msg;
            $this->api_response_arry['global_error'] = $msg;
        } else {
            $uploaded_data = $this->upload->data();
            
            //$thumb_data = $this->create_thumb($temp_file, $subdir . $file_name, 2000, 2000);
        
            $thumb_data = $this->create_thumb($temp_file, $thumb_dir . $file_name, 300, 300);
            if ($thumb_data['result'] == 'error') {
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['error'] = $thumb_data['data'];
                $this->api_response_arry['global_error'] = $thumb_data['data'];
            } 
            else {
                
                $thumb_url = IMAGE_UPLOADS_URL.'product/thumb/'. $file_name;

                $msg = array('field_name'=>$field_name, 'image_url' => $thumb_url, 'file_name' => $file_name);

                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['message'] = "upload success";
                $this->api_response_arry['data'] = $msg;
            }
        }

        $this->api_response();
    }

    /**
     * @Summary: check if folder exists otherwise create new
     * @create_date: 3 apr, 2013
     * @last_update_date:
     * @access: public
     * @param:
     * @return:
     */
    public function check_folder_exist($dir, $subdir) {
        if (!is_dir($dir))
            @mkdir($dir, 0777);

        if (!is_dir($subdir))
            @mkdir($subdir, 0777);
    }
    
    function create_thumb($file, $thumb_file, $width, $height) {
        
        $config['image_library']    = 'gd2';
        $config['source_image']     = $file;
        $config['new_image']     = $thumb_file;
        $config['create_thumb']     = FALSE;
        $config['maintain_ratio']   = TRUE;
        $config['master_dim']       = 'width'; 
        //upload_resize('file','settings', $imageName );
        $config['width']            = $width;
        $config['height']           = $height;

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        return;
        
        /*
         * OLD SCRIPT
         * 
        $this->load->library('phpThumb');

        $phpThumb = new phpThumb();
        $original_source_path = file_get_contents($file);

        $phpThumb->setSourceData($original_source_path);
        $phpThumb->setParameter('w', $width);
        $phpThumb->setParameter('h', $height);
        $phpThumb->setParameter('zc', false);
        $output_filename = $thumb_file;

        // this line is VERY important, do not remove it!
        if ($phpThumb->GenerateThumbnail()) {
            if ($phpThumb->RenderToFile($output_filename)) {
                $result['result'] = 'success';
                $result['data'] = '';
            }
        } else {
            $result['result'] = 'error';
            $result['data'] = '';
        }*/
    }

    public function get_product_list(){
        $limit           = $this->input->post('limit');
        $offset          = $this->input->post('offset');

        $result  = $this->Product_model->get_product_list($limit, $offset);

        if(!empty($result['results'])){
            $this->load->library('Encrypt');
            
            foreach($result['results'] as $key=>$item){
                $result['results'][$key]['item_key'] = $this->encrypt->encode($item['item_id']);
            }
        }
        $this->api_response_arry['data']          = $result;
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name']  = "get_product_list";
        $this->api_response_arry['message']       = '';
        $this->api_response_arry['error']         = '';
        $this->api_response();
    }
    
    function add_to_buylist(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('item_id', 'product key', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "add_to_watchlist";
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                $where = array(
                    'item_id' => $this->input->post('item_id'),
                    'user_id' => $this->user_id
                        );
                $BuyStatus = $this->Product_model->get_single_row('buy_status', ITEM_BUY, $where);
                
                if(empty($BuyStatus) || $BuyStatus['buy_status'] != ITEM_BOUGHT){ 
                    
                    $ins_data[] = array(
                        'item_id' => $this->input->post('item_id'),
                        'user_id' => $this->user_id,
                        'buy_status' => $this->input->post('buy_status'),
                        'created_date' => format_date('today', 'Y-m-d H:i:s')
                    );
                    $this->Product_model->replace_into_batch(ITEM_BUY, $ins_data);
                }
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array();
                $this->api_response_arry['service_name'] = "add_to_watchlist";
                $this->api_response_arry['message'] = 'Item added successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "add_to_watchlist";
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    function remove_from_buylist(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('item_id', 'product key', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "remove_from_buylist";
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                $where = array(
                    'item_id' => $this->input->post('item_id'),
                    'user_id' => $this->user_id
                        );
                
                $this->db->delete(ITEM_BUY, $where);
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array();
                $this->api_response_arry['service_name'] = "remove_from_buylist";
                $this->api_response_arry['message'] = 'Item removed successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "remove_from_buylist";
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    function ask_question(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('question_text', 'message', 'required|trim');
            $this->form_validation->set_rules('item_id', 'product key', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "ask_question";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                
                $ins_data = array(
                    'message' => trim($this->input->post('question_text')),
                    'item_id' => $this->input->post('item_id'),
                    'message_type' => MESSAGE_TYPE_QUESTION,
                    'user_from' => $this->user_id,
                    'created_date' => format_date('today', 'Y-m-d H:i:s')
                );
                
                $this->db->insert(MESSAGE, $ins_data);
                $last_question = $this->db->insert_id();
                
                $this->db->select('M.message_id, M.message, M.user_from, M.user_to, M.item_id, U.user_guid AS from_user_guid, U.first_name AS from_user_fname, CONCAT(U.first_name, " ", U.last_name) AS from_full_name, U.image AS from_user_image', FALSE);
  		$this->db->from(MESSAGE.' AS M')
                        ->join(USER." AS U", "U.user_id = M.user_from", 'left');
                
                $this->db->where('M.item_id', $this->input->post('item_id'));
                $this->db->where('M.message_id>', $this->input->post('last_question'));
                $this->db->order_by('M.message_id', 'ASC');
                
		$result = $this->db->get();
		//echo $this->db->last_query();
		$question_result = $result->result_array();
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('question_result'=> $question_result,'last_question' => $last_question);
                $this->api_response_arry['service_name'] = "ask_question";
                $this->api_response_arry['message'] = 'Message added successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "ask_question";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    public function get_product_question() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('item_id', 'product key', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $message = $error[array_keys($error)[0]];
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "get_product_question";
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = $message;
            $this->api_response();
            exit();
        }

        $this->db->select('M.message_id, M.message, M.user_from, M.user_to, M.item_id, U.user_guid AS from_user_guid, U.first_name AS from_user_fname, CONCAT(U.first_name, " ", U.last_name) AS from_full_name, U.image AS from_user_image', FALSE);
        $this->db->from(MESSAGE . ' AS M')
                ->join(USER . " AS U", "U.user_id = M.user_from", 'left');

        $this->db->where('M.item_id', $this->input->post('item_id'));
        $this->db->where('M.message_id>', $this->input->post('last_question'));
        $this->db->order_by('M.message_id', 'ASC');

        $result = $this->db->get();
        //echo $this->db->last_query();
        $question_result = $result->result_array();

        $last_question = 0;
        if (!empty($question_result)) {
            $lastQuestion = end($question_result);
            $last_question = $lastQuestion['message_id'];
        } else {
            $last_question= $this->input->post('last_question');
        }
        $this->api_response_arry['data'] = array('question_result' => $question_result, 'last_question' => $last_question);
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name'] = "get_product_question";
        $this->api_response_arry['message'] = '';
        $this->api_response_arry['error'] = '';
        $this->api_response();
    }
    
    function add_offer(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('price', 'offer price', 'required|numeric|trim');
            $this->form_validation->set_rules('message', 'offer message', 'required|trim');
            $this->form_validation->set_rules('item_id', 'product key', 'required|trim');
            $this->form_validation->set_rules('owner_id', 'product owner', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "add_offer";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                //print_r($this->input->post()); die;
                
                if($this->input->post('conversation_id')){
                    $conversation_id = $this->input->post('conversation_id');
                } 
                else {
                    $ins_conv = array(
                        'item_id' => $this->input->post('item_id'),
                        'user_one' => $this->input->post('owner_id'),
                        'user_two' => $this->user_id,
                        'created_date' => format_date('today', 'Y-m-d H:i:s')
                    );

                    $this->db->insert(CONVERSATION, $ins_conv);
                    $conversation_id = $this->db->insert_id();

                }
                if($conversation_id > 0){
                    $ins_ofr = array(
                        'conversation_id' => $conversation_id,
                        'item_id' => $this->input->post('item_id'),
                        'user_id' => $this->user_id,
                        'message' => $this->input->post('message'),
                        'price' => $this->input->post('price'),
                        'created_date' => format_date('today', 'Y-m-d H:i:s')
                    );

                    $this->db->insert(ITEM_OFFERS, $ins_ofr);
                    $last_offer = $this->db->insert_id();
                    
                }
                
                $param = array('conversation_id'=>$conversation_id);
                $OfferList = $this->Product_model->get_all_product_offers($param);

                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('offer_list'=> $OfferList, 'conversation_id' => $conversation_id);
                $this->api_response_arry['service_name'] = "add_offer";
                $this->api_response_arry['message'] = 'Offer added successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "add_offer";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    function accept_offer(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('conversation_id', 'conversation key', 'required|numeric|trim');
            $this->form_validation->set_rules('offer_id', 'offer key', 'required|trim');
            $this->form_validation->set_rules('owner_id', 'product owner', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "accept_offer";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                //print_r($this->input->post()); die;
                
                $conversation_id = $this->input->post('conversation_id');
                $is_owner_confirm = $is_buyer_confirm = 0;
                if($this->user_id == $this->input->post('owner_id')){
                    $is_owner_confirm = $this->user_id;
                } else {
                    $is_buyer_confirm = $this->user_id;
                }
                
                $upd_data = array(
                    'confirm_offer_id' => $this->input->post('offer_id'),
                    'is_owner_confirm' => $is_owner_confirm,
                    'is_buyer_confirm' => $is_buyer_confirm,
                    'deal_date' => format_date('today', 'Y-m-d H:i:s')
                );

                $this->db->update(CONVERSATION, $upd_data, "conversation_id=$conversation_id");
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('conversation_id' => $conversation_id);
                $this->api_response_arry['service_name'] = "accept_offer";
                $this->api_response_arry['message'] = 'Offer accepted successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "accept_offer";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    function confirm_deal(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('conversation_id', 'conversation key', 'required|numeric|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "confirm_deal";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                //print_r($this->input->post()); die;
                
                $conversation_id = $this->input->post('conversation_id');
                
                $conversationData = $this->Product_model->get_single_row('item_id, confirm_offer_id, is_owner_confirm, is_buyer_confirm', CONVERSATION, array("conversation_id" => $conversation_id));
                $buyOffer = $this->Product_model->get_single_row('price', ITEM_OFFERS, array("offer_id" => $conversationData['confirm_offer_id']));
                //print_r($conversationData); die;
                if($conversationData['is_owner_confirm']){
                    $is_owner_confirm = $conversationData['is_owner_confirm'];
                    $is_buyer_confirm = $this->user_id;
                }
                if($conversationData['is_buyer_confirm']){
                    $is_buyer_confirm = $conversationData['is_buyer_confirm'];
                    $is_owner_confirm = $this->user_id;
                }
                $upd_data = array(
                    'is_owner_confirm' => $is_owner_confirm,
                    'is_buyer_confirm' => $is_buyer_confirm,
                    'deal_date' => format_date('today', 'Y-m-d H:i:s')
                );

                $this->db->update(CONVERSATION, $upd_data, "conversation_id=$conversation_id");
                $this->db->update(ITEM, array("is_sold"=> 1), "item_id=".$conversationData['item_id']);
                $this->db->update(ITEM_BUY, array("buy_status"=> ITEM_BOUGHT, "buy_price" => $buyOffer['price']), "item_id=".$conversationData['item_id']." AND user_id=$is_buyer_confirm");
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('conversation_id' => $conversation_id);
                $this->api_response_arry['service_name'] = "confirm_deal";
                $this->api_response_arry['message'] = 'Deal confirmed successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "confirm_deal";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    function cancel_deal(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('conversation_id', 'conversation key', 'required|numeric|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "cancel_deal";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                //print_r($this->input->post()); die;
                
                $conversation_id = $this->input->post('conversation_id');
                
                $upd_data = array(
                    'confirm_offer_id' => 0,
                    'is_owner_confirm' => 0,
                    'is_buyer_confirm' => 0,
                    'deal_date' => format_date('today', 'Y-m-d H:i:s')
                );

                $this->db->update(CONVERSATION, $upd_data, "conversation_id=$conversation_id");
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('conversation_id' => $conversation_id);
                $this->api_response_arry['service_name'] = "cancel_deal";
                $this->api_response_arry['message'] = 'Deal cancelled successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "cancel_deal";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
    
    public function get_product_offers() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('item_id', 'product key', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $message = $error[array_keys($error)[0]];
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "get_product_offers";
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = $message;
            $this->api_response();
            exit();
        }
        $have_you_bid = 0;
        $ProductConv = $this->Product_model->get_product_conversation($this->input->post('item_id'));
        //echo '<pre>'; print_r($ProductConv);
        if(!empty($ProductConv)){
            
            $ItemDetail = $this->Product_model->get_single_row('user_id', ITEM, array('item_id' => $this->user_id));
            
            $ConvIDs = array_column($ProductConv, 'conversation_id');
            $param = array('conversation_id'=>$ConvIDs);
            $OfferList = $this->Product_model->get_all_product_offers($param);

            $OfferListArr = array();
            if(!empty($OfferList)){
                foreach($OfferList as $OLst){
                    $OfferListArr[$OLst['conversation_id']][] = $OLst;
                }
                $LastOffer = array();
                foreach($OfferListArr as $OKey=>$Offer){
                    foreach($Offer as $ofr){
                        if($ofr['user_id'] != $this->user_id){
                            $LastOffer[$OKey] = $ofr;
                        }
                    }
                }
            }
            
            foreach($ProductConv as $key=>$PConv){
                if($ItemDetail['user_id'] == $this->user_id){
                    $ProductConv[$key]['offers'] = isset($OfferListArr[$PConv['conversation_id']]) ? $OfferListArr[$PConv['conversation_id']] : array();
                } 
                else if($this->user_id == $PConv['user_one'] || $this->user_id == $PConv['user_two']){
                    $ProductConv[$key]['offers'] = isset($OfferListArr[$PConv['conversation_id']]) ? $OfferListArr[$PConv['conversation_id']] : array();
                }
                $ProductConv[$key]['lastoffer'] = isset($LastOffer[$PConv['conversation_id']]) ? $LastOffer[$PConv['conversation_id']] : array();
                
                if($this->user_id == $PConv['user_one'] || $this->user_id == $PConv['user_two']){
                    $have_you_bid = 1;
                }
            }
            
        }
        
        $this->api_response_arry['data'] = array('result' => $ProductConv, 'have_you_bid'=>$have_you_bid);
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name'] = "get_product_offers";
        $this->api_response_arry['message'] = '';
        $this->api_response_arry['error'] = '';
        $this->api_response();
    }

    public function get_watch_list(){
        
        $result = array();
        if($this->session->userdata('user_id')){
            $result  = $this->Product_model->get_watch_list($this->session->userdata('user_id'));
            
            // GET Question and Response Count
            if(!empty($result)){
                foreach($result as $key=>$res){
                    //$result[$key]['item_key'] = 
                    $que_cnt = $this->Product_model->get_question_count($res['item_id']);
                    $result[$key]['question_cnt'] = ($que_cnt['question_count']) ? $que_cnt['question_count'] : 0;
                    
                    $res_cnt = $this->Product_model->get_response_count($res['item_id']);
                    $result[$key]['response_cnt'] = ($res_cnt['response_count']) ? $res_cnt['response_count'] : 0;
                }
            }
        }
        $this->api_response_arry['data']          = array('results'=>$result);
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name']  = "get_watch_list";
        $this->api_response_arry['message']       = '';
        $this->api_response_arry['error']         = '';
        $this->api_response();
    }
    
    public function get_review_list(){
        
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('user_id', 'user key', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->error_array();
            $message = $error[array_keys($error)[0]];
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "get_review_list";
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = $message;
            $this->api_response();
            exit();
        }
        $result = array();
        
        $user_id = $this->input->post('user_id');
        
        $this->db->select('R.review, R.rating, UB.user_guid AS rb_user_guid, UB.first_name AS rb_first_name, UB.image As rb_image', false);
        $this->db->select('DATE_FORMAT (R.created_date,  "%d.%m.%Y" ) AS added_date', false);
        $this->db->from(REVIEW . ' AS R')
                ->join(USER . " AS UB", "UB.user_id = R.review_by", 'LEFT')
                ->where('R.review_for', $user_id);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->result_array();
        
        $this->api_response_arry['data']          = array('results'=>$result, "total_review"=>count($result));
        $this->api_response_arry['response_code'] = 200;
        $this->api_response_arry['service_name']  = "get_review_list";
        $this->api_response_arry['message']       = '';
        $this->api_response_arry['error']         = '';
        $this->api_response();
    }
    
    function add_review(){
        if ($this->input->post()) {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('review_for', 'key', 'required|trim');
            $this->form_validation->set_rules('review', 'review', 'required|trim');
            $this->form_validation->set_rules('rating', 'rating', 'required|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $error = $this->form_validation->error_array();
                $message = $error[array_keys($error)[0]];
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['service_name'] = "add_review";
                $this->api_response_arry['message'] = '';
                $this->api_response_arry['error'] = $error;
                $this->api_response_arry['global_error'] = $message;
                $this->api_response();
            } else {
                //print_r($this->input->post()); die;
                
                $ins_data = array(
                    'conversation_id' => $this->input->post('conversation_id'),
                    'review_for' => $this->input->post('review_for'),
                    'review_by' => $this->user_id,
                    'rating' => $this->input->post('rating'),
                    'review' => trim($this->input->post('review')),
                    'created_date' => format_date('today', 'Y-m-d H:i:s')
                );

                $this->db->insert(REVIEW, $ins_data);
                $review_id = $this->db->insert_id();
                
                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['data'] = array('review_id' => $review_id);
                $this->api_response_arry['service_name'] = "add_review";
                $this->api_response_arry['message'] = 'Review submitted successfully.';
                $this->api_response();
            }
        } else {
            $error = 'Invaid input data.';
            $this->api_response_arry['response_code'] = 500;
            $this->api_response_arry['service_name'] = "add_review";
            $this->api_response_arry['message'] = '';
            $this->api_response_arry['error'] = $error;
            $this->api_response_arry['global_error'] = 'Invaid input data.';
            $this->api_response();
        }
    }
}
