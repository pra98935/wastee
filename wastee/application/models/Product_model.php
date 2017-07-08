<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    function create_item($data) {

        $this->db->insert(ITEM, $data);
        if ($this->db->affected_rows() == 1) {
            return $this->db->insert_id();
        }

        return FALSE;
    }

    function insert_item_images($item_id, $data) {

        $this->db->where(array('entity_id' => $item_id, 'entity_type' => ENTITY_TYPE_PRODUCT));
        $this->db->delete(ENTITY_MEDIA);

        $this->insert_batch(ENTITY_MEDIA, $data);

        return TRUE;
    }

    public function get_product_list() {

        $results = array();

        $limit = 30;
        if ($this->input->post('limit'))
            $limit = $this->input->post('limit');

        $offset = 0;
        if ($this->input->post('offset'))
            $offset = $this->input->post('offset');

        $sort_field = 'item_id';
        $sort_order = 'DESC';
        if ($this->input->post('sort_field')) {
            $sort_field = $this->input->post('sort_field');
        }
        if ($this->input->post('sort_order')) {
            $sort_order = $this->input->post('sort_order');
        }
        
        $my_lat = '';
        $my_long = '';
        $km = '';
        
        if($this->input->post('location_lat')){
            $my_lat = $this->input->post('location_lat');
        }
        if($this->input->post('location_long')){
            $my_long = $this->input->post('location_long');
        }
        if($this->input->post('distance')){
            $km = $this->input->post('distance');
        }
        
        if($my_lat != '' && $my_long != '' && $km != ''){
            
            $dis_sql = "SELECT
                        item_id, (
                          6371 * acos (
                            cos ( radians($my_lat) )
                            * cos( radians( location_lat ) )
                            * cos( radians( location_long ) - radians($my_long) )
                            + sin ( radians($my_lat) )
                            * sin( radians( location_lat ) )
                          )
                        ) AS distance
                      FROM tbl_items
                      HAVING distance < 5 ";//
            $range_ids = $this->db->query($dis_sql)->result_array();
            
            $item_ids = '';
            if(!empty($range_ids)){
                $item_ids = array_column((array)$range_ids, 'item_id');
            }
            $this->db->where_in('I.item_id', $item_ids);

        }
        
        $this->db->select('I.*', false);
        if(isset($dis_sql)){
            $this->db->select('DIS.distance', false);
        }
        $this->db->from(ITEM . ' AS I');
        if(isset($dis_sql)){
            $this->db->join("($dis_sql) AS DIS", "DIS.item_id = I.item_id", 'left');
        }
        $this->db->join(CATEGORY . " AS C", "C.category_id = I.category_id", 'left');
        $this->db->join(USER . " AS U", "U.user_id = I.user_id", 'left');

        $this->db->where('I.status_id', 2);
        
//        if(!empty($item_ids)){
//            $this->db->where_in('I.item_id', $item_ids);
//        }

        if ($this->input->post('user_guid')) {
            $this->db->where('U.user_guid', $this->input->post('user_guid'));
        }

        if ($this->input->post('category_id')) {
            $this->db->where('I.category_id', $this->input->post('category_id'));
        }
        
        if ($this->input->post('search_text')) {
            $this->db->like('I.title', $this->input->post('search_text'));
        }

        if ($this->input->post('is_sold') != '') {
            $this->db->where('I.is_sold', $this->input->post('is_sold'));
        }
        if(isset($dis_sql)){
            $this->db->order_by("distance", "ASC");
        }
        if (!empty($sort_field)) {
            $this->db->order_by($sort_field, $sort_order);
        }

        $tempdb = clone $this->db;
        $temp_q = $tempdb->get();
        $row_count = $temp_q->num_rows();



        $this->db->limit($limit, $offset);
        $result = $this->db->get();
        //echo $this->db->last_query();
        $count_result = $result->result_array();

        $offset = $offset + $limit;
        $is_load_more = TRUE;

        if ($row_count < $offset) {
            $is_load_more = FALSE;
        }

        if (!$result)
            $offset = 0;
        $data_array = array('total' => $row_count, 'results' => $count_result, 'is_load_more' => $is_load_more, 'offset' => $offset);
        return $data_array;
    }

    public function get_product_detail($item_id) {
        $this->db->select('I.*, I.user_id, U.user_guid, U.first_name as owner_fname, U.email, U.image as owner_image, U.last_name as owner_lname, DATE_FORMAT (U.created_date,  "%d.%m.%Y" ) AS owner_register_date, DATE_FORMAT (I.modified_date,  "%d.%m.%Y" ) AS last_update, I.created_date, C.category_name', false);
        $this->db->select('COUNT(IO.item_id) AS sell_count, COUNT(IBO.item_id) AS buy_count', false);
        if ($this->session->userdata('user_id')) {
            $this->db->select('IFNULL(is_follow, 0) AS is_follow', false);
        } else {
            $this->db->select('0 AS is_follow', false);
        }
        $this->db->from(ITEM . ' AS I')
                ->join(CATEGORY . " AS C", "C.category_id = I.category_id", 'left')
                ->join(USER . " AS U", "U.user_id = I.user_id", 'left')
                ->join(ITEM . " AS IO", "IO.user_id = U.user_id", 'left')
                ->join(ITEM_BUY . " AS IBO", "IBO.user_id = U.user_id AND IBO.buy_status='bought'", 'left');

        if ($this->session->userdata('user_id')) {
            $this->db->join(FOLLOWERS . " AS F", "F.following_id = U.user_id AND F.follower_id = " . $this->session->userdata('user_id'), 'left');
        }
        $this->db->where('I.status_id', 2);
        $this->db->where('I.item_id', $item_id);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->row_array();

        return $result;
    }

    public function get_product_images($item_id) {
        $this->db->select('EM.*', false);
        $this->db->from(ENTITY_MEDIA . ' AS EM')
                ->where('EM.entity_type', ENTITY_TYPE_PRODUCT)
                ->where('EM.entity_id', $item_id);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->result_array();

        return $result;
    }

    public function get_watch_list($user_id){
        $this->db->select('IB.item_id, IB.user_id, I.user_id as owner_id, I.title, I.currency, I.price, I.cover_image, I.created_date', false);
        $this->db->select('DATE_FORMAT (I.created_date,  "%d.%m.%Y" ) AS item_listed_date', false);
        //$this->db->select('COUNT(MQ.message_id) AS question_count, COUNT(MR.message_id) AS response_count', false);
        $this->db->from(ITEM_BUY . ' AS IB')
                ->join(USER . " AS U", "U.user_id = IB.user_id", 'left')
                ->join(ITEM . " AS I", "I.item_id = IB.item_id", 'left');
                //->join(MESSAGE . " AS MQ", "MQ.item_id = I.item_id AND MQ.user_from != I.user_id", 'LEFT')
                //->join(MESSAGE . " AS MR", "MR.item_id = I.item_id AND MR.user_from = I.user_id", 'LEFT')
                
                $this->db->where('IB.user_id', $user_id);
                $this->db->where('IB.buy_status', ITEM_WATCHING);
            //->group_by('IB.item_id');

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->result_array();

        return $result;
    }
    
    public function get_question_count($item_id){
        $this->db->select('COUNT(MQ.message_id) AS question_count', false);
        $this->db->from(ITEM . ' AS I')
                ->join(MESSAGE . " AS MQ", "(MQ.item_id = I.item_id AND MQ.user_from != I.user_id)", 'LEFT');
                
                $this->db->where('I.item_id', $item_id);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->row_array();

        return $result;
    }
    public function get_response_count($item_id){
        $this->db->select('COUNT(MR.message_id) AS response_count', false);
        $this->db->from(ITEM . ' AS I')
                ->join(MESSAGE . " AS MR", "(MR.item_id = I.item_id AND MR.user_from = I.user_id)", 'LEFT');
                
                $this->db->where('I.item_id', $item_id);
            //->group_by('IB.item_id');

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->row_array();

        return $result;
    }
    
    public function get_product_conversation($item_id){
        
        $this->db->select('C.conversation_id, C.item_id, C.user_one, C.user_two, C.confirm_offer_id, C.is_owner_confirm, C.is_buyer_confirm', false);
        $this->db->select('I.user_id AS owner_id, I.currency, IO.user_id, IO.price, U.user_guid, U.first_name, U.image AS user_image', false);
        $this->db->select('CIO.price AS c_price, BU.first_name AS buyer_fname, BU.email AS buyer_email', false);
        $this->db->from(CONVERSATION . ' AS C')
                ->join(ITEM . " AS I", "I.item_id = C.item_id", "LEFT")
                ->join(ITEM_OFFERS . " AS CIO", "(CIO.offer_id = C.confirm_offer_id)", "LEFT")
                ->join("(SELECT conversation_id, user_id, price FROM ".ITEM_OFFERS . " ORDER BY offer_id DESC ) AS IO", "(IO.conversation_id = C.conversation_id AND IO.user_id!=I.user_id)",  "LEFT")
                ->join(USER . " AS U", "U.user_id = IO.user_id", "LEFT")
                ->join(USER . " AS BU", "BU.user_id = C.is_buyer_confirm", "LEFT");
                
        $this->db->where('C.item_id', $item_id);
        $this->db->group_by('C.conversation_id');
        
        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->result_array();

        return $result;
    }
    
    public function get_all_product_offers($param=array()){
        
        $this->db->select('IO.offer_id, IO.conversation_id, IO.user_id, IO.price, IO.message, DATE_FORMAT (IO.created_date,  "%d.%m.%Y %H:%i" ) AS added_date', false);
        $this->db->select('U.first_name, U.image AS user_image', false);
        $this->db->from(ITEM_OFFERS . ' AS IO')
                ->join(USER . " AS U", "U.user_id = IO.user_id", "LEFT");
        if(isset($param['item_id'])){        
            $this->db->where('IO.item_id', $param['item_id']);
        }
        if(isset($param['conversation_id'])){        
            $this->db->where_in('IO.conversation_id', $param['conversation_id']);
        }
        
        $this->db->order_by('IO.offer_id ASC');
        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->result_array();

        return $result;
    }
}
