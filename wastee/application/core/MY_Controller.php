<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $layout = "<br><br>Please don't forget to set a layout for this page. <br>Layout file must be kept in views/layout folder ";
    public $data = array();
    public $title = PROJECT_NAME;
    public $site_name = PROJECT_NAME;
    public $user_email = "";
    public $user_fullname = "";
    public $user_status = "";
    public $user_type = "";
    public $user_type_admin = "";
    public $user_guid = "";
    public $user_id = "";
    public $success_message = "";
    public $error_message = "";
    public $warning_message = "";
    public $information_message = "";
    public $base_controller = "";
    public $login_user_league_id = "";
    public $api_response_arry = array(
        "response_code" => 200,
        "service_name" => "",
        "message" => "",
        "global_error" => "",
        "error" => array(),
        "data" => array()
    );

    function __construct() {
        parent::__construct();

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

//		$currentClass = $this->router->fetch_class();
//		echo $currentClass; die;


        $this->GetMessages();

        $this->InitializeAdminSessiondata();
    }

    function GetMessages() {
        $warning_message = $this->session->flashdata('warning_message');
        $information_message = $this->session->flashdata('information_message');
        $success_message = $this->session->flashdata('success_message');
        $error_message = $this->session->flashdata('error_message');

        $this->data['open_login'] = $this->session->flashdata('login');

        if ($warning_message)
            $this->data['warning_message'] = $warning_message;
        if ($information_message)
            $this->data['information_message'] = $information_message;
        if ($success_message)
            $this->data['success_message'] = $success_message;
        if ($error_message)
            $this->data['error_message'] = $error_message;
    }

    function echo_Jason($data) {
        echo json_encode($data);
        exit;
    }

    function InitializeUserSessiondata($x_api_key = NULL, $force_session_check = FALSE) {
        
        $data = array();
        if ($x_api_key !== NULL && $x_api_key) {
            $data = $this->db->select('U.user_id, U.email, U.first_name, U.last_name, U.user_name, U.country, AL.key, U.user_guid')
                    ->from(ACTIVE_LOGIN . ' AS AL')
                    ->join(USER . " AS  U", "U.user_id = AL.user_id", 'inner')
                    ->where('AL.key', $x_api_key)
                    ->get()
                    ->row_array();
            
            if (empty($data)) {
                $this->api_response_arry['response_code'] = 401;
                $this->api_response_arry['service_name'] = ($this->router->fetch_method() == 'index') ? $this->router->fetch_class() : $this->router->fetch_method();
                $this->api_response_arry['message'] = "Not Authorised";
                $this->api_response_arry['global_error'] = "Not Authorised";
                $this->api_response();
            }
        }

        if (!empty($data)) {
            $newdata = array(
                'user_id' => $data['user_id'],
                'user_guid' => $data['user_guid'],
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'user_name' => $data['user_name'],
                'user_country' => $data['country'],
                'user_type' => USER_TYPE,
                'logged_in' => TRUE,
                AUTH_KEY => $data['key']
            );
            
            $this->session->set_userdata($newdata);

            $this->user_email = $data['email'];
            $this->user_fullname = $data['first_name'] . " " . $data['last_name'];
            $this->user_status = TRUE;
            $this->user_type = USER_TYPE;
            $this->user_guid = $data['user_guid'];
            $this->user_id = $data['user_id'];
        } else if ($this->session->userdata('user_id')) {
            $this->user_email = $this->session->userdata('email');
            $this->user_fullname = $this->session->userdata('first_name') . " " . $this->session->userdata('last_name');
            $this->user_status = TRUE;
            $this->user_type = USER_TYPE;
            $this->user_guid = $this->session->userdata('user_guid');
            $this->user_id = $this->session->userdata('user_id');
        } else if ($force_session_check === TRUE) {
            $method = strtolower($this->input->server('REQUEST_METHOD'));

            if (!$method || $method == 'get') {
                $this->session->set_userdata('redirect_url', current_url()); //echo current_url(); die;
                redirect(base_url('login'));
            }
            $this->api_response_arry['response_code'] = 401;
            $this->api_response_arry['service_name'] = ($this->router->fetch_method() == 'index') ? $this->router->fetch_class() : $this->router->fetch_method();
            $this->api_response_arry['message'] = "Not Authorised";
            $this->api_response_arry['global_error'] = "Not Authorised";
            $this->api_response();
        }
        return;
    }

    function destroy_session() {
        if (!$this->session->userdata('user_id')) {
            $this->load->helper('cookie');
            delete_cookie('users');
            $login_user_data['user_id'] = '';
            $login_user_data['user_type'] = '';
            $login_user_data['user_name'] = '';
            $login_user_data['last_name'] = '';
            $this->session->set_userdata($login_user_data);
        }
    }

    function InitializeAdminSessiondata() {
        $user_type = $this->session->userdata('user_type');

        if ($this->session->userdata('user_type_admin') == ADMIN_TYPE) {
            $this->user_type_admin = $this->session->userdata('user_type_admin');
            $this->admin_id = $this->session->userdata('admin_id');
            $this->admin_email = $this->session->userdata('email');
            $this->admin_fullname = $this->session->userdata('name');
            $this->user_email = $this->session->userdata('email');
            $this->admin_role = $this->session->userdata('admin_role');
            $this->admin_privilege = $this->session->userdata('admin_privilege');
        }
    }

    public function generateUniqueId() {
        $unicode = strtoupper(substr(md5(time()), 0, 10));
        return $unicode;
    }

    function isAllowedUser($allowed_user_type, $user_type = 'user_type') {
        $message = $this->lang->line('invalid_login');
        $user_type_value = '';

        if ('user_type' == $user_type) {
            $user_type_value = $this->user_type;
        } elseif ('user_type_admin' == $user_type) {
            $user_type_value = $this->user_type_admin;
        }

        if (in_array($user_type_value, $allowed_user_type)) {
            return TRUE;
        }

        if (!$this->uri->segment(1))
            return TRUE;

        if ($this->input->is_ajax_request()) {
            $this->response(array('login' => FALSE));
        } else {
            redirect('');
        }
    }

    public function CheckLoginStatus() {
        if ($this->user_type) {
            if ($this->user_type == USER_TYPE) {
                $redirect = USER_DEFAULT_REDIRECT;
            } else if ($this->user_type == ADMIN_TYPE) {
                // $redirect = '';
            } else {
                
            }
            if (isset($redirect))
                redirect($redirect);
        }
        return true;
    }

    function is_logged_in() {
        if ($this->session->userdata('user_type')) {
            return TRUE;
        }
        return FALSE;
    }

    function set_messages($message = 'There was some error.', $key = 'error_message') {
        $this->session->set_flashdata($key, $message);
    }

    function check_redirect_url() {
        if ($this->session->userdata('redirect_url')) {
            $redirect_url = $this->session->userdata('redirect_url');
            $this->session->unset_userdata('redirect_url');
            $this->session->unset_userdata('redirect_url');
            redirect($redirect_url);
            return TRUE;
        }
        return TRUE;
    }

    public function UserAutologin() {
        $this->load->model('Login_model');
        $this->load->helper('cookie');
        $cookie = get_cookie('users', TRUE);

        if ($cookie != '') {
            $data = unserialize($cookie);
            $email = $data['email'];
            if ($email != '') {
                $Userdata = $this->Login_model->get_single_row('*', USER, array('email' => $email));
                if (!is_null($Userdata) && $Userdata) {
                    $newdata = array(
                        'user_id' => $Userdata['user_id'],
                        'email' => $Userdata['email'],
                        'first_name' => $Userdata['first_name'],
                        'user_name' => $Userdata['user_name'],
                        'last_name' => @$Userdata['last_name'],
                        'user_country' => $Userdata['country'],
                        'user_type' => USER_TYPE,
                        'logged_in' => TRUE,
                    );

                    $key = $this->generate_active_login_key($Userdata['user_id'], 1);
                    $newdata[AUTH_KEY] = $key;
                    $this->session->sess_destroy();
                    $this->session->sess_create();
                    $this->session->set_userdata($newdata);
                }
            }
        }
    }

    public function generate_active_login_key($user_id = "", $device_type = "1") {
        $this->db->where('user_id', $user_id)->where('device_type', $device_type)->delete(ACTIVE_LOGIN);

        $this->load->helper('string');
        $key = random_string('unique');
        $insert_data = array(
            'key' => $key,
            'user_id' => $user_id,
            'device_type' => $device_type,
            'level' => '1',
            'date_created' => date('Y-m-d H:i:s')
        );
        $this->db->insert(ACTIVE_LOGIN, $insert_data);
        return $key;
    }

    public function api_response() {
        $output = array();
        $output['ResponseCode'] = $this->api_response_arry['response_code'];
        $output['ServiceName'] = $this->api_response_arry['service_name'];
        $output['Message'] = $this->api_response_arry['message'];
        $output['GlobalError'] = $this->api_response_arry['global_error'];
        $output['Error'] = $this->api_response_arry['error'];
        $output['Data'] = $this->api_response_arry['data'];
        //$this->response($output, $this->api_response_arry['response_code'] );
        echo json_encode($output);
        exit();
    }

    function create_thumb($file, $thumb_file, $width, $height) {
        $this->load->library('phpthumb');

        $phpThumb = new phpThumb();
        $original_source_path = file_get_contents($file);

        $phpThumb->setSourceData($original_source_path);
        $phpThumb->setParameter('w', $width);
        $phpThumb->setParameter('h', $height);
        $phpThumb->setParameter('zc', true);
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
        }
    }

    /**
     * custome validation for 18 year old 
     * return @true,@false
     */
    function year_validation($str) {
        // $str will be field value which post. will get auto and pass to function.
        $current_year = strtotime($str);
        $timestamp = strtotime('-18 years');

        if ($current_year > $timestamp) {
            $this->form_validation->set_message("year_validation", $this->lang->line('invalid_dob'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */