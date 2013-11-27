<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("main.php");

class Login extends Main {
	
	public $user_session;
	public $user;
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$dbconnect = $this->load->database();
	}
	
	public function login_page()
	{		
		$this->load->view("user_login");
	}
	
	public function process_login()
	{		
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email_login", "Email", "trim|valid_email|required");
		$this->form_validation->set_rules("password_login", "Password", "trim|min_length[8]|required|md5");
		
		if($this->form_validation->run() === FALSE)
		{
			$data["login_errors"] = validation_errors();
			$this->load->view("user_login", $data);
		}
		else
		{
			$this->load->model("user_model");
			$user = $this->input->post();
			$user_info = array("email" => $user["email_login"],
							   "password" => $user["password_login"]
							   );
							   
			$this->user_model->get_user($user_info);
			
			$this->load->library('session');
			$this->session->set_userdata("user_session", $user_info);
			redirect(base_url("login/profile"));
		}
	}
	
	public function process_registration()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("first_name", "First Name", "trim|required");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required");
		$this->form_validation->set_rules("email", "Email", "trim|valid_email|required");
		$this->form_validation->set_rules("password", "Password", "trim|min_length[8]|required|matches[confirm_password]|md5");
		$this->form_validation->set_rules("confirm_password", "Confirm Password", "trim|required|md5");
		
		if($this->form_validation->run() === FALSE)
		{
			$data["registration_errors"] = validation_errors();
			$this->load->view("user_login", $data);
		}
		else
		{
			$this->load->helper(date);
			$this->load->model("user_model");
			$user = $this->input->post();
			$user_info = array("first_name" => $user["first_name"],
							   "last_name" => $user["last_name"],
							   "email" => $user["email"],
							   "password" => $user["password"],
							   "created_at" => date('Y-m-d H:i:s')
							   );
							   
			$this->user_model->insert_user($user_info);
			
			$this->load->library('session');
			$this->session->set_userdata("user_session", $user_info);
			redirect(base_url("login/profile"));
		}
	}
	
	public function profile()
	{
		echo "Hello " . $this->user_session["email"];
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url("/login/login_page"));
	}
	
}

//* End of file