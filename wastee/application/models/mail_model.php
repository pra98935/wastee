<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mail_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function send_registration_confirmation_link($rows,$time,$reset_key)
	{
		$data['username'] = ($rows['user_name'] == "") ? $rows['first_name']." ".$rows['last_name']: $rows['user_name'];
		$data['email']    = $rows['email'];
		$data['link']     = base_url()."activate-account/".base64_encode($reset_key.'_'.$time);
		$message          = $this->load->view('emailer/signup_emailer',$data,true);
		$to               = $rows['email'];
		$subject          = '['.PROJECT_NAME.'] Thank you for registering with us';
		$message          = $message;
		send_email($to,$subject,$message);
	}

	public function forgot_password_mail($rows,$time,$reset_key)
	{
		$data['username'] = ($rows['user_name'] == "") ? $rows['first_name'] : $rows['user_name'];
		$data['email']    = $rows['email'];
		$data['link']     = base_url()."forgotpasswordcode/".base64_encode($reset_key.'_'.$time);
		$message          = $this->load->view('emailer/forgot_pass_emailer',$data,true); 
		$to               = $rows['email'];
		$subject          = '['.PROJECT_NAME.'] Password reminder';
		$message          = $message;    
		send_email($to,$subject,$message);
	}

}