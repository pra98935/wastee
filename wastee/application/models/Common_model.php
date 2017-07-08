<?php
/**
 * This model is used for common function
 * @package    common_model
 * @author     Vinod patidar  <vinod@vinfotech.com>
 * @version    1.0
 *
 */

class Common_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	/*common function used to get single row from any table
	* @param String $select
	* @param String $table
	* @param Array/String $where
	*/
	function get_single_row($select = '*', $table, $where = "", $group_by = "", $order_by = "", $offset = '', $limit = '')
	{
		$this->db->select($select);
		$this->db->from($table);
		if ($where != "") {
			$this->db->where($where);
		}
		if ($group_by != "") {
			$this->db->group_by($group_by);
		}
		if ($order_by != "") {
			$this->db->order_by($order_by);
		}
		if ($limit != "") {
			$this->db->limit($offset, $limit);
		}
		$query = $this->db->get();
                //echo $this->db->last_query();
		return $query->row_array();
	}

	/*common function used to get all data from any table
	* @param String $select
	* @param String $table
	* @param Array/String $where
	*/
	function get_all_table_data($select = '*', $table, $where = "", $group_by = "", $order_by = "", $offset = '', $limit = '')
	{
		$this->db->select($select);
		$this->db->from($table);
		if ($where != "") {
			$this->db->where($where);
		}
		if ($group_by != "") {
			$this->db->group_by($group_by);
		}
		if ($order_by != "") {
			$this->db->order_by($order_by);
		}
		if ($limit != "") {
			$this->db->limit($offset, $limit);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * Updates whole row [unlike update_field()]
	 * @param Array $data
	 * @param Integer $id
	 */
	public function update($table = "", $data, $where = "")
	{

		if (!is_array($data)) {
			log_message('error', 'Supposed to get an array!');
			return FALSE;
		} else if ($table == "") {
			log_message('error', 'Got empty table name');
			return FALSE;
		} else if ($where == "") {
			return false;
		} else {
			$this->db->where($where);
			$this->db->update($table, $data);
			return true;
		}
	}

	/* insert data in table
	* @param String $table
	* @param String $data
	* @param String $return
	*/
	function insert_data($table_name, $data_array, $return = 'id')
	{
		if ($table_name && is_array($data_array)) {
			$columns = $this->getTableFields($table_name);
			foreach ($columns as $coloumn_data)
				$column_name[] = $coloumn_data['Field'];

			foreach ($data_array as $FLEXey => $val) {
				if (in_array(trim($FLEXey), $column_name)) {
					$data[$FLEXey] = trim($val);
				}
			}
			$this->db->insert($table_name, $data);
			$id = $this->db->insert_id();
			if ($return == 'id') {
				return $id;
			} else {
				$arr[$return] = $id;
				//return $this->get_single_row('*', $table_name, array($arr));
			}
		}
	}

	function getTableFields($table_name)
	{
		$query = "SHOW COLUMNS FROM " . $this->db->dbprefix . "$table_name";
		$rs = $this->db->query($query);
		return $rs->result_array();
	}

	/**
	 * Delete row
	 * @param String $table
	 * @param Array/String $where
	 */
	public function delete($table = "", $where = "")
	{

		if ($table == "") {
			log_message('error', 'Got empty table name');
			return FALSE;
		} else if ($where == "") {
			return false;
		} else {
			$this->db->where($where);
			$this->db->delete($table);
		}
	}

   /**
	 * Replace into statement
	 *
	 * Generates a replace into string from the supplied data
	 *
	 * @access    public
	 * @param    string    the table name
	 * @param    array    the update data
	 * @return    string
	 */
	public function replace_into($table, $data)
	{
		$column_name   = array();
		$coloumn_data  = array();
		$update_fields = array();

		foreach ($data as $FLEXey => $val) {
			$column_name[]   = "`" . $FLEXey . "`";
			$update_fields[] = "`" . $FLEXey . "`" .'=VALUES(`'.$FLEXey.'`)';

			if (is_numeric($val)) {
				$coloumn_data[] = $val;
			} else {
				$coloumn_data[] = "'" . $val . "'";
			}

		}
		$sql = "INSERT INTO " . $this->db->dbprefix($table) . " ( " . implode(", ", $column_name) . " ) VALUES ( " . implode(', ', $coloumn_data) . " ) ON DUPLICATE KEY UPDATE " .implode(', ', $update_fields);
		$this->db->query($sql);
	}

	/**
	 * Replace into Batch statement
	 * Generates a replace into string from the supplied data
	 * @access    public
	 * @param    string    the table name
	 * @param    array    the update data
	 * @return    string
	 */
	public function replace_into_batch($table, $data)
	{
		$column_name   = array();
		$update_fields = array();
		$append        = array();

		foreach($data as $i=>$outer){

			$coloumn_data = array();
			foreach ($outer as $FLEXey => $val) {

				if($i == 0){
					$column_name[]   = "`" . $FLEXey . "`";
					$update_fields[] = "`" . $FLEXey . "`" .'=VALUES(`'.$FLEXey.'`)';
				}

				if (is_numeric($val)) {
					$coloumn_data[] = $val;
				} else {
					$coloumn_data[] = "'" . replace_quotes($val) . "'";
				}
			}

			$append[] = " ( ".implode(', ', $coloumn_data). " ) ";
		}

		$sql = "INSERT INTO " . $this->db->dbprefix($table) . " ( " . implode(", ", $column_name) . " ) VALUES " . implode(', ', $append) . " ON DUPLICATE KEY UPDATE " .implode(', ', $update_fields);
		$this->db->query($sql);
	} 

	
}