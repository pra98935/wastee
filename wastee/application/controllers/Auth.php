<?php defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH.'/libraries/REST_Controller.php';

class Auth extends MY_Controller {
        
        
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		
		$this->load->model('Login_model');
		$this->load->model('Common_model');
                $post = file_get_contents("php://input");
                $_POST = (array) json_decode($post);
		//$_POST = $this->post();
	}
        
        public function generate_active_login_key($user_id = "", $device_type = "1")
	{
		$this->db->where('user_id', $user_id)->where('device_type', $device_type)->delete(ACTIVE_LOGIN);

		$this->load->helper('string');
		$key = random_string('unique');
		$insert_data = array(
								'key'          => $key,
								'user_id'      => $user_id,
								'device_type'  =>$device_type,
								'level'=> '1',
								'date_created' => date('Y-m-d H:i:s')
							);
		$this->db->insert(ACTIVE_LOGIN, $insert_data);
		return $key;
	}

	public function user_login()
	{
		$post_data = $this->input->post();
	
                if(array_key_exists('social_type',$post_data) && $post_data['social_type'] == 'facebook')
		{
			$post_data['facebook_id'] = $post_data['social_id'];
			$this->social_login($post_data);
		}
		else if(array_key_exists('social_type',$post_data) && $post_data['social_type'] == 'twitter')
		{
			$post_data['twitter_id'] = $post_data['social_id'];
			if(!empty($post_data['screen_name']))
			{
				$post_data['screen_name'] = $post_data['screen_name'];
			}
			$this->social_login($post_data);
		}
		else if(array_key_exists('social_type',$post_data) && $post_data['social_type'] == 'google')
		{
			$post_data['google_id'] = $post_data['social_id'];
			$this->social_login($post_data);
		}
		else 
		{  			
			$this->custom_login();
		}
	}

	/* 
	* This method used for user custom login functionality
	*/
	public function custom_login()
	{
		if ($this->input->post())
		{
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('email', 'Email' , 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password' , 'required|trim');
			
			$email             = strtolower($this->input->post('email'));
			$password          = md5($this->input->post('password'));
			$remember_me       = $this->input->post('remember_me');
			$this->device_id   = $this->input->post('device_id');
			$this->device_type = $this->input->post('device_type');

			if($this->form_validation->run() == FALSE)
			{
				$error   = $this->form_validation->error_array();
				$message = $error[array_keys($error)[0]];
				$this->api_response_arry['response_code'] = 500;
				$this->api_response_arry['service_name']  = "user_login";
				$this->api_response_arry['message']       = '';
				$this->api_response_arry['error']         = $error;
				$this->api_response_arry['global_error']  = $message;
				$this->api_response();
			} 
			else 
			{
				$profile_data = $this->user_profile_data(array('profile_type'=>'native','email' => $email, 'password' => $password));

				if(false || isset($profile_data) && !empty($profile_data))
				{
					if ($profile_data['is_banned'] == 1)
					{
						if($profile_data['varified_email'] == 1)
						{
							$remember_me = $this->input->post('remember_me');

							if($remember_me){
								$this->create_user_autologin($email,$this->input->post('password'));
                                                        }
							$this->user_id = $profile_data['user_id'];

							$response = $this->db->where('user_id', $this->user_id)
												 ->where('device_type', $this->device_type)
												 ->delete(ACTIVE_LOGIN);

							//used to update last login date & last ip
							$this->db->update(USER ,array('is_login'=>'1','last_login'=>date('Y-m-d H:i:s'),'last_ip'=>$this->input->ip_address()),array('user_id'=>$profile_data['user_id']));

							$new_key =  $this->generate_active_login_key($this->user_id, $this->device_type);

							$redirect_url = $this->session->userdata('redirect_url');
							$this->Set_session($profile_data['user_id'], '',$this->device_type);

							if($new_key == '0')
							{
								$this->api_response_arry['response_code'] 	= 500;
								$this->api_response_arry['service_name']    = "user_login";
								$this->api_response_arry['message']  		= '';
								$this->api_response_arry['error']           = 'Unable to create key';
								$this->api_response_arry['global_error']  	= 'Unable to create key';
							}
							else
							{
								//Remove Null value from array
								$profile_data = remove_null_values($profile_data);

								//$profile_data['full_image_url'] = show_user_image($profile_data['image']);
								if(isset($profile_data['image'])&&$profile_data['image'])
								{
								}
								$data = array(AUTH_KEY=>$new_key, 'profile_data'=>$profile_data);

								if($redirect_url)
								{
									$data['redirect_url'] = $redirect_url;
								}
								$this->api_response_arry['data'] 			= $data;
								$this->api_response_arry['response_code'] 	= 200;
								$this->api_response_arry['service_name']    = "user_login";
								$this->api_response_arry['message']  		= 'Login successfull';
							}
							$this->api_response();
						}
						else
						{
							$error = array('email'=>'You have not confirmed your email');
							$this->api_response_arry['response_code'] 	= 500;
							$this->api_response_arry['service_name']    = "user_login";
							$this->api_response_arry['message']  		= '';
							$this->api_response_arry['error']  			= $error;
							$this->api_response_arry['global_error']  	= 'You have not confirmed your email';
							$this->api_response();
						}
					}
					else
					{
						$error = array('email'=>'Your account is blocked');
						$this->api_response_arry['response_code'] 	= 500;
						$this->api_response_arry['service_name']    = "user_login";
						$this->api_response_arry['message']  		= '';
						$this->api_response_arry['error']  			= $error;
						$this->api_response_arry['global_error']  	= 'Your account is blocked';
						$this->api_response();
					}
				}
				else
				{
					$error = array('email'=>'Invalid login details');
					$this->api_response_arry['response_code'] 	= 500;
					$this->api_response_arry['service_name']    = "user_login";
					$this->api_response_arry['message']  		= '';
					$this->api_response_arry['error']  			= $error;
					$this->api_response_arry['global_error']  	= 'Invalid login details';
					$this->api_response();
				}
			}
		}
		else
		{
			$error = array('email'=>$this->lang->line('invalid_type'));
			$this->api_response_arry['response_code'] 	= 500;
			$this->api_response_arry['service_name']    = "user_login";
			$this->api_response_arry['message']  		= '';
			$this->api_response_arry['error']  			= $error;
			$this->api_response_arry['global_error']  	= $this->lang->line('invalid_type');
			$this->api_response();
		}
	}

	public function user_profile_data($argument_array =  array())
	{
		switch ($argument_array['profile_type']) {
			case 'facebook':
					$profile_data = $this->Common_model->get_single_row('user_id,first_name,last_name,user_name,email,dob,facebook_id,,google_id,zip_code,country,street,street_2,city,image,varified_email,status,is_banned,last_ip,last_login,created_date,updated_date,is_login' , USER , array('facebook_id' => $argument_array['facebook_id']));
					return $profile_data;
				break;
			case 'twitter':
					$profile_data = $this->Common_model->get_single_row('user_id,first_name,last_name,user_name,email,dob,facebook_id,,google_id,zip_code,country,street,street_2,city,image,varified_email,status,is_banned,last_ip,last_login,created_date,updated_date,is_login' , USER , array('twitter_id' => $argument_array['twitter_id'], 'status' => '1'));
					return $profile_data;
				break;
			case 'google':
					$profile_data = $this->Common_model->get_single_row('user_id,first_name,last_name,user_name,email,dob,facebook_id,,google_id,zip_code,country,street,street_2,city,image,varified_email,status,is_banned,last_ip,last_login,created_date,updated_date,is_login' , USER , array('google_id' => $argument_array['google_id'], 'status' => '1'));
					return $profile_data;
				break;
			case 'native':
					//$profile_data = $this->Common_model->get_single_row('user_id,first_name,last_name,user_name,email,dob,facebook_id,,google_id,zip_code,country,street,street_2,city,image,varified_email,status,is_banned,last_ip,last_login,created_date,updated_date,is_login' , USER , array('email' => $argument_array['email'], 'password' => $argument_array['password'], 'status' => '1'));
                                        $profile_data = $this->Common_model->get_single_row('user_id,first_name,last_name,user_name,email,dob,facebook_id,,google_id,zip_code,country,street,street_2,city,image,varified_email,status,is_banned,last_ip,last_login,created_date,updated_date,is_login' , USER , '(email = "'.$argument_array['email'].'" OR user_name = "'.$argument_array['email'].'") AND password="'.$argument_array['password'].'" AND status = "1"');
					return $profile_data;
				break;
			default:
				break;
		}
	}

	private function create_user_autologin($email='-',$pass="")
	{
		$this->load->helper('cookie');

		//$key = substr(md5(uniqid(rand())), 0, 16);
		if ($email !='-'){	

			set_cookie(
					array(
							'name'   => 'users',
							'value'  => serialize(array('email' => $email, 'key' => $pass)),
							'expire' => time() + (86400 * 30)
						)
					);
			$cookie = get_cookie('users', TRUE);
			return TRUE;
		}
		delete_cookie('users');
		return FALSE;
	}

	/*
	* Method to set session from social login
	*/
	private function Set_session($id, $social_type = "",$device_type='1')
	{
		if(!$id){return true;}

		$this->db->select('U.user_id, U.user_guid, U.email, U.first_name, U.last_name, U.user_name, U.country,U.image, U.search_tag, AL.key');
		$this->db->select("IFNULL(U.user_name, CONCAT(U.first_name,' ', U.last_name)) AS fullname",FALSE);
		$this->db->from(USER." AS U");
		$this->db->join(ACTIVE_LOGIN.' AS AL', " AL.user_id = U.user_id", 'left');
		$this->db->where('AL.device_type', $device_type);

		if ($social_type == "facebook" || $social_type == "twitter"  || $social_type == "google") 
		{			
			switch($social_type){
				case 'facebook':
					$social_id = "facebook_id";
				break;
				case 'google':
					$social_id = "google_id";
				break;
				case 'twitter':
						$social_id = "twitter_id";
				break;
			}
			$this->db->where(array($social_id => $id));
		}
		else 
		{
			$this->db->where(array('U.user_id' => $id));
		}

		$query_check = $this->db->get()->row_array();

		//$image   = show_user_image($query_check['image']);
		$country = $query_check['country'];
		if($query_check['country'] == '')
		{
			$country = $this->session->userdata('user_country');
		}

		//$notifycount = $this->Common_model->get_single_row('COUNT(notification_id) AS readcount' , NOTIFICATION , array('is_read' => '0','receiver_user_id' => $id));
		
		//$image = show_user_image($image);
		$newdata = array(
				'user_id'            => $query_check['user_id'],
				'user_guid'            => $query_check['user_guid'],
				'email'              => $query_check['email'],
				'first_name'         => $query_check['first_name'],
				'last_name'          => $query_check['last_name'],
				'user_name'          => $query_check['user_name'],
				'user_country'       => $country,
				'user_image'         => $query_check['image'], //$image
				'user_type'          => USER_TYPE,
				'logged_in'          => TRUE,
				AUTH_KEY             => $query_check['key'],
				//'notification_count' =>	$notifycount['readcount'],
                    		'fullname'           =>	$query_check['fullname'],
                                'search_tag'         => $query_check['search_tag']
			);

		$this->session->sess_destroy();
		$this->session->sess_create();
		$this->session->set_userdata($newdata);
	}

	public function social_login($post_data = array())
	{//echo '<pre>';print_r($post_data); die;
		if($post_data)
		{
			$this->form_validation->set_error_delimiters('', '');
			if(trim($this->input->post('device_type'))!='1')
			{
				$this->form_validation->set_rules( 'device_id' , $this->lang->line('device_id') , 'trim|required' );
			}

			$this->form_validation->set_rules( 'device_type' , $this->lang->line('device_type') , 'required|trim' );
			$this->form_validation->set_rules( 'social_id' , 'Social id' , 'required|trim' );

			if($this->form_validation->run() == FALSE)
			{
				$error = $this->form_validation->error_array();
				$message  = $error[ array_keys($error)[0] ] ;

				$this->api_response_arry['response_code'] 	= 500;
				$this->api_response_arry['service_name']    = "user_login";
				$this->api_response_arry['message']  		= $message;
				$this->api_response_arry['error']  			= $error;
				$this->api_response_arry['global_error']  	= $message;
				$this->api_response();
			}

			$data           = array();
			$social_type    = "";
			$user_social_id = '';
			$current_tiem = time()."_".rand(0,999);
			if(isset($post_data['facebook_id']) && $post_data['facebook_id'])
			{
				$social_type = "facebook";
				if(!empty($post_data['email']) && $post_data['email']!='' ){
					$data['email']     = strtolower($post_data['email']);
				}
				$data['first_name']     = $post_data['first_name'];
				$data['last_name']      = $post_data['last_name'];
				$data['facebook_id']    = $post_data['facebook_id'];

				//In some cases we are not get image extension so using default here for that
				$ext            = 'jpg';
				//Make destination for temp image
				$temp_file        = $current_tiem.".".$ext;
				$destination      = ROOT_PATH_UPLOADS.'user/'.$temp_file;
				//Make destination for thumb image
				$logo_file_name   = $current_tiem.".".$ext;
				$logo_destination = $destination.'thumb/'.$logo_file_name;
				//Copy source image into temp destination
				copy($post_data['image'],$destination);
				//Now make thumb of temp image
				create_thumb($destination, $logo_destination, 200, 200);
				//Now assign image new file_name
				$data['image'] = $logo_file_name;
				
				$user_social_id = $post_data['facebook_id'];
			}
                        if(isset($post_data['google_id']) && $post_data['google_id'])
			{
				$social_type = "google";
				if(!empty($post_data['email']) && $post_data['email']!='' ){
					$data['email']     = strtolower($post_data['email']);
				}
				$data['first_name']     = $post_data['first_name'];
				$data['last_name']      = $post_data['last_name'];
				$data['google_id']    = $post_data['google_id'];

				//In some cases we are not get image extension so using default here for that
				/*$ext            = 'jpg';
				//Make destination for temp image
				$temp_file        = $current_tiem.".".$ext;
				$destination      = ROOT_PATH.PROFILE.$temp_file;
				//Make destination for thumb image
				$logo_file_name   = $current_tiem.".".$ext;
				$logo_destination = ROOT_PATH.PROFILE_THUMB.$logo_file_name;
				//Copy source image into temp destination
				copy($post_data['image'],$destination);
				//Now make thumb of temp image
				$this->create_thumb($destination, $logo_destination, 200, 200);
				//Now assign image new file_name
				$data['image'] = $logo_file_name;*/
				
				$user_social_id = $post_data['google_id'];
			}
			else if (isset($post_data['twitter_id']) && $post_data['twitter_id'])
			{
				$social_type = "twitter";
				$name = $post_data['first_name'];
				$exploded_name = explode(' ', $name, 2);
				
				$first_name = $exploded_name[0];
				$last_name  = '';
				if(isset($exploded_name[1]))
					$last_name = $exploded_name[1];

				$data['first_name']     = $first_name;
				$data['last_name']      = $last_name;
				$data['twitter_id']     = $post_data['twitter_id'];
				if(!empty($post_data['screen_name']))
				{
					$data['twitter_screen_name']     = $post_data['screen_name'];
				}

				/*//First remove _normal from original image name
				$original_file_name = str_replace('_normal', '', $post_data['image']);
				//Make destination for temp image
				$ext         = 'jpg';
				$temp_file   = $current_tiem.".".$ext;
				$destination = ROOT_PATH.PROFILE.$temp_file;
				//Make destination for thumb image
				$logo_file_name   = $current_tiem.".".$ext;
				$logo_destination = ROOT_PATH.PROFILE_THUMB.$logo_file_name;
				//Copy source image into temp destination
				copy($original_file_name,$destination);
				//Now make thumb of temp image
				$this->create_thumb($destination, $logo_destination, 200, 200);
				//Now assign image new file_name
				$data['image']  = $logo_file_name;
*/				
				$user_social_id = $post_data['twitter_id'];
			}
			
			$data['varified_email'] = '1';
			$data['status']         = '1';
			$data['created_date']   = date('Y-m-d H:i:s');
			$data['is_login']       = '1';
			$data['last_login']     = date('Y-m-d H:i:s');
			$data['last_ip']        = $this->input->ip_address();
			
			$device_type = $post_data['device_type'] or 1;
			//@unlink($destination);
			//echo '<pre>'; print_r($data);
			$output = $this->Login_model->registration($data);

			if($output['status']){

				$api_key = $this->generate_active_login_key($output['data']['user_id'], $device_type );

				$redirect_url = $this->session->userdata('redirect_url');

				$this->Set_session($user_social_id , $social_type, $device_type);

				$profile_data = array();

				if($social_type == 'facebook')
				{
					$profile_data = $this->user_profile_data(array( 'profile_type'=>'facebook','facebook_id' => $post_data['facebook_id'] ) );
				}
				else if( $social_type == 'twitter') 
				{
					$profile_data = $this->user_profile_data(array( 'profile_type'=>'twitter','twitter_id' => $post_data['twitter_id'] ) );
				}
				else if( $social_type == 'google') 
				{
					$profile_data = $this->user_profile_data(array( 'profile_type'=>'google','google_id' => $post_data['google_id'] ) );
				}
				$this->api_response_arry['response_code'] = 200;
				$this->api_response_arry['service_name']  ='user_login' ;
				$this->api_response_arry['message']       = $this->lang->line('login_successfull');
				//Remove Null value from array
				//$profile_data['image'] = show_user_image($profile_data['image'],TRUE);
				$profile_data = remove_null_values($profile_data);
				$data = array(AUTH_KEY=>$api_key,'profile_data'=>$profile_data);

				if($redirect_url)
				{
					$data['redirect_url'] = $redirect_url;
				}

				$this->api_response_arry['data'] = $data;
			}
			else
			{					
				$this->api_response_arry['response_code'] = 500;
				$this->api_response_arry['service_name']  = "user_login";
				$this->api_response_arry['message']       = $output['msg'];
				$this->api_response_arry['global_error']  = $output['msg'];
				$this->api_response_arry['error']         = array();
			}
			$this->api_response();
		}
		else
		{
			$this->api_response_arry['response_code'] = 500;
			$this->api_response_arry['service_name']  = "user_login";
			$this->api_response_arry['message']       = $this->lang->line('no_post_data');
			$this->api_response_arry['global_error']  =  $this->lang->line('no_post_data');
			$this->api_response_arry['error']         = array();
			$this->api_response();
		}
	}

	public function signup()
	{
		if ($this->input->post()) 
		{
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('first_name'	, 'first name'	,'required|trim');
			$this->form_validation->set_rules('last_name'	, 'last name'	,'required|trim');
			$this->form_validation->set_rules('email'	, 'email'		,'trim|required|valid_email|is_unique['.USER.'.email]');
			$this->form_validation->set_rules('password'	, 'password'		,'required|trim|min_length[6]|max_length[80]|matches[conf_password]');
                        $this->form_validation->set_rules('conf_password'   , 'confirm password' , 'trim|required');
                        
                        
			if ($this->form_validation->run() == FALSE)
			{
				$error    = $this->form_validation->error_array();
				$message  = $error[ array_keys($error)[0] ];
				$this->api_response_arry['response_code'] = 500;
				$this->api_response_arry['service_name']  = "signup";
				$this->api_response_arry['message']       = '';
				$this->api_response_arry['error']         = $error;
				$this->api_response_arry['global_error']  = $message;
				$this->api_response();
			}
			else 
			{
				$post_values['first_name']     = $this->input->post('first_name');
				$post_values['last_name']      = $this->input->post('last_name');
				$post_values['email']          = strtolower($this->input->post('email'));
				//$post_values['user_name']      = $this->input->post('user_name');
				$post_values['password']       = md5($this->input->post('password'));
				$post_values['image']       = trim($this->input->post('image'));
				$post_values['varified_email'] = '1';

				if( $this->input->post('facebook_id') > 0 ){
					$post_values['facebook_id']    =  $this->input->post('facebook_id');
					$post_values['varified_email'] =  '1';
				}
				if( $this->input->post('google_id') > 0 ){
					$post_values['google_id']      =  $this->input->post('google_id');
					$post_values['varified_email'] =  '1';
				}

				$date                               = format_date( 'today' , 'Y-m-d H:i:s' );
				$post_values['created_date'] 		= $date;
				$post_values['updated_date'] 		= $date;
				$post_values['last_ip'] 	 	= $this->input->ip_address();
				
				unset($post_values['social_type']);

				$email_exist = $this->Common_model->get_single_row( 'email' , USER , array('email' => $this->input->post('email'), 'status' => '1'));

				if(!empty($email_exist['email']))
				{
					$error['email']                           = 'Email already exist';
					$this->api_response_arry['response_code'] = 500;
					$this->api_response_arry['service_name']  = "signup";
					$this->api_response_arry['message']       = '';
					$this->api_response_arry['error']         = $error;
					$this->api_response_arry['global_error']  = 'Email already exist';
					$this->api_response();
				}

				$response = $this->Login_model->registration($post_values);
				$this->api_response_arry['response_code'] 	= 200;
				$this->api_response_arry['service_name']    = "signup";
				$this->api_response_arry['message']  		= 'Thank you for signing up with '.PROJECT_NAME.'. Please check your email (don\'t forget to check you junk email) to activate your account.';
				$this->api_response();
			}
		}
		else
		{
			$this->api_response_arry['response_code'] = 500;
			$this->api_response_arry['service_name']  = "signup";
			$this->api_response_arry['message']       = '';
			$this->api_response_arry['error']         = $this->lang->line('invalid_type');
			$this->api_response_arry['global_error']  = $this->lang->line('invalid_type');
			$this->api_response();
		}
	}

	

	public function activate_account_get($link)
	{
		if($link=="")
		{
			redirect('');
		}
		else
		{	
			$clink = base64_decode($link);
			$rec = explode("_",$clink);
			$unique_id = $rec[0];
			$user_record = $this->Login_model->get_single_row('user_id,email,first_name,varified_email',USER,array('user_guid'=>$unique_id));

			@$get_invitation_list = $this->Login_model->get_invitation_list($user_record['email']);

			if(isset($get_invitation_list['email'])&&$get_invitation_list['email']==$user_record['email'])
			{
				$this->db->update('invite',array('code'=>'0','status'=>'1'),array('email'=>$user_record['email']));
			}

			if(isset($user_record) && !empty($user_record)) 
			{
				$this->db->update('user',array('varified_email'=>'1'),array('user_id'=>$user_record['user_id']));
				if($this->db->affected_rows())
				{
					/** automatic login if user verifed link start */
					$this->user_id     = $user_record['user_id'];
					$this->device_type = '1';//Web
					$response = $this->db->where('user_id', $this->user_id)
										 ->where('device_type', $this->device_type)
										 ->delete(ACTIVE_LOGIN);

					//used to update last login date & last ip
					$this->db->update('user',array('is_login'=>'1','last_login'=>date('Y-m-d H:i:s'),'last_ip'=>$this->input->ip_address()),array('user_id'=>$this->user_id));

					$new_key =  $this->generate_active_login_key($this->user_id, $this->device_type);

					$this->Set_session($this->user_id, '', $this->device_type);

					/** automatic login if user verifed link end  */

					$this->session->set_flashdata('successMessage',$this->lang->line('account_confirm'));
					redirect('lobby');
				}
				else
				{
					$this->session->set_flashdata('warningMessage', $this->lang->line('invalid_link'));
					redirect( '' );
				}
			}
			else
			{
				$this->session->set_flashdata('warningMessage', $this->lang->line('invalid_link'));
				redirect('');
			}
		}
	}

	public function forgot_password()
	{
		if ($this->input->post())
		{
			$this->load->helper('mail_helper');
			$rand                                           = rand();
			$random                                         = md5($rand);
			$reset_key                                      = substr($random, 15, 20);
			$time                                           = time()+(24*60*60); 
			$email                                          = trim($this->input->post('email'));
			$user_record                                    = $this->Common_model->get_single_row('*',USER,array('email'=>$email));
			$datetime                                       = date('Y-m-d H:i:s');
			
			$this->form_validation->set_error_delimiters('', '');
			
			$this->form_validation->set_rules('email', 'email'	,'required|trim');

			if ($this->form_validation->run() == FALSE)
			{        			
				$error = $this->form_validation->error_array();
				$message  = $error[array_keys($error)[0]];
				$this->api_response_arry['response_code'] 	= 500;
				$this->api_response_arry['service_name']    = "forgot_password";
				$this->api_response_arry['message']  		= $message;
				$this->api_response_arry['error']  			= $error;
				$this->api_response_arry['global_error']  	= $message;
				$this->api_response();
			}
			else 
			{
				if(isset($user_record) && !empty($user_record))
				{
					$this->db->update(USER,array('new_password_key' => $reset_key,'new_password_requested'=>$datetime),array('email'=>$email));
					$this->load->model('Mail_model');
					$this->Mail_model->forgot_password_mail($user_record,$time,$reset_key);
					$this->api_response_arry['response_code'] 	= 200;
					$this->api_response_arry['service_name']    = "forgot_password";
					$this->api_response_arry['message']  		= 'Password reset link has been sent to the enail address.';
					$this->api_response();
				}
				else
				{
					$this->api_response_arry['response_code'] 	= 500;
					$this->api_response_arry['service_name']    = "forgot_password";
					$this->api_response_arry['message']  		= 'Email not found.';
					$this->api_response_arry['error']  			= 'Email not found.';
					$this->api_response_arry['global_error']  	= 'Email not found.';
					$this->api_response();
				}
			}
		}
		else
		{
			$error = array('email'=>'Invaid request data.');
			$this->api_response_arry['response_code'] 	= 500;
			$this->api_response_arry['service_name']    = "forgot_password";
			$this->api_response_arry['message']  		= 'Invaid request data.';
			$this->api_response_arry['error']  			= $error;
			$this->api_response_arry['global_error']  	= 'Invaid request data.';
			$this->api_response();
		}
	}

	public function submit_reset_password(){
		if ($this->input->post()){

			$this->form_validation->set_error_delimiters('', '');
			
                        $this->form_validation->set_rules('reset_pass'	, 'password'		,'required|trim|min_length[6]|max_length[80]|matches[reset_cpass]');
                        $this->form_validation->set_rules('reset_cpass'   , 'confirm password' , 'trim|required');
                        $this->form_validation->set_rules('link'   , 'reset link' , 'trim|required');
                        

			if ($this->form_validation->run() == FALSE)
			{
				$error = $this->form_validation->error_array();
				$message  = $error[ array_keys($error)[0] ] ;
				$this->api_response_arry['response_code'] 	= 500;
				$this->api_response_arry['service_name']    = "submit_reset_password";
				$this->api_response_arry['message']  		= $message;
				$this->api_response_arry['error']  			= $message;
				$this->api_response_arry['global_error']  	= $message;
				$this->api_response();
			}
			else 
			{	
				$clink    = base64_decode($this->input->post('link'));
				$rec      = explode("_", $clink);
				$uniqueid = $rec[0];
				
				$new_password_key                       = $uniqueid;
				$password                               = md5(trim($this->input->post('reset_pass')));
				$this->db->update(USER,array('password' =>$password,'new_password_key'=>"",'varified_email'=>'1'),array('new_password_key'=>$new_password_key));	
				
				if($this->db->affected_rows()){

					$this->api_response_arry['response_code'] 	= 200;
					$this->api_response_arry['service_name']    = "submit_reset_password";
					$this->api_response_arry['message']  		= 'Password has been reset successfully';
					$this->api_response();
				}				
				else
				{
					$this->api_response_arry['response_code'] 	= 500;
					$this->api_response_arry['service_name']    = "submit_reset_password";
					$this->api_response_arry['message']  		= 'There is some problem in reset password';
					$this->api_response_arry['global_error']  	= 'There is some problem in reset password';
					$this->api_response();
				}
			}
		}
		else
		{
			$error = array('password'=>$this->lang->line('invalid_type'));
			$this->api_response_arry['response_code'] 	= 500;
			$this->api_response_arry['service_name']    = "submit_reset_password";
			$this->api_response_arry['message']  		= $this->lang->line('invalid_type');
			$this->api_response_arry['error']  			= $error;
			$this->api_response_arry['global_error']  	= $this->lang->line('invalid_type');
			$this->api_response();
		}
	}

	/**
	 * Change password from my profile page
	 */
	public function changed_password_post()
	{
		$is_login = ($this->user_id) ? $this->user_id : 0;
		$post_req = $this->input->post('req');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules('new_pass','Password','required|trim|min_length[6]');
		$this->form_validation->set_rules('new_confirm_pass','confirm password','required|trim|matches[new_pass]');
		
		if($post_req == 'changePass')
		{
			$this->form_validation->set_rules('old_pass','old password','required|trim');

			if ($this->form_validation->run() == FALSE)
			{
				$error  = array();
				$error   = $this->form_validation->error_array();
				$message = $error[ array_keys($error)[0] ] ;
				
				$this->api_response_arry['response_code'] 	= 500;
				$this->api_response_arry['service_name']    = "change_password";
				$this->api_response_arry['message']  		= $message;
				$this->api_response_arry['error']  			= $error;
				$this->api_response_arry['global_error']  	= $message;
				$this->api_response();
			}
			else 
			{
				$old_pass = $this->input->post('old_pass');
				$old_pass = md5($old_pass);

				$password = $this->db->select('user_id')
									->from(USER)
									->where(array( 'user_id' => $is_login, 'password' => $old_pass))
									->get()
									->row_array();

				if($password['user_id'] != '' && $password['user_id'] > 0)
				{
					$post_values['password']      = $this->input->post('new_pass');
					$post_values['password']      = md5($post_values['password']); 
					$this->User_model->table_name = USER;
					$condition                    = array('user_id' => $is_login);
					$updated                      = $this->User_model->update($condition , $post_values);

					$this->api_response_arry['response_code'] 	= 200;
					$this->api_response_arry['service_name']    = "change_password";
					$this->api_response_arry['message']  		= $this->lang->line('pwd_change_msg');
					$this->api_response();
				}
				else
				{
					$this->api_response_arry['response_code'] = 500;
					$this->api_response_arry['service_name']  = "change_password";
					$this->api_response_arry['message']       = $this->lang->line('wrong_pwd_msg');
					$this->api_response_arry['error'] = array('old_pass'=> $this->lang->line('wrong_pwd_msg'));
					$this->api_response_arry['global_error']  	= $this->lang->line('wrong_pwd_msg');
					$this->api_response();
				}
			}
		}
		elseif ($post_req == 'addPass') 
		{
			$post_values['password']      = $this->input->post('new_pass');
			$post_values['password']      = md5($post_values['password']); 
			$this->User_model->table_name = USER;
			$condition                    = array('user_id' => $is_login);
			$updated                      = $this->User_model->update($condition, $post_values);
			$this->response(array('status'=>true,'msg'=> $this->lang->line('pwd_add_msg')));
		}
	}

	/**
	 * [logout_post description]
	 * @Summary :-  LOGOUT SERVICE TO REMOVE CURRENT USER SESSION
	 * @return  [type]
	 */
	public function logout()
	{
		$key =  $this->input->get_request_header(AUTH_KEY);

		$redirect_url = $this->session->userdata('redirect_url');

		$this->db->update(USER, array('is_login'=>'0'), array('user_id'=>$this->session->userdata('user_id')));

		$this->load->helper('cookie');
		delete_cookie('users');

		$this->session->sess_destroy();

		$this->session->sess_create();

		$this->session->set_userdata('redirect_url', $redirect_url);
		
                redirect(base_url());
//                if(!$this->session->userdata('redirect_url')) {
//			redirect(base_url());
//		}
//		else {
//			redirect($redirect_url);	
//		}
	}

	public function logout_get()
	{
		$this->logout_post(TRUE);

		if(!$this->session->userdata('redirect_url'))
		{
			redirect();
		}
		else
		{
			redirect();	
		}

	}

    function do_upload() {
        //print_r($_FILES);
        $field_name = key($_FILES);
        $dir = ROOT_PATH_UPLOADS; // upload/
        $subdir = ROOT_PATH_UPLOADS.'user/'; // upload/logo/
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

        check_folder_exist($dir, $subdir);

        check_folder_exist($subdir, $thumb_dir);

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
        
            $thumb_data = create_thumb($temp_file, $thumb_dir . $file_name, 200, 200);
            if ($thumb_data['result'] == 'error') {
                $this->api_response_arry['response_code'] = 500;
                $this->api_response_arry['error'] = $thumb_data['data'];
                $this->api_response_arry['global_error'] = $thumb_data['data'];
            } 
            else {
                
                $thumb_url = IMAGE_UPLOADS_URL.'user/thumb/'. $file_name;

                $msg = array('field_name'=>$field_name, 'image_url' => $thumb_url, 'file_name' => $file_name);

                $this->api_response_arry['response_code'] = 200;
                $this->api_response_arry['message'] = "upload success";
                $this->api_response_arry['data'] = $msg;
            }
        }

        $this->api_response();
    }
}
/* End of file auth.php */
/* Location: ./application/controllers/auth.php */