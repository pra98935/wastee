<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_profile_detail($user_guid) {
        $this->db->select('U.user_id, U.user_guid, U.first_name, U.image, U.last_name, DATE_FORMAT (U.created_date,  "%d.%m.%Y" ) AS register_date', false);
        $this->db->select('COUNT(I.item_id) AS sell_count, COUNT(IB.item_id) AS buy_count', false);
        if ($this->session->userdata('user_id')) {
            $this->db->select('IFNULL(is_follow, 0) AS is_follow', false);
        } else {
            $this->db->select('0 AS is_follow', false);
        }
        $this->db->from(USER . ' AS U')
                ->join(ITEM . " AS I", "I.user_id = U.user_id", 'left')
                ->join(ITEM_BUY . " AS IB", "IB.user_id = U.user_id AND IB.buy_status='bought'", 'left');
        if ($this->session->userdata('user_id')) {
            $this->db->join(FOLLOWERS . " AS F", "F.following_id = U.user_id AND F.follower_id = " . $this->session->userdata('user_id'), 'left');
        }
        $this->db->where('U.user_guid', $user_guid);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        $result = $sql->row_array();

        return $result;
    }

    function set_follow_status($data) {
        $this->replace_into_batch(FOLLOWERS, $data);
        return 1;
    }

    public function get_follows_list($user_id = 0) {
        $sort_field = 'U.first_name';
        $sort_order = 'ASC';

        $this->db->select('U.user_id, U.user_guid, U.first_name, U.image, U.last_name', false);
        $this->db->from(USER . ' AS U')
                ->join(FOLLOWERS . " AS F", "F.following_id = U.user_id", 'INNER');

        $this->db->where('F.is_follow', 1);

        if ($user_id) {
            $this->db->where('F.follower_id', $user_id);
        }

        if (!empty($sort_field)) {
            $this->db->order_by($sort_field, $sort_order);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result_array();

        return $result;
    }

    public function get_follower_list($user_id) {
        $sort_field = 'U.first_name';
        $sort_order = 'ASC';

        $this->db->select('U.user_id, U.user_guid, U.first_name, U.image, U.last_name', false);
        $this->db->from(USER . ' AS U')
                ->join(FOLLOWERS . " AS F", "F.follower_id = U.user_id", 'INNER');

        $this->db->where('F.is_follow', 1);

        if ($user_id) {
            $this->db->where('F.following_id', $user_id);
        }

        if (!empty($sort_field)) {
            $this->db->order_by($sort_field, $sort_order);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result_array();

        return $result;
    }

}
