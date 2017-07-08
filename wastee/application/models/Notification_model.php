<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function user_notifications($user_id) {

        $limit = 10;
        if ($this->input->post('limit'))
            $limit = $this->input->post('limit');

        $offset = 0;

        if ($this->input->post('offset')) {
            $offset = $this->input->post('offset');
        }

        $this->db->select('NF.notification_id, NF.notification_type_id, NF.receiver_id, NF.product_id, NF.entity_user_id, NF.is_read, NFT.notification_text', false);
        $this->db->select('CONCAT(U.first_name, " ", U.last_name) AS full_name, U.image AS user_image', FALSE);
        $this->db->select('I.title AS product_title, I.cover_image AS product_image', FALSE);
        $this->db->select("concat(DATE_FORMAT ( NF.created_date , '" . MYSQL_DATE_FORMAT . "' ), ' ', '" . DEFAULT_TIME_ZONE_ABBR . "') AS date", false);
        $this->db->from(NOTIFICATION . ' NF');
        $this->db->join(NOTIFICATION_TYPE . ' NFT', 'NFT.notification_type_id= NF.notification_type_id', 'LEFT');
        $this->db->join(ITEM.' I', 'I.item_id= NF.product_id', 'LEFT');
        $this->db->join(USER.' U', 'U.user_id= NF.entity_user_id', 'LEFT');
        $this->db->where('receiver_id', $user_id);
        $this->db->order_by('notification_id', 'DESC');

        $tempdb = clone $this->db;
        $temp_q = $tempdb->get();
        $num_results = $temp_q->num_rows();

        $this->db->limit($limit, $offset);
        $result = $this->db->get();
        //echo $this->db->last_query();
        $results['results'] = $result->result_array();

        $offset = $offset + $limit;
        $is_load_more = TRUE;

        if ($num_results < $offset) {
            $is_load_more = FALSE;
        }

        if (!$result)
            $offset = 0;

        $results['total'] = $num_results;
        $results['offset'] = $offset;
        $results['is_load_more'] = $is_load_more;
        
        $this->db->where('receiver_id', $user_id);
        $this->db->set('is_read', '1', FALSE);
        $this->db->update(NOTIFICATION);
        $this->session->set_userdata('notification_count', '0');

        return $results;
    }

    function add_notification($notification_type_id, $receiver_id = 0, $product_id=0, $entity_user_id = 0, $param_value = '') {
        $data = array(
            'notification_type_id' => $notification_type_id,
            'receiver_id' => $receiver_id,
            'product_id' => $product_id,
            'entity_user_id' => $entity_user_id,
            'param_value' => $param_value,
            'created_date' => format_date(),
            'is_read' => '0'
        );

        $this->db->insert($this->db->dbprefix(NOTIFICATION), $data);
        return 1; 
    }

}

/* End of file leaderboard_model.php */
/* Location: ./application/models/leaderboard_model.php */