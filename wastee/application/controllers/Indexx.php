<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'/libraries/REST_Controller.php';

class Indexx extends MY_Controller {

	
    public function __construct(){
        parent::__construct(); 
      //$this->load->model('chmshotel_model');
    }
    
	public function index() {
            $search_category = $searchtext = '';
            if(!empty($_GET['category'])){
                $search_category = $_GET['category'];
            }
            if(!empty($_GET['searchtext'])){
                $searchtext = $_GET['searchtext'];
            }
            $data = array();
            $data['search_category'] = $search_category;
            $data['searchtext'] = $searchtext;
            $this->load->view('index', $data);
	}
        
        public function signup() {
            if($this->session->userdata('user_id') != ''){
                redirect(base_url());
            }
            $this->load->view('signup');
	}
        public function login() {
            if($this->session->userdata('user_id') != ''){
                redirect(base_url());
            }
            $this->load->view('login');
	}
        
        public function forgotpasswordcode($link)
	{
		$clink    = base64_decode(urldecode($link));
		$rec      = explode("_", $clink);
		$uniqueid = $rec[0];
		$time     = $rec[1];
		$today    = time();
		
		$data     = array();
		$error    = '';

		if ($time >= $today)
		{
                    $this->load->model('Common_model');
			$row_result = $this->Common_model->get_single_row('user_id,email,new_password_key', USER, array('new_password_key' => $uniqueid));
			
			if (isset($row_result) && !empty($row_result))
			{
				$data['user_reset_id'] = $row_result['new_password_key'];
				$data['email']         = $row_result['email'];
				$data['link']         = urldecode($link);
			}
			else
			{
				$data['error']         = 'Invalid link';
			}
		}
		else
		{
			$data['error']         = 'Link has been expired. ';
		}
                $this->load->view('forgotpasswordcode', $data);
	}

	public function contact() {
		$this->load->view('contact');
	}
	
        public function jobs() {
		$this->load->view('jobs');
	}
	
        public function blog() {
		$this->load->view('blog');
	}
        
    public function faq() {
		$this->load->view('faq');
	}
    
    public function privacy() {
		$this->load->view('privacy');
	}

	public function terms() {
		$this->load->view('terms');
	}
       
	public function notfound() {
		$this->load->view('notfound');
	}

	public function detail() {
		$this->load->view('detail');
	}

    public function forgotpass() {
        $this->load->view('forgotpass');
    }

	


}
