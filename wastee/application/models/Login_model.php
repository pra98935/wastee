<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mail_model');
                
	}

	public function get_user_data($input_arry=array()){
		$this->db->select()->from(USER);
		
		if(array_key_exists('email', $input_arry) && $input_arry['email'] != '' &&  (!isset($input_arry['facebook_id']) || $input_arry['facebook_id'] == ''))
		{
			$this->db->or_where('email', $input_arry['email']);
		}

		if(array_key_exists('facebook_id', $input_arry) && $input_arry['facebook_id'] != '')
		{
			$this->db->or_where('facebook_id', $input_arry['facebook_id']);
			if(!empty($input_arry['email']))
			{
				$this->db->or_where('email', $input_arry['email']);
			}
		}


		if(array_key_exists('google_id', $input_arry) && $input_arry['google_id'] != '')
		{
			$this->db->or_where('google_id', $input_arry['google_id']);
		}

		if(array_key_exists('user_name', $input_arry) && $input_arry['user_name'] != '')
		{
			$this->db->or_where('user_name', $input_arry['user_name']);
		}

		$rs = $this->db->get();
		$result = $rs->row_array();

		return $result;
	}

	public function registration($post)
	{
		/*print_r($post);
		die;*/
		$user_data = $this->get_user_data($post);
		$response = array(
					'status'   =>FALSE,
					'msg'      =>'Some thing went wrong',
					'acc_type' => '',
					'data'     => array()
				);

		if(empty($user_data))
		{
			// Registration for new user
			$reset_key = $post['user_guid'] = self::_generate_key();

			if(!isset($post['country'])&&$this->session->userdata('user_country'))
			{
				$post['country'] = $this->session->userdata('user_country');
			}
			$this->db->insert(USER, $post);
			$inserted_id = $this->db->insert_id();
			$rows        = $this->get_single_row('*',USER,array('user_id'=>$inserted_id));

			$rows['first_name'] = $rows['email'];
			$rows['last_name']  = '';

			$post['user_id'] = $inserted_id;

			if ((isset($post['facebook_id']) && $post['facebook_id'] != "") )
			{
				$response = array(
							'status'   =>TRUE,
							'msg'      => $this->lang->line('new_registration_success'),
							'acc_type' =>'facebook',
							'data'     => $post
						);
			} 
			else if((isset($post['google_id']) && $post['google_id'] != ""))
			{
				$response = array(
							'status'   =>TRUE,
							'msg'      =>$this->lang->line('new_registration_success'),
							'acc_type' =>'google',
							'data'     => $post
						);
			}
			else
			{
				$time=time();
				$this->mail_model->send_registration_confirmation_link($rows,$time,$reset_key);

				$response = array(
					'status'=>TRUE,
					'msg'=>'Mail sent you for activation'
				);
			}
		}
		else
		{
			if(array_key_exists('email', $post) &&  $post['email'] == $user_data['email']){
				// Email already exist in db
				// Check user comes as a  facebook user
				if ( (isset($post['facebook_id']) && $post['facebook_id'] != "") ){
					$update_data = array('image'=>$post['image'], 'facebook_id'=> $post['facebook_id'],'is_login'=>'1','last_login'=>date('Y-m-d H:i:s'));
					$where       = array('user_id'=> $user_data['user_id']);
					$this->db->update(USER, $update_data , $where);

					$response = array(
								'status'   =>TRUE,
								'msg'      =>'',
								'acc_type' => 'facebook',
								'data'     => $user_data
							);
				}
				else if((isset($post['twitter_id']) && $post['twitter_id'] != ""))
				{
					// Check user comes as a twitter user
					$update_data = array('twitter_id'=> $post['twitter_id'],'twitter_screen_name'=>$post['twitter_screen_name'],'is_login'=>'1','last_login'=>date('Y-m-d H:i:s'));
					$where       = array('user_id'=> $user_data['user_id']);
					$this->db->update(USER,$update_data , $where);
					$response = array(
								'status'   =>TRUE,
								'msg'      =>'',
								'acc_type' => 'twitter',
								'data'     => $user_data
							);
				}
				//  Check user comes as a google user
				else if((isset($post['google_id']) && $post['google_id'] != ""))
				{
					$update_data = array('google_id'=> $post['google_id']);
					$where       = array('user_id'=> $user_data['user_id']);
					$this->db->update(USER,$update_data , $where);
					$response = array(
								'status'   =>TRUE,
								'msg'      =>'',
								'acc_type' => 'google',
								'data'     => $user_data
							);
				}
				else
				{
					// Returning ERROR 
					$response = array(
							'status' => FALSE,
							'msg'    => $this->lang->line('email_exist')
						);
				}
			}
			else if(array_key_exists('user_name', $post) && $post['user_name'] == $user_data['user_name'])
			{
				// Returning ERROR 
				$response = array(
							'status' => FALSE,
							'msg'    => $this->lang->line('user_name_exist')
						);
			}
			else if(isset($post['facebook_id']) && $post['facebook_id'] == $user_data['facebook_id'])
			{
				// Facebook id exist in database
				$response = array(
						'status'   =>TRUE,
						'msg'      =>'',
						'acc_type' => 'facebook',
						'data'     => $user_data
					);
			}
			else if( isset($post['twitter_id']) && $post['twitter_id'] == $user_data['twitter_id'])
			{
				//update twwiter data if exist
				$update_data = array('twitter_id'=> $post['twitter_id'],'twitter_screen_name'=>$post['twitter_screen_name'],'is_login'=>'1','last_login'=>date('Y-m-d H:i:s'));
				$where       = array('user_id'=> $user_data['user_id']);
				$this->db->update(USER,$update_data , $where);
				
				// Twitter id exist in database
				$response = array(
						'status'   =>TRUE,
						'msg'      =>'',
						'acc_type' => 'twitter',
						'data'     => $user_data
					);
			}
			else if( isset($post['google_id']) && $post['google_id'] == $user_data['google_id'])
			{
				// Twitter id exist in database
				$response = array(
						'status'   =>TRUE,
						'msg'      =>'',
						'acc_type' => 'google',
						'data'     => $user_data
					);
			}
		}
		return $response;
	}

	function clear_attempts($ip_address, $login, $expire_period = 86400)
	{
		$this->db->where(array('ip_address' => $ip_address, 'login' => $login));
		// Purge obsolete login attempts
		// $this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);
		$this->db->delete(LOGIN_ATTEMPTS);
	}
	
	function get_invitation_list($email){

		$sql="SELECT email
				FROM ".$this->db->dbprefix( INVITE )."
					WHERE
					email='".$email."'
						";
		$rs = $this->db->query($sql);
		$result = $rs->row_array();
		return $result ;
	}

	public function get_plan_details(){
		$result = $this->db->select()
							->from(MASTER_MEMBER_FEES)
							->where('is_active', '1')
							->order_by('amount','ASC')
							->get()
							->result_array();
		return $result ;
	}

   //check username exist
   public function check_user_name($username = ''){
	  $result = $this->db->select()
							->from('user')
							->where('user_name', $username)
							->get();
	 return $result->num_rows;   
   }

   //check email exist
   public function check_user_email($email = ''){
	  $result = $this->db->select()
							->from('user')
							->where('email', $email)
							->get();
	  return $result->num_rows;   
   }

   public function check_password_update(){
	   $is_login = ($this->user_id) ? $this->user_id : 0;
	   $result = $this->db->select('password')
							->from('user')
							->where('user_id', $is_login)
							->get();	 
	  return $result->row_array();
   }

	public function check_state_valid($country,$state_id)
	{
		$rs = $this->db->select('id')
						->from(MASTER_STATE." AS MS")
						->where('MS.country',$country)
						->where('MS.id',$state_id)
						->get();
		$result = $rs->row_array();
		return $result ;
	}

	private function _generate_key() {
		$this->load->helper('security');

		do {
			$salt = do_hash(time() . mt_rand());
			$new_key = substr($salt, 0, 10);
		}

		// Already in the DB? Fail. Try again
		while (self::_key_exists($new_key));

		return $new_key;
	}

	private function _key_exists($key) {
		return $this->db->where('user_guid', $key)->count_all_results(USER) > 0;
	}
        
        function current_game_home_page($league_id=15){
                
                $this->db->select('S.season_game_unique_id,S.season_scheduled_date')
					->select("DATE_FORMAT ( `S`.`season_scheduled_date` , '".MYSQL_DATE_FORMAT."' ) AS season_scheduled_date_formated",false)
					->select("T1.".$this->site_lang."_team_abbr AS home,T2.".$this->site_lang."_team_abbr AS away")
                                        ->select("T1.".$this->site_lang."_team_name AS home_team_name,T2.".$this->site_lang."_team_name AS away_team_name")
					->from(SEASON.' S')
					->join(TEAM.' T1','T1.team_abbr = S.home AND T1.year = "'.$this->current_season_year.'"','LEFT')
					->join(TEAM.' T2','T2.team_abbr = S.away AND T2.year = "'.$this->current_season_year.'"','LEFT')
					->where('S.league_id',$league_id)
					->where('S.year',$this->current_season_year)
                                        ->where('S.season_scheduled_date >',format_date())
					->group_by('S.season_game_unique_id')
                        		->order_by('S.season_scheduled_date','ASC')
                                        ->limit(4);
                
		$sql = $this->db->get();
		$result = $sql->result_array();
		//echo $this->db->last_query();
		return (is_array($result)) ? $result : array();


        }
        
        
}